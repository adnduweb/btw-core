<?php

/**
 * This file is part of Doudou.
 *
 * (c) Fabrice Loru <fabrice@adnduweb.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace Btw\Core\Libraries\Notice;

use Btw\Core\Libraries\Notice\NoticeCollection;
use Btw\Core\Models\NoticeModel;
use Btw\Core\Entities\Notice;

class Notices
{
    protected $objectAll = [];

    public function instance(Notice $notice)
    {
        /** @var notice $noticeConfig */
        $noticeConfig = config('Notice');

        $collection = new NoticeCollection();
        $collection->setId($notice->id);
        $collection->setCompanyId($notice->company_id);
        $collection->setUserId($notice->user_id);
        $collection->setTypeId($notice->type_id);
        $collection->setBadge($notice->type_id);
        $collection->setFrom($notice->from);
        $collection->setTo($notice->to);
        $collection->setName($notice->name);
        $collection->setDescription($notice->description);
        $collection->run();
        return $collection;

    }

    public function instanceAll()
    {
        $noticeModel = model(noticeModel::class);
        $noticeModel->where('from <="' . date('Y-m-d H:i:s') . '"');
        $noticeModel->where('to >="' . date('Y-m-d H:i:s') . '"');

        // print_r($noticeModel->join('notices_langs', 'notices_langs.notice_id = notices.id')->where('lang', service('language')->getLocale())->where('active', true)->findAll());
        // echo db_connect()->getLastQuery();
        // exit;

        foreach ($noticeModel->join('notices_langs', 'notices_langs.notice_id = notices.id')->where('lang', service('language')->getLocale())->where('active', true)->findAll() as $notice) {
            $this->objectAll[] = $this->instance($notice);
        }
        return $this;
    }


    public function getItemsGlobal()
    {
        return $this->objectAll;
    }

    public function getDisplay()
    {
        if(!empty($this->objectAll)) {
            $i = 0;
            foreach ($this->objectAll as &$notice) {
                if($notice->getItsMe() != 1) {
                    // unset($this->objectAll[$i]);
                }
                $i++;
            }
        }
        return $this;
    }

}
