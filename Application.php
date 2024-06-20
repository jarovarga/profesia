<?php

declare(strict_types=1);

namespace App;

use Authentication\AuthenticationService;
use Authentication\AuthenticationServiceInterface;
use Authentication\AuthenticationServiceProviderInterface;
use Authentication\Identifier\AbstractIdentifier;
use Authentication\Middleware\AuthenticationMiddleware;
use Authorization\AuthorizationService;
use Authorization\AuthorizationServiceInterface;
use Authorization\AuthorizationServiceProviderInterface;
use Authorization\Middleware\AuthorizationMiddleware;
use Authorization\Policy\OrmResolver;
use Cake\Core\Configure;
use Cake\Core\ContainerInterface;
use Cake\Datasource\FactoryLocator;
use Cake\Error\Middleware\ErrorHandlerMiddleware;
use Cake\Http\BaseApplication;
use Cake\Http\MiddlewareQueue;
use Cake\Http\Middleware\BodyParserMiddleware;
use Cake\Http\Middleware\CsrfProtectionMiddleware;
use Cake\ORM\Locator\TableLocator;
use Cake\Routing\Middleware\AssetMiddleware;
use Cake\Routing\Middleware\RoutingMiddleware;
use Cake\Routing\Router;
use Psr\Http\Message\ServerRequestInterface;

class Application extends BaseApplication implements
    AuthenticationServiceProviderInterface,
    AuthorizationServiceProviderInterface
{
    /**
     * Bootstraps the application.
     *
     * This method should be called to initialize the application before it starts handling requests.
     * It performs necessary setup and configuration.
     *
     * @return void
     */
    public function bootstrap(): void
    {
        parent::bootstrap();

        if (PHP_SAPI !== 'cli') {
            FactoryLocator::add('Table', (new TableLocator())->allowFallbackClass(false));
        }
    }

    /**
     * Adds various middlewares to the middleware queue.
     *
     * @param MiddlewareQueue $middlewareQueue The middleware queue to add the middlewares to.
     *
     * @return MiddlewareQueue The updated middleware queue.
     */
    public function middleware(MiddlewareQueue $middlewareQueue): MiddlewareQueue
    {
        $middlewareQueue
            ->add(new ErrorHandlerMiddleware(Configure::read('Error'), $this))
            ->add(new AssetMiddleware([
                'cacheTime' => Configure::read('Asset.cacheTime'),
            ]))
            ->add(new RoutingMiddleware($this))
            ->add(new BodyParserMiddleware())
            ->add(new AuthenticationMiddleware($this))
            ->add(new AuthorizationMiddleware($this, [
                'identityDecorator' => function ($service, $user) {
                    return $user->setAuthorization($service);
                },
            ]))
            ->add(new CsrfProtectionMiddleware([
                'httponly' => true,
            ]));

        return $middlewareQueue;
    }

    /**
     * @param ContainerInterface $container
     *
     * @return void
     */
    public function services(ContainerInterface $container): void
    {
    }

    /**
     * Retrieves the authentication service for the given request.
     *
     * @param ServerRequestInterface $request The request object to extract parameters from.
     *
     * @return AuthenticationServiceInterface The authentication service instance.
     */
    public function getAuthenticationService(ServerRequestInterface $request): AuthenticationServiceInterface
    {
        $parameters = $request->getAttribute('params');
        $loginUrl = Router::url([
            'controller' => 'Auth',
            'action' => 'login',
            'plugin' => false,
            'prefix' => false,
        ]);
        $fields = [
            AbstractIdentifier::CREDENTIAL_USERNAME => 'email',
            AbstractIdentifier::CREDENTIAL_PASSWORD => 'password',
        ];

        return $this->createAuthenticationService($parameters, $loginUrl, $fields);
    }

    /**
     * Retrieves the authorization service for the given request.
     *
     * @param ServerRequestInterface $request The request object.
     *
     * @return AuthorizationServiceInterface The authorization service instance.
     */
    public function getAuthorizationService(ServerRequestInterface $request): AuthorizationServiceInterface
    {
        $resolver = new OrmResolver();

        return new AuthorizationService($resolver);
    }

    /**
     * Creates an authentication service instance.
     *
     * @param array $parameters The parameters extracted from the request.
     * @param string $loginUrl The URL to redirect an unauthenticated user to.
     * @param array $fields The fields used for authentication.
     *
     * @return AuthenticationServiceInterface The created authentication service instance.
     */
    private function createAuthenticationService(
        array $parameters,
        string $loginUrl,
        array $fields
    ): AuthenticationServiceInterface {
        $service = new AuthenticationService([
            'queryParam' => $parameters['action'] == 'logout' ? null : 'redirect',
            'unauthenticatedRedirect' => $loginUrl,
        ]);

        $service->loadAuthenticator('Authentication.Session');
        $service->loadAuthenticator('Authentication.Form', [
            'fields' => $fields,
            'loginUrl' => $loginUrl,
        ]);
        $service->loadIdentifier('Authentication.Password', [
            'fields' => $fields,
            'resolver' => [
                'className' => 'Authentication.Orm',
                'finder' => 'publicUser',
            ],
        ]);

        return $service;
    }
}
