<?php

namespace Btw\Core\Config;

use CodeIgniter\Events\Events;

Events::on('post_system', static function () {
    service('activitys')->save();
});
