<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;
use Cake\Http\Response;
use Exception;

use function App\Controller\__d;

class AuthController extends AppController
{
    /**
     * Sets the layout to be used during rendering.
     *
     * @param EventInterface $event The event object.
     *
     * @return void
     */
    public function beforeRender(EventInterface $event): void
    {
        $this->viewBuilder()->setLayout('auth');
    }

    /**
     * Executes code before the specified event occurs.
     *
     * This method is called before the specified event occurs. It allows you
     * to perform any necessary setup or checks before the event logic executes.
     *
     * @param EventInterface $event The event object.
     *
     * @return void
     */
    public function beforeFilter(EventInterface $event): void
    {
        $this->request->allowMethod(['get', 'post']);

        $this->Authentication->allowUnauthenticated(['login']);
        $this->Authorization->skipAuthorization();
    }

    /**
     * Logs in a user.
     *
     * This method handles the login request and returns the response.
     *
     * If the user is already logged in and their authentication is valid, it will
     * redirect to the specified login redirect or the home page.
     *
     * If the authentication result is not valid and the request method is POST,
     * it will display an error message.
     *
     * @return ?Response The response object or null.
     */
    public function login(): ?Response
    {
        $result = $this->Authentication->getResult();

        if ($result->isValid()) {
            return $this->redirect($this->Authentication->getLoginRedirect() ?? '/');
        }

        if ($this->request->is('post') && !$result->isValid()) {
            $this->Flash->error(__d('auth', 'Incorrect email or password'));
        }

        return null;
    }

    /**
     * Logs out the authenticated user.
     *
     * If the user is currently impersonating another user, the method will stop
     * the impersonation and redirect to the home page.
     *
     * If the user is authenticated, the method will log out the user by
     * invalidating their session.
     *
     * @return Response The response object for redirecting to the login page.
     * @throws Exception
     */
    public function logout(): Response
    {
        if ($this->Authentication->isImpersonating()) {
            $this->Authentication->stopImpersonating();

            return $this->redirect('/');
        }

        $result = $this->Authentication->getResult();

        if ($result->isValid()) {
            $this->Authentication->logout();
        }

        return $this->redirect([
            'controller' => 'Auth',
            'action' => 'login',
        ]);
    }
}
