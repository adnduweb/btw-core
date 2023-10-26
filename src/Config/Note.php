<?php

namespace Btw\Core\Config;

use CodeIgniter\Config\BaseConfig;

class Note extends BaseConfig
{
    /**
    * --------------------------------------------------------------------
    * Actions All Header list Datatable
    * --------------------------------------------------------------------
    */
    public array $actionsAll = ['delete'];

    /**
    * --------------------------------------------------------------------
    * Actions Only by quote
    * --------------------------------------------------------------------
    */
    public array $actions = [
        'delete',
        'custom' => [
            [
                'name' => "shareNote",
                'route' => "note-share-note-modal",
                'modal' => true,
                'type' => "showShareNoteModal",
                'identifier' => "sharenote",
                'callback' => 'displayShareNoteAction'
            ]
        ]
    ];

    /**
    * --------------------------------------------------------------------
    * Datatable Customer Lenght pagination
    * --------------------------------------------------------------------
    */
    public $pageLenght = 50;

}
