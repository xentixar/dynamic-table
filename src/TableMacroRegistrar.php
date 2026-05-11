<?php

namespace Xentixar\DynamicTable;

use Xentixar\DynamicTable\Contracts\TableMacro;

class TableMacroRegistrar
{
    /**
     * @param  iterable<TableMacro>  $macros
     */
    public function __construct(
        protected iterable $macros,
    ) {
    }

    public function register(): void
    {
        foreach ($this->macros as $macro) {
            $macro->register();
        }
    }
}
