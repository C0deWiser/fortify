# Fortify Assets

This package provides blade templates for every view, described by [Laravel 
Fortify](https://laravel.com/docs/12.x/fortify).

First, publish views (and lang files).

```shell
php artisan vendor:publish --tag=fortify
```

Second, setup views in `FortifyServiceProvider` class.

```php
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::loginView(fn() => view('auth.login'));
        Fortify::registerView(fn() => view('auth.register'));
        Fortify::verifyEmailView(fn() => view('auth.verify-email'));
        Fortify::confirmPasswordView(fn() => view('auth.confirm-password'));
        Fortify::twoFactorChallengeView(fn() => view('auth.two-factor-challenge'));
        Fortify::requestPasswordResetLinkView(fn() => view('auth.forgot-password'));
        Fortify::resetPasswordView(fn(Request $request) => view('auth.reset-password', [
            'request' => $request
        ]));
    }
}
```

## User profile page

This package provides a simple user profile page. It's up to you to enable it.

```php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;
use Laravel\Fortify\Contracts\ProfileInformationUpdatedResponse;

Route::middleware('auth')->group(function () {
    
    Route::view('/profile', 'auth.profile');
    
    Route::put('/profile', 
        function(Request $request, UpdatesUserProfileInformation $updater) {
            
            $updater->update($request->user(), $request->all());
    
            return app(ProfileInformationUpdatedResponse::class)
        }
    )->name('user-profile');
});
```

## Two-factor setup page

If you need two-factor authentication in your application, 
you may add a route to the page, where user can enable or disable two-factor 
authentication and may see the recovery codes.

```php
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::view('/user/two-factor-authentication', 'auth.two-factor-setup');
};
```