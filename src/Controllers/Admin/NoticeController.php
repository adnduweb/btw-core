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
use Btw\Core\Models\NoticeModel;
use Btw\Core\Entities\Notice;
use CodeIgniter\Exceptions\PageNotFoundException;

class NoticeController extends AdminController
{
    protected $theme      = 'admin';
    protected $viewPrefix = 'Btw\Core\Views\Admin\\notices\\';


    protected $meta;

    public function __construct()
    {
        helper('text');
        $this->meta = service('viewMeta');
    }
    /**
     * Displays the site's initial page.
     */
    public function index()
    {
        $this->meta->setTitle('Liste des Notices');
        $noticesModel = model(NoticeModel::class);

        $notices = $noticesModel->join('notices_langs', 'notices_langs.notice_id = notices.id')->where('lang', service('language')->getLocale())->findAll();

        return $this->render($this->viewPrefix . 'index', [
            'notices' => $notices,
            'columns' => $noticesModel->getColumn()
        ]);
    }

    /**
     * Update list Infos Techniques
     */
    public function updateListNotices(): string
    {
        $notices = model(NoticeModel::class);

        return view($this->viewPrefix . 'cells\list_notices', [
            'notices' => $notices->findAll(),
            'columns' => $notices->getColumn()
        ]);
    }


    /**
    * Display Infos Techniques modal
    */
    public function modalNotice(?int $noticeId = 0)
    {
        $notices = model(NoticeModel::class);

        /**
         * @var Notice
         */
        $notice = $noticeId !== 0
            ? $notices->join('notices_langs', 'notices_langs.notice_id = notices.id')->where('id', $noticeId)->where('lang', service('language')->getLocale())->first()
            : new Notice();

        $this->response->triggerClientEvent('openmodalnotice', true);
        $this->response->triggerClientEvent('modalcomponent', true);

        return view($this->viewPrefix . 'modals\form_notice', [
            'noticeModal' => $notice,
        ]);
    }

    /**
    * Edit Informations techniques.
    */
    public function edit(): string
    {
        $notices = model(NoticeModel::class);

        $data = $this->request->getPost();
        $validation = service('validation');

        $validation->setRules([
            'name' => 'required'

        ]);

        if (!$validation->run($data)) {
            $this->response->triggerClientEvent('showMessage', ['type' => 'error', 'content' => $validation->getErrors()]);
            return view($this->viewPrefix . 'modals\form_notice', [
                'noticeModal' => new Notice($data),
                'validation' => $validation
            ]);
        }

        $notice = new Notice();
        $notice->fill($data);

        try {
            $notices->withLang()->save($notice);
            $this->response->triggerClientEvent('showMessage', ['type' => 'success', 'content' => lang('Btw.message.resourcesSaved', ['notices'])]);
            $this->response->triggerClientEvent('updateListNotice', time(), 'receive');
            $this->response->setReswap('innerHTML show:#information:top');
            $this->response->triggerClientEvent('closemodal');
            log_message('info', 'Notice save {notice}', ['notice' => json_encode($notice, JSON_UNESCAPED_SLASHES)]);

        } catch (\CodeIgniter\Database\Exceptions\DataException $e) {
            $this->response->triggerClientEvent('showMessage', ['type' => 'error', 'content' => $e->getMessage()]);
            log_message('debug', 'Notice save {notice}', ['notice' => $e->getMessage()]);
        }

        return view($this->viewPrefix . 'modals\form_notice', [
            'noticeModal' => $notice,
            'columns' => $notices->getColumn()
        ]);
    }

    /**
    * Delete the item Informations Techniques (soft).
    *
    * @param string $itemId
    *
    */
    public function actionDeleteNotice(int $noticeId)
    {
        if ($this->request->is('delete')) {

            $notices = model(NoticeModel::class);

            if (!$infoTech = $notices->where('id', $noticeId)->first()) {
                throw new PageNotFoundException('Incorrect notice');
            }

            $notices->delete($noticeId);

            $this->response->triggerClientEvent('deleteNotice', time(), 'receive');
            $this->response->triggerClientEvent('updateListNotice', time(), 'receive');
            $this->response->triggerClientEvent('showMessage', ['type' => 'success', 'content' => lang('Btw.message.resourcesDeleted', ['notices'])]);
            $this->response->triggerClientEvent('closemodal');
        }
    }

    public function activeTable(string $noticeId)
    {
        $notices = model(NoticeModel::class);
        if (!$notice = $notices->where('id', $noticeId)->first()) {
            throw new PageNotFoundException('Incorrect notice uuid.');
        }

        $notice->active = $notice->active != true;
        $notice->updated_at = date('Y-m-d H:i:s');

        try {
            $notices->save($notice);
            $this->response->triggerClientEvent('showMessage', ['type' => 'success', 'content' => lang('Btw.message.resourcesSaved', ['notices'])]);
            log_message('info', 'Notice save {notice}', ['notice' => json_encode($notice, JSON_UNESCAPED_SLASHES)]);

        } catch (\CodeIgniter\Database\Exceptions\DataException $e) {
            $this->response->triggerClientEvent('showMessage', ['type' => 'error', 'content' => $e->getMessage()]);
            log_message('debug', 'Notice save {notice}', ['notice' => $e->getMessage()]);
        }

        $this->response->setStatusCode(204, 'No Content');
    }

}
