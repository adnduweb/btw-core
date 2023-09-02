<?php

namespace Btw\Core\Libraries;

class SearchManager
{
    /**
     * Displays all cells that are currently specified in the config.
     */
    public function render()
    {
        $cellClasses = setting('Search.cellsearch');

        if (! count($cellClasses)) {
            return;
        }

        foreach ($cellClasses as $alias) {
            [$class, $method] = explode('::', $alias);
            $class            = new $class();

            //var_dump($class->{$method}()); exit;

            echo (string) $class->{$method}();
        }
    }
}