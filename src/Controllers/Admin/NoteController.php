<?php

/**
 * This file is part of Doudou.
 *
 * (c) Fabrice Loru <fabrice@adnduweb.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Btw\Core\Controllers\Admin;

use Btw\Core\Controllers\AdminController;
use Btw\Core\Libraries\Menus\MenuItem;
use Btw\Core\Models\NoteModel;
use Btw\Core\Entities\Note;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\I18n\Time;
use Btw\Core\Libraries\DataTable\DataTable;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\Events\Events;

/**
 * Class Customer
 *
 * The primary entry-point to the Btw admin area.
 */
class NoteController extends AdminController
{
    use ResponseTrait;
    /**
     * Base URL.
     */
    protected string $baseURL = 'admin/notes';
    protected $viewPrefix = 'Btw\Core\Views\Admin\\notes\\';
    public static $actions = [
        'edit',
        'delete',
        'activate',
        'desactivate'
    ];

    protected $meta;

    public function __construct()
    {
        helper('text');
        $this->meta = service('viewMeta');
        $this->meta->addStyle(['rel' => 'stylesheet', 'href' => 'https://cdn.quilljs.com/1.3.6/quill.snow.css']);
        $this->meta->addStyle(['rel' => 'stylesheet', 'href' => 'https://cdn.jsdelivr.net/npm/easymde/dist/easymde.min.css']);
    }

    /**
     * Displays the site's initial page.
     */
    public function index()
    {
        helper('inflector');

        $this->meta->setTitle('Liste des Notes');
        $model = model(NoteModel::class);
        $data['columns'] = $model->getColumn();
        if (isset(config('Btw')->types)) :
            $i = 0;
            foreach (config('Btw')->types as $key => $types) :
                $data['nbre'][$types['name']] = $model->like('type', $key)->countAllResults();
            endforeach;
        endif;

        return $this->render($this->viewPrefix . 'index', $data);
    }


    /**
     * Function datatable.
     *
     */
    public function ajaxDatatable()
    {

        $model = model(NoteModel::class);
        $datatable = $model->select('id as identifier, company_id, user_id, titre, type, content, created_at');
        $datatable->where('deleted_at', null);

        return DataTable::of($datatable)
            ->add('select', function ($row) {
                $row = new Note((array) $row);
                return view_cell('Btw\Core\Cells\Datatable\DatatableSelect', ['row' => $row]);
            }, 'first')
            ->edit('type', function ($row): string {
                return '<span class="inline-flex items-center rounded-full px-2 py-1 text-xs font-medium' . config('Btw')->typesInfos[$row->type]['class'] . '">' . ucfirst(lang('Btw.types.' . config('Btw')->typesInfos[$row->type]['name'])) . '</span>';
            })

            ->edit('content', function ($row) {
                $row = new Note((array) $row);
                if ($row->getAskAuthContent('note') && ((time() - $row->getAskAuthContent('note')['expire']) < config('Btw')->dataAskAuthExpiration)) :
                    return getExcerpt($row->getContentPrep());
                else :
                    $row->removeAskAuthContent($row->getAskAuthContent('note'));
                    return view_cell('Btw\Core\Cells\Datatable\DatatableAskAuth', ['row' => $row, 'hxTrigger' => 'reloadTable', 'controller' => 'note', 'method' => 'ajaxDatatable']);

                endif;
            })

            ->format('created_at', function ($value) {
                return Time::parse($value, setting('App.appTimezone'))->format(setting('App.dateFormat') . ' à ' . setting('App.timeFormat'));
            })
            ->add('action', function ($row) {
                $row = new Note((array) $row);
                return view_cell('Btw\Core\Cells\Datatable\DatatableAction', [
                    'row' => $row,
                    'actions' => DataTable::actions(config('Note')->actions, $row)
                ]);
            }, 'last')

            ->add('askAuth', function ($row) {
                $row = new Note((array) $row);
                if ($row->getAskAuthContent('note') && ((time() - $row->getAskAuthContent('note')['expire']) < config('Btw')->dataAskAuthExpiration)) :
                    return true;
                else :
                    return false;

                endif;
            }, 'last')

            ->filter(function ($datatable, $request) {

                if (!empty($request->daterange)) {
                    list($initial_date, $final_date) = explode('-', $request->daterange);
                    $datatable->where([
                        'created_at >=' => date('Y/m/d', strtotime(app_datesql(trim($initial_date)))),
                        'created_at <=' => date('Y/m/d', strtotime(app_datesql(trim($final_date)))),
                    ]);
                }

                if (!empty($request->types) && $request->types != 0) {
                    $datatable->where([
                        'type' => $request->types
                    ]);
                }
            })
            ->toJson(true);
    }


    /**
     * Create list Infos Techniques
     */
    public function modalCreateInfosTechAction(): string
    {
        $notes = model(NoteModel::class);

        if (!$this->request->is('post')) {
            $this->response->triggerClientEvent('openmodalnote', true);
            $this->response->triggerClientEvent('modalcomponent', true);

            return view($this->viewPrefix . 'cells\form_cell_infos_create_tech', [
                'noteModal' => new Note(),
            ]);
        }

        $data = $this->request->getPost();
        $validation = service('validation');

        $validation->setRules([
            'titre' => 'required'

        ]);

        if (!$validation->run($data)) {
            $this->response->triggerClientEvent('showMessage', ['type' => 'error', 'content' => $validation->getErrors()]);
            return view($this->viewPrefix . 'cells\form_cell_infos_create_tech', [
                'noteModal' => new Note($data),
                'validation' => $validation
            ]);
        }
        $note = new Note();
        $note->fill($data);
        $note->updated_at = date('Y-m-d H:i:s');
        $note->company_id = Auth()->user()->company_id;
        $note->user_id = Auth()->user()->id;
        $note->content = $note->setContentPrep($data['content']);

        try {
            if (!$notes->save($note, true)) {
                log_message('error', 'infosTech errors', $notes->errors());
            }

        } catch (\Exception $e) {
            log_message('debug', 'modalCreateInfosTechAction error: ' . $e->getMessage());
        }

        Events::trigger('notification', 'Add note', $note);

        $this->response->triggerClientEvent('createNote', time(), 'receive');
        $this->response->triggerClientEvent('updateListNote', time(), 'receive');
        $this->response->triggerClientEvent('showMessage', ['type' => 'success', 'content' => lang('Btw.message.resourcesSaved', [lang('Customer.itemCustomer')])]);
        $this->response->triggerClientEvent('reloadTable');
        $this->response->triggerClientEvent('updateNotification');
        $this->response->triggerClientEvent('closemodal');

        return view($this->viewPrefix . 'cells\form_cell_infos_create_tech', [
            'noteModal' => new Note(),
            'menu' => service('menus')->menu('sidebar_page_current'),
            'currentUrl' => (string) current_url(true)
        ]);
    }

    /**
     * Update list Infos Techniques
     */
    public function modalEditNoteAction(int $noteID): string
    {
        $notes = model(NoteModel::class);

        if (!$note = $notes->where('id', $noteID)->first()) {
            throw new PageNotFoundException('Incorrect informations techniques');
        }

        if (!$this->request->is('post')) {
            $this->response->triggerClientEvent('openmodalcreatenote', true);
            $this->response->triggerClientEvent('modalcomponent', true);

            // if (!session()->get('note' . '_' . $note->getIdentifier()) && !((time() - session()->get('note' . '_' . $note->getIdentifier())) < config('Btw')->dataAskAuthExpiration)) :
            //     return view_cell('Btw\Core\Cells\Datatable\DatatableAskAuth', ['row' => $note]);
            // endif;

            return view($this->viewPrefix . 'cells\form_cell_infos_edit_tech', [
                'noteModal' => $note,
            ]);
        }

        $data = $this->request->getPost();
        $validation = service('validation');

        $validation->setRules([
            'titre' => 'required'

        ]);

        if (!$validation->run($data)) {
            $this->response->triggerClientEvent('showMessage', ['type' => 'error', 'content' => $validation->getErrors()]);
            return view($this->viewPrefix . 'cells\form_cell_infos_edit_tech', [
                'noteModal' => $note,
                'validation' => $validation
            ]);
        }
        $note = new Note();
        $note->fill($data);
        $note->updated_at = date('Y-m-d H:i:s');
        $note->company_id = Auth()->user()->company_id;
        $note->user_id = Auth()->user()->id;
        $note->content = $note->setContentPrep($data['content']);

        try {
            if (!$notes->save($note, true)) {
                log_message('error', 'infosTech errors', $notes->errors());
            }
        } catch (\Exception $e) {
            log_message('debug', 'modalCreateInfosTechAction error: ' . $e->getMessage());
        }

        $this->response->triggerClientEvent('updateNote', time(), 'receive');
        $this->response->triggerClientEvent('updateListNote', time(), 'receive');
        $this->response->triggerClientEvent('showMessage', ['type' => 'success', 'content' => lang('Btw.message.resourcesSaved', [lang('Customer.itemCustomer')])]);
        $this->response->triggerClientEvent('reloadTable');
        $this->response->triggerClientEvent('closemodal');

        return view($this->viewPrefix . 'cells\form_cell_infos_edit_tech', [
            'noteModal' => $note,
            'menu' => service('menus')->menu('sidebar_page_current'),
            'currentUrl' => (string) current_url(true)
        ]);
    }

    /**
     * Delete the item (soft).
     *
     * @param string $itemId
     *
     */
    public function delete()
    {

        if ($this->request->is('delete')) {

            $data = $this->request->getRawInput();

            if (!is_array($data['identifier'])) {
                $data['identifier'] = [$data['identifier']];
            }

            $model = model(NoteModel::class);

            foreach ($data['identifier'] as $key => $identifier) {
                $model->where('id', $identifier)->delete();
            }
            $this->response->triggerClientEvent('showMessage', ['type' => 'success', 'content' => lang('Btw.message.resourcesDeleted', ['customers'])]);
            $this->response->triggerClientEvent('reloadTable');
        }
        return $this->respondNoContent();
    }

    public function modalShare(int $noteID)
    {
        $notes = model(NoteModel::class);

        if (!$note = $notes->where('id', $noteID)->first()) {
            throw new PageNotFoundException('Incorrect invoice id.');
        }


        if (!$this->request->is('post')) {
            $this->response->triggerClientEvent('openmodalnotesharenote', true);
            $this->response->triggerClientEvent('modalcomponent', true);

            if (!session()->get('note_' . $note->getIdentifier()) && !((time() - session()->get('note_' . $note->getIdentifier())) < config('Btw')->dataAskAuthExpiration)) :
                return view_cell('Btw\Core\Cells\Datatable\DatatableAskAuth', ['row' => $note]);
            endif;

            return view($this->viewPrefix . 'cells\form_cell_form_share', [
                'note' => $note,
            ]);
        }

        $data = $this->request->getPost();
        $validation = service('validation');

        $validation->setRules([
            'date_expiration' => 'required'

        ]);

        if (!$validation->run($data)) {
            $this->response->triggerClientEvent('showMessage', ['type' => 'error', 'content' => $validation->getErrors()]);
            return view($this->viewPrefix . 'cells\form_cell_form_share', [
                'note' => $note,
                'validation' => $validation
            ]);
        }

        $this->response->triggerClientEvent('shareNote', time(), 'receive');
        $this->response->triggerClientEvent('showMessage', ['type' => 'success', 'content' => lang('Btw.message.resourcesSaved', [lang('Note.itemCustomer')])]);

        return view($this->viewPrefix . 'cells\form_cell_form_share', [
            'url_signed' => service('signedurl')->setExpiration($data['date_expiration'])->urlTo('note-view', $note->id),
            'note' => $note
        ]);
    }

    /**
    * Update list table Address
    */
    public function updateListeNoteItem(string $noteID): string
    {
        $notes = model(NoteModel::class);

        if (!$note = $notes->where('id', $noteID)->withAskAuth()->first()) {
            throw new PageNotFoundException('Incorrect invoice id.');
        }

        return view('Btw\Core\Views\Admin\search\cells\form_search_note_item', [
            'note' => $note
        ]);
    }
}
