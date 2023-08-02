<?php

namespace Btw\Core\Libraries;

class SearchManager
{
    /**
     * Displays all cells that are currently specified in the config.
     */
    public function render()
    {
        $cellClasses = setting('Btw.cellsearch');

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