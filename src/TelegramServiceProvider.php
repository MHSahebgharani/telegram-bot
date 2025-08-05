<?php

namespace Telegram;

use Telegram\Commands\SetTelegramWebhook;
use Telegram\Contracts\TelegramHandlerInterface;
use Telegram\Dispatchers\TelegramHandlerRegistry;
use Telegram\Handlers\Commands\StartCommandHandler;
use Telegram\Helper\TelegramStrategyResolver;
use Telegram\Strategies\Base64MessageStrategy;
use Telegram\Strategies\CallbackMessageStrategy;
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
        $this->app->bind(CallbackMessageStrategy::class);

        $this->app->singleton(TelegramStrategyResolver::class, function ($app) {
            return new TelegramStrategyResolver(
                $app->make(TextMessageStrategy::class),
                $app->make(FileMessageStrategy::class),
                $app->make(PollMessageStrategy::class),
                $app->make(Base64MessageStrategy::class),
                $app->make(CallbackMessageStrategy::class),
            );
        });
        $this->app->singleton(TelegramHandlerRegistry::class, function ($app) {
            $registry = new TelegramHandlerRegistry();

            foreach ($this->discoverHandlers() as $handlerClass) {
                $registry->register($app->make($handlerClass));
            }

            return $registry;
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

    protected function discoverHandlers(): array
    {
        $paths = config('telegram.commands', []); // user-defined handler class paths

        return collect($paths)
            ->filter(fn ($class) => class_exists($class) && is_subclass_of($class, TelegramHandlerInterface::class))
            ->values()
            ->all();
    }
}

