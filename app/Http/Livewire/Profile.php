<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use App\Helpers\MyHelper;
use Illuminate\Support\Facades\Auth;
use Artesaos\SEOTools\Facades\JsonLdMulti;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Profile extends Component
{
    public $user;
    public $isSavedPage = false;

    public $pageTitle;
    public $pageDescription;
    public $seoImage;

    public function mount($slug = null)
    {
        if (!empty($slug)) {
            $this->user = User::whereSlug($slug)->with('reactions')->firstOrFail();
        } else {
            $this->user = Auth::user();
            $this->isSavedPage = true;
        }

        // SEO Optimizations
        if ($this->isSavedPage) {
            $this->pageTitle = __('Saved Properties');
        } else {
            $count = $this->user->properties->count();
            $total_properties = $count == 0 ? '' : $count . ' ';

            if (app()->getLocale() == 'my') {
                $this->pageTitle = $this->user->name . ' (ဖုန်း၊ လိပ်စာနှင့် ' . $total_properties . 'အိမ်ခြံမြေများ)';
            } else {
                $this->pageTitle = $this->user->name . ' (Phone, Address & ' . $total_properties . 'Properties)';
            }
        }

        $this->pageDescription = __($this->user->shortAbout);
        $this->seoImage = $this->user->profile_photo_url ?: '';

        MyHelper::setGlobalSEOData($this->pageTitle, $this->pageDescription, $this->seoImage);
        $this->setJsonLD();
    }

    public function setJsonLD()
    {
        // Information about the organization
        JsonLdMulti::setType("Organization");
        JsonLdMulti::addValues([
            "@id" => url()->current() . "#organization",
            "name" => $this->user->name,
            "url" => url()->current(),
            // "email" => $this->user->email,
            "address" => [
                "@type" => "PostalAddress",
                "streetAddress" => $this->user->address,
                "addressRegion" => $this->user->location ?: "Yangon",
                "postalCode" => $this->user->location ? $this->user->location->postal_code : "11121",
                "addressCountry" => "MM"
            ],
            "logo" => [
                "@type" => "ImageObject",
                "@id" => url()->current() . "#logo",
                "url" => $this->seoImage,
                "caption" => $this->user->name,
            ],
        ]);

        // Information about the current page
        JsonLdMulti::newJsonLd()
            ->setType('WebPage')
            ->setTitle($this->pageTitle)
            ->setDescription($this->pageDescription)
            ->setUrl(url()->current())
            ->setImages($this->seoImage)
            ->addValues([
                "@id" => url()->current() . "#webpage",
                "inLanguage" => LaravelLocalization::getCurrentLocale(),
            ]);
    }

    public function render()
    {
        // return view('livewire.profile')->layout($this->isSavedPage ? 'layouts.dashboard.master' : 'layouts.app', ['title' => 'Saved Properties']);
        return view('livewire.profile')->layout('layouts.app');
    }
}
