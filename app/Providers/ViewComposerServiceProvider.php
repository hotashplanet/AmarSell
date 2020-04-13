<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Http\View\Composers\CartComposer;
use App\Http\View\Composers\Admin\HeaderComposer;
use App\Http\View\Composers\Admin\SidebarComposer as AdminSidebarComposer;
use App\Http\View\Composers\Reseller\SidebarComposer as ResellerSidebarComposer;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // View::composer(['layouts.*', 'reseller.shop.header'], HeaderComposer::class);
        View::composer(['admin.*'], AdminSidebarComposer::class);
        View::composer(['reseller.*'], ResellerSidebarComposer::class);
        View::composer(['reseller.shop.partials.mini-cart', 'reseller.checkout.*', 'reseller.cart.index', 'reseller.checkout.partials.confirm'], CartComposer::class);
    }
}
