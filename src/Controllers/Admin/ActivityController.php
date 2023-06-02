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

use Btw\Core\Libraries\Logs;
use Btw\Core\Controllers\AdminController;
use Btw\Core\Models\ActivityModel;
use Btw\Core\Entities\Activity;
use Btw\Core\Libraries\DataTable\DataTable;
use CodeIgniter\I18n\Time;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Exceptions\PageNotFoundException;
use InvalidArgumentException;
use ReflectionException;


/**
 * Class Dashboard
 *
 * The primary entry-point to the Bonfire admin area.
 */
class ActivityController extends AdminController
{

    use ResponseTrait;

    protected $viewPrefix = 'Btw\Core\Views\Admin\\activity\\';

    protected $logsPath = WRITEPATH . 'logs/';
    protected $logsLimit;
    protected $logsHandler;

    public static $actions = [
        'delete'
    ];


    public function __construct()
    {
        helper('filesystem');
        $this->logsLimit = setting('Site.perPage') ?? 60;
        $this->logsHandler = new Logs();
    }

    /**
     * Displays the site's initial page.
     */
    public function logsFile()
    {

        // Load the Log Files.
        $logs = get_filenames($this->logsPath);
        arsort($logs);
        unset($logs[0]);

        $result = $this->logsHandler->paginateLogs($logs, $this->logsLimit);

        return $this->render($this->viewPrefix . 'files\index', [
            'logs' => $result['logs'],
            'pager' => $result['pager'],
        ]);
    }

    /**
     * Show the contents of a single log file.
     *
     * @param string $file The full name of the file to view (including extension).
     *
     * @return RedirectResponse|string
     */
    public function viewFile(string $file = '')
    {
        helper('security');
        $file = sanitize_filename($file);

        if (empty($file) || !file_exists($this->logsPath . $file)) {
            return redirect()->to(ADMIN_AREA . '/logs/files/list')->with('danger', lang('Logs.empty'));
        }

        $logs = $this->logsHandler->processFileLogs($this->logsPath . $file);

        $result = $this->logsHandler->paginateLogs($logs, $this->logsLimit);

        return $this->render($this->viewPrefix . 'files\view_log', [
            'logFile' => $file,
            'canDelete' => 1,
            'logContent' => $result['logs'],
            'pager' => $result['pager'],
            'logFilePretty' => date('F j, Y', strtotime(str_replace('.log', '', str_replace('log-', '', $file)))),
        ]);
    }

    public function listsystem()
    {

        $data = [
            'limit' => $this->request->getGet('limit') ?? 5,
            'page' => $this->request->getGet('page') ?? 1,
            'query' => $this->request->getGet('query') ?? '',
            'sortColumn' => $this->request->getGet('sortColumn') ?? 'id',
            'sortDirection' => $this->request->getGet('sortDirection') ?? 'asc',
        ];

        $model = model(ActivityModel::class);
        $data['columns'] = $model->getColumn();
        $data['actions'] = self::$actions;

        return $this->render($this->viewPrefix . 'system\index', $data);
    }

    /**
     * Function datatable.
     *
     */
    public function ajaxDatatableSystem()
    {

        $model = model(ActivityModel::class);
        $model->select('id as identifier, event_type, event_access, event_method, source, source_id, user_id, event, summary, properties, created_at')
        ->orderBy('created_at DESC');

        return DataTable::of($model)
            ->setSearchableColumns(['event_access', 'event_method', 'user_id'])
            ->add('select', function ($row) {
                $row = new Activity((array) $row);
                return view('Themes\Admin\Datatabase\select', ['row' => $row]);
            }, 'first')
            // ->hide('id')
            ->format('created_at', function ($value) {
                return Time::parse($value, setting('App.appTimezone'))->format(setting('App.dateFormat') . ' à ' . setting('App.timeFormat'));
            })
            ->edit('event_method', function ($row) {

                switch ($row->event_method) {
                    case 'get':
                        return '<span class="bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2 py-1 rounded dark:bg-blue-900 dark:text-blue-300"> GET </span>';
                        break;
                    case 'post':
                        return '<span class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2 py-1 rounded dark:bg-green-900 dark:text-green-300"> POST </span>';
                        break;
                    case 'delete':
                        return '<span class="bg-red-100 text-red-800 text-xs font-medium mr-2 px-2 py-1 rounded dark:bg-red-900 dark:text-red-300"> DELETE </span>';
                        break;
                    default:
                    // silent
                }
            })

            ->edit('properties', function ($row) {

                // return json_decode($row->properties);
                return '<code>' . $row->properties . '</code>';
            })
            ->edit('user_id', function ($row) {
                if ($row->user_id == '0' || $row->user_id == null) {
                    return lang('Btw.system');
                } else {
                    return getUser($row->user_id)->last_name;
                }
            })
            ->add('action', function ($row) {
                $row = new Activity((array) $row);
                return view('Themes\Admin\Datatabase\action', ['row' => $row, 'actions' => DataTable::actions(self::$actions, $row)]);
            }, 'last')
            ->toJson(true);
    }

    /**
     * Delete the item (soft).
     *
     * @param string $itemId
     *
     */
    public function deleteSystem()
    {

        if ($this->request->is('delete')) {

            $data = $this->request->getRawInput();

            if (!is_array($data['identifier']))
                $data['identifier'] = [$data['identifier']];

            $model = model(ActivityModel::class);

            $isNatif = false;
            foreach ($data['identifier'] as $identifier) {
                $model->where('id', $identifier)->delete();
            }
            $this->response->triggerClientEvent('showMessage', ['type' => 'success', 'content' => lang('Btw.message.resourcesDeleted', ['customers'])]);
            $this->response->triggerClientEvent('reloadTable');
        }
        return $this->respondNoContent();
    }

    /**
     * Delete the specified log file or all.
     *
     */
    public function deleteFilesAll()
    {
        $delete = $this->request->getPost('delete');
        $deleteAll = $this->request->getPost('delete_all');

        if (empty($delete) && empty($deleteAll)) {
            theme()->set_message_htmx('error', lang('Btw.resourcesNotFound', ['Logs']));
            return redirect()->to(route_to('logs-file'));
        }

        if (!empty($delete)) {
            helper('security');

            $checked = $_POST['checked'];
            $numChecked = count($checked);

            if (is_array($checked) && $numChecked) {
                foreach ($checked as $file) {
                    @unlink($this->logsPath . sanitize_filename($file));
                }

                theme()->set_message_htmx('success', lang('Btw.message.resourcesDeleted', ['Logs']));
                return redirect()->to(route_to('logs-file'));
            }
        }

        if (!empty($deleteAll)) {
            if (delete_files($this->logsPath)) {
                // Restore the index.html file.
                @copy(APPPATH . '/index.html', "{$this->logsPath}index.html");

                theme()->set_message_htmx('success', lang('Btw.message.resourcesDeletedAll', ['Logs']));
                return redirect()->to(route_to('logs-file'));
            }

            theme()->set_message_htmx('error', lang('Btw.resourcesErrorDeleted', ['Logs']));
            return redirect()->to(route_to('logs-file'));
        }

        theme()->set_message_htmx('error', lang('Btw.unknownAction', ['Logs']));
        return redirect()->to(route_to('logs-file'));
    }
}