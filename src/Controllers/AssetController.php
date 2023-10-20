<?php

/**
 * This file is part of Btw.
 *
 * (c) Fabrice Loru <fabrice@adnduweb.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Btw\Core\Controllers;

use CodeIgniter\Controller;

/**
 * Responsible for serving css/js/image assets from
 * non-web-accessible folders as if they were in the
 * /assets folder.
 *
 * Folders to search are defined in Config\Assets.
 * The folder name becomes the place where the assets
 * is searched for.
 *
 * Example:
 * - A CSS file is stored in /themes/Admin/css.
 * - The folder is specified as 'admin' => ROOTPATH.'themes/Admin'
 * - You can link to the CSS file with 'asset('admin/css/theme.css')'
 */
class AssetController extends Controller
{
    /**
     * Locates and returns the file to the browser
     * with the correct mime-type.
     *
     * @param string ...$segments
     */
    public function serve(...$segments)
    {
        /**
         * De-bust the filename
         *
         * @var string
         */
        $filename     = array_pop($segments);
        $origFilename = $filename;
        $filename     = explode('.', $filename);

        // Must be at least a name and extension
        if (count($filename) < 2) {
            $this->response->setStatusCode(404);

            return;
        }

        // If we have a fingerprint...
        $filenameNew = count($filename) === 3
            ? $filename[0] . '.' . $filename[2]
            : $origFilename;

        // min
        if (str_contains($origFilename, '.min.')) {
            $filenameNew = count($filename) === 4
                ? $filename[0] . '.' . $filename[1] . '.' . end($filename)
                : $origFilename;
        }

        // min
        if (str_contains($origFilename, '.umd.min.')) {
            $filenameNew = count($filename) === 5
                ? $filename[0] . '.' . $filename[1] . '.' . $filename[2] . '.' . end($filename)
                : $origFilename;
        }

        $folder = config('Assets')->folders[array_shift($segments)];
        $path   = $folder . '/' . implode('/', $segments) . '/' . $filenameNew;

        if (!is_file($path)) {
            $this->response->setStatusCode(404);

            return;
        }

        return $this->response->download($origFilename, file_get_contents($path), true);
    }

    public function renderFile(...$segments)
    {
        if (count($segments) != 3) {
            //@todo
            //image par defaut au cas ou
            return false;
        }

        //@todo
        // list($base, $options) = explode('-', $segments[2]);
        // print_r($options);
        // print_r($segments); exit;

        // $year = $segments[0];
        // $month = $segments[1];
        // $file = $segments[2];

        $year = $segments[0];
        $month = $segments[1];
        $file = $segments[2];

        if (($fileName = @file_get_contents(WRITEPATH . 'uploads/' . config('Storage')->disk . '/attachments/' . $year . '/' . $month . '/' . $file)) === false) {
            $file = new \CodeIgniter\Files\File(WRITEPATH . 'uploads' . DIRECTORY_SEPARATOR . 'placeholder/placeholder.webp');
            $fileName = @file_get_contents(WRITEPATH . 'uploads' . DIRECTORY_SEPARATOR . 'placeholder/placeholder.webp');
            // choose the right mime type
            $mimeType = $file->getMimeType();

            return $this->response
                ->setStatusCode(200)
                ->setContentType($mimeType)
                ->setBody($fileName)
                ->send();
        }

        $file = new \CodeIgniter\Files\File(WRITEPATH . 'uploads/' . config('Storage')->disk . '/attachments/' . $year . '/' . $month . '/' . $file);

        // choose the right mime type
        $mimeType = $file->getMimeType();

        return $this->response
            ->setStatusCode(200)
            ->setContentType($mimeType)
            ->setBody($fileName)
            ->send();
        // print_r($segments); exit;

    }

    public function renderFilePLaceholder(...$segments)
    {

        if (count($segments) != 1) {
            return false;
        }

        $file = $segments[0];

        if (($fileName = file_get_contents(WRITEPATH . 'uploads/' . '/placeholder/' . $file)) === false) {
            return false;
        }

        $file = new \CodeIgniter\Files\File(WRITEPATH . 'uploads/' . '/placeholder/' . $file);

        // choose the right mime type
        $mimeType = $file->getMimeType();

        $this->response
            ->setStatusCode(200)
            ->setContentType($mimeType)
            ->setBody($fileName)
            ->send();
        // print_r($segments); exit;

    }

    public function serveTheme(...$segments)
    {
        /**
         * De-bust the filename
         *
         * @var string
         */
        $filename     = array_pop($segments);
        $origFilename = $filename;
        $filename     = explode('.', $filename);

        // Must be at least a name and extension
        if (count($filename) < 2) {
            $this->response->setStatusCode(404);
            return;
        }

        // If we have a fingerprint...
        $filename = $origFilename;

        $folder = config('Assets')->folders[array_shift($segments)];
        $path   = $folder . '/' . implode('/', $segments) . '/' . $filename;

        if (!is_file($path)) {
            $this->response->setStatusCode(404);

            return;
        }

        // return $this->response->download($origFilename, file_get_contents($path), true);
        $file = new \CodeIgniter\Files\File($path);

        // choose the right mime type
        $mimeType = $file->getMimeType();

        return $this->response
            ->setStatusCode(200)
            ->setContentType($mimeType)
            ->setBody(file_get_contents($path))
            ->send();
    }
}
