<?php

namespace Btw\Core\Config;

use CodeIgniter\Events\Events;

// // use Btw\Core\Entities\User;
Events::on('post_system', static function () {
    service('activitys')->save();
});


// Events::on('notification', '\Btw\Core\Libraries\Notifications::store');
Events::on('notification', static function ($type, $object) {
    service('notifications')->store($type, $object);
});

// Events::on('userCreated', function (User $user) {
//     //send an email to registered user
//     service('notifications')->save();
// });

//minify html output on codeigniter 4 in production environment
Events::on('post_controller_constructor', function () {

    $allSegments = request()->getUri()->getSegments();

    if(!empty($allSegments)) {
        if(in_array($allSegments[0], ['attachments', 'assets', 'files', 'uploads', 'themes'])) {
            return false;
        }
    }

    $admin_area = empty($allSegments) || $allSegments[0] != ADMIN_AREA ? false : true;

    if (ENVIRONMENT == 'production' && $admin_area == false) {
        while (ob_get_level() > 0) {
            ob_end_flush();
        }

        ob_start(function ($buffer) {
            $search = array(
                '/\n/',      // replace end of line by a <del>space</del> nothing , if you want space make it down ' ' instead of ''
                '/\>[^\S ]+/s',    // strip whitespaces after tags, except space
                '/[^\S ]+\</s',    // strip whitespaces before tags, except space
                '/(\s)+/s',    // shorten multiple whitespace sequences
                '/<!--(.|\s)*?-->/' //remove HTML comments
            );

            $replace = array(
                '',
                '>',
                '<',
                '\\1',
                ''
            );

            $buffer = preg_replace($search, $replace, $buffer);
            return $buffer;
        });
    }
});
