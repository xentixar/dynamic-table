<?php

namespace Xentixar\DynamicTable;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\Tables\Table;

class DynamicTable implements Plugin
{
    public static function make(): static
    {
        return app(static::class);
    }

    public function getId(): string
    {
        return 'dynamic-table';
    }

    public function register(Panel $panel): void
    {
        $panel->resources([
            //
        ]);
    }

    public function boot(Panel $panel): void
    {
        //
    }
}