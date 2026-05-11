<?php

namespace Xentixar\DynamicTable\Support;

class LiveSelectionWatchScriptBuilder
{
    public function build(?string $livewireMethod = null): string
    {
        $callback = $this->buildCallback($livewireMethod);

        return str_replace(
            '__CALLBACK__',
            $callback,
            <<<'JS'
                $watch(
                    () => JSON.stringify([
                        [...selectedRecords],
                        [...deselectedRecords],
                        isTrackingDeselectedRecords,
                    ]),
                    () => __CALLBACK__,
                )
            JS,
        );
    }

    protected function buildCallback(?string $livewireMethod = null): string
    {
        if ($livewireMethod === null || $livewireMethod === '') {
            return '$wire.$refresh()';
        }

        return "\$wire.\$call('{$livewireMethod}', [...selectedRecords], [...deselectedRecords], isTrackingDeselectedRecords)";
    }
}
