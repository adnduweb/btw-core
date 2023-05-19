<?php

namespace Btw\Core\Cells;

use RuntimeException;


class SwitchCell
{
    protected $label;

    protected $name;

    protected $value;

    protected $checkedNew;

    protected $xOnClick;

    protected $xChange;

    protected $xInput;

    protected $class;

    protected $xOn;

    protected $xNotData;

    /** HTMX get */
    protected $hxGet;

    /** HTMX swap */
    protected $hxSwap;

    protected $disabled;

    public function renderList($params)
    {
        if (!isset($params['label'])) {
            throw new RuntimeException('You must provide the Filter view cell with the model to use.');
        }

        $html = "";


        $this->checkedNew = $params['checked'] == false ? 'false' : 'true';        

        if (request()->is('json')) {
            $requestOld = request()->getJSON(true);
            if (isset($requestOld[$params['name']]) && $requestOld[$params['name']] == true) {
                $this->checkedNew = 'true';
            }
        }
        
        $this->value = (!empty($params['value'])) ? $params['value'] : true;
        $this->xOnClick = (isset($params['xOnClick'])) ? 'x-on:click="' . $params['xOnClick'] . '"' : false;
        $this->xChange = (isset($params['xChange'])) ? '@change="' . $params['xChange'] . '"' : false;
        $this->xInput = (isset($params['xInput'])) ? '@input="' . $params['xInput'] . '"' : '';
        $this->class = (isset($params['class'])) ? $params['class'] : '';
        $this->xOn = (isset($params['xOn'])) ? $params['xOn'] : 'on';
        $this->xNotData = (isset($params['xNotData'])) ? '' : 'x-data="{' . $this->xOn . ': ' . $this->checkedNew . '}"';
        $this->hxGet = (isset($params['hxGet'])) ? 'hx-get="' . $params['hxGet'] . '"' : '';
        $this->hxSwap = (isset($params['hxSwap'])) ? 'hx-swap="' . $params['hxSwap'] . '"' : '';
        $this->disabled = (isset($params['disabled']) && $params['disabled'] == true) ? 'disabled="disabled"' : false;
        $disabledClass = (isset($params['disabled']) && $params['disabled'] == true) ? 'bg-gray-100 dark:bg-gray-300' : 'bg-gray-400 dark:bg-gray-700';

        $html .= '<div class="flex items-center ' . $this->class . '">';
        $html .= '<button ' . $this->disabled . ' type="button" class="button-switch relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-slate-600 focus:ring-offset-2 bg-slate-100" ' . $this->xNotData . '  role="switch" aria-checked="true" :aria-checked="' . $this->xOn . '.toString()" @click="' . $this->xOn . ' = !' . $this->xOn . '" x-state:on="Enabled" x-state:off="Not Enabled" :class="{ \' ' . $disabledClass . ' \': ' . $this->xOn . ',\'bg-slate-100\': !(' . $this->xOn . ') }" ' . $this->xOnClick . ' ' . $this->xChange . ' ' . $this->hxGet . ' ' . $this->hxSwap . ' >';
        $html .= '<span class="sr-only">Use setting</span>';
        $html .= $this->getInput($params);
        $html .= '<span class="pointer-events-none relative inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out translate-x-5" x-state:on="Enabled" x-state:off="Not Enabled" :class="{ \'translate-x-5\': ' . $this->xOn . ', \'translate-x-0\': !(' . $this->xOn . ') }">';
        $html .= '<span class="absolute inset-0 flex h-full w-full items-center justify-center transition-opacity opacity-0 duration-100 ease-out" aria-hidden="true" x-state:on="Enabled" x-state:off="Not Enabled" :class="{ \'opacity-0 duration-100 ease-out\': ' . $this->xOn . ', \'opacity-100 duration-200 ease-in\': !(' . $this->xOn . ') }">';
        $html .= '<svg class="h-3 w-3 text-gray-400" fill="none" viewBox="0 0 12 12">';
        $html .= '<path d="M4 8l2-2m0 0l2-2M6 6L4 4m2 2l2 2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>';
        $html .= '</svg>';
        $html .= '</span>';
        $html .= '<span class="absolute inset-0 flex h-full w-full items-center justify-center transition-opacity opacity-100 duration-200 ease-in" aria-hidden="true" x-state:on="Enabled" x-state:off="Not Enabled" :class="{ \'opacity-100 duration-200 ease-in\': ' . $this->xOn . ', \'opacity-0 duration-100 ease-out\': !(' . $this->xOn . ') }">';
        $html .= '<svg class="h-3 w-3 text-slate-600" fill="currentColor" viewBox="0 0 12 12">';
        $html .= '<path d="M3.707 5.293a1 1 0 00-1.414 1.414l1.414-1.414zM5 8l-.707.707a1 1 0 001.414 0L5 8zm4.707-3.293a1 1 0 00-1.414-1.414l1.414 1.414zm-7.414 2l2 2 1.414-1.414-2-2-1.414 1.414zm3.414 2l4-4-1.414-1.414-4 4 1.414 1.414z"></path>';
        $html .= '</svg>';
        $html .= '</span>';
        $html .= ' </span>';
        $html .= ' </button>';
        $html .= $this->getLabel($params);
        $html .= '</div>';

        if (isset($params['description'])) {
            $html .= ' <p class="mt-2 text-sm text-gray-500">' . $params['description'] . '</p>';
        }

        $html .= $this->getValidation($params);

        return $html;
    }

    public function getLabel($params)
    {
        $html = "";
        $html .= '<label @click="$refs.toggle.click(); $refs.toggle.focus()" :id="$id(\'toggle-label\')" class="text-gray-900 dark:text-white font-medium ml-3">';
        $html .= $params['label'];
        $html .= '</label>';

        return $html;
    }

    public function getInput($params)
    {

        $html = "";
        $html = '<input type="checkbox" id="toggle" name="' . $params['name'] . '" x-model="' . $this->xOn . '" value="' . $this->value . '" class="hidden appearance-none w-full h-full active:outline-none focus:outline-none" />';
        return $html;
    }

    public function getValidation($params)
    {

        $html = '';
        if (isset($params['lang']) && $params['lang'] == true) {

            if (service('validation')->hasError('lang.' . request()->getLocale() . '.' . uniforme($params['name']))):
                // print_r($params['validation']); exit;
                $html = '<div class="invalid-feedback block text-red-600">';
                $html .= service('validation')->getError('lang.' . request()->getLocale() . '.' . uniforme($params['name']));
                $html .= '</div>';
            endif;
        } else {
            if (service('validation')->hasError(uniforme($params['name']))):
                $html = '<div class="invalid-feedback block text-red-600">';
                $html .= service('validation')->getError(uniforme($params['name']));
                $html .= '</div>';
            endif;
        }
        return $html;
    }
}