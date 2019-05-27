<?php
namespace App\Providers;
use App\Repositories\Eloquent\ProductRepository;
use Illuminate\Support\ServiceProvider;

class ProductRepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            'App\Repositories\Contracts\ProductRepositoryInterface'
            // To change the data source, replace this class name
            // with another implementation

        );

        $this->app->bind('App\Repositories\Eloquent\ProductRepository', function ($app) {
            return new ProductRepository();
        });




    }
}