<?php

/**
 * This file is part of Doudou.
 *
 * (c) Fabrice Loru <fabrice@adnduweb.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Btw\Core\Cells\Forms;

use RuntimeException;

class SelectCell
{

    protected $xOnClick;
    protected $class;
    protected $label;
    protected $xChange;
    protected $hxGet;
    protected $hxTarget;
    protected $hxInclude;
    protected $hxTrigger;
    protected $hxSwap;
    protected $ktData;
    protected $placeholder;
    protected $classError = 'border-transparent';
    protected $key;
    protected $val;
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

        if (!isset($params['selected'])) {
            throw new RuntimeException('You must provide the Select view cell with the selected to use.');
        }

        $this->xOnClick = (isset($params['xOnClick'])) ? 'x-on:click="' . $params['xOnClick'] . '"' : false;
        $this->xChange = (isset($params['change'])) ? '@change="' . $params['change'] . '"' : false;
        $this->hxGet = (isset($params['hxGet'])) ? 'hx-get="' . $params['hxGet'] . '"' : false;
        $this->hxTarget = (isset($params['hxTarget'])) ? 'hx-target="' . $params['hxTarget'] . '"' : false;
        $this->hxInclude = (isset($params['hxInclude'])) ? 'hx-include="' . $params['hxInclude'] . '"' : false;
        $this->hxTrigger = (isset($params['hxTrigger'])) ? 'hx-trigger="' . $params['hxTrigger'] . '"' : false;
        $this->hxSwap = (isset($params['hxSwap'])) ? 'hx-swap="' . $params['hxSwap'] . '"' : false;
        $this->class = (isset($params['class'])) ? $params['class'] : false;
        $this->label = (isset($params['label'])) ? $params['label'] : false;
        $this->ktData = (isset($params['ktData'])) ? $params['ktData'] : false;
        $this->placeholder = (isset($params['placeholder'])) ? $params['placeholder'] : null;
        $this->key = (isset($params['key'])) ? $params['key'] : null;
        $this->val = (isset($params['val'])) ? $params['val'] : null;
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
        if ($this->label == true)
            $html = '<label for="' . $params['name'] . '" class="block text-sm font-medium text-gray-700 mt-px pb-2 dark:text-gray-300">' . $params['label'] . ' ' . $required . ' </label>';
        $html .= '<select name="' . $params['name'] . '" class="' . $this->class . ' appearance-none block px-4 py-3 w-full rounded-md bg-gray-100  focus:border-gray-500 focus:bg-white focus:ring-0 text-sm ease-linear transition-all duration-150 ' . $this->classError . '"  
        ' . $this->xOnClick . ' ' . $this->xChange . ' ' . $this->hxGet . ' ' . $this->hxTarget . '  ' . $this->hxInclude . '  ' . $this->hxTrigger . '  ' . $this->hxSwap . ' ' . $this->ktData . ' data-kt-form-select >';
        $i = 0;
        $placeHoler = $this->placeholder ?? lang('Form.general.choisissezVotreValeur');
        $html .= '<option value="">' . $placeHoler . '</option>';

        if (isset($params['options']) && count($params['options'])) :

            foreach ($params['options'] as $key => $val) :
                $apinejs = isset($params['alpinejs']) ? $params['alpinejs'][$i] : '';

                if (!isset($params['byKey']) || $params['byKey'] == false) {
                    $value = isset($val['name']) ? $val['name'] : $val;
                    $newSelected = ($params['selected'] === $value) ? ' selected="selected" ' : '';
                    $valueOption = $value;
                } else {
                    if (!is_null($this->val) && !is_null($this->key)) {
                        $value = isset($val[$this->val]) ? $val[$this->val] : $val;
                        $newSelected = ((!empty($params['selected'])) && $params['selected'] == $val[$this->key]) ? ' selected="selected" ' : '';
                        $valueOption = $val[$this->key];
                    } else {
                        $value = isset($val['name']) ? $val['name'] : $val;
                        $newSelected = ((!empty($params['selected'])) && $params['selected'] == $key) ? ' selected="selected" ' : '';
                        if (isset($params['default'])) {
                            $newSelected = (empty($params['selected']) && $params['default'] ==  $key) ? ' selected="selected" ' : $newSelected;
                        }
                        $valueOption = $key;
                    }
                }


                $html .= '<option value="' . $valueOption . '" ' . $apinejs . ' ' . $newSelected . '>';
                $html .= ucfirst($value);
                $html .= '</option>';
                $i++;
            endforeach;
        endif;
        $html .= '</select>';
        $html .= $this->getValidation($params);
        return $html;
    }


    public function getValidation($params)
    {
        $html = '';
        if (isset($params['lang']) && $params['lang'] == true) {

            if (service('validation')->hasError('lang.' . service('language')->getLocale() . '.' . uniforme($params['name']))) :
                // print_r($params['validation']); exit;
                $html = '<div class="invalid-feedback block text-red-600 text-xs mt-2">';
                $html .= service('validation')->getError('lang.' . service('language')->getLocale() . '.' . uniforme($params['name']));
                $html .= '</div>';
            endif;
        } else {
            if (service('validation')->hasError($params['name'])) :
                $html = '<div class="invalid-feedback block text-red-600 text-xs mt-2">';
                $html .= service('validation')->getError($params['name']);
                $html .= '</div>';
            endif;
        }
        return $html;
    }
}
