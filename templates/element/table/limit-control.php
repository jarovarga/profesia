<?php

use App\View\AppView;

/**
 * @var AppView $this
 */

?>
<div class="form">
    <?= $this->Form->create(null, [
        'type' => 'get',
        'valueSources' => ['query'],
    ]); ?>
    <?= $this->Form->control('limit', [
        'type' => 'select',
        'label' => __('Number of records'),
        'options' => [50 => '50', 100 => '100', 250 => '250', 500 => '500'],
        'onChange' => 'this.form.submit()',
    ]); ?>
    <?php foreach ($this->request->getQueryParams() as $key => $value) : ?>
        <?php if ($key != 'limit') : ?>
            <?= $this->Form->hidden($key, ['value' => $value]) ?>
        <?php endif; ?>
    <?php endforeach; ?>
    <?= $this->Form->end(); ?>
</div>
