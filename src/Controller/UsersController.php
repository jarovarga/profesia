<?php

declare(strict_types=1);

namespace App\Controller;

use App\src\Model\Entity\User;
use App\src\Model\Table\UsersTable;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Datasource\ResultSetInterface;
use Exception;
use Throwable;

use function App\Controller\__;

/**
 * @property UsersTable $Users
 *
 * @method User[]|ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    /**
     * Updates the profile of a user.
     *
     * This method is used to update the profile of a user identified by the given UUID.
     *
     * @param string $uuid The UUID of the user.
     *
     * @return void
     * @throws RecordNotFoundException When the user with the given UUID is not found.
     */
    public function profile(string $uuid): void
    {
        $user = $this->Users->get($uuid);

        $this->Authorization->authorize($user);

        if ($this->request->is('put')) {
            $data = $this->request->getData();

            $this->save($user, $data, [
                'accessibleFields' => [
                    'role' => false,
                    'is_public' => false,
                ],
            ]);

            $this->Authentication->getIdentity()->offsetSet(
                ['username' => $data['username']],
                ['email' => $data['email']]
            );
        }

        $this->set('user', $user);
    }

    /**
     * Impersonates a user by their UUID.
     *
     * @param string $uuid The UUID of the user to impersonate.
     *
     * @return void
     * @throws Exception
     */
    public function impersonate(string $uuid): void
    {
        $this->Authorization->authorize($this->Authentication->getIdentity());

        if ($this->Authentication->isImpersonating()) {
            $this->Authentication->stopImpersonating();
        }

        $this->Authentication->impersonate($this->Users->get($uuid));

        $this->redirect('/');
    }

    /**
     * Retrieves and displays a paginated list of users.
     *
     * @return void
     * @throws RecordNotFoundException if no users are found
     */
    public function index(): void
    {
        $users = $this->Users->find();

        $this->Authorization->authorize($users);

        $this->set('users', $this->paginate($users));
    }

    /**
     * Creates a new user entity and saves it to the database.
     *
     * @return void
     * @throws RecordNotFoundException
     */
    public function add(): void
    {
        $user = $this->Users->newEmptyEntity();

        $this->Authorization->authorize($user);

        if ($this->request->is('post')) {
            $this->save($user, $this->request->getData());
        }

        $this->set('user', $user);
    }

    /**
     * Edits a user record.
     *
     * @param string $uuid The UUID of the user to edit.
     *
     * @return void
     */
    public function edit(string $uuid): void
    {
        $user = $this->Users->get($uuid);

        $this->Authorization->authorize($user);

        if ($this->request->is('put')) {
            $this->save($user, $this->request->getData());
        }

        $this->set('user', $user);
    }

    /**
     * Saves user data.
     *
     * @param User $user The user entity to save.
     * @param array $data The data to be patched into the user entity.
     * @param array $options Additional options for saving the user entity (optional).
     *
     * @return void
     */
    private function save(User $user, array $data, array $options = []): void
    {
        try {
            $this->Users->patchEntity($user, $data, $options);
            $this->Users->saveOrFail($user);

            $this->Flash->success(__('Success!'));
        } catch (Throwable $e) {
            $this->log($e->getMessage());

            $this->Flash->error($e->getMessage());
        }
    }
}
