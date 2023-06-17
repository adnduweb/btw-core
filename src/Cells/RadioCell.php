<?php

namespace Btw\Core\Cells;

use RuntimeException;


class RadioCell
{

    protected $type = 'text';

    protected $label;

    protected $name;

    protected $value;

    protected $checkedNew;

    public function renderList($params)
    {
        if (!isset($params['label'])) {
            throw new RuntimeException('You must provide the Filter view cell with the model to use.');
        }

        $html = '<div class="flex items-center">';
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
        $isChecked = ( $params['checked']) ? 'checked' : '';

        $html = "";
        if (isset($params['lang']) && $params['lang'] == true) {
            $html .= '<input type="radio" name="lang[' . request()->getLocale() . '][' . $params['name'] . ']" id="' . uniforme($params['name']) . '" autocomplete="text" value="' . $params['value'] . '" ' . $isChecked. ' class="radio radio-primary ml-1 w-5 h-5 ease-linear transition-all duration-150">';
        } else {
            $html .= '<input type="radio" name="' . $params['name'] . '" id="' . uniforme($params['name']) . '" autocomplete="text" value="' . $params['value'] . '" ' . $isChecked. ' class="radio radio-primary ml-1 w-5 h-5 ease-linear transition-all duration-150">';
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
