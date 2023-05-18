<?php

declare(strict_types=1);

namespace Btw\Core\Filters;

use Btw\Core\BtwCore;
use CodeIgniter\Filters\FilterInterface;
use Btw\Core\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class Admin implements FilterInterface
{
    /**
     * Do whatever processing this filter needs to do.
     * By default it should not return anything during
     * normal execution. However, when an abnormal state
     * is found, it should return an instance of
     * CodeIgniter\HTTP\Response. If it does, script
     * execution will end and that Response will be
     * sent back to the client, allowing for error pages,
     * redirects, etc.
     *
     * @param array|null $arguments
     *
     * @return mixed
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        helper(['auth', 'setting']);

        // Boot Btw
        (new BtwCore())->boot();
        $current = (string) current_url(true)->setHost('')->setScheme('')->stripQuery('token');

        if (!auth('session')->user()->can('admin.access')) {
            return redirect()->to('/')->with('error', lang('Btw.notAuthorized'));
        }


        //http://localhost:8080/admin1198009422/users


        //        // On controle les permissions
        // $controllerName = service('router')->controllerName();
        // $handle = explode('\\', $controllerName);
        // $end = end($handle);
        // $controller = strtolower(str_replace('Controller', '', $end));
        // $methodName = service('router')->methodName();

        // if ($request->isHtmx()) {
        //     // echo $controller . '.' . $methodName; exit;
        //     if (!auth('session')->user()->can($controller . '.' . $methodName)) {
        //        response()->triggerClientEvent('showMessage', ['type' => 'danger', 'content' => lang('Btw.notAuthorizedDebug', [$controller . '(' . $controller . '.' . $methodName . ')'])]);
        //        return redirect()->route('dashboard');
        //     }
        // } else {
        //    // echo $controller . '.' . $methodName; exit;
        //     if (!auth('session')->user()->can($controller . '.' . $methodName)) {
        //         return redirect()->route('dashboard')->with('error', lang('Btw.notAuthorized'));
        //     }
        // }

        // Restrict an IP address to no more than 1 request
        // per second across the entire site.
        if ($request->isHtmx()) {
           
            if (!$request->is('get') && ($request->is('post') || $request->is('json'))) {
                if (service('throttler')->check(md5($request->getIPAddress()), 10, MINUTE) === false) {
                    response()->triggerClientEvent('showMessage', ['type' => 'error', 'content' => lang('Auth.throttled', [service('throttler')->getTokenTime()])]);
                    return service('response')->setStatusCode(
                        429,
                        lang('Auth.throttled', [service('throttler')->getTokenTime()]) // message
                    )->setJson([
                        'message' => lang('Auth.throttled'), 
                        'time' => service('throttler')->getTokenTime(), 
                        'csrf_hash' => csrf_hash(),
                        'ip' => $request->getIPAddress()
                    ]);
                }
            }
        }


        // print_r($controller);
        // print_r($methodName);
        // exit;
    }

    /**
     * Allows After filters to inspect and modify the response
     * object as needed. This method does not allow any way
     * to stop execution of other after filters, short of
     * throwing an Exception or Error.
     *
     * @param array|null $arguments
     *
     * @return mixed
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {

        //    print_r($response); exit;

        $allSession = service('session')->getFlashdata();

        if (!empty($allSession)) {

            switch (key($allSession)) {
                case 'htmx:error':
                    $data['showMessage'] = ['type' => 'error', 'content' => lang('Btw.notAuthorized')];
                    $response->setHeader('HX-Trigger', json_encode($data));

                    $html = '<script type="module">
                    
                    // Create the event
                    let event = new CustomEvent("notify", {
                        bubbles: true,
                        cancelable: true,
                        detail: {
                            content: "' . lang('Btw.notAuthorized') . '",
                            type: "error",
                          }
                    });
                    // Emit the event
                    document.dispatchEvent(event);
                    </script>';

                    $body = str_replace('{CustomEvent}', $html, $response->getBody());

                    // Use the new body and return the updated Response
                    return $response->setBody($body);

                    break;
                default:
                // silent
            }

            $body = str_replace('{CustomEvent}', '<script type="module"></script>', $response->getBody());
            return $response->setBody($body);

        }

        $body = str_replace('{CustomEvent}', '<script type="module"></script>', $response->getBody());
        return $response->setBody($body);

        // print_r($allSession);
        // exit;
    }
}