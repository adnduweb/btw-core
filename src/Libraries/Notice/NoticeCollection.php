<?php

/**
 * This file is part of BillingTrack.
 *
 *
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Btw\Core\Libraries\Notice;

use Btw\Core\Libraries\Notice\Collection;

class NoticeCollection extends Collection
{
    protected $itsMe;

    /**
     * Call the calculation methods.
     */
    public function run()
    {

        $this->detectDisplay();

    }

    public function setItsMe($itsMe)
    {
        $this->itsMe = $itsMe;
    }


    public function getItsMe()
    {
        return $this->itsMe;
    }

    /**
        * Set the total paid amount.
        *
        * @param float $totalPaid
        */
    public function detectDisplay()
    {
        $itsMe = false;

        // All Company or your company
        if($this->getCompanyId() == 0 || $this->getCompanyId() == Auth()->user()->company_id) {
            $itsMe = true;
        }
        // In company
        if($itsMe != false) {
            if($this->getUserId() == 0 || $this->getUserId() == Auth()->user()->id) {
                $itsMe = true;
            } else {
                $itsMe = false;
            }
        }

        // Search Date
        if($this->getFrom() != '0000-00-00 00:00:00' && $this->getTo() != '0000-00-00 00:00:00') {
            if(strtotime(date('Y-m-d H:i:s')) >= strtotime($this->getFrom()) && strtotime(date('Y-m-d H:i:s')) <= strtotime($this->getTo())) {
                $itsMe = true;
            } else {
                $itsMe = false;
            }
        }

        $this->setItsMe($itsMe);
    }
}
