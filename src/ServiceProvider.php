<?php

namespace Kolirt\Telegram;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Kolirt\Telegram\Config\Config;
use Kolirt\Telegram\ConsoleCommands\Bot\BotCreateConsoleCommand;
use Kolirt\Telegram\ConsoleCommands\Bot\BotDeleteCommandsConsoleCommand;
use Kolirt\Telegram\ConsoleCommands\Bot\BotSetWebhookConsoleCommand;
use Kolirt\Telegram\ConsoleCommands\Bot\BotUpdateCommandsConsoleCommand;
use Kolirt\Telegram\ConsoleCommands\GenerateMetaConsoleCommand;
use Kolirt\Telegram\ConsoleCommands\Initial\InstallConsoleCommand;
use Kolirt\Telegram\ConsoleCommands\Initial\PublishCommandsConsoleCommand;
use Kolirt\Telegram\ConsoleCommands\Initial\PublishConfigConsoleCommand;
use Kolirt\Telegram\ConsoleCommands\Initial\PublishMigrationsConsoleCommand;
use Kolirt\Telegram\ConsoleCommands\Initial\PublishRoutesConsoleCommand;
use Kolirt\Telegram\ConsoleCommands\ServeConsoleCommand;

class ServiceProvider extends BaseServiceProvider
{

    protected array $commands = [
        BotCreateConsoleCommand::class,
        BotDeleteCommandsConsoleCommand::class,
        BotUpdateCommandsConsoleCommand::class,
        BotSetWebhookConsoleCommand::class,

        InstallConsoleCommand::class,
        PublishCommandsConsoleCommand::class,
        PublishConfigConsoleCommand::class,
        PublishMigrationsConsoleCommand::class,
        PublishRoutesConsoleCommand::class,

        GenerateMetaConsoleCommand::class,
        ServeConsoleCommand::class
    ];

    public function boot(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/telegram.php', 'telegram');

        $this->loadRoutes();
        $this->publishFiles();
    }

    public function register(): void
    {
        $this->commands($this->commands);

        $this->app->singleton('telegram-config', function (Application $app) {
            $config = new Config;
            $config->load();
            return $config;
        });
    }

    private function loadRoutes(): void
    {
        Route::middleware('api')
            ->domain(config('telegram.domain'))
            ->any(config('telegram.webhook_path'), [TelegramController::class, 'index']);
    }

    private function publishFiles(): void
    {
        $this->publishes([
            __DIR__ . '/../stubs/telegram/test.php.stub' => base_path('telegram/test.php')
        ], 'routes');

        $this->publishes([
            __DIR__ . '/../stubs/app/Http/Telegram/Commands/StartCommand.php.stub' => app_path('Http/Telegram/Commands/StartCommand.php'),
            __DIR__ . '/../stubs/app/Http/Telegram/Commands/InfoCommand.php.stub' => app_path('Http/Telegram/Commands/InfoCommand.php'),
            __DIR__ . '/../stubs/app/Http/Telegram/Commands/TestCommand.php.stub' => app_path('Http/Telegram/Commands/TestCommand.php'),
        ], 'commands');

        $this->publishes([
            __DIR__ . '/../stubs/app/Http/Telegram/Controllers/HomeController.php.stub' => app_path('Http/Telegram/Controllers/HomeController.php'),
            __DIR__ . '/../stubs/app/Http/Telegram/Controllers/Button1Controller.php.stub' => app_path('Http/Telegram/Controllers/Button1Controller.php'),
            __DIR__ . '/../stubs/app/Http/Telegram/Controllers/Button2Controller.php.stub' => app_path('Http/Telegram/Controllers/Button2Controller.php'),
            __DIR__ . '/../stubs/app/Http/Telegram/Controllers/Button3Controller.php.stub' => app_path('Http/Telegram/Controllers/Button3Controller.php'),
        ], 'controllers');

        $this->publishes([
            __DIR__ . '/../config/telegram.php' => config_path('telegram.php')
        ], 'config');

        $this->publishesMigrations([
            __DIR__ . '/../database/migrations' => database_path('migrations')
        ], 'migrations');
    }
}
