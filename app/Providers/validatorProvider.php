<?php
namespace App\Providers;
use Validator;

use Illuminate\Support\ServiceProvider;

class validatorProvider extends ServiceProvider
{
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
        validator::extend('foo', function($attribute, $value, $parameters, $validator){
            return $value=='foo';
        });
    }
}
