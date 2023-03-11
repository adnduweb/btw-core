<?php

namespace Btw\Core\Entities;

use CodeIgniter\Entity\Entity;
use CodeIgniter\I18n\Time;
use \DateTime;

class Session extends Entity
{

    protected $agent;

    public function getAgent()
    {
        $this->agent = new \WhichBrowser\Parser($this->attributes['user_agent']);
        $this->attributes['agent'] = $this->agent;

        return $this->attributes['agent'];
    }

    public function getTimestamp()
    {
        return $this->attributes['date_session'] = Time::parse($this->attributes['timestamp'])->humanize();
    }
}
