<?php

namespace Btw\Core\Entities;

use CodeIgniter\Entity\Entity;
use Btw\Core\Libraries\Encrypt;

class Note extends Entity
{
    /**
     * Renders Datatable Identifier primary
     *
     * @return int
     */
    public function getIdentifier()
    {
        if (isset($this->attributes['identifier'])) {
            return $this->attributes['identifier'] ?? null;
        } else {
            return $this->attributes['id'] ?? null;
        }
    }

    /**
     * Renders Identifier UUID
     *
     * @return int
     */
    public function getIdentifierUUID()
    {
        return $this->attributes['uuid'] ?? null;
    }


    /**
     * Renders Datatable Url
     *
     * @return string
     */
    public function getUrlEditAdmin()
    {
        return route_to('note-information', $this->attributes['uuid']);
    }

    /**
     * Renders Front Url
     *
     * @return string
     */
    public function getPermalink()
    {
        return site_url(service('language')->getLocale() . '/notes/' . strtolower($this->attributes['type']));
    }

    public function setContentPrep($content)
    {
        $content = strtr(addslashes($content), array("\n" => "\\n", "\r" => "\\r"));
        $this->encrypter = new Encrypt(['driver' => 'OpenSSL']);
        return $this->attributes['content'] = $this->encrypter->encrypt($content);
    }

    public function getContentPrep($content = null)
    {
        $content = $this->attributes['content'] ?? $content;
        $this->encrypter = new Encrypt(['driver' => 'OpenSSL']);
        return $this->attributes['content'] = $this->encrypter->decrypt($content);
    }

    public function getAttrType()
    {
        $type = config('Customer')->typesInfos[$this->attributes['type']]['name'];
        return lang('Btw.types.' . $type);
    }

}
