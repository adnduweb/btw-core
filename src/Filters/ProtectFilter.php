<?php

declare(strict_types=1);

namespace Btw\Core\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\Response;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Shield\Authentication\Authenticators\Session;

/**
 * Session Authentication Filter.
 *
 * Email/Password-based authentication for web applications.
 */
class ProtectFilter implements FilterInterface
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

        $current = (string)current_url(true);

        /** @var Session $authenticator */
        $authenticator = auth('session')->getAuthenticator();


        if ($authenticator->isPending() == true) {

            // If an action has been defined for login, start it up.
            if ($authenticator->hasAction()) {
                if (!in_array('/' . $request->getPath(), [route_to('auth-action-show'), route_to('auth-action-handle'), route_to('auth-action-verify')]) && str_contains($request->getPath(), 'assets/')) {
                    return redirect()->route('auth-action-show')->withCookies();
                }
            }
        }

        if ($authenticator->loggedIn()) {

            if (in_array('/' . $request->getPath(), [route_to('login'), route_to('magic-link'), route_to('verify-magic-link'), route_to('auth-action-show'), route_to('auth-action-handle'), route_to('auth-action-verify')])) {
                return redirect()->route('dashboard');
            }
        }
    }

    /**
     * We don't have anything to do here.
     *
     * @param Response|ResponseInterface $response
     * @param array|null                 $arguments
     *
     * @return mixed
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
