<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features as Fortify;

Route::middleware(['auth', 'web'])->group(function () {

    Route::view('/user/profile-information', 'fortify::profile-information')
        ->when(Fortify::canUpdateProfileInformation())
        ->name('user-profile-information.show');

    Route::view('/user/password', 'fortify::user-password')
        ->when(Fortify::enabled(Fortify::updatePasswords()))
        ->name('user-password.show');

    Route::view('/user/two-factor-authentication', 'fortify::two-factor-setup')
        ->when(Fortify::canManageTwoFactorAuthentication())
        ->name('two-factor.show');

    $pk = config('fortify-options.passkeys');

    Route::view('/user/passkeys', 'fortify::user-passkeys')
        ->when(Fortify::canManagePasskeys())
        // Route is protected with current password
        ->middleware((is_array($pk) && $pk['confirmPassword'] ?? false) ? 'password.confirm' : [])
        ->name('passkey.index');
});