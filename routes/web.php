<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features as Fortify;

if (Fortify::hasProfileFeatures()) {
    Route::middleware(['auth', 'web'])->group(function () {

        Route::view('/user/profile-information', 'auth.profile-information')
            ->name('user-profile-information.show');

        Route::view('/user/password', 'auth.user-password')
            ->name('user-password.show');

        Route::view('/user/two-factor-authentication', 'auth.two-factor-setup')
            ->name('two-factor.show');
    });
}