<?php

namespace Kukocrunch\Qrtosheets;

use Illuminate\Support\ServiceProvider;

class QrtosheetsServiceProvider extends ServiceProvider
{


    public function boot()
    {

        //Load Views
        $this->loadViewsFrom(__DIR__.'/../src/resources/views', 'qrtosheets');

        //Load Config
        $this->publishes([
            __DIR__.'/../src/config/qrtosheets.php' => config_path('qrtosheets.php'),
        ]);
        
        //Load Routes
        $this->loadRoutesFrom(__DIR__.'/../src/routes/web.php');
    }



    public function register()
    {

    }


}