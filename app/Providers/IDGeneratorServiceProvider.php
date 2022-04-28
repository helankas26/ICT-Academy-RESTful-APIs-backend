<?php

namespace App\Providers;

use App\Services\Implementation\IDGeneratorQueryService;
use App\Services\Implementation\IDGeneratorService;
use Illuminate\Support\ServiceProvider;

class IDGeneratorServiceProvider extends ServiceProvider
{
    /**
     * All of the container singletons that should be registered.
     *
     * @var array
     */

    public $singletons = [
        IDGeneratorServiceInterface::class => IDGeneratorService::class,
        IDGeneratorQueryServiceInterface::class => IDGeneratorQueryService::class,
    ];


    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(IDGeneratorService::class, function ($app){
            $queryService = new IDGeneratorQueryService();

            return new IDGeneratorService($queryService);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
