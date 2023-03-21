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

        # Check whether vite is running or manifest is ready.
        if (env('VITE_AUTO_INJECTING') && Vite::routeIsNotExluded()) {


            if (Vite::isReady() === false) {
                throw new \Exception('CodeIgniter Vite package is installed, but not initialized. did you run "php spark vite:init" ?');
            }

            # Get generated tags.
            $tags = Vite::tags();

            // var_dump($tags['js']);
            // exit;

            $jsTags  = $tags['js'];

            # now inject css
            if (!empty($tags['css'])) {
                $cssTags = $tags['css'];

                if (strpos($html, "\n\t$cssTags\n") === false) {
                    $html = str_replace('</head>', "\n\t$cssTags\n</head>", $html);
                }

                if (strpos($html, "\n\t$jsTags\n") === false) {
                    $html = str_replace('</main>', "\n\t$jsTags\n</main>", $html);
                }
            } else {
                if (strpos($html, "\n\t$jsTags\n") === false) {
                    $html = str_replace('</head>', "\n\t$jsTags\n</head>", $html);
                }
            }
        }

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

        $message = $session->getFlashdata('message');
        if (!empty($message)) {
            // Split out the message parts
            $temp_message = explode('::', $message);
            if (count($temp_message) > 3) {
                $type = $temp_message[0];
                $message = $temp_message[1];
                $title = $temp_message[2];
            } else {
                $type = $temp_message[0];
                $message = $temp_message[1];
                $title = $temp_message[2];
            }

            unset($temp_message);


            // If message is empty, check the $message property.
            if (empty($message)) {
                if (empty(self::$message['message'])) {
                    return '';
                }
                $message = unserialize(self::$message['message']);
                $type = self::$message['type'];
                $title = self::$message['title'];
            }
            $message = unserialize($message);
            $templateVarMessage = '';
            if (is_array($message) && !empty($message)) {
                $templateVarMessage .= '<ul>';
                foreach ($message as $k => $v) {
                    $templateVarMessage .= '<li>' . addslashes($v) . '</li>';
                }
                $templateVarMessage .= '</ul>';
            } else {
                $templateVarMessage = addslashes($message);
            }
            if (strpos($html, alertHtmx($type, $templateVarMessage)) === false) {
                $html = str_replace('<div id="alerts-wrapper" class="fixed inset-x-0 mx-auto bottom-5  max-w-xl sm:w-full space-y-5 z-50">', '<div id="alerts-wrapper" class="fixed inset-x-0 mx-auto bottom-5  max-w-xl sm:w-full space-y-5 z-50">' . alertHtmx($type, $templateVarMessage), $html);
            }
        }
        return $html;
    }
}
