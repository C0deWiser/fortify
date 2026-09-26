<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features as Fortify;

Route::middleware(['auth'])->group(function () {

    $middlewares = config('fortify.middleware', []);

    Route::view('/user/profile-information', 'fortify::profile-information')
        ->when(Fortify::canUpdateProfileInformation())
        ->middleware($middlewares)
        ->name('user-profile-information.show');

    Route::view('/user/password', 'fortify::user-password')
        ->when(Fortify::canUpdatePasswords())
        ->middleware($middlewares)
        ->name('user-password.show');

    $pk = config('fortify-options.two-factor-authentication');
    $pk = (is_array($pk) && $pk['confirmPassword'] ?? false) ? ['password.confirm'] : [];

    Route::view('/user/two-factor-authentication', 'fortify::two-factor-setup')
        ->when(Fortify::canManageTwoFactorAuthentication())
        ->middleware($middlewares)
        ->middleware($pk)
        ->name('two-factor.show');

    $pk = config('fortify-options.passkeys');
    $pk = (is_array($pk) && $pk['confirmPassword'] ?? false) ? ['password.confirm'] : [];

    Route::view('/user/passkeys', 'fortify::user-passkeys')
        ->when(Fortify::canManagePasskeys())
        ->middleware($middlewares)
        ->middleware($pk)
        ->name('user-passkey.index');
});

Route::view('/example/restricted-area', 'fortify::examples.password-confirmed')
    ->middleware(['web', 'password.confirm'])
    ->name('password-confirmation.example');

Route::view('/example/email-verified', 'fortify::examples.email-verified')
    ->middleware(['web', 'verified'])
    ->name('email-verified.example');