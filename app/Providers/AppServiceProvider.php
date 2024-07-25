<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace App\Providers;

use Illuminate\Foundation\Console\AboutCommand;
use Illuminate\Support\ServiceProvider;

/**
 * \App\Providers\AppServiceProvider
 */
class AppServiceProvider extends ServiceProvider
{
    public const VERSION = '73.0.0';

    protected string $package = 'site-api-angular';

    /**
     * Register any application services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->about();
    }

    public function about(): void
    {
        /**
         * @var class-string $auth_providers_users_model
         */
        $auth_providers_users_model = config('auth.providers.users.model');

        AboutCommand::add('Environment', fn () => [
            '<fg=cyan;options=bold>User</> [auth.providers.users.model]' => sprintf('[%s]', is_string($auth_providers_users_model) ? $auth_providers_users_model : ''),
            'Package' => $this->package,
            'Application Version' => AppServiceProvider::VERSION,
        ]);
    }
}
