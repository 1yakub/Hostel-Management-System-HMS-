<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class AppLayoutServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Blade::component('layouts.app', 'app-layout');
    }
}
