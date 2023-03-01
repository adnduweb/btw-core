<?php

use Btw\Core\View\Component;

/**
 * Class SidebarComponent
 *
 * Uses the MenuManager to get the registered menu items
 * and render out the sidebar.
 */
class ButtonComponent extends Component
{

    protected $viewData = [];

    public function render() : string
    {
        $data = [
            'server' => time()
        ];
        $this->viewData  = array_merge($data, $this->data);
        return $this->renderView($this->view, $this->viewData);
    }
}
