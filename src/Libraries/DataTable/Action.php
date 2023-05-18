<?php 
namespace Btw\Core\Libraries\DataTable;

class Action {

    /**
     * Holds all items/collections that appear
     * at top level in this menu.
     *
     * @var array
     */
    protected $actions = [];

    public function __construct(?array $data = null)
    {
        if (!is_array($data)) {
            return;
        }

        foreach ($data as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (method_exists($this, $method)) {
                $this->{$method}($value);
            }
        }
    }

    /**
     * Returns all items/collections in the menu.
     *
     * @return array
     */
    public function actions()
    {
        return $this->actions;
    }

    /**
     * Adds a new item
     *
     * @return $this
     */
    public function addItem(ActionItem $action)
    {
        $this->actions = $action;

        return $this;
    }

}

