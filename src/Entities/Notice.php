<?php

namespace Btw\Core\Entities;

use CodeIgniter\Entity\Entity;

class Notice extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];

    /**
     * Renders Datatable Identifier primary
     *
     * @return int
     */
    public function getIdentifier()
    {
        return $this->attributes['id'] ?? null;
    }

    public function getTitle()
    {
        return $this->attributes['name'] ?? null;
    }

    public function getDescription()
    {
        return $this->attributes['description'] ?? null;
    }

    public function getType()
    {
        return $this->attributes['type_id'] ?? null;
    }

    // public function setContent($content)
    // {
    //     $this->encrypter = new Encrypt(['driver' => 'OpenSSL']);
    //     return $this->attributes['content'] = $this->encrypter->encrypt($content);
    // }

    public function contentPrep($description = null)
    {
        $description = $this->attributes['description'] ?? $description;
        // $this->encrypter = new Encrypt(['driver' => 'OpenSSL']);
        // $descriptionNew = $this->encrypter->decrypt($description);
        $descriptionNew = strtr(addslashes($description), array("\n" => "\\n", "\r" => "\\r"));
        return $this->attributes['description'] = $descriptionNew;
    }

    public function getContentPrepFront($description = null)
    {
        $description = $this->attributes['description'] ?? $description;
        // $this->encrypter = new Encrypt(['driver' => 'OpenSSL']);
        $descriptionNew = $this->encrypter->decrypt($description);
        return $this->attributes['description'] = $descriptionNew;
    }

}
