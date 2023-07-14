<?php

namespace Btw\Core\Libraries\Storage\Drivers;

use Btw\Core\Config\Storage;
use Btw\Core\Libraries\Storage\Exceptions\StorageException;
use Btw\Core\Libraries\Storage\FileSystem;
use Btw\Core\Models\MediaModel;
use CodeIgniter\HTTP\Files\UploadedFile;
use Exception;
use RuntimeException;

class PublicDisk implements FileSystem
{
    protected $disk;
    protected $basePath;
    protected $baseUrl;
    protected $mode;

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
        }

        $this->makeDirectory($this->basePath . $path);

        $result = $content->move($this->basePath . $path, $fileName, $overwrite);


        // Diffrente taille
        if ($sizeImg = config('storage')->sizeImg) {

            foreach ($sizeImg as $item) {
                service('image')->withFile($this->basePath . $path . $fileName)
                    ->fit($item[0], $item[1], $item[2])
                    ->save(($this->basePath . $path . str_replace('.' . $ext, '-' . $item[0] . 'x' . $item[1] . '.' . $ext, $fileName)));
            }
        }



        if ($result) {
            $mode = $options['mode'] ?? $this->mode;
            chmod($this->basePath . $path . $fileName, $mode);
        }

        if ($result !== false) {
            $data = [
                'id' => '2',
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
     * Get file from storage.
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
     * Get file from storage.
     *
     * @param null $path
     * @param array $options
     * @return mixed
     */
    public function getFileUrl($idFile, $options = [])
    {

        if (is_null($idFile))
            return false;

        $media = model(MediaModel::class)->find($idFile);

        if ($media === false) {
            return false;
        }

    //@todo Add image par defaut
        if (empty($media->full_path))
            return false;

        if (($fileName = @file_get_contents($media->full_path)) === FALSE)
            return false;

        $file = new \CodeIgniter\Files\File($media->full_path);

        if (!empty($options) && is_array($options)) {
            if (isset($options['size'])) {
                $sizeImg = config('storage')->sizeImg[$options['size']];
                $new_file_url = str_replace('.' . $file->guessExtension(), '-' . $sizeImg[0] . 'x' . $sizeImg[1] . '.' . $file->guessExtension(), $media->file_url);
                return $new_file_url;
            }
        }

        return $media->getFileUrl();
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
            if ('.' === $file || '..' === $file)
                continue;
            if (is_dir($dir . DIRECTORY_SEPARATOR . $file))
                $this->deleteRecursive($dir . DIRECTORY_SEPARATOR . $file);
            else
                unlink($dir . DIRECTORY_SEPARATOR . $file);
        }
        return rmdir($dir);
    }
}
