<?php

use App\View\AppView;
use Cake\Utility\Hash;

/**
 * @var AppView $this
 * @var string $type
 * @var string $name
 * @var string $label
 * @var string $placeholder
 * @var array $options
 */

?>
<div class="form">
    <?= $this->Form->create(null, [
        'type' => 'get',
        'valueSources' => ['query'],
    ]); ?>
    <?php $resetUrl = $this->Url->build([
        '?' => Hash::remove($this->request->getQueryParams(), $name),
    ], ['escape' => false]); ?>
    <?php if ($type == 'text') : ?>
        <?= $this->Form->control($name, [
            'type' => 'text',
            'label' => $label,
            'placeholder' => $placeholder ?? $label,
            'pattern' => '.{3,}',
            'required' => true,
            'data-reset-url' => $resetUrl,
        ]); ?>
    <?php endif; ?>
    <?php if ($type == 'select') : ?>
        <?= $this->Form->control($name, [
            'type' => 'select',
            'label' => $label,
            'empty' => $placeholder ?? $label,
            'options' => $options,
            'required' => true,
            'data-reset-url' => $resetUrl,
            'onChange' => 'this.form.submit()',
        ]); ?>
    <?php endif; ?>
    <?php if ($type == 'date') : ?>
        <?= $this->Form->control($name, [
            'type' => 'date',
            'label' => $label,
            'pattern' => '\d{4}-\d{2}-\d{2}',
            'required' => true,
            'data-reset-url' => $resetUrl,
            'onChange' => 'this.form.submit()',
        ]); ?>
    <?php endif; ?>
    <?php foreach ($this->request->getQueryParams() as $key => $value) : ?>
        <?php if ($key != $name) : ?>
            <?= $this->Form->hidden($key, ['value' => $value]) ?>
        <?php endif; ?>
    <?php endforeach; ?>
    <?= $this->Form->end(); ?>
</div>
