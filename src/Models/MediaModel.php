<?php

namespace Btw\Core\Models;

use CodeIgniter\Model;
use Btw\Core\Entities\Media;
use Btw\Core\Entities\MediaLang;
use Btw\Core\Models\MediaLangModel;

class MediaModel extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'medias';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $insertID = 0;
    protected $returnType = Media::class;
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['uuid', 'disk', 'type', 'size', 'path', 'file_name', 'file_path', 'file_url', 'full_path', 'created_at', 'updated_at'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // Validation
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = [];
    protected $afterInsert = ['insertLang'];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];

    protected $columns = [
        ['name' => 'selection', 'responsivePriority' => 1],
        [
            'name' => 'id',
            'orderable' => true,
            'header' => 'ID',
            'order_by_alias' => 'DESC',
        ],
        ['name' => 'filename', 'orderable' => true, 'header' => 'File name', 'order_by_name' => 'DESC', 'responsivePriority' => 2],
        ['name' => 'type', 'orderable' => true, 'header' => 'Type', 'order_by_type' => 'DESC'],
        ['name' => 'size', 'orderable' => true, 'header' => 'Taille', 'order_by_taille' => 'DESC'],
        ['name' => 'created_at', 'orderable' => true, 'header' => 'created_at', 'order_by_created' => 'DESC'],
        ['name' => 'action', 'header' => 'Action', 'order_by_alias' => NULL, 'responsivePriority' => 3]

    ];

    public function getColumn()
    {
        return $this->columns;
    }

    public function insertLang($params)
    {

        $mediaLangModel = model(MediaLangModel::class);
        $mediaLang = $mediaLangModel->find($params['id']) ?? new MediaLang();

        foreach (config('App')->supportedLocales as $lang) {

            $data['id_media_lang'] = isset($params['data']['id_media_lang']) ? $params['data']['id_media_lang'] : null;
            $data['media_id'] = $params['id'];
            $data['lang'] = $lang ?? service('language')->getLocale();
            $data['titre'] = isset($params['data']['titre']) ? $params['data']['titre'] : '';
            $data['legend'] = isset($params['data']['legend']) ? $params['data']['legend'] : '';
            $data['description'] = isset($params['data']['description']) ? $params['data']['description'] : '';

            $mediaLang->fill($data);

            // Try saving basic details
            try {
                if (!$mediaLangModel->save($mediaLang)) {
                    log_message('error', 'MEDIA ERRORS', $mediaLangModel->errors());
                    return $this->errors();
                }
            } catch (\Exception $e) {
                log_message('debug', 'SAVING MEDIA LANG: ' . $e->getMessage());
            }
        }

        return $params;

        // $mediaLangModel = model(MediaLangModel::class);
        // $mediaLang = $mediaLangModel->find($params['id']) ?? new MediaLang();

        // $data['id_media_lang'] = isset($params['data']['id_media_lang']) ? $params['data']['id_media_lang'] : null;
        // $data['media_id'] = $params['id'];
        // $data['lang'] = isset($params['data']['lang']) ? $params['data']['lang'] : service('language')->getLocale();
        // $data['titre'] = isset($params['data']['titre']) ? $params['data']['titre'] : '';
        // $data['legend'] = isset($params['data']['legend']) ? $params['data']['legend'] : '';
        // $data['description'] = isset($params['data']['description']) ? $params['data']['description'] : '';

        // $mediaLang->fill($data);

        // // Try saving basic details
        // try {
        //     if (!$mediaLangModel->save($mediaLang)) {
        //         log_message('error', 'MEDIA ERRORS', $mediaLangModel->errors());
        //         return $this->errors();
        //     }
        // } catch (\Exception $e) {
        //     log_message('debug', 'SAVING MEDIA LANG: ' . $e->getMessage());
        // }

        // return $params;
    }
}
