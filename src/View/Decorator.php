<?php

namespace Btw\Core\View;

use CodeIgniter\View\ViewDecoratorInterface;

/**
 * Class Decorator
 *
 * Enables rendering of View Components into the views.
 */
class Decorator implements ViewDecoratorInterface
{
    private static ?ComponentRenderer $components = null;

    public static function decorate(string $html): string
    {

        //message ajax not htmx
        $html = self::message($html);
        $components = self::factory();

        return $components->render($html);
    }

    /**
     *  Factory method to create a new instance of ComponentRenderer
     */
    private static function factory(): ComponentRenderer
    {
        if (self::$components === null) {
            self::$components = new ComponentRenderer();
        }

        return self::$components;
    }

    public static function message($html)
    {
        $session = \Config\Services::session();

        $messageHTMX = $session->getFlashdata('messageHTMX');
        if (!empty($messageHTMX)) {
            // Split out the messageHTMX parts
            $temp_messageHTMX = explode('::', $messageHTMX);
            if (count($temp_messageHTMX) > 3) {
                $type = $temp_messageHTMX[0];
                $messageHTMX = $temp_messageHTMX[1];
                $title = $temp_messageHTMX[2];
            } else {
                $type = $temp_messageHTMX[0];
                $messageHTMX = $temp_messageHTMX[1];
                $title = $temp_messageHTMX[2];
            }

            unset($temp_messageHTMX);


            // If messageHTMX is empty, check the $messageHTMX property.
            if (empty($messageHTMX)) {
                if (empty(self::$messageHTMX['messageHTMX'])) {
                    return '';
                }
                $messageHTMX = unserialize(self::$messageHTMX['messageHTMX']);
                $type = self::$messageHTMX['type'];
                $title = self::$messageHTMX['title'];
            }
            $messageHTMX = unserialize($messageHTMX);
            $templateVarMessage = '';
            if (is_array($messageHTMX) && !empty($messageHTMX)) {
                $templateVarMessage .= '<ul>';
                foreach ($messageHTMX as $k => $v) {
                    $templateVarMessage .= '<li>' . addslashes($v) . '</li>';
                }
                $templateVarMessage .= '</ul>';
            } else {
                $templateVarMessage = addslashes($messageHTMX);
            }
            if (strpos($html, alertHtmx($type, $templateVarMessage)) === false) {
                $html = str_replace(
                    '<div id="alerts-wrapper" class="fixed inset-x-0 mx-auto bottom-5  max-w-xl sm:w-full space-y-5 z-50">',
                    '<div id="alerts-wrapper" class="fixed inset-x-0 mx-auto bottom-5  max-w-xl sm:w-full space-y-5 z-50">' . alertHtmx($type, $templateVarMessage),
                    $html
                );
            }
        }
        return $html;
    }
}