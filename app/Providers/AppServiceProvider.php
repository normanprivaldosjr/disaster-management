<?php

namespace App\Providers;

use App\GraphQL\Resolvers\SocialUserResolver;
use Coderello\SocialGrant\Resolvers\SocialUserResolverInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    /**
     * All of the container bindings that should be registered.
     *
     * @var array
     */
    public $bindings = [
        SocialUserResolverInterface::class => SocialUserResolver::class,
    ];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Load migrations with sub directory
        $migration_path = database_path('migrations');
        $sub_directories = glob($migration_path . '/*', GLOB_ONLYDIR);
        $paths = array_merge([$migration_path], $sub_directories);

        $this->loadMigrationsFrom($paths);
    }
}
