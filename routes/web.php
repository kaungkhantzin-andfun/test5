<?php

use App\Models\Image;
use App\Models\Slider;
use App\Models\Category;
use App\Models\Location;
use App\Models\Property;
use App\Helpers\MyHelper;
use App\Jobs\ProcessImage;
use App\Http\Livewire\Home;
use App\Http\Livewire\Search;
use App\Http\Livewire\Single;
use Laravel\Fortify\Features;
use App\Http\Livewire\Profile;

// from vendor/laravel/fortify/routes/routes.php
use App\Http\Livewire\Register;
use App\Http\Livewire\Blog\Blog;
use App\Http\Livewire\Directory;
use Laravel\Jetstream\Jetstream;

// from vendor/laravel/fortify/routes/routes.php
use App\Http\Livewire\Dashboard\Ads;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Blog\SinglePost;
use App\Http\Livewire\Dashboard\Blogs;
use App\Http\Livewire\Dashboard\TopUp;
use App\Http\Livewire\Dashboard\Users;
use App\Http\Livewire\Dashboard\EditAds;
use App\Http\Livewire\Dashboard\Sliders;
use App\Http\Controllers\ToolsController;
use App\Http\Livewire\Dashboard\Packages;
use App\Http\Livewire\Dashboard\Purposes;
use App\Http\Controllers\SocialController;
use App\Http\Livewire\Compare\ComparePage;
use App\Http\Livewire\Dashboard\Dashboard;

// from vendor/laravel/jetstream/routes/livewire.php
use App\Http\Livewire\Dashboard\EditBlogs;
use App\Http\Livewire\Dashboard\Enquiries;
use App\Http\Livewire\Dashboard\Properties;
use App\Http\Livewire\Dashboard\EditSliders;
use App\Http\Livewire\Dashboard\EditPackages;
use App\Http\Livewire\Dashboard\EditProperties;
use App\Http\Livewire\Dashboard\Properties\Types;
use App\Http\Livewire\Dashboard\Locations\Locations;
use App\Http\Livewire\Dashboard\Properties\EditTypes;
use App\Http\Livewire\Dashboard\Locations\EditLocation;
use Laravel\Fortify\Http\Controllers\PasswordController;
use Laravel\Fortify\Http\Controllers\NewPasswordController;
use Laravel\Fortify\Http\Controllers\VerifyEmailController;
use Laravel\Fortify\Http\Controllers\RecoveryCodeController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Laravel\Jetstream\Http\Controllers\CurrentTeamController;
use Laravel\Fortify\Http\Controllers\TwoFactorQrCodeController;
use Laravel\Jetstream\Http\Controllers\Livewire\TeamController;
use Laravel\Fortify\Http\Controllers\PasswordResetLinkController;
use Laravel\Fortify\Http\Controllers\ProfileInformationController;
use Laravel\Fortify\Http\Controllers\ConfirmablePasswordController;
use Laravel\Jetstream\Http\Controllers\Livewire\ApiTokenController;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use Laravel\Jetstream\Http\Controllers\Livewire\UserProfileController;
use Laravel\Fortify\Http\Controllers\ConfirmedPasswordStatusController;
use Laravel\Fortify\Http\Controllers\EmailVerificationPromptController;
use Laravel\Fortify\Http\Controllers\TwoFactorAuthenticationController;
use Laravel\Fortify\Http\Controllers\EmailVerificationNotificationController;
use Laravel\Fortify\Http\Controllers\TwoFactorAuthenticatedSessionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('duplicates', function () {
//     $results = Location::whereIn('slug', function ($query) {
//         $query->select('slug')->from('locations')->groupBy('slug')->havingRaw('count(*) > 1');
//     })->get();

//     foreach ($results as $result) {
//         if (Location::where('slug',  Str::slug($result->name))->doesntExist()) {
//             $result->update(['slug' => Str::slug($result->name)]);
//         } else {
//             $result->update(['slug' => Str::slug($result->name) . '-' . $result->id]);
//         }
//     }
//     return $results;
// });

// Route::get('fix-locations', function () {
//     $loc = Location::all();
//     foreach ($loc as $l) {
//         $name = Str::beforeLast($l->name, " (");
//         $l->update(['name' => $name]);
//     }
//     return 'location fixed!';
// });

// generate blog post images
// Route::get('gen_blog_imgs', function () {
//     $imgs = Image::where('imageable_type', 'blog')->get();

//     foreach ($imgs as $img) {
//         ProcessImage::dispatch(
//             realPath: storage_path('app/public/' . $img->path),
//             uniqueName: $img->path,
//             options: [
//                 ['watermark' => true],
//                 ['cropWidth' => 415, 'namePrefix' => 'card_'],
//                 ['cropWidth' => 150, 'cropHeight' => 70, 'namePrefix' => 'thumb_'],
//             ]
//         );
//     }

//     return 'blog images fixed!';
// });

// generate other image types
// Route::get('gen_images', function () {
//     // regenerate property images
//     $properties = Property::all();

//     foreach ($properties as $ppt) {
//         if (!empty($ppt->images)) {
//             foreach ($ppt->images as $img) {
//                 ProcessImage::dispatch(
//                     realPath: storage_path('app/public/' . $img['path']),
//                     uniqueName: $img['path'],
//                     options: [
//                         ['cropWidth' => 415, 'cropHeight' => 240, 'namePrefix' => 'card_'],
//                         ['cropWidth' => 150, 'cropHeight' => 70, 'namePrefix' => 'thumb_'],
//                     ]
//                 );
//             }
//         }
//     }

//     // regenerate slider images
//     $sliders = Slider::all();

//     if (!empty($sliders)) {
//         foreach ($sliders as $slider) {
//             if (!empty($slider->image)) {
//                 ProcessImage::dispatch(
//                     realPath: storage_path('app/public/' . $slider->image->path),
//                     uniqueName: $slider->image->path,
//                     options: [
//                         ['cropWidth' => 1920, 'cropHeight' => 700], // large slider
//                         ['cropWidth' => 1024, 'cropHeight' => 576, 'namePrefix' => 'medium_'], // medium slider
//                         ['cropWidth' => 640, 'cropHeight' => 360, 'namePrefix' => 'small_'], // small slider
//                     ]
//                 );
//             }
//         }
//     }

//     // regenerate location images
//     $locations = Location::all();

//     if (!empty($locations)) {
//         foreach ($locations as $location) {
//             if (!empty($location->image)) {
//                 ProcessImage::dispatch(
//                     realPath: storage_path('app/public/' . $location->image->path),
//                     uniqueName: $location->image->path,
//                     options: [
//                         ['cropWidth' => 400, 'cropHeight' => 267],
//                     ]
//                 );
//             }
//         }
//     }

//     // regenerate property type images
//     $types = Category::where('of', 'property')->whereNull('parent_id')->with('image')->get();
//     if (!empty($types)) {
//         foreach ($types as $type) {
//             if (!empty($type->image)) {
//                 ProcessImage::dispatch(
//                     realPath: storage_path('app/public/' . $type->image->path),
//                     uniqueName: $type->image->path,
//                     options: [
//                         ['cropWidth' => 400, 'cropHeight' => 300],
//                     ]
//                 );
//             }
//         }
//     }

//     return 'done';
// });

// localization prefix and middlewares
Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => ['localeSessionRedirect', 'localizationRedirect']], function () {

    // Pages routes
    Route::get('/', Home::class)->name('home');

    // Blog routes
    Route::get('/blog', Blog::class)->name('blog');
    Route::get('/blog/{category}', Blog::class);
    Route::get('/blog/{id}/{slug}', SinglePost::class);

    // Property routes
    Route::get('/properties/{id}/{slug}', Single::class);

    Route::get('properties-in-myanmar', Search::class)->name('all-properties');
    Route::get('properties-for-sale-in-myanmar', Search::class)->name('for-sale');
    Route::get('properties-for-rent-in-myanmar', Search::class)->name('for-rent');
    Route::get('search/{type}/{purpose}/{region}/{township?}/{min?}/{max?}/{keyword?}', Search::class);
    Route::get('compare-properties', ComparePage::class);

    // Public register route
    Route::get('/register', Register::class)->name('register');

    // Business directory routes
    Route::prefix('real-estate-agents')->group(function () {
        Route::get('/', Directory::class);
        Route::get('{slug}', Profile::class)->name('agent');
    });

    Route::group(['prefix' => 'tools', 'as' => 'tools.'], function () {
        Route::get('myanmar-font-converter', [ToolsController::class, 'converter'])->name('font-converter');
        Route::get('myanmar-font-download', [ToolsController::class, 'fontDownload'])->name('font-download');
    });

    // Auth middleware routes
    Route::group(
        ['prefix' => 'user', 'middleware' => ['auth']],
        function () {
            Route::get('/{user}/edit', Register::class)->name('user.edit');
            Route::get('/saved', Profile::class)->name('saved');
        }
    );

    // Dashboard routes
    Route::group(['prefix' => 'dashboard', 'as' => 'dashboard.', 'middleware' => ['auth:sanctum', 'verified']], function () {
        // Dashboard routes for all users
        // Dashboard
        Route::get('/', Dashboard::class)->name('index');

        // Enquiries route
        Route::get('/enquiries', Enquiries::class);

        // Property routes
        Route::get('/properties', Properties::class);
        Route::get('/properties/{property}/edit', EditProperties::class)->name('pptedit');
        Route::get('/properties/create', EditProperties::class)->name('pptcreate');

        Route::group(['prefix' => 'blog-posts'], function () {
            // Blog routes
            Route::get('/', Blogs::class);
            Route::get('/{blog}/edit', EditBlogs::class)->name('edit-post');
            Route::get('/create', EditBlogs::class)->name('create-post');
        });

        Route::get('/top-up', TopUp::class)->name('top-up');

        // Dashboard routes for admin users only
        Route::group(['middleware' => ['admin']], function () {
            // Purposes routes
            Route::get('/purposes', Purposes::class);

            Route::group(['prefix' => 'sliders', 'as' => 'slider.'], function () {
                // Slider routes
                Route::get('/', Sliders::class);
                Route::get('/{slider}/edit', EditSliders::class)->name('edit');
                Route::get('/create', EditSliders::class)->name('create');
            });

            Route::group(['prefix' => 'ads'], function () {
                // Ads routes
                Route::get('/', Ads::class);
                Route::get('/{ad}/edit', EditAds::class);
                Route::get('/create', EditAds::class);
            });

            Route::group(['prefix' => 'packages'], function () {
                // User routes
                Route::get('/', Packages::class);
                Route::get('/{package}/edit', EditPackages::class);
                Route::get('/create', EditPackages::class);
            });

            Route::group(['prefix' => 'users'], function () {
                // User routes
                Route::get('/', Users::class);
                Route::get('/{user}/edit', Register::class);
                Route::get('/create', Register::class);
            });

            Route::group(['prefix' => 'types'], function () {
                // Property types routes
                Route::get('/property', Types::class);
                Route::get('/property/{type}/edit', EditTypes::class);
                Route::get('/property/create', EditTypes::class);

                // Blog categories routes
                Route::get('/blog', Types::class);
                Route::get('/blog/{type}/edit', EditTypes::class);
                Route::get('/blog/create', EditTypes::class);
            });

            Route::group(['prefix' => 'locations'], function () {
                // Location routes
                Route::get('/', Locations::class);
                Route::get('/{location}/edit', EditLocation::class);
                Route::get('/create', EditLocation::class);
            });
        });
    });

    // Social logins and callbacks
    Route::group(['prefix' => 'login'], function () {
        /* FACEBOOK */
        Route::get('/fb', [SocialController::class, 'toFB']);
        // Route::get('/fb-register', [SocialController::class, 'fbRegister']);
        Route::get('/fb/callback', [SocialController::class, 'fbCallback']);
        /* GOOGLE */
        Route::get('/google', [SocialController::class, 'toGoogle']);
        Route::get('/google/callback', [SocialController::class, 'googleCallback']);
        /* LINKEDIN */
        Route::get('/linkedin', [SocialController::class, 'toLinkedin']);
        Route::get('/linkedin/callback', [SocialController::class, 'linkedinCallback']);
        /* TWITTER */
        Route::get('/twitter', [SocialController::class, 'toTwitter']);
        Route::get('/twitter/callback', [SocialController::class, 'twitterCallback']);
    });

    // routes copied for localization
    // copied from vendor/laravel/fortify/routes/routes.php
    Route::group(['middleware' => config('fortify.middleware', ['web'])], function () {
        $enableViews = config('fortify.views', true);

        // Authentication...
        if ($enableViews) {
            Route::get('/login', [AuthenticatedSessionController::class, 'create'])
                ->middleware(['guest'])
                ->name('login');
        }

        $limiter = config('fortify.limiters.login');

        Route::post('/login', [AuthenticatedSessionController::class, 'store'])
            ->middleware(array_filter([
                'guest',
                $limiter ? 'throttle:' . $limiter : null,
            ]));

        Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
            ->name('logout');

        // Password Reset...
        if (Features::enabled(Features::resetPasswords())) {
            if ($enableViews) {
                Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
                    ->middleware(['guest'])
                    ->name('password.request');

                Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
                    ->middleware(['guest'])
                    ->name('password.reset');
            }

            Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
                ->middleware(['guest'])
                ->name('password.email');

            Route::post('/reset-password', [NewPasswordController::class, 'store'])
                ->middleware(['guest'])
                ->name('password.update');
        }

        // Registration...
        // if (Features::enabled(Features::registration())) {
        //     if ($enableViews) {
        //         Route::get('/register', [RegisteredUserController::class, 'create'])
        //             ->middleware(['guest'])
        //             ->name('register');
        //     }

        //     Route::post('/register', [RegisteredUserController::class, 'store'])
        //         ->middleware(['guest']);
        // }

        // Email Verification...
        if (Features::enabled(Features::emailVerification())) {
            if ($enableViews) {
                Route::get('/email/verify', [EmailVerificationPromptController::class, '__invoke'])
                    ->middleware(['auth'])
                    ->name('verification.notice');
            }

            Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
                ->middleware(['auth', 'signed', 'throttle:6,1'])
                ->name('verification.verify');

            Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware(['auth', 'throttle:6,1'])
                ->name('verification.send');
        }

        // Profile Information...
        if (Features::enabled(Features::updateProfileInformation())) {
            Route::put('/user/profile-information', [ProfileInformationController::class, 'update'])
                ->middleware(['auth'])
                ->name('user-profile-information.update');
        }

        // Passwords...
        if (Features::enabled(Features::updatePasswords())) {
            Route::put('/user/password', [PasswordController::class, 'update'])
                ->middleware(['auth'])
                ->name('user-password.update');
        }

        // Password Confirmation...
        if ($enableViews) {
            Route::get('/user/confirm-password', [ConfirmablePasswordController::class, 'show'])
                ->middleware(['auth'])
                ->name('password.confirm');

            Route::get('/user/confirmed-password-status', [ConfirmedPasswordStatusController::class, 'show'])
                ->middleware(['auth'])
                ->name('password.confirmation');
        }

        Route::post('/user/confirm-password', [ConfirmablePasswordController::class, 'store'])
            ->middleware(['auth']);

        // Two Factor Authentication...
        if (Features::enabled(Features::twoFactorAuthentication())) {
            if ($enableViews) {
                Route::get('/two-factor-challenge', [TwoFactorAuthenticatedSessionController::class, 'create'])
                    ->middleware(['guest'])
                    ->name('two-factor.login');
            }

            Route::post('/two-factor-challenge', [TwoFactorAuthenticatedSessionController::class, 'store'])
                ->middleware(['guest']);

            $twoFactorMiddleware = Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword')
                ? ['auth', 'password.confirm']
                : ['auth'];

            Route::post('/user/two-factor-authentication', [TwoFactorAuthenticationController::class, 'store'])
                ->middleware($twoFactorMiddleware);

            Route::delete('/user/two-factor-authentication', [TwoFactorAuthenticationController::class, 'destroy'])
                ->middleware($twoFactorMiddleware);

            Route::get('/user/two-factor-qr-code', [TwoFactorQrCodeController::class, 'show'])
                ->middleware($twoFactorMiddleware);

            Route::get('/user/two-factor-recovery-codes', [RecoveryCodeController::class, 'index'])
                ->middleware($twoFactorMiddleware);

            Route::post('/user/two-factor-recovery-codes', [RecoveryCodeController::class, 'store'])
                ->middleware($twoFactorMiddleware);
        }
    });

    // routes copied for localization
    // copied from vendor/laravel/jetstream/routes/livewire.php
    Route::group(
        ['middleware' => config('jetstream.middleware', ['web'])],
        function () {
            Route::group(['middleware' => ['auth', 'verified']], function () {
                // User & Profile...
                Route::get('/user/profile', [UserProfileController::class, 'show'])->name('profile.show');

                // API...
                if (Jetstream::hasApiFeatures()) {
                    Route::get('/user/api-tokens', [ApiTokenController::class, 'index'])->name('api-tokens.index');
                }

                // Teams...
                if (Jetstream::hasTeamFeatures()) {
                    Route::get('/teams/create', [TeamController::class, 'create'])->name('teams.create');
                    Route::get('/teams/{team}', [TeamController::class, 'show'])->name('teams.show');
                    Route::put('/current-team', [CurrentTeamController::class, 'update'])->name('current-team.update');
                }
            });
        }
    );
});
