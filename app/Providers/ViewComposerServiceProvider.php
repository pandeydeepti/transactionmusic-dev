<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\ShopOption;
use App\Page;
class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->composeNavigation();
        $this->composePayPalValidation();
        $this->composeAdminNavigation();
        $this->composeFooter();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    private function composeFooter()
    {
        view()->composer(['includes.footer'], function ($view) {
            $view->with('google_analytics', ShopOption::where('meta_key', 'google_analytics')->first()['meta_value']);
            $view->with('terms_policies', Page::where('id', 1)->where('active', 1)->first());
        });
    }

    private function composeNavigation()
    {
        view()->composer(['includes.navbar', 'includes.footer'], function ($view) {
            $view->with('pages', Page::where('active', 1)->where('type', 'page')->orderBy('order', 'ASC')->get() );
            $view->with('logo', ShopOption::where('meta_key', 'logo_path')->first()['meta_value']);
            $view->with('faqs', Page::where('type', 'faq')->avg('active') );
            $view->with('terms_policies', Page::where('id', 1)->where('active', 1)->first() );
        });
    }

    private function composeAdminNavigation()
    {
        view()->composer(['includes.admin.navbar', 'email.beats-email'], function ($view) {
            $view->with('logo', ShopOption::where('meta_key', 'logo_path')->first()['meta_value']);
        });
    }

    private function composePayPalValidation()
    {
        view()->composer(['layouts.admin'], function ($view) {
            $view->with('paypal_email', ShopOption::where('meta_key', 'paypal_email')->first()['meta_value'] );
        });
    }
}
