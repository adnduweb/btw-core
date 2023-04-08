<?php

/**
 * This file is part of Bonfire.
 *
 * (c) Lonnie Ezell <lonnieje@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Btw\Core\Cells;

use RuntimeException;

class SelectCell
{

    protected $xOnClick;
    protected $xChange;
    protected $hxGet;
    protected $hxTarget; 
    protected $hxInclude; 
    protected $hxTrigger;
    protected $hxSwap;

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

        $this->xOnClick = (isset($params['xOnClick'])) ? 'x-on:click="'.$params['xOnClick'].'"' : false;
        $this->xChange = (isset($params['change'])) ? '@change="'.$params['change'].'"' : false;
        $this->hxGet = (isset($params['hxGet'])) ? 'hx-get="'.$params['hxGet'].'"' : false;
        $this->hxTarget = (isset($params['hxTarget'])) ? 'hx-target="'.$params['hxTarget'].'"' : false;
        $this->hxInclude = (isset($params['hxInclude'])) ? 'hx-include="'.$params['hxInclude'].'"' : false;
        $this->hxTrigger = (isset($params['hxTrigger'])) ? 'hx-trigger="'.$params['hxTrigger'].'"' : false;
        $this->hxSwap = (isset($params['hxSwap'])) ? 'hx-swap="'.$params['hxSwap'].'"' : false;


        $html = "";
        $html = '<label for="' . $params['name'] . '" class="block text-sm font-medium text-gray-700 mt-px pb-2 dark:text-gray-300">' . $params['label'] . '</label>';
        $html .= '<select name="' . $params['name'] . '" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 dark:border-gray-700 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500  dark:text-gray-200 dark:bg-gray-900 ease-linear transition-all duration-150" 
        ' . $this->xOnClick . ' ' . $this->xChange . ' ' . $this->hxGet . ' ' . $this->hxTarget . '  ' . $this->hxInclude . '  ' . $this->hxTrigger . '  ' . $this->hxSwap . ' >';
        $i = 0;
        $html .= '<option value="0">How long to remember...</option>';
        
        if (isset($params['options']) && count($params['options'])) :

            foreach ($params['options'] as $key => $val) :
                $apinejs  = isset($params['alpinejs']) ?  $params['alpinejs'][$i]  : '' ; 
                $newSelected = ($params['selected'] === (string) $val) ?  'selected' : '';
                $html .= '<option value="' . $val . '" ' . $apinejs . ' ' .  $newSelected . '>';
                $html .= !isset($params['byKey']) ? $key : $val;
                $html .= '</option>';
                $i++;
            endforeach;
        endif;
        $html .='</select>';
        return $html;
    }
}
