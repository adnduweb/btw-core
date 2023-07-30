<?php

/**
 * This file is part of Doudou.
 *
 * (c) Fabrice Loru <fabrice@adnduweb.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Btw\Core\Cells;

use RuntimeException;

class DropdownCell
{

    protected $options;
    protected $class;
    protected $label;
    protected $ktData;
    protected $placeholder;
    protected $dataSelect;
    protected $identifier;
    protected $valueSelect;
    protected $value;
    protected $name;
    protected $classError = 'border-transparent';
    protected $key;
    protected $val;
    protected $addButton;
     protected $required;


    /**
     * A view cell that displays the list of available filters.
     *
     * @param mixed $params
     *
     * @throws RuntimeException
     */
    public function renderList($params = [])
    {
        if (!isset($params['options'])) {
            throw new RuntimeException('You must provide the Select view cell with the options to use.');
        }

      
        $this->class = (isset($params['class'])) ? $params['class'] : false;
        $this->label = (isset($params['label'])) ? $params['label'] : false;
        $this->ktData = (isset($params['ktData'])) ? $params['ktData'] : false;
        $this->placeholder = (isset($params['placeholder'])) ? $params['placeholder'] : null;
        $this->options = (isset($params['options'])) ? $params['options'] : null;
        $this->identifier = (isset($params['identifier'])) ? $params['identifier'] : null;
        $this->valueSelect = (isset($params['valueSelect'])) ? $params['valueSelect'] : null;
        $this->value = (isset($params['value'])) ? $params['value'] : null;
        $this->name = (isset($params['name'])) ? $params['name'] : null;
        $this->key = (isset($params['key'])) ? $params['key'] : null;
        $this->val = (isset($params['val'])) ? $params['val'] : null;
        $this->addButton = (isset($params['addButton'])) ? $params['addButton'] : null;
         $this->required = (isset($params['required'])) ? 'required' : '';
        


        if (isset($params['lang']) && $params['lang'] == true) {
            if (service('validation')->hasError('lang.' . service('language')->getLocale() . '.' . uniforme($params['name']))) :
                $this->classError = "border-red-500 focus:border-red-500";
            endif;
        } else {
            if (service('validation')->hasError($params['name'])) :
                $this->classError = "border-red-500 focus:border-red-500";
            endif;
        }

        $html = "";
        $required = ($this->required) ? '<sup class="text-red-600">*</sup>' : '';
        $html .= "<div x-data=\"initSelect2Alpine()\" x-init=\"init()\">";
        if ($this->label == true)
            $html .= '<label for="' . $params['name'] . '" class="block text-sm font-medium text-gray-700 mt-px pb-2 dark:text-gray-300">' . $params['label'] . '  ' . $required . ' ' .  $this->addButton . '</label>';
        $html .= '<select data-allow-clear="true" data-hide-search="false" x-ref="select" data-placeholder="' . $this->placeholder . '" name="' . $params['name'] . '" class="' . $this->class . ' kt-select2 appearance-none block px-4 py-3 w-full rounded-md bg-gray-100  focus:border-gray-500 focus:bg-white focus:ring-0 text-sm ease-linear transition-all duration-150 ' . $this->classError . '"  
        ' . $this->ktData . ' data-kt-form-select >';
        $i = 0;
        $placeHoler = $this->placeholder ?? lang('Form.general.choisissezVotreValeur');
        $html .= '<option value="">' . $placeHoler . '</option>';

        //print_r($params['options']);exit;

        if (isset($params['options']) && count($params['options'])) :

            foreach ($params['options'] as $key => $val) :
            
                // Not key
                if (!isset($params['byKey']) || $params['byKey'] == false) {
                    $value = isset($val['nameoption']) ? $val['nameoption'] : $val;
                    $newSelected = ($params['selected'] === $value) ? ' selected="selected" ' : '';
                    $valueOption = $value;
                } else {
                    // Par key
                    if (!is_null($this->val) && !is_null($this->key)) {
                        $value = isset($val[$this->val]) ? $val[$this->val] : $val;
                        $newSelected = ((!empty($params['selected'])) && $params['selected'] == $val[$this->key]) ? ' selected="selected" ' : '';
                        $valueOption = $val[$this->key];
                    } else {
                        $value = isset($val[$this->val]) ? $val[$this->val] : $val;
                        $newSelected = ((!empty($params['selected'])) && $params['selected'] == $key) ? ' selected="selected" ' : '';
                        $newSelected = (empty($params['selected']) && $params['default'] ==  $key) ? ' selected="selected" ' : $newSelected;
                        $valueOption = $key;
                    }
                }


                $html .= '<option value="' . $valueOption . '" ' . $newSelected . '>';
                $html .= ucfirst($value);
                $html .= '</option>';
                $i++;
            endforeach;
        endif;
        $html .= '</select>';
        $html .= $this->getValidation($params);
        $html .= '</div>';
        return $html;
    }


    public function getValidation($params)
    {
        $html = '';
        if (isset($params['lang']) && $params['lang'] == true) {

            if (service('validation')->hasError('lang.' . service('language')->getLocale() . '.' . $params['name'])) :
                // print_r($params['validation']); exit;
                $html = '<div class="invalid-feedback block text-red-600 text-sm">';
                $html .= service('validation')->getError('lang.' . service('language')->getLocale() . '.' . $params['name']);
                $html .= '</div>';
            endif;
        } else {
            if (service('validation')->hasError($params['name'])) :
                $html = '<div class="invalid-feedback block text-red-600 text-sm">';
                $html .= service('validation')->getError($params['name']);
                $html .= '</div>';
            endif;
        }
        return $html;
    }
}
