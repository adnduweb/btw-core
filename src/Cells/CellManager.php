<?php

namespace Btw\Core\Cells;

class CellManager
{
    /**
     * Displays all cells that are currently specified in the config.
     */
    public function render()
    {
        $cellClasses = setting('Btw.cellsDashboard');

        if (! count($cellClasses)) {
            return;
        }

        foreach ($cellClasses as $alias) {
            [$class, $method] = explode('::', $alias);
            $class            = new $class();

            echo (string) $class->{$method}();
        }
    }
}
