<?php

use Btw\Core\View\Component;

/**
 * Class SidebarComponent
 *
 * Uses the MenuManager to get the registered menu items
 * and render out the sidebar.
 */
class MessageComponent extends Component
{
    protected $listeners = ['show' => 'setFlash'];
    public $alertTypeClasses = [
        'success' => ' bg-green-500 text-white',
        'warning' => ' bg-orange-500 text-white',
        'danger' => ' bg-red-500 text-white',
        'info' => ' bg-blue-500 text-white'
    ];

    public $message = 'Notification Message';
    public $alertType = 'success';

    public function setFlash($message, $alertType)
    {
        $this->message = $message;
        $this->alertType = $alertType;

        // $this->dispatchBrowserEvent('flash');
    }

    public function render(): string
    {
        return $this->renderView($this->view, []);
    }
}
