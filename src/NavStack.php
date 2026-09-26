<?php

namespace Codewiser\Fortify;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Traits\Conditionable;
use Laravel\Fortify\Features;

class NavStack implements Arrayable
{
    use Conditionable;

    protected array $stack = [];

    public function __construct()
    {
        $this->when(auth()->user(),
            // Auth
            fn(self $stack, Authenticatable $user) => $stack
                ->when(Features::canUpdateProfileInformation(), fn(self $stack) => $stack
                    ->push('user-profile-information.show', __('Profile information'))
                )
                ->when(Features::canUpdatePasswords(), fn(self $stack) => $stack
                    ->push('user-password.show', __('Password'))
                )
                ->when(Features::canManageTwoFactorAuthentication(), fn(self $stack) => $stack
                    ->push('two-factor.show', __('Two-factor authentication'))
                )
                ->when(Features::canManagePasskeys(), fn(self $stack) => $stack
                    ->push('user-passkey.index', __('Passkeys'))
                )
                ->when(fn() => $user instanceof MustVerifyEmail && ! $user->hasVerifiedEmail(),
                    fn(self $stack) => $stack
                        ->push('verification.notice', __('Email Verification'))
                ),
            // Guest
            fn(self $stack) => $stack
                ->push('login', __('Sign In'))
                ->when(Features::enabled(Features::registration()), fn(self $stack) => $stack
                    ->push('register', __('Sign Up'))
                )
                ->when(Features::enabled(Features::resetPasswords()), fn(self $stack) => $stack
                    ->push('password.request', __('Password reset'))
                )
        );
    }

    public function push(string $route, string $name, ?int $index = null): static
    {
        $payload = [
            'route' => $route,
            'name'  => $name
        ];

        if ($index === null || $index >= count($this->stack)) {
            $this->stack[] = $payload;
        } else {
            $this->stack = array_merge(
                array_slice($this->stack, 0, $index),
                [$payload],
                array_slice($this->stack, $index)
            );
        }

        return $this;
    }

    /**
     * @return array<int, array{name: string, route: string}>
     */
    public function toArray(): array
    {
        return $this->stack;
    }
}