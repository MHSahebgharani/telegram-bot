<?php

namespace Telegram;

use Telegram\Commands\SetTelegramWebhook;
use Telegram\Helper\TelegramStrategyResolver;
use Telegram\Strategies\Base64MessageStrategy;
use Telegram\Strategies\FileMessageStrategy;
use Telegram\Strategies\PollMessageStrategy;
use Telegram\Strategies\TextMessageStrategy;
use Illuminate\Support\ServiceProvider;

class TelegramServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(TextMessageStrategy::class);
        $this->app->bind(FileMessageStrategy::class);
        $this->app->bind(Base64MessageStrategy::class);
        $this->app->bind(PollMessageStrategy::class);

        $this->app->singleton(TelegramStrategyResolver::class, function ($app) {
            return new TelegramStrategyResolver(
                $app->make(TextMessageStrategy::class),
                $app->make(FileMessageStrategy::class),
                $app->make(PollMessageStrategy::class),
                $app->make(Base64MessageStrategy::class),
            );
        });
    }

    public function boot()
    {
        $this->loadRoutesFrom(app_path('Modules/Telegram/Http/routes.php'));
        if ($this->app->runningInConsole()) {
            $this->commands([
                SetTelegramWebhook::class,
            ]);
        }
    }
}

