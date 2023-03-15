<?php

/**
 * This file is part of Bonfire.
 *
 * (c) Lonnie Ezell <lonnieje@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Btw\Core\Controllers\Admin;

use Btw\Core\Libraries\Logs;
use Btw\Core\Controllers\AdminController;

/**
 * Class Dashboard
 *
 * The primary entry-point to the Bonfire admin area.
 */
class ActivityController extends AdminController
{

    protected $viewPrefix = 'Btw\Core\Views\Admin\\activity\\files\\';

    protected $logsPath   = WRITEPATH . 'logs/';
    protected $logsLimit;
    protected $logsHandler;



    public function __construct()
    {
        helper('filesystem');
        $this->logsLimit   = setting('Site.perPage') ?? 10;
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

        return $this->render($this->viewPrefix . 'index', [
            'logs'  => $result['logs'],
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
    public function view(string $file = '')
    {
        helper('security');
        $file = sanitize_filename($file);

        if (empty($file) || ! file_exists($this->logsPath . $file)) {
            return redirect()->to(ADMIN_AREA . '/logs/files/list')->with('danger', lang('Logs.empty'));
        }

        $logs = $this->logsHandler->processFileLogs($this->logsPath . $file);

        $result = $this->logsHandler->paginateLogs($logs, $this->logsLimit);

        return $this->render($this->viewPrefix . 'view_log', [
            'logFile'       => $file,
            'canDelete'     => 1,
            'logContent'    => $result['logs'],
            'pager'         => $result['pager'],
            'logFilePretty' => date('F j, Y', strtotime(str_replace('.log', '', str_replace('log-', '', $file)))),
        ]);
    }
}
