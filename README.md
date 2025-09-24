# Fortify blade templates 

This package provides blade templates for every view, described by [Laravel 
Fortify](https://laravel.com/docs/12.x/fortify).

First, publish resources.

```shell
php artisan vendor:publish --tag=fortify
```

Next, setup views in `FortifyServiceProvider` class.

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

Next, declare routes to optional user pages: profile information, password 
update and two-factor setup.

```php
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features as Fortify;

if (Fortify::hasProfileFeatures()) {
    Route::middleware('auth')->group() {
    
        Route::view('/user/profile', 'auth.profile-information')
            ->name('user-profile-information.show');
            
        Route::view('/user/password', 'auth.user-password')
            ->name('user-password.show');
        
        Route::view('/user/two-factor-authentication', 'auth.two-factor-setup')
            ->name('two-factor.show');
    });
}
```

Finally, change views from `resources/views/auth` however you like.

**P.S.**        
After publishing the package resources, you may remove the package from your
application.
