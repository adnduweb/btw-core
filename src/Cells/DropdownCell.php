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
    protected $dataSelect;
    protected $identifier;
    protected $valueSelect;
    protected $value;

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

        if (!isset($params['value'])) {
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
        $this->options = (isset($params['options'])) ? $params['options'] : null;
        $this->identifier = (isset($params['identifier'])) ? $params['identifier'] : null;
        $this->valueSelect = (isset($params['valueSelect'])) ? $params['valueSelect'] : null;
        $this->value = (isset($params['value'])) ? $params['value'] : null;
        

        // print_r($this->options); exit;
        // print_r(end($this->options)); exit;

        if (!empty($this->options)) {
            foreach ($this->options as $option) {
                $this->dataSelect .= "'" . str_replace('-', '_', $option->{$this->identifier}) . "': '" . $option->{$this->valueSelect} . "'";
                $this->dataSelect .= ", ";
            }
        }
        $this->dataSelect = substr($this->dataSelect,0,-2);
        $this->value = str_replace('-', '_', $this->value);

        // au: 'Australia', be: 'Belgium', cn: 'China', fr: 'France', de: 'Germany', it: 'Italy', mx: 'Mexico', es: 'Spain', tr: 'Turkey', gb: 'United Kingdom', 'us': 'United States'
        // print_r($this->dataSelect); exit;


        $html = "";
        if ($this->label == true)
            $html = '<label for="' . $params['name'] . '" class="block text-sm font-medium text-gray-700 mt-px pb-2 dark:text-gray-300">' . $params['label'] . '</label>';
        $html .= "<div x-data=\"select({ data: { " . $this->dataSelect . " }, emptyOptionsMessage: 'No countries match your search.', name: 'country', placeholder: 'Select a country' })\" x-init=\"init()\" @click.away=\"closeListbox()\" @keydown.escape=\"closeListbox()\" class=\"relative\">
                <span class=\"inline-block w-full rounded-md shadow-sm\">
                    <button type=\"button\" x-ref=\"button\" @click=\"toggleListboxVisibility()\" :aria-expanded=\"open\" aria-haspopup=\"listbox\" class=\"relative z-0 w-full py-2 pl-3 pr-10 text-left transition duration-150 ease-in-out bg-white border border-gray-300 rounded-md cursor-default focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm sm:leading-5\">
                        <span x-show=\"! open\" x-text=\"'".$this->value."' in options ? options['".$this->value."'] : placeholder\" :class=\"{ 'text-gray-500': ! (value in options) }\" class=\"block truncate\"></span>

                        <input x-ref=\"search\" x-show=\"open\" x-model=\"search\" name=\"country\" :value=\"value\" @keydown.enter.stop.prevent=\"selectOption()\" @keydown.arrow-up.prevent=\"focusPreviousOption()\" @keydown.arrow-down.prevent=\"focusNextOption()\" type=\"search\" class=\"w-full h-full form-control focus:outline-none\" />

                        <span class=\"absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none\">
                            <svg class=\"w-5 h-5 text-gray-400\" viewBox=\"0 0 20 20\" fill=\"none\" stroke=\"currentColor\">
                                <path d=\"M7 7l3-3 3 3m0 6l-3 3-3-3\" stroke-width=\"1.5\" stroke-linecap=\"round\" stroke-linejoin=\"round\"></path>
                            </svg>
                        </span>
                    </button>
                </span>

                <div x-show=\"open\" x-transition:leave=\"transition ease-in duration-100\" x-transition:leave-start=\"opacity-100\" x-transition:leave-end=\"opacity-0\" x-cloak class=\"absolute z-10 w-full mt-1 bg-white rounded-md shadow-lg\">
                    <ul x-ref=\"listbox\" @keydown.enter.stop.prevent=\"selectOption()\" @keydown.arrow-up.prevent=\"focusPreviousOption()\" @keydown.arrow-down.prevent=\"focusNextOption()\" role=\"listbox\" :aria-activedescendant=\"focusedOptionIndex ? name + 'Option' + focusedOptionIndex : null\" tabindex=\"-1\" class=\"py-1 overflow-auto text-base leading-6 rounded-md shadow-xs max-h-60 focus:outline-none sm:text-sm sm:leading-5\">
                        <template x-for=\"(key, index) in Object.keys(options)\" :key=\"index\">
                            <li :id=\"name + 'Option' + focusedOptionIndex\" @click=\"selectOption()\" @mouseenter=\"focusedOptionIndex = index\" @mouseleave=\"focusedOptionIndex = null\" role=\"option\" :aria-selected=\"focusedOptionIndex === index\" :class=\"{ 'text-white bg-indigo-600': index === focusedOptionIndex, 'text-gray-900': index !== focusedOptionIndex }\" class=\"relative py-2 pl-3 text-gray-900 cursor-default select-none pr-9\">
                                <span x-text=\"Object.values(options)[index]\" :class=\"{ 'font-semibold': index === focusedOptionIndex, 'font-normal': index !== focusedOptionIndex }\" class=\"block font-normal truncate\"></span>

                                <span x-show=\"key === value\" :class=\"{ 'text-white': index === focusedOptionIndex, 'text-indigo-600': index !== focusedOptionIndex }\" class=\"absolute inset-y-0 right-0 flex items-center pr-4 text-indigo-600\">
                                    <svg class=\"w-5 h-5\" viewBox=\"0 0 20 20\" fill=\"currentColor\">
                                        <path fill-rule=\"evenodd\" d=\"M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z\" clip-rule=\"evenodd\" />
                                    </svg>
                                </span>
                            </li>
                        </template>

                        <div x-show=\"! Object.keys(options).length\" x-text=\"emptyOptionsMessage\" class=\"px-3 py-2 text-gray-900 cursor-default select-none\"></div>
                    </ul>
                </div>";
        $html .= $this->getValidation($params);
        return $html;
    }


    public function getValidation($params)
    {
        $html = '';
        if (isset($params['lang']) && $params['lang'] == true) {

            if (service('validation')->hasError('lang.' . service('language')->getLocale() . '.' . uniforme($params['name']))) :
                // print_r($params['validation']); exit;
                $html = '<div class="invalid-feedback block text-red-600 text-sm">';
                $html .= service('validation')->getError('lang.' . service('language')->getLocale() . '.' . uniforme($params['name']));
                $html .= '</div>';
            endif;
        } else {
            if (service('validation')->hasError(uniforme($params['name']))) :
                $html = '<div class="invalid-feedback block text-red-600 text-sm">';
                $html .= service('validation')->getError(uniforme($params['name']));
                $html .= '</div>';
            endif;
        }
        return $html;
    }
}
