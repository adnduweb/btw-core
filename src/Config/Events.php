<?php

namespace Btw\Core\Config;

use CodeIgniter\Events\Events;
// // use Btw\Core\Entities\User;
Events::on('post_system', static function () {
    service('activitys')->save();
});


// Events::on('userCreated', function (User $user) {
//     //send an email to registered user
//     service('notifications')->save();
// });