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
            
            # First inject app div
            $html = str_replace('<body>', "<body>\n\t<div id=\"app\">", $html);
            # Close the div
            $html = str_replace('</body>', "\n\t</div>\n</body>", $html);

            # Get generated tags.
            $tags = Vite::tags();

            $jsTags  = $tags['js'];

            # now inject css
            if (!empty($tags['css'])) {
                $cssTags = $tags['css'];

                $html = str_replace('</head>', "\n\t$cssTags\n", $html);
                $html = str_replace('</body>', "\n\t$jsTags\n</body>", $html);
            } else {
                $html = str_replace('</head>', "\n\t$jsTags\n</head>", $html);
            }
        }

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
}
