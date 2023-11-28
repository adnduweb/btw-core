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
        // $content = strtr(addslashes($content), array("\n" => "\\n", "\r" => "\\r"));
        $this->encrypter = new Encrypt(['driver' => 'OpenSSL']);
        return $this->attributes['content'] = $this->encrypter->encrypt($content);
    }

    public function getContentPrep($content = null)
    {
        $content = $this->attributes['content'] ?? $content;
        $this->encrypter = new Encrypt(['driver' => 'OpenSSL']);
        $contentNew = $this->encrypter->decrypt($content);
        $contentNew = strtr(addslashes($contentNew), array("\n" => "\\n", "\r" => "\\r"));
        return $this->attributes['content'] = $contentNew;
    }

    public function getContentPrepFront($content = null)
    {
        $content = $this->attributes['content'] ?? $content;
        $this->encrypter = new Encrypt(['driver' => 'OpenSSL']);
        $contentNew = $this->encrypter->decrypt($content);
        return $this->attributes['content'] = $contentNew;
    }

    public function getAskAuthContent(string $controllerMethod)
    {
        $askAuth = session()->get('askAuth');

        if(isset($askAuth[$controllerMethod . '-ajaxdatatable' . '_' . $this->getIdentifier()])) {
            $entry = $askAuth[$controllerMethod . '-ajaxdatatable' . '_' . $this->getIdentifier()];
            return ['name' => $controllerMethod . '-ajaxdatatable' . '_' . $this->getIdentifier() , 'expire' => $entry];
        }
    }

    public function removeAskAuthContent(array $confirm_auth_content = null)
    {
        if(!is_array($confirm_auth_content)) {
            return false;
        }

        session()->remove(['askAuth' => $confirm_auth_content['name']]);
    }

    public function getAttrType()
    {
        $type = config('Customer')->typesInfos[$this->attributes['type']]['name'];
        return lang('Btw.types.' . $type);
    }

    public function displayShareNoteAction()
    {
        return true;
    }
}