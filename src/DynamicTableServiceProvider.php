<?php

namespace Xentixar\DynamicTable;

use Illuminate\Support\ServiceProvider;
use Xentixar\DynamicTable\Macros\LiveSelectionMacro;

class DynamicTableServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(TableMacroRegistrar::class, function () {
            return new TableMacroRegistrar([
                $this->app->make(LiveSelectionMacro::class),
            ]);
        });
    }

    public function boot(): void
    {
        $this->app->make(TableMacroRegistrar::class)->register();
    }
}
