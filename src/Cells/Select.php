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

class Select
{
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

        $html = "";
        $i = 0;
        $html .= '<option value="0">How long to remember...</option>';
        if (isset($params['options']) && count($params['options'])) :

            foreach ($params['options'] as $key => $val) :
                $apinejs  = isset($params['alpinejs']) ?  $params['alpinejs'][$i]  : '' ; 
                $newSelected = ($params['selected'] === (string) $val) ?  'selected' : '';
                $html .= '<option value="' . $val . '" ' . $apinejs . ' ' .  $newSelected . '>';
                $html .= $key;
                $html .= '</option>';
                $i++;
            endforeach;
        endif;

        return $html;
    }
}
