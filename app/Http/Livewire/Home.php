<?php

namespace App\Http\Livewire;

use App\Models\Slider;
use Livewire\Component;
use App\Models\Category;
use App\Models\Location;
use App\Models\Property;
use App\Helpers\MyHelper;
use App\Models\Blog;
use App\Models\PropertyPurpose;
use Illuminate\Support\Facades\Storage;
use Artesaos\SEOTools\Facades\JsonLdMulti;
use Carbon\Carbon;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Home extends Component
{
    public $slides;
    public $featuredProperties;
    public $resendPosts;
    public $saleProperties;
    public $rentProperties;
    // two resent Properties and
    // three resent Properties
    public $twoResendProperties;
    public $threeResendProperties;
    public $seoImages;
    public $blogs;

    public function mount()
    {
        $this->slides = Slider::whereHas('image')->with('image')->get();
        $this->blogs = Blog::whereHas('categories')->get();
        // Get latest 2 properties
        $this->twoResendProperties = Property::whereNull('soldout')
            ->with(['images', 'location', 'type', 'purpose', 'user', 'detail'])
            ->orderBy('created_at', 'desc')
            ->take(2)
            ->get();

        // Get 3 properties after the first 2 (i.e., 3rd, 4th, 5th latest)
        $this->threeResendProperties = Property::whereNull('soldout')
            ->with(['images', 'location', 'type', 'purpose', 'user', 'detail'])
            ->orderBy('created_at', 'desc')
            ->skip(2)
            ->take(3)
            ->get();

        // for now we will show latest instead of featured
        // $this->featuredProperties = Property::whereNotNull('featured')->whereNull('soldout')->with(['images', 'location', 'type', 'purpose', 'user', 'detail'])->orderBy('stat')->take(9)->get();
        $featuredBuilder = Property::whereDate('created_at', Carbon::today())->whereNull('soldout')->with(['images', 'location', 'type', 'purpose', 'user', 'detail']);
        $resentBuilder = Property::whereDate('created_at', Carbon::today())->whereNull('soldout')->with(['images', 'location', 'type', 'purpose', 'user', 'detail']);
        MyHelper::increaseViewCount($featuredBuilder);
        MyHelper::increaseViewCount($resentBuilder);
        $this->featuredProperties = $featuredBuilder->get();
        $this->resendPosts = $featuredBuilder->take(6)->get();


        $saleBuilder = Property::whereNull('soldout')->where('property_purpose_id', 1)->with(['images', 'location', 'type', 'purpose', 'detail'])->orderBy('created_at', 'desc')->take(8);
        MyHelper::increaseViewCount($saleBuilder);
        $this->saleProperties = $saleBuilder->get();

        $rentBuilder = Property::whereNull('soldout')->where('property_purpose_id', 2)->with(['images', 'location', 'type', 'purpose', 'detail'])->orderBy('created_at', 'desc')->take(8);
        MyHelper::increaseViewCount($rentBuilder);
        $this->rentProperties = $rentBuilder->get();

        // Getting all regions
        $this->types = Category::where('of', 'property')->whereNull('parent_id')->select(['id', 'slug', 'name'])->with('image')->withCount('properties')->orderBy('properties_count', 'desc')->get();
        $this->regions = Location::whereNull('parent_id')->select(['id', 'slug', 'name'])->with('image')->withCount('properties')->orderBy('properties_count', 'desc')->get();

        if (count($this->slides) > 0) {
            foreach ($this->slides as $slide) {
                $this->seoImages[] = config('app.url') . Storage::url($slide->image->path);
            }
        }

        // SEO Optimizations
        MyHelper::setGlobalSEOData(__('seo.home.title'), __('seo.home.description'), $this->seoImages);
        $this->setJsonLD();
    }

    public function setJsonLD()
    {
        // Information about the organization
        JsonLdMulti::setType("Organization");
        JsonLdMulti::addValues([
            "@id" => url()->current() . "#organization",
            "name" => __(config("app.name")),
            "url" => url()->current(),
            "email" => "info@myanmarhouse.com.mm",
            "address" => [
                "@type" => "PostalAddress",
                // "streetAddress" => "367, 4th Floor, Lower Kyeemyindaing Road, Saw Yan Paing (North) Quarter, Ahlone Township, Yangon",
                "addressLocality" => "Yangon",
                "addressRegion" => "Yangon",
                "postalCode" => "11121",
                "addressCountry" => "MM"
            ],
            "logo" => [
                "@type" => "ImageObject",
                "@id" => url()->current() . "#logo",
                "url" => asset('assets/images/Myanmar-House-Logo.png'),
                "caption" => __(config("app.name")),
                "inLanguage" => LaravelLocalization::getCurrentLocale(),
                "width" => "500",
                "height" => "227"
            ],
        ]);

        // Information about the website
        JsonLdMulti::newJsonLd()
            ->setType('WebSite')
            ->setUrl(url()->current())
            ->addValues([
                "@id" => url()->current() . "#website",
                "name" => __(config("app.name")),
                "publisher" => [
                    "@id" => url()->current() . "#organization"
                ],
                "inLanguage" => LaravelLocalization::getCurrentLocale(),
            ]);

        // Information about the current page
        JsonLdMulti::newJsonLd()
            ->setType('WebPage')
            ->setTitle(__('seo.home.title'))
            ->setDescription(__('seo.home.description'))
            ->setUrl(url()->current())
            ->setImages($this->seoImages)
            ->addValues([
                "@id" => url()->current() . "#webpage",
                "inLanguage" => LaravelLocalization::getCurrentLocale(),
            ]);
    }

    public function render()
    {
        return view('livewire.home');
    }
}
