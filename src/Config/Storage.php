<?php


namespace Btw\Core\Config;


use Btw\Core\Libraries\Storage\Drivers\LocalDisk;
use Btw\Core\Libraries\Storage\Drivers\PublicDisk;
use Btw\Core\Libraries\Storage\Drivers\S3Disk;
use CodeIgniter\Config\BaseConfig;

class Storage extends BaseConfig
{
    /**
     * --------------------------------------------------------------------------
     * Storage Handler
     * --------------------------------------------------------------------------
     *
     * The name of the preferred handler that should be used. If for some reason
     * it is not available, the $backupHandler will be used in its place.
     *
     * @var string
     */
    public $disk = 'public';

    public $local = [
        'driver' => 'local',
        'basePath' => WRITEPATH . 'uploads' . DIRECTORY_SEPARATOR . 'local',
        'mode' => 0600
    ];

    public $public = [
        'driver' => 'public',
        'basePath' => WRITEPATH . 'uploads' . DIRECTORY_SEPARATOR . 'public',
        'baseUrl' => '/storage/',
        'mode' => 0664
    ];

    public $s3 = [
        'driver' => 's3',
        'endpoint' => 'example-bucket.s3-website.us-west-2.amazonaws.com',
        'accessKey' => 'access-key',
        'secretKey' => 'secret-key',
        'defaultRegion' => 'us-west-2',
        'bucket' => 'my-bucket',
    ];

    /**
     * --------------------------------------------------------------------------
     * Available Disk Drivers
     * --------------------------------------------------------------------------
     *
     * This is an array of driver engine alias' and class names. Only engines
     * that are listed here are allowed to be used.
     *
     * @var array<string, string>
     */
    public $validDrivers = [
        'local' => LocalDisk::class,
        'public' => PublicDisk::class,
        's3' => S3Disk::class,
    ];

    public function __construct()
    {
        parent::__construct();

        if (!empty($_ENV['app.baseURL'])) {
            $this->public['baseUrl'] = $_ENV['app.baseURL'];
        }
    }

    public $sizeImg = [
        'image150x150' => ['150', '150', 'center'],
        'image300x300' => ['300', '300', 'center'],
        'image600x600' => ['600', '600', 'center']
    ];

    public $watermark = false;

    public $watermarkTexte = 'adnduweb';

    public $watermarkDef = [
        'color' => '#fff',
        'opacity' => 0.5,
        'withShadow' => true,
        'hAlign' => 'center',
        'vAlign' => 'center',
        'fontSize' => 20
    ];

       //--------------------------------------------------------------------
    // Display Preferences
    //--------------------------------------------------------------------

     /**
     * By Page
     */
    public int $perPage = 8;

    /**
     * Display format for listing files.
     * Included options are 'cards', 'list', 'select'
     */
    public string $filesFormat = 'cards';

    /**
     * Default sort column.
     * See FileModel::$allowedFields for options.
     */
    public string $filesSort = 'file_name';

    /**
     * Default sort ordering. "asc" or "desc"
     */
    public string $filesOrder = 'asc';

}