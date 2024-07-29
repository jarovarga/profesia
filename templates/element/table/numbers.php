<?php

use App\View\AppView;

/**
 * @var AppView $this
 */

?>
<ul class="numbers">
    <?= $this->Paginator->numbers([
        'modulus' => 4,
        'first' => 1,
        'last' => 1,
    ]) ?>
</ul>
