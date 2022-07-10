<?php

namespace Nodus\Packages\OpenApiGenerator;

use Illuminate\Support\ServiceProvider;

class OpenApiGeneratorServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/openapi-generator.php', 'openapi-generator');
    }
}
