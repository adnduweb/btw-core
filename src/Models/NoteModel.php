<?php

namespace Btw\Core\Models;

use CodeIgniter\Model;
use Btw\Core\Entities\Note;

class NoteModel extends Model
{
    protected $table           = 'notes';
    protected $without         = [];
    protected $primaryKey      = 'id';
    protected $returnType      = Note::class;
    protected $useSoftDeletes  = true;
    protected $allowedFields    = ['company_id', 'user_id', 'type', 'titre', 'content'];
    protected $useTimestamps   = true;
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    protected $columns = [
        ['name' => 'selection',  'responsivePriority' => 1],
        ['name' => 'type', 'orderable' => true, 'header' => 'Type', 'order_by_name' => 'DESC', 'responsivePriority' => 2],
        ['name' => 'titre', 'orderable' => true, 'header' => 'Titre', 'order_by_lang' => 'DESC'],
        ['name' => 'content', 'orderable' => true, 'header' => 'Description', 'order_by_lang' => 'DESC'],
        ['name' => 'created_at', 'orderable' => true, 'header' => 'Date de création', 'order_by_lang' => 'DESC'],
        ['name' => 'action', 'header' => 'Action', 'order_by_alias' => null,  'responsivePriority' => 3]

    ];

    public function getColumn()
    {
        return $this->columns;
    }

    public function searchAll(string $search)
    {
        // $searchs = explode(" ", trim($search));
        $noteNew = [];
        $searchs = $search;
        if ($searchs) {

            $builder = $this->db->table('notes');
            $builder->groupStart();

            // foreach ($searchs as $s) {
            $builder->orLike('titre', $search)
                ->orLike('content', $search);
            // }
            $builder->groupEnd();
            $builder->where('user_id', Auth()->User()->id);

            $notes = $builder->get()->getResultArray();
            if(!empty($notes)) {
                foreach ($notes as $note) {
                    $noteNew[] = new Note($note);
                }
            }
            return $noteNew;

        }
    }
}