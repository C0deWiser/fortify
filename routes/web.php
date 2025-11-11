<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features as Fortify;

Route::middleware(['auth', 'web'])->group(function () {

    Route::view('/user/profile-information', 'auth.profile-information')
        ->when(Fortify::canUpdateProfileInformation())
        ->name('user-profile-information.show');

    Route::view('/user/password', 'auth.user-password')
        ->when(Fortify::enabled(Fortify::updatePasswords()))
        ->name('user-password.show');

    Route::view('/user/two-factor-authentication', 'auth.two-factor-setup')
        ->when(Fortify::canManageTwoFactorAuthentication())
        ->name('two-factor.show');
});