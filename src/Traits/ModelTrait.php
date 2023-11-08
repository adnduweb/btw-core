<?php

namespace Btw\Core\Traits;

use RuntimeException;

trait ModelTrait
{
    /**
     * Add related tables to load along with the next finder.
     *
     * @param mixed $with      Table name, array of table names, or false (to disable)
     * @param bool  $overwrite Whether to merge with existing table 'with' list
     *
     * @return $this
     */
    public function withAskAuth()
    {

        $this->tmpWithAskAuth = true;

        return $this;
    }

    /**
    * Add related tables to load along with the next finder.
    *
    * @param mixed $with      Table name, array of table names, or false (to disable)
    * @param bool  $overwrite Whether to merge with existing table 'with' list
    *
    * @return $this
    */
    public function withLang()
    {

        $this->tmpWithLang = true;

        return $this;
    }


    //--------------------------------------------------------------------
    /**
     * Works with the current Query Builder instance to return
     * all results, while optionally limiting them.
     *
     * @return array|null
     */
    public function findAll(int $limit = 0, int $offset = 0)
    {
        $data = parent::findAll($limit, $offset);

        if ($this->tmpWithAskAuth) {
            return $this->withAuthSession($data);
        }

        return $data;
    }

    /**
    * Returns the first row of the result set. Will take any previous
    * Query Builder calls into account when determining the result set.
    *
    * @return array|object|null
    */
    public function first()
    {
        $data = parent::first();

        if ($this->tmpWithAskAuth) {
            return $this->withAuthSessionSingle($data);
        }

        return $data;
    }


    /**
     * Intercepts data from a finder and injects related items
     *
     * @param array $rows Array of rows from the finder
     *
     * @return array
     */
    protected function withAuthSession($rows): ?array
    {
        // Harvest the IDs that want relations
        $ids = array_column($rows, $this->primaryKey);

        // Inject related items back into the rows
        $return = [];

        foreach ($rows as $item) {
            $item->confirm_auth_content = $item->getAskAuthContent($this->getController());
            $return[] = $item;
            $item->syncOriginal();

        }

        // Clear old data and reset per-query properties
        unset($rows);

        return $return;
    }

    /**
     * Intercepts data from a finder and injects related items
     *
     * @param array $rows Array of rows from the finder
     *
     * @return array
     */
    protected function withAuthSessionSingle($row)
    {

        // Inject related items back into the row
        $row->confirm_auth_content = $row->getAskAuthContent($this->getController());
        $return = $row;
        $row->syncOriginal();

        // Clear old data and reset per-query properties
        unset($row);

        return $return;
    }

    protected function getController(): string
    {
        $controllerName = service('router')->controllerName();
        $handle = explode('\\', $controllerName);
        $end = end($handle);
        return strtolower(str_replace('Controller', '', $end));
    }
}
