<?php

namespace Btw\Core\Models;

use CodeIgniter\Model;
use Btw\Core\Entities\MediaLang;

class MediaLangModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'medias_translations';
    protected $primaryKey       = 'id_media_lang';
    protected $useAutoIncrement = true;
    protected $returnType       = MediaLang::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['media_id', 'lang', 'titre', 'legend', 'description'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
