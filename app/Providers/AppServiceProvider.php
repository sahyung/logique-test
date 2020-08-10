<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Carbon;
use CreditCard;
use Validator;

class AppServiceProvider extends ServiceProvider
{
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
        Validator::extend('alpha_spaces', function ($attribute, $value) {
            // This will only accept alpha and spaces. 
            // If you want to accept hyphens use: /^[\pL\s-]+$/u.
            return preg_match('/^[\pL\s]+$/u', $value); 
        });

        Validator::extend('check_address', function ($attribute, $value) {
            return preg_match('/^(?:\\d+ [a-zA-Z ]+, ){2}[a-zA-Z ]+$/', $value);
        });

        Validator::extend('cc_number', function ($attribute, $value) {
            return CreditCard::validCreditCard($value)['valid'];
        });

        Validator::extend('cc_expiry', function ($attribute, $value) {
            $expiry = Carbon::createFromFormat('m-y', $value);
            return CreditCard::validDate($expiry->year, $expiry->month);
        });
    }
}
