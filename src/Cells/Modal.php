<?php

namespace Btw\Core\Cells;

use RuntimeException;


class Modal
{

    protected $type = 'showModal';
    protected $title = 'test';
    protected $identifier = 'delete';
    protected $view;

    public function renderList($params)
    {

        if (!isset($params['type'])) {
            throw new RuntimeException('You must provide the Filter view cell with the model to use.');
        }

        if (!isset($params['identifier'])) {
            throw new RuntimeException('You must provide the Filter view cell with the model to use.');
        }

        return view('Btw\Core\Cells\views\modal', ['params' => $params]);
       
    }
}
