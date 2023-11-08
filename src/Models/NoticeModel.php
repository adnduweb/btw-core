<?php

namespace Btw\Core\Models;

use CodeIgniter\Model;
use Btw\Core\Entities\Notice;
use Btw\Core\Entities\NoticeLang;
use Btw\Core\Models\NoticeLangModel;
use Btw\Core\Traits\ModelTrait;

class NoticeModel extends Model
{
    use ModelTrait;

    protected $table            = 'notices';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType      = Notice::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['company_id', 'user_id', 'active', 'order'];

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

    protected $columns = [
        ['name' => 'selection',  'responsivePriority' => 1],
        ['name' => 'type', 'orderable' => true, 'header' => 'Type', 'order_by_name' => 'DESC', 'responsivePriority' => 2],
        ['name' => 'titre', 'orderable' => true, 'header' => 'Titre', 'order_by_lang' => 'DESC'],
        ['name' => 'content', 'orderable' => true, 'header' => 'Description', 'order_by_lang' => 'DESC'],
        ['name' => 'created_at', 'orderable' => true, 'header' => 'Date de création', 'order_by_lang' => 'DESC'],
        ['name' => 'action', 'header' => 'Action', 'order_by_alias' => null,  'responsivePriority' => 3]

    ];


    // Callbacks
    protected $allowCallbacks = true;
    protected $afterInsert    = ['saveLang'];
    protected $afterUpdate    = ['saveLang'];
    protected $lang             = true;

    public function getColumn()
    {
        return $this->columns;
    }

    /**
     * Save lang
     *
     * Model event callback called by `afterInsert` and `afterUpdate`.
     */
    protected function saveLang(array $data): array
    {
        if ($this->tmpWithLang == true) {

            $request = request()->getPost();

            $noticeslang =  model(NoticeLangModel::class);

            // print_r($data);
            // exit;

            // Search if lang insert
            $noticeAllLang = $noticeslang->where(['notice_id' => $data['id']])->findAll();

            if(empty($noticeAllLang)) {
                foreach(config('Btw')->supportedLocales as $key => $locale) {
                    $noticeLang = $noticeslang->where(['notice_id' => $data['id'], 'lang' => $key])->first();
                    if(empty($noticeLang)) {
                        $noticeLang = new NoticeLang();
                        $noticeLang->fill($request);
                        $noticeLang->lang = $key;
                        $noticeLang->notice_id = $data['id'];

                        $noticeslang->save($noticeLang);
                        log_message('info', 'Notice Lang save {noticeLang}', ['noticeLang' => json_encode($noticeLang, JSON_UNESCAPED_SLASHES)]);
                    }
                }

            }
            // print_r($noticeAllLang);
            // exit;

            $noticeLang = $noticeslang->where(['notice_id' => $data['id'], 'lang' => $request['lang']])->first() ?? new NoticeLang();
            $noticeLang->fill($request);
            $noticeLang->notice_id = $data['id'];

            // config('Btw')->supportedLocales;

            $noticeslang->save($noticeLang);
            log_message('info', 'Notice Lang save {noticeLang}', ['noticeLang' => json_encode($noticeLang, JSON_UNESCAPED_SLASHES)]);

            return $data;
        }
    }


}
