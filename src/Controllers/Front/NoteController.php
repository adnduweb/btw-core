<?php

/**
 * This file is part of Doudou.
 *
 * (c) Fabrice Loru <fabrice@adnduweb.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Btw\Core\Controllers\Front;

use Btw\Core\Controllers\FrontController;
use Btw\Core\Models\NoteModel;
use Btw\Core\Entities\Note;
use Michelf\Markdown;
use CodeIgniter\Exceptions\PageNotFoundException;

/**
 * Class Customer
 *
 * The primary entry-point to the Btw admin area.
 */
class NoteController extends FrontController
{
    protected $viewPrefix = 'Btw\Core\Views\\';
    protected $viewMeta;
    protected $note;

    public function __construct()
    {
        $this->viewMeta = service('viewMeta');
    }

    public function viewNote(int $noteID)
    {
        $notes = model(NoteModel::class);
        if (!$note = $notes->where('id', $noteID)->first()) {
            throw new PageNotFoundException('Incorrect informations techniques');
        }

        $this->viewMeta->setTitle('Note');
        $this->viewMeta->addMeta(['HandheldFriendly' => "true"]);
        $this->viewMeta->addMeta(['format-detection' => "telephone=no"]);
        $this->viewMeta->addMeta(['format-detection' => "address=no"]);
        $this->viewMeta->addMeta(['apple-mobile-web-app-capable' => 'yes']);
        $this->viewMeta->addMeta(['description' => 'Note']);
        $this->viewMeta->addMeta(['name' => 'robots', 'content' => 'noindex, nofollow']);

        $contentMark = Markdown::defaultTransform($note->getContentPrepFront());

        return $this->twig->display('signed_url_note', [
            'note' => $note,
            'contentMark' => $contentMark,
            'class' => 'tmp_note_signed_url',
            'id' => 'tmp_note_signed_url'
        ]);


    }
}
