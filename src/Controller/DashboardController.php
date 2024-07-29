<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;

class DashboardController extends AppController
{
    /**
     * Applies authorization filter before the action is executed.
     *
     * @param EventInterface $event The event object.
     *
     * @return void
     */
    public function beforeFilter(EventInterface $event): void
    {
        $this->Authorization->skipAuthorization();
    }

    /**
     * Index method
     *
     * This method serves as the entry point of the application.
     *
     * @return void
     */
    public function index(): void
    {
    }
}
