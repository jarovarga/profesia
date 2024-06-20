<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;

class ErrorController extends AppController
{
    /**
     * Initializes the method.
     *
     * @return void
     */
    public function initialize(): void
    {
    }

    /**
     * Executes before the controller action is called.
     *
     * @param EventInterface $event The event instance.
     *
     * @return void
     */
    public function beforeFilter(EventInterface $event): void
    {
    }

    /**
     * Set up the error page view before rendering.
     *
     * @param EventInterface $event The event object for before render.
     *
     * @return void
     */
    public function beforeRender(EventInterface $event): void
    {
        $this->setupErrorPageView();
    }

    /**
     * Applies logic after a filter has been executed.
     *
     * @param EventInterface $event The event object representing the filter event.
     *
     * @return void
     */
    public function afterFilter(EventInterface $event): void
    {
    }

    /**
     * Sets up the error page view.
     *
     * This method configures the template path and layout for the error page view.
     * It sets the template path to 'Error' and the layout to 'error'.
     *
     * @return void
     */
    private function setupErrorPageView(): void
    {
        $this->viewBuilder()->setTemplatePath('Error');
        $this->viewBuilder()->setLayout('error');
    }
}
