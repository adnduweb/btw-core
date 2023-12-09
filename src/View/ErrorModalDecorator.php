<?php

namespace Btw\Core\View;

use CodeIgniter\View\ViewDecoratorInterface;

class ErrorModalDecorator implements ViewDecoratorInterface
{
    public static function decorate(string $html): string
    {
        if (CI_DEBUG
            && (!is_cli() || ENVIRONMENT === 'testing')
            && !service('request')->isHtmx()
            // && str_contains($html, '</body>')
            && config('Btw')->errorModalDecorator
            && str_contains($html, '</head>')
            && !str_contains($html, config('Btw')->skipViewDecoratorsString)
            && !str_contains($html, 'id="htmxErrorModalScript"')
        ) {
            $script = sprintf(
                '<script %s id="htmxErrorModalScript">%s</script>',
                csp_script_nonce(),
                file_get_contents(__DIR__ . '/error_modal_decorator.js')
            );

            $html = preg_replace(
                '/<\/body>/',
                $script . '</body>',
                $html,
                1
            );
        }

        return $html;
    }
}
