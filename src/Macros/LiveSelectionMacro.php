<?php

namespace Xentixar\DynamicTable\Macros;

use Filament\Tables\Table;
use Xentixar\DynamicTable\Contracts\TableMacro;
use Xentixar\DynamicTable\Support\LiveSelectionWatchScriptBuilder;

class LiveSelectionMacro implements TableMacro
{
    public function __construct(
        protected LiveSelectionWatchScriptBuilder $watchScriptBuilder,
    ) {
    }

    public function register(): void
    {
        $this->registerForTableClass(Table::class);
        $this->registerForTableClass('Archilex\\AdvancedTables\\Filament\\Table');
    }

    protected function registerForTableClass(string $tableClass): void
    {
        if (! class_exists($tableClass)) {
            return;
        }

        if (! method_exists($tableClass, 'hasMacro') || ! method_exists($tableClass, 'macro')) {
            return;
        }

        if ($tableClass::hasMacro('liveSelection')) {
            return;
        }

        $watchScriptBuilder = $this->watchScriptBuilder;

        $tableClass::macro('liveSelection', function (bool $condition = true, string $livewireProperty = 'selectedTableRecords', ?string $livewireMethod = null) use ($watchScriptBuilder) {
            $setSelectionProperty = 'currentSelectionLivewireProperty';

            if (! method_exists($this, $setSelectionProperty)) {
                return $this;
            }

            if (! $condition) {
                return $this->{$setSelectionProperty}(null);
            }

            $watchScript = $watchScriptBuilder->build($livewireMethod);

            return $this
                ->{$setSelectionProperty}($livewireProperty)
                ->extraAttributes([
                    'x-init' => $watchScript,
                ], merge: true);
        });
    }
}
