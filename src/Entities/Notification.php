<?php

namespace Btw\Core\Entities;

use CodeIgniter\Entity\Entity;
use CodeIgniter\I18n\Time;
use DateTime;

class Notification extends Entity
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

    public function getTimestamp()
    {
        return $this->attributes['created_at'] = Time::parse($this->attributes['created_at'])->humanize();
    }

    public function getIcon()
    {

        return $this->attributes['icon'] =  theme()->getSVG('admin/images/icons/' . config('Notification')->typesNotify[$this->attributes['type_id']]['svg'], 'icon-notification grid place-content-center w-9 h-9 rounded-full bg-success-light dark:bg-success text-success dark:text-success-light', true);
    }
}
