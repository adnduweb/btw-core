<?php

/**
 * This file is part of Doudou.
 *
 * (c) Fabrice Loru <fabrice@adnduweb.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

 namespace Btw\Core\Libraries\DataTable;

/**
 * Class Manager
 *
 * The main class used to work with actions in the system.
 */
class ActionManager
{
    /**
     * A collection of actions currently known about.
     *
     * @var array
     */
    private $actions = [];

    /**
     * Creates a new action in the system.
     *
     * @return $this
     */
    public function createAction(string $name)
    {
        $this->actions[$name] = new Action();

        return $this;
    }

    /**
     * Returns the specified menu instance
     *
     * @return mixed
     */
    public function action(string $name)
    {
        if (! isset($this->actions[$name])) {
            $this->createAction($name);
        }

        return $this->actions[$name];
    }
}
