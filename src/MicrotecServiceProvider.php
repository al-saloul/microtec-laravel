<?php

namespace Alsaloul\Microtec;

use Illuminate\Support\ServiceProvider;

class MicrotecServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Merge config
        $this->mergeConfigFrom(__DIR__ . '/../config/microtec.php', 'microtec');
    }

    public function boot()
    {
        // Publish config
        $this->publishes([
            __DIR__ . '/../config/microtec.php' => config_path('microtec.php'),
        ]);
    }
}
