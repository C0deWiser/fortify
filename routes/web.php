<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features as Fortify;

Route::middleware(['auth', 'web'])->group(function () {

    Route::view('/user/profile-information', 'auth.profile-information')
        ->when(Fortify::enabled(Fortify::updateProfileInformation()))
        ->name('user-profile-information.show');

    Route::view('/user/password', 'auth.user-password')
        ->when(Fortify::enabled(Fortify::updatePasswords()))
        ->name('user-password.show');

    Route::view('/user/two-factor-authentication', 'auth.two-factor-setup')
        ->when(Fortify::enabled(Fortify::twoFactorAuthentication()))
        ->name('two-factor.show');
});