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
        if (Table::hasMacro('liveSelection')) {
            return;
        }

        $watchScriptBuilder = $this->watchScriptBuilder;

        Table::macro('liveSelection', function (bool $condition = true, string $livewireProperty = 'selectedTableRecords', ?string $livewireMethod = null) use ($watchScriptBuilder): Table {
            /** @var Table $this */
            if (! $condition) {
                return $this->currentSelectionLivewireProperty(null);
            }

            $watchScript = $watchScriptBuilder->build($livewireMethod);

            return $this
                ->currentSelectionLivewireProperty($livewireProperty)
                ->extraAttributes([
                    'x-init' => $watchScript,
                ], merge: true);
        });
    }
}
