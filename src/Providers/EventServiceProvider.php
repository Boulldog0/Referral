<?php

namespace Azuriom\Plugin\Referral\Providers;

use Azuriom\Plugin\Referral\Listeners\ShopBuyListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Mail\Events\MessageSending;
use Azuriom\Plugin\Referral\Listeners\RedirectAfterRegistration;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Registered::class => [
            RedirectAfterRegistration::class,
        ],
        MessageSending::class => [
            ShopBuyListener::class,
        ]
    ];
}
