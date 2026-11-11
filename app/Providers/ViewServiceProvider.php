<?php

namespace App\Providers;

use App\View\Composers\AppLayoutComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        View::composer(['layouts.app', 'home', 'ui-kit'], AppLayoutComposer::class);
    }
}
