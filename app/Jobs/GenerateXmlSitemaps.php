<?php

namespace App\Jobs;

use App\Models\Blog;
use App\Models\User;
use App\Models\Category;
use App\Models\Location;
use App\Models\Property;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use Illuminate\Bus\Queueable;
use App\Models\PropertyPurpose;
use Spatie\Sitemap\SitemapIndex;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class GenerateXmlSitemaps implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // ref: https://github.com/spatie/laravel-sitemap/issues/258#issuecomment-573346191
        $sitemapIndex = SitemapIndex::create();

        // generate pages sitemap
        $this->generatePagesSitemap($sitemapIndex);

        // generate searches sitemap
        $this->generateSearchesSitemap($sitemapIndex);

        // // generate categories sitemap
        // $this->generateCategoriesSitemap($sitemapIndex);

        // generate properties sitemap
        $this->generatePropertiesSitemap($sitemapIndex);

        // // generate blogs sitemap
        $this->generateBlogsSitemap($sitemapIndex);

        // generate profiles sitemap
        $this->generateAgentsSitemap($sitemapIndex);

        // put all sitemaps to the sitemap index
        $sitemapIndex->writeToFile(public_path('sitemap.xml'));
    }

    public function generatePagesSitemap($sitemapIndex)
    {
        /**
         * Page Sitemap
         */
        $sitemapName = 'pages_sitemap.xml';
        $sitemap = Sitemap::create();

        $sitemap
            ->add(Url::create('/')->addAlternate('en/', 'en'))
            ->add(Url::create('/properties-in-myanmar')->addAlternate('en/properties-in-myanmar', 'en'))
            ->add(Url::create('/properties-for-sale-in-myanmar')->addAlternate('en/properties-for-sale-in-myanmar', 'en'))
            ->add(Url::create('/properties-for-rent-in-myanmar')->addAlternate('en/properties-for-rent-in-myanmar', 'en'))
            ->add(Url::create('tools/myanmar-font-download')->addAlternate('en/tools/myanmar-font-download', 'en'))
            ->add(Url::create('tools/myanmar-font-converter')->addAlternate('en/tools/myanmar-font-converter', 'en'))
            ->add(Url::create('/login')->addAlternate('en/login', 'en'))
            ->add(Url::create('/register')->addAlternate('en/register', 'en'));

        $sitemap->writeToFile(public_path('sitemaps/' . $sitemapName));
        $sitemapIndex->add('sitemaps/' . $sitemapName);
    }

    public function generateSearchesSitemap($sitemapIndex)
    {
        /**
         * Search Sitemap
         */
        $sitemapName = 'searches_sitemap.xml';
        $sitemap = Sitemap::create();

        // adding search urls
        // all, for sale, for rent are added in pages sitemap
        $propertyTypes = Category::where('of', 'property')->whereNull('parent_id')->get();
        foreach ($propertyTypes as $type) {
            $sitemap->add(
                Url::create("search/$type->slug/all-purposes/all-regions/all-townships")
                    ->addAlternate("en/search/$type->slug/all-purposes/all-regions/all-townships", 'en')
            );

            $purposes = PropertyPurpose::select('slug')->get();
            foreach ($purposes as $purpose) {
                $sitemap->add(
                    Url::create("search/properties/$purpose->slug/all-regions/all-townships")
                        ->addAlternate("en/search/properties/$purpose->slug/all-regions/all-townships", 'en')
                );
                $sitemap->add(
                    Url::create("search/$type->slug/$purpose->slug/all-regions/all-townships")
                        ->addAlternate("en/search/$type->slug/$purpose->slug/all-regions/all-townships", 'en')
                );

                $regions = Location::whereNull('parent_id')->select(['id', 'slug'])->get();
                foreach ($regions as $reg) {
                    $sitemap->add(
                        Url::create("search/properties/all-purposes/$reg->slug/all-townships")
                            ->addAlternate("en/search/properties/all-purposes/$reg->slug/all-townships", 'en')
                    );
                    $sitemap->add(
                        Url::create("search/$type->slug/$purpose->slug/$reg->slug/all-townships")
                            ->addAlternate("en/search/$type->slug/$purpose->slug/$reg->slug/all-townships", 'en')
                    );

                    $townships = Location::where('parent_id', $reg->id)->select('slug')->get();
                    foreach ($townships as $tsp) {
                        $sitemap->add(
                            Url::create("search/$type->slug/$purpose->slug/$reg->slug/$tsp->slug")
                                ->addAlternate("en/search/$type->slug/$purpose->slug/$reg->slug/$tsp->slug", 'en')
                        );
                    }
                }
            }
        }

        $sitemap->writeToFile(public_path('sitemaps/' . $sitemapName));
        $sitemapIndex->add('sitemaps/' . $sitemapName);
    }

    public function generateCategoriesSitemap($sitemapIndex)
    {
        /**
         * Category Sitemap
         */
        $sitemapName = 'categories_sitemap.xml';
        $sitemap = Sitemap::create();

        // adding blog categories
        $sitemap->add(Url::create('blog')->addAlternate('en/blog', 'en'));

        // preparing parent categories
        $blogCategories = Category::where('of', 'blog')->where('slug', '<>', 'pages')->get();
        foreach ($blogCategories->whereNull('parent_id') as $parent_cat) {
            $sitemap->add(Url::create('blog/' . $parent_cat->slug)->addAlternate('en/blog/' . $parent_cat->slug, 'en'));

            // preparing sub categories
            $subCategories = $blogCategories->where('parent_id', $parent_cat->id);
            foreach ($subCategories as $cat) {
                $sitemap->add(Url::create('blog/' . $cat->slug)->addAlternate('en/blog/' . $cat->slug, 'en'));
            }
        }

        // adding directory categories
        $sitemap->add(Url::create('directory')->addAlternate('en/directory', 'en'));
        $roles = User::whereNotIn('role', ['remwdstate20', 'user'])->select('role')->groupBy('role')->get();
        foreach ($roles as $role) {
            $sitemap->add(Url::create("directory/$role->role/")->addAlternate("en/directory/$role->role/", 'en'));
        }

        $sitemap->writeToFile(public_path('sitemaps/' . $sitemapName));
        $sitemapIndex->add('sitemaps/' . $sitemapName);
    }

    public function generatePropertiesSitemap($sitemapIndex)
    {
        /**
         * Properties Sitemap
         */
        Property::select(['id', 'slug', 'updated_at'])->chunk(50000, function ($properties, $chunk) use ($sitemapIndex) {
            $sitemapName = 'properties_sitemap_' . $chunk . '.xml';
            $sitemap = Sitemap::create();

            foreach ($properties as $property) {
                $sitemap->add(
                    Url::create('properties/' . $property->id . '/' . $property->slug)
                        ->addAlternate('en/properties/' . $property->id . '/' . $property->slug, 'en')
                        ->setLastModificationDate($property->updated_at)
                );
            }

            $sitemap->writeToFile(public_path('sitemaps/' . $sitemapName));
            $sitemapIndex->add('sitemaps/' . $sitemapName);
        });
    }

    public function generateBlogsSitemap($sitemapIndex)
    {
        /**
         * Blog Sitemap
         */
        Blog::select(['id', 'slug', 'updated_at'])->chunk(50000, function ($blogs, $chunk) use ($sitemapIndex) {
            $sitemapName = 'blogs_sitemap_' . $chunk . '.xml';
            $sitemap = Sitemap::create();

            foreach ($blogs as $blog) {
                $sitemap->add(
                    Url::create('blog/' . $blog->id . '/' . $blog->slug)
                        ->addAlternate('en/blog/' . $blog->id . '/' . $blog->slug, 'en')
                        ->setLastModificationDate($blog->updated_at)
                );
            }

            $sitemap->writeToFile(public_path('sitemaps/' . $sitemapName));
            $sitemapIndex->add('sitemaps/' . $sitemapName);
        });
    }

    public function generateAgentsSitemap($sitemapIndex)
    {
        /**
         * Profiles Sitemap
         */
        // User::whereNotIn('role', ['remwdstate20', 'user'])->select(['slug', 'updated_at'])->chunk(50000, function ($profiles, $chunk) use ($sitemapIndex) {
        User::where('role', 'real-estate-agent')->select(['slug', 'updated_at'])->chunk(50000, function ($profiles, $chunk) use ($sitemapIndex) {
            $sitemapName = 'agents_sitemap_' . $chunk . '.xml';
            $sitemap = Sitemap::create();

            foreach ($profiles as $profile) {
                $sitemap->add(
                    Url::create('real-estate-agents/' . $profile->slug)
                        ->addAlternate('en/real-estate-agents/' . $profile->slug, 'en')
                        ->setLastModificationDate(now()->subDay(1))
                );
            }

            $sitemap->writeToFile(public_path('sitemaps/' . $sitemapName));
            $sitemapIndex->add('sitemaps/' . $sitemapName);
        });
    }
}
