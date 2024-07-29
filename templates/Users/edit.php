<?php

use App\Model\Entity\User;
use App\View\AppView;
use Cake\Collection\CollectionInterface;

/**
 * @var AppView $this
 * @var User $user
 * @var CollectionInterface $roles
 */

$this->assign('title', __('Edit'));

?>
<div class="grid">
    <div class="">
        <div class="controls">
            <h1><?= $this->fetch('title') ?> #<?= $user->id ?></h1>
        </div>
    </div>
    <div class="">
        <div class="panel">
            <div class="form">
                <?= $this->Form->create($user) ?>
                <div class="grid">
                    <div class="sm-6">
                        <?= $this->Form->control('username', [
                            'label' => __d('users', 'Username'),
                            'pattern' => '.{0,50}',
                            'required' => true,
                        ]) ?>
                    </div>
                    <div class="sm-6">
                        <?= $this->Form->control('email', [
                            'label' => __d('users', 'Email'),
                            'pattern' => '.{0,100}',
                        ]) ?>
                    </div>
                    <div class="sm-6">
                        <?= $this->Form->control('role_id', [
                            'type' => 'select',
                            'label' => __d('users', 'Role'),
                            'options' => $roles,
                        ]) ?>
                    </div>
                    <div class="sm-6">
                        <?= $this->Form->control('new_password', [
                            'type' => 'password',
                            'label' => __d('users', 'Password'),
                            'pattern' => '.{8,16}',
                        ]) ?>
                    </div>
                    <div class="">
                        <?= $this->Form->submit(__('Save')) ?>
                    </div>
                </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>
