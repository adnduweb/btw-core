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

        // print_r($params); exit;
        $this->addStyles($params);
        return view('Btw\Core\Cells\Views\display_modal_cell', ['params' => $params]);

    }

    public function addStyles($params)
    {
        if (!isset($params['wysiwyg'])) {
            return false;
        }

        helper('assets');

        switch ($params['wysiwyg']) {
            case 'quilljs':
                service('viewMeta')->addStyle(['rel' => 'stylesheet', 'href' => asset_url('admin/css/quill-editor.css', 'css')]);
                service('viewMeta')->addStyle(['rel' => 'stylesheet', 'href' => asset_url('admin/css/quill-snow.css', 'css')]);
                break;
            case 'simplemde':
                service('viewMeta')->addStyle(['rel' => 'stylesheet', 'href' => asset_url('admin/css/easymde.min.css', 'css')]);
                break;
            default:
                return 'pas de script';
                break;
        }
    }
}
