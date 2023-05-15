<?php

namespace Btw\Core\Cells;

use RuntimeException;


class CheckBoxCell
{

    protected $type = 'checkbox';

    protected $label;

    protected $name;

    protected $value;

    protected $checkedNew;

    protected $class;

    protected $xInput;

    public function renderList($params)
    {
        if (!isset($params['label'])) {
            throw new RuntimeException('You must provide the Filter view cell with the model to use.');
        }

        $this->checkedNew = esc(set_value(str_replace(' ', '_', $params['name']), $params['checked'] ?? null), 'attr');
        $this->class = (isset($params['class'])) ? $params['class'] : '';
        $this->xInput = (isset($params['xInput'])) ? '@input="' . $params['xInput'] . '"' : '';

        $html = '<div class="flex items-center '.$this->class.'">';
        $html .= $this->getInput($params);
        $html .= $this->getLabel($params);
        $html .= '</div>';

        return $html;
    }

    public function getLabel($params)
    {
        $html = "";
        if (isset($params['lang']) && $params['lang'] == true) {
            $html .= '<label for="lang[' . request()->getLocale() . '][' . $params['name'] . ']" class="ml-3 block whitespace-nowrap text-sm font-medium text-gray-700 dark:text-gray-300"> ' . $params['label'] . ' </label>';
        } else {
            $html .= '<label for="' . $params['name'] . '" class="ml-3 block whitespace-nowrap text-sm font-medium text-gray-700 dark:text-gray-300"> ' . $params['label'] . ' </label>';
        }

        return $html;
    }

    public function getInput($params)
    {
        $isChecked = ( $this->checkedNew) ? 'checked' : '';

        $html = "";
        if (isset($params['lang']) && $params['lang'] == true) {
            $html .= '<input type="checkbox" ' .  $this->xInput . ' name="lang[' . request()->getLocale() . '][' . $params['name'] . ']" id="' . $params['name'] . '" autocomplete="text" value="' . $params['value'] . '" ' . $isChecked. ' class="rcheckbox checkbox-primary rounded ml-1 w-5 h-5 ease-linear transition-all duration-150 border border-gray-200 focus:bg-white focus:border-gray-500">';
        } else {
            $html .= '<input type="checkbox" ' .  $this->xInput . ' name="' . $params['name'] . '" id="' . $params['name']. '" autocomplete="text" value="' . $params['value'] . '" ' . $isChecked. ' class="rcheckbox checkbox-primary rounded ml-1 w-5 h-5 ease-linear transition-all duration-150 border border-gray-200 focus:bg-white focus:border-gray-500">';
        }

        if (isset($params['description'])) {
            $html .= '<p class="text-sm text-gray-500">' . $params['description'] . '</p>';
        }

        return $html;
    }

    public function getValidation($params)
    {

        $html = '';
        if (isset($params['lang']) && $params['lang'] == true) {

            if (service('validation')->hasError('lang.' . request()->getLocale() . '.' . uniforme($params['name']))) :
                // print_r($params['validation']); exit;
                $html = '<div class="invalid-feedback block text-red-600">';
                $html .= service('validation')->getError('lang.' . request()->getLocale() . '.' . uniforme($params['name']));
                $html .= '</div>';
            endif;
        } else {
            if (service('validation')->hasError(uniforme($params['name']))) :
                $html = '<div class="invalid-feedback block text-red-600">';
                $html .= service('validation')->getError(uniforme($params['name']));
                $html .= '</div>';
            endif;
        }
        return $html;
    }
}
