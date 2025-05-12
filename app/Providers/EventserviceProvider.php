<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Stephenjude\FilamentTwoFactorAuthentication\Events\{
    RecoveryCodeReplaced,
    RecoveryCodesGenerated,
    TwoFactorAuthenticationChallenged,
    TwoFactorAuthenticationConfirmed,
    TwoFactorAuthenticationDisabled,
    TwoFactorAuthenticationEnabled,
    TwoFactorAuthenticationFailed,
    ValidTwoFactorAuthenticationCodeProvided
};

class EventserviceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        TwoFactorAuthenticationChallenged::class => [
            // Add your listeners here
        ],
        TwoFactorAuthenticationFailed::class => [
            // Add your listeners here
        ],
        ValidTwoFactorAuthenticationCodeProvided::class => [
            // Add your listeners here
        ],
        TwoFactorAuthenticationConfirmed::class => [
            // Add your listeners here
        ],
        TwoFactorAuthenticationEnabled::class => [
            // Add your listeners here
        ],
        TwoFactorAuthenticationDisabled::class => [
            // Add your listeners here
        ],
        RecoveryCodeReplaced::class => [
            // Add your listeners here
        ],
        RecoveryCodesGenerated::class => [
            // Add your listeners here
        ],
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}