<?php

namespace Gordyush\Records;

use Illuminate\Support\ServiceProvider;
use Gordyush\Records\Services\Records\Records;

class RecordsServiceProvider extends ServiceProvider
{
    public function register()
    {
        if ($this->app->config->get('records') === null) {
            $this->app->config->set('records', require __DIR__
                .'/config/records.php');
        }

        $this->app->bind(Records::class);
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/records.php' => config_path('records.php'),
        ]);
    }

}
