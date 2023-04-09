<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class CustomValidationServiceProvider extends ServiceProvider
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
    public function boot()
    {
        Validator::extend('phone', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^(01)\d{9}$/', $value);
        });



        Validator::replacer('phone', function ($message, $attribute, $rule, $parameters) {
            return str_replace(':attribute', $attribute, 'The ' . $attribute . ' field is not a valid phone number.');
        });
    }

}
