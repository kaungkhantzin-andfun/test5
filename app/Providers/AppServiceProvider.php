<?php

namespace App\Providers;

use App\Models\Savable;
use App\Models\Category;
use App\Models\Location;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;
use Opcodes\LogViewer\Facades\LogViewer;
use Illuminate\Database\Eloquent\Relations\Relation;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        LogViewer::auth(function ($request) {
            return $request->user()
                && in_array($request->user()->email, [
                    'gtu.myowin@gmail.com',
                ]);
        });

        if (!app()->runningInConsole()) {
            // mapping custom polymorphic types
            // read more » https://laravel.com/docs/8.x/eloquent-relationships#custom-polymorphic-types
            Relation::morphMap([
                'blog' => 'App\Models\Blog',
                'property' => 'App\Models\Property',
                'slider' => 'App\Models\Slider',
                'location' => 'App\Models\Location',
                'ad' => 'App\Models\Ad',
                'category' => 'App\Models\Category',
            ]);

            $propertyTypes = Category::where('of', 'property')->whereNull('parent_id')->get();
            $blogCategories = Category::where('of', 'blog')->whereNotIn('slug', ['pages', 'event'])->get();
            $regions = Location::whereNull('parent_id')->get();

            View::share(['propertyTypes' => $propertyTypes, 'regions' => $regions, 'blogCategories' => $blogCategories]);

            // For property save feature
            // to get user in appserviceprovider » https://stackoverflow.com/questions/37372357/laravel-how-to-get-current-user-in-appserviceprovider
            // readmore about view composers » https://laravel.com/docs/8.x/views#view-composers

            // instead of sharing data with all views (*), we will share only with parent views to reduce db queries per page
            // view()->composer('*', function ($view) {
            view()->composer(['livewire.home', 'livewire.single', 'livewire.search', 'livewire.realtime-filter', 'livewire.dashboard.enquiries'], function ($view) {
                // empty array for public
                $savedPropertyIds = [];
                $compareIds = Session::get('compare', []);

                if (Auth::check()) {
                    $savedPropertyIds = Savable::where('user_id', Auth::user()->id)->where('savable_type', 'property')->pluck('savable_id')->all();
                }

                $view->with(['savedPropertyIds' => $savedPropertyIds, 'compareIds' => $compareIds]);
            });
        }
    }
}
