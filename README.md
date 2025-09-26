# Fortify user forms scaffolding

As we know,
[Laravel Fortify](https://laravel.com/docs/12.x/fortify)
provides all the backend authentication logic. And missing all 
user forms. We need to develop it ourselves.

Every time I install Fortify, I create the same user forms... And... why not 
to create it once?

This package provides blade templates for every view, described by Fortify.

Install Fortify (this package already requires `laravel/fortify`) and publish 
resources.

```shell
composer require codewiser/fortify

php artisan fortify:install
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

Finally, customize blades in `resources/views/auth` however you like.

### Additional routes

Package provides few additional user pages: profile information, password
update and two-factor setup.

These routes are available if relevant Fortify features have been enabled. 

| Route name                      | Allows user...                    |
|---------------------------------|-----------------------------------|
| `user-profile-information.show` | to change name and email          |
| `user-password.show`            | to update password                |
| `two-factor.show`               | to setup two factor authorization |

You may add this routes to a user menu.
