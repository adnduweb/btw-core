<?php

/**
 * This file is part of Btw.
 *
 * (c) Fabrice Loru <fabrice@adnduweb.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

 namespace Btw\Core\View;

class Vite
{

    /**
     * @var string manifest path.
     */
    private static $manifest = FCPATH . 'manifest.json';

    /**
     * Get vite entry file on running or bundled files instead.
     * 
     * @return array single script tag on developing and much more on production
     */
    public static function tags(): ?array
    {
        $result = [
            'js'    => null,
            'css'   => null
        ];

        # Check if vite is running.
        $entryFile = env('VITE_ORIGIN') . '/' . env('VITE_RESOURCES_DIR') . '/' . env('VITE_ENTRY_FILE');

        $result['js'] = @file_get_contents($entryFile) ? '<script type="module" src="' . $entryFile . '"></script>' : null;
        //$result['js'] = '<script type="module" src="' . $entryFile . '"></script>';

        # React HMR fix.
        if (!empty($result['js']))
        {
            $result['js'] = self::getReactTag() . $result['js'];
        }

        # If vite isn't running, then return the bundled resources.
        if (empty($result['js']) && is_file(self::$manifest))
        {
            # Get the manifest content.
            $manifest = file_get_contents(self::$manifest);
            # You look much pretty as a php object =).
            $manifest = json_decode($manifest);

            //  print_r($manifest); exit;

            # Now, we will get all js files and css from the manifest.
            foreach ($manifest as $file)
            {
                // print_r($file);exit; 
                # Check extension
                $fileExtension = substr($file->file, -3, 3);

                # Generate js tag.
                if ($fileExtension === '.js' && isset($file->isEntry) && $file->isEntry === true && (!isset($file->isDynamicEntry) || $file->isDynamicEntry !== true))
                {
                    $result['js'] .= '<script type="module" src="/' . $file->file . '"></script>' . "\n";
                }

                if (!empty($file->css))
                {
                    foreach ($file->css as $cssFile)
                    {
                        $result['css'] .= '<link rel="stylesheet" href="/' . $cssFile . '" />'. "\n";
                    }
                }
            }
        }

        return $result;
    }

    /**
     * Enable HMR for react.
     * 
     * @see https://vitejs.dev/guide/backend-integration.html
     * 
     * @return string|null a simple module script
     */
    public static function getReactTag(): ?string
    {
        if (env('VITE_FRAMEWORK') === 'react')
        {
            $origin = env('VITE_ORIGIN');
            $result = "<script type=\"module\">import RefreshRuntime from '$origin/@react-refresh';RefreshRuntime.injectIntoGlobalHook(window);window.\$RefreshReg\$ = () => {};window.\$RefreshSig\$ = () => (type) => type;window.__vite_plugin_react_preamble_installed__ = true;</script>";
            return "$result\n\t";
        }

        return null;
    }

    /**
     * Check whether vite is running or manifest does exist.
     * 
     * @return bool true if vite is runnig or if manifest does exist, otherwise false;
     */
    public static function isReady(): bool
    {
        $entryFile = env('VITE_ORIGIN') . '/' . env('VITE_RESOURCES_DIR') . '/' . env('VITE_ENTRY_FILE');

        switch (true)
        {
            case @file_get_contents($entryFile):
                $result = true;
                break;
            case is_file(self::$manifest):
                $result = true;
                break;

            default:
                $result = false;
        }

        return $result;
    }

	/**
	 * Check whether the current route is exluded or not.
	 * 
	 * @return bool
	 */
	public static function routeIsNotExluded(): bool
	{
		$routes = explode(',', env('VITE_EXCLUDED_ROUTES'));
		
		# remove spaces before and after the route.
		// foreach($routes as $i => $route) $routes[$i] = ltrim( rtrim($route) );

		return !in_array(uri_string(), $routes);
	}
}