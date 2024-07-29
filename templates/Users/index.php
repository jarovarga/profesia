<?php

use App\Model\Entity\User;
use App\Model\Enum\UserRole;
use App\View\AppView;
use Cake\Collection\CollectionInterface;

/**
 * @var AppView $this
 * @var User[]|CollectionInterface $users
 * @var CollectionInterface $roles
 */

$this->assign('title', __d('users', 'Users'));

?>
<div class="grid">
    <div class="">
        <div class="controls">
            <h1><?= $this->fetch('title') ?></h1>
            <ul class="actions">
                <li class="actions__item">
                    <?= $this->Html->tag('button', __('Export'), [
                        'data-api-url' => $this->Url->build(['action' => 'export'], ['fullBase' => true]),
                        'data-ajax-mode' => 'export',
                    ]) ?>
                </li>
                <li class="actions__item">
                    <?= $this->Html->tag('button', __('Add'), [
                        'data-api-url' => $this->Url->build(['action' => 'add'], ['fullBase' => true]),
                        'data-ajax-mode' => 'template',
                    ]) ?>
                </li>
            </ul>
        </div>
    </div>
    <div class="">
        <div class="panel">
            <div class="table">
                <div class="table__controls">
                    <div class="table__counter">
                        <?= $this->element('table/counter') ?>
                    </div>
                    <div class="table__paginate">
                        <?= $this->element('table/numbers') ?>
                    </div>
                </div>
                <div class="table__container">
                    <table>
                        <thead>
                            <tr class="table__sort">
                                <th class="table__bulk-action"></th>
                                <th><?= $this->Paginator->sort('username', __d('users', 'Username')) ?></th>
                                <th><?= $this->Paginator->sort('email', __d('users', 'Email')) ?></th>
                                <th><?= $this->Paginator->sort('role', __d('users', 'Role')) ?></th>
                            </tr>
                            <tr class="table__filter">
                                <th class="table__bulk-action"><label>
                                        <input type="checkbox" name="select-all">
                                    </label></th>
                                <th><?= $this->element('table/filter', [
                                        'type' => 'text',
                                        'name' => 'identifier',
                                        'label' => __d('filter', 'Search for a username'),
                                    ]) ?></th>
                                <th><?= $this->element('table/filter', [
                                        'type' => 'text',
                                        'name' => 'email',
                                        'label' => __d('filter', 'Search for an email'),
                                    ]) ?></th>
                                <th><?= $this->element('table/filter', [
                                        'type' => 'select',
                                        'name' => 'role',
                                        'label' => __d('filter', 'Search for a role'),
                                        'options' => $roles,
                                    ]) ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user) : ?>
                                <tr data-api-url="<?= $this->Url->build([
                                    'action' => 'edit',
                                    $user->id,
                                ]) ?>" data-ajax-mode="template">
                                    <td class="table__bulk-action"><label>
                                            <input type="checkbox" name="export[]" value="<?= $user->id ?>">
                                        </label></td>
                                    <td><?= $user->username ?></td>
                                    <td><?= $user->email ?></td>
                                    <td><?= UserRole::from($user->role)->name ?></td>
                                </tr>
                            <?php endforeach; ?>
                            <?php if ($users->isEmpty()) : ?>
                                <tr>
                                    <td colspan="3"><?= __d('table', 'No records found') ?></td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <div class="table__controls">
                    <div class="table__limit-control">
                        <?= $this->element('table/limit-control') ?>
                    </div>
                    <div class="table__paginate">
                        <?= $this->element('table/numbers') ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
