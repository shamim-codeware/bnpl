<?php 


namespace App\Repositories;

use Illuminate\Support\ServiceProvider;


class EnquryRepoServiceProvide extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        
    }


    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Repositories\EnquiryInterface', 'App\Repositories\EnquryRepository');
    }
}