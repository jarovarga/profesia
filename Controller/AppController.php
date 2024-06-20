<?php

declare(strict_types=1);

namespace App\Controller;

use Authentication\Controller\Component\AuthenticationComponent;
use Authorization\Controller\Component\AuthorizationComponent;
use Cake\Controller\Controller;
use Exception;

/**
 * @property AuthenticationComponent $Authentication
 * @property AuthorizationComponent $Authorization
 */
class AppController extends Controller
{
    /**
     * Pagination configuration options.
     *
     * This variable is used to configure pagination options for a specific action in a controller.
     *
     * @var array
     */
    protected array $paginate = [
        'limit' => 10,
        'maxLimit' => 100,
        'order' => ['created' => 'DESC'],
    ];

    /**
     * Initialize the class.
     *
     * This method is called after the constructor.
     * It is used to set up any initial configurations or dependencies needed by the class.
     *
     * @return void
     * @throws Exception
     */
    public function initialize(): void
    {
        $this->loadComponents();
        $this->configureViewBuilder();
        $this->configureResponse();
    }

    /**
     * Load the necessary components for the current controller.
     *
     * @return void
     * @throws Exception
     */
    private function loadComponents(): void
    {
        $this->loadComponent('Flash');
        $this->loadComponent('FormProtection');
        $this->loadComponent('Authentication.Authentication');
        $this->loadComponent('Authorization.Authorization');
    }

    /**
     * Configure the view builder options.
     *
     * @return void
     */
    private function configureViewBuilder(): void
    {
        $this->viewBuilder()
            ->setOption('serialize', true)
            ->setOption('jsonOptions', JSON_FORCE_OBJECT);
    }

    /**
     * Configures the response object.
     *
     * This method sets the expiration time to '+0 seconds' and adds a custom header with the key 'X-CakePHP' and value '`Yes!' to the response object.
     *
     * @return void
     */
    private function configureResponse(): void
    {
        $this->response = $this->response
            ->withExpires('+0 seconds')
            ->withHeader('X-CakePHP', '`Yes!');
    }
}
