<?php

namespace Btw\Core\Libraries\Storage\Drivers;

use Btw\Core\Config\Storage;
use Btw\Core\Libraries\Storage\Exceptions\StorageException;
use Btw\Core\Libraries\Storage\FileSystem;
use Btw\Core\Models\MediaModel;
use CodeIgniter\HTTP\Files\UploadedFile;
use Ramsey\Uuid\Uuid;
use Exception;
use RuntimeException;

class PublicDisk implements FileSystem
{
    protected $disk;
    protected $basePath;
    protected $baseUrl;
    protected $mode;
    /**
     * @var string
     */
    protected $cwebpPath;
    protected $quality;

    protected $new_file_url;

    /**
     * PublicDisk constructor.
     *
     * @param Storage $config
     * @throws StorageException|Exception
     */
    public function __construct(Storage $config)
    {
        $this->disk = $config->disk;

        if (!property_exists($config, 'public')) {
            $config->public = [
                'basePath' => WRITEPATH . 'uploads' . DIRECTORY_SEPARATOR . 'public',
            ];
        }

        $this->basePath = rtrim($config->public['basePath'], '/') . '/';
        $this->baseUrl = rtrim($config->public['baseUrl'], '/') . '/';

        if (!is_really_writable($this->basePath)) {
            throw StorageException::unableToWrite($this->basePath);
        }

        $this->mode = $config->file['mode'] ?? 0664;
        $this->quality = $config->default_quality;
        $this->cwebpPath = $config->cwebp['path'];
    }

    /**
     * Get driver client.
     *
     * @return mixed
     */
    public function getClient()
    {
        return null;
    }

    /**
     * Store or put file into storage.
     *
     * @param $content
     * @param null $path
     * @param array $options
     * @return mixed
     */
    public function store($content, $path = null, $options = [])
    {
        if (!$content->isValid()) {
            throw StorageException::contentIsInvalid();
        }

        $path = empty($path) ? '' : rtrim($path, '/') . '/';
        $fileName = $options['file_name'] ?? $content->getRandomName();
        $overwrite = $options['overwrite'] ?? false;
        $ext = $options['file_name'] ?? $content->guessExtension();

        $fileType = $options['mime_type'] ?? '';
        $fileSize = $options['file_size'] ?? 0;
        if ($content instanceof UploadedFile) {
            $fileType = $content->getMimeType();
            $fileSize = $content->getSize();
            $ext = $content->getClientExtension();
        }
        $companyPdf = $options['company_pdf'] ?? '';

        $this->makeDirectory($this->basePath . $path);

        $result = $content->move($this->basePath . $path, $fileName, $overwrite);

        if ($result) {
            $mode = $options['mode'] ?? $this->mode;
            chmod($this->basePath . $path . $fileName, $mode);
        }

        if (in_array($ext, config('Storage')->isImage)) {
            // Diffrente taille
            if ($sizeImg = setting('Storage.sizeImg')) {

                foreach ($sizeImg as $item) {
                    service('image')->withFile($this->basePath . $path . $fileName)
                        ->fit($item[0], $item[1], $item[2])
                        ->save(($this->basePath . $path . str_replace('.' . $ext, '-' . $item[0] . 'x' . $item[1] . '.' . $ext, $fileName)));

                    $cmd = $this->cwebpPath . ' -q ' . $this->quality . ' ' . ($this->basePath . $path . str_replace('.' . $ext, '-' . $item[0] . 'x' . $item[1] . '.' . $ext, $fileName)) . ' -o ' . ($this->basePath . $path . str_replace('.' . $ext, '-' . $item[0] . 'x' . $item[1] . '.' . $ext, $fileName)) . '.webp';
                    exec($cmd, $output, $exitCode);
                }
            }

            $cmd = $this->cwebpPath . ' -q ' . $this->quality . ' ' . $this->basePath . $path . $fileName . ' -o ' . ($this->basePath . $path . str_replace('.' . $ext, '-' . $item[0] . 'x' . $item[1] . '.' . $ext, $fileName)) . '.webp';
            exec($cmd, $output, $exitCode);

            if ($companyPdf) {
                service('image')->withFile($this->basePath . $path . $fileName)
                    ->resize(250, 200, true, 'width')
                    ->save(ROOTPATH . 'public/admin/images/logo-company' . $fileName);
            }
        }


        if ($result !== false) {
            $myuuid = Uuid::uuid4();
            $data = [
                // 'id' => '2',
                'uuid' => $myuuid,
                'disk' => $this->disk,
                'type' => $fileType,
                'size' => $fileSize,
                'path' => $path,
                'file_name' => $fileName,
                'file_path' => $path . $fileName,
                'file_url' => $this->baseUrl . $path . $fileName,
                'full_path' => $this->basePath . $path . $fileName,
            ];

            try {
                $mediaId = model(MediaModel::class)->insert($data);
            } catch (StorageException $e) {
                // return response()->triggerClientEvent('showMessage', ['type' => 'error', 'content' => model(MediaModel::class)->errors()]);
                // return redirect()->back()->withInput()->with('errors', model(MediaModel::class)->errors());
                throw new RuntimeException('Cannot get the pending login User.');
            }


            return $mediaId;
        }

        return $result;
    }
    /**
     * Store or put file into storage.
     *
     * @param $content
     * @param null $path
     * @param array $options
     * @return mixed
     */
    public function storeVsMore($idFile, $path = null, $sizeImg = [], bool $webp = true)
    {
        $media = model(MediaModel::class)->find($idFile);

        if ($media === false) {
            return false;
        }
        $path = empty($path) ? '' : rtrim($path, '/') . '/';
        $file = pathinfo(WRITEPATH . 'uploads' . DIRECTORY_SEPARATOR . $media->disk . DIRECTORY_SEPARATOR . $media->file_path);

        if (!empty($sizeImg)) {
            // Diffrente taille
            foreach ($sizeImg as $item) {
                service('image')->withFile($this->basePath . $path . $media->file_name)
                    ->fit($item[0], $item[1], $item[2])
                    ->save(($this->basePath . $path . str_replace('.' . $file['extension'], '-' . $item[0] . 'x' . $item[1] . '.' . $file['extension'], $media->file_name)));

                if ($webp == true) {
                    $cmd = $this->cwebpPath . ' -q ' . $this->quality . ' ' . ($this->basePath . $path . str_replace('.' . $file['extension'], '-' . $item[0] . 'x' . $item[1] . '.' . $file['extension'], $media->file_name)) . ' -o ' . ($this->basePath . $path . str_replace('.' . $file['extension'], '-' . $item[0] . 'x' . $item[1] . '.' . $file['extension'], $media->file_name)) . '.webp';
                    exec($cmd, $output, $exitCode);
                }
            }
        }

        return true;
    }

    /**
     * Get file from Storage.
     *
     * @param null $path
     * @param array $options
     * @return mixed
     */
    public function get($path = null, $options = [])
    {
        $contents = @file_get_contents($this->basePath . $path);

        if ($contents === false) {
            return false;
        }

        return [
            'location' => $this->basePath . $path,
            'path' => $path,
            'contents' => $contents
        ];
    }

    /**
     * Get file from Storage.
     *
     * @param null $path
     * @param array $options
     * @return mixed
     */
    public function getFileUrl($idFile, $options = [])
    {

        if (is_null($idFile)) {
            return base_url($this->getPlaceholderIn());
        }

        $media = model(MediaModel::class)->find($idFile);

        if ($media === false) {
            return base_url($this->getPlaceholderIn());
        }

        //@todo Add image par defaut
        if (empty($media->full_path)) {
            return base_url($this->getPlaceholderIn());
        }


        if (($fileName = @file_get_contents($media->full_path)) === false) {

            return base_url($this->getPlaceholderIn());
        }


        $file = new \CodeIgniter\Files\File($media->full_path);

        if (!empty($options) && is_array($options)) {
            if (isset($options['size'])) {
                $sizeImg = setting('Storage.sizeImg')[$options['size']];
                $new_full_path = str_replace('.' . $file->guessExtension(), '-' . $sizeImg[0] . 'x' . $sizeImg[1] . '.' . $file->guessExtension(), $media->full_path);
                if (($fileName = @file_get_contents($new_full_path)) === false) {
                    return base_url($this->getPlaceholderIn());
                } else {

                    $new_file_url = str_replace('.' . $file->guessExtension(), '-' . $sizeImg[0] . 'x' . $sizeImg[1] . '.' . $file->guessExtension(), $media->file_url);
                    return $new_file_url;
                }
            }
        }

        return $media->getFileUrl();
    }

    /**
     * Get placeholder from Storage.
     *
     * @param null $path
     * @param array $options
     * @return mixed
     */
    public function getPlaceholder($options = [])
    {
        $file = new \CodeIgniter\Files\File(WRITEPATH . 'uploads' . DIRECTORY_SEPARATOR . 'placeholder/placeholder.webp');
        $urlPlaceholder = str_replace(WRITEPATH, '/', $file->getPathName());
        $new_file_url = $urlPlaceholder;
        return base_url($new_file_url);
    }

    /**
     * Get placeholder in from Storage.
     *
     * @param null $path
     * @param array $options
     * @return mixed
     */
    public function getPlaceholderIn($options = [])
    {
        $file = new \CodeIgniter\Files\File(WRITEPATH . 'uploads' . DIRECTORY_SEPARATOR . 'placeholder/placeholder.webp');
        $urlPlaceholder = str_replace(WRITEPATH, '/', $file->getPathName());
        $this->new_file_url = $urlPlaceholder;
        return $this->new_file_url;
    }

    /**
     * Get placeholder img Data in from Storage.
     *
     * @param null $path
     * @param array $options
     * @return mixed
     */
    public function getPlaceholderImgdata($options = [])
    {
        $file = new \CodeIgniter\Files\File(WRITEPATH . 'uploads' . DIRECTORY_SEPARATOR . 'placeholder/placeholder.webp');
        return img_data($file->getPathName());
    }


    public function getFileBaseUrl($idFile, $options = [])
    {

        if (is_null($idFile)) {
            return false;
        }

        $media = model(MediaModel::class)->find($idFile);

        if ($media === false) {
            return false;
        }

        //@todo Add image par defaut
        if (empty($media->full_path)) {
            return false;
        }

        if (($fileName = @file_get_contents($media->full_path)) === false) {
            return false;
        }

        $file = new \CodeIgniter\Files\File($media->full_path);

        if ($file) {
            return ROOTPATH . 'public/admin/images/logo-company' . $media->file_name;
        }
    }

    public function getImgData($idFile, $options = [])
    {

        if (is_null($idFile)) {
            return $this->getPlaceholderImgdata();
        }

        $media = model(MediaModel::class)->find($idFile);

        if ($media === false) {
            return $this->getPlaceholderImgdata();
        }

        //@todo Add image par defaut
        if (empty($media->full_path)) {
            return $this->getPlaceholderImgdata();
        }


        if (($fileName = @file_get_contents($media->full_path)) === false) {

            return $this->getPlaceholderImgdata();
        }


        $file = new \CodeIgniter\Files\File($media->full_path);

        // print_r($media->getFileUrl());
        // print_r($file);
        // exit;

        if (!empty($options) && is_array($options)) {
            if (isset($options['size'])) {
                $sizeImg = setting('Storage.sizeImg')[$options['size']];
                $new_full_path = str_replace('.' . $file->guessExtension(), '-' . $sizeImg[0] . 'x' . $sizeImg[1] . '.' . $file->guessExtension(), $media->full_path);
                if (($fileName = @file_get_contents($new_full_path)) === false) {
                    return $this->getPlaceholderImgdata();
                } else {

                    $new_file_url = str_replace('.' . $file->guessExtension(), '-' . $sizeImg[0] . 'x' . $sizeImg[1] . '.' . $file->guessExtension(), $media->file_url);
                    img_data($new_file_url);
                }
            }
        }

        return img_data($file->getPathName());

    }

    /**
     * Get url of path (depends on url)
     *
     * @param $filePath
     * @return mixed
     */
    public function url($filePath)
    {
        return $this->basePath . $filePath;
    }

    /**
     * Create a directory.
     *
     * @param $path
     * @param array $options
     * @return bool
     */
    public function makeDirectory($path, $options = [])
    {
        $baseSource = rtrim($options['base_source'] ?? $this->basePath, '/') . '/';
        $mode = $options['mode'] ?? 0775;

        if (!file_exists($baseSource . $path) && is_writable($baseSource . $path)) {
            return mkdir($baseSource . $path, $mode, true);
        }
        return false;
    }

    /**
     * Copy data inside disk.
     *
     * @param $from
     * @param $to
     * @param array $options
     * @return mixed
     */
    public function copy($from, $to, $options = [])
    {
        $baseSource = rtrim($options['base_source'] ?? $this->basePath, '/') . '/';
        $baseDestination = rtrim($options['base_destination'] ?? $this->basePath, '/') . '/';

        $this->makeDirectory(dirname($to));
        if (file_exists($baseSource . $from) && is_writable($baseDestination . $to)) {
            return copy($baseSource . $from, $baseDestination . $to);
        }
        return false;
    }

    /**
     * Move data inside disk.
     *
     * @param $from
     * @param $to
     * @param array $options
     * @return mixed
     */
    public function move($from, $to, $options = [])
    {
        $baseSource = rtrim($options['base_source'] ?? $this->basePath, '/') . '/';
        $baseDestination = rtrim($options['base_destination'] ?? $this->basePath, '/') . '/';

        $this->makeDirectory(dirname($to));
        if (file_exists($baseSource . $from) && is_writable($baseDestination . $to)) {
            return rename($baseSource . $from, $baseDestination . $to);
        }
        return false;
    }

    /**
     * Delete data inside disk.
     *
     * @param $path
     * @return mixed
     */
    public function delete($path)
    {
        $fileName = $this->basePath . $path;
        if (file_exists($fileName) && is_writable($fileName)) {
            if (is_dir($fileName) && !empty($path)) {
                $this->deleteRecursive($fileName);
                return true;
            } else {
                return unlink($fileName);
            }
        }
        return false;
    }

    /**
     * Delete folder and its content recursively.
     *
     * @param $dir
     * @return bool
     */
    private function deleteRecursive($dir)
    {
        foreach (scandir($dir) as $file) {
            if ('.' === $file || '..' === $file) {
                continue;
            }
            if (is_dir($dir . DIRECTORY_SEPARATOR . $file)) {
                $this->deleteRecursive($dir . DIRECTORY_SEPARATOR . $file);
            } else {
                unlink($dir . DIRECTORY_SEPARATOR . $file);
            }
        }
        return rmdir($dir);
    }
}
