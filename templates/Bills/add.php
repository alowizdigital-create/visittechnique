<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Bill $bill
 * @var \Cake\Collection\CollectionInterface|string[] $payments
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Bills'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="bills form content">
            <?= $this->Form->create($bill) ?>
            <fieldset>
                <legend><?= __('Add Bill') ?></legend>
                <?php
                    echo $this->Form->control('number');
                    echo $this->Form->control('amount');
                    echo $this->Form->control('payment_id', ['options' => $payments]);
                    echo $this->Form->control('note');
                    echo $this->Form->control('create_uid');
                    echo $this->Form->control('write_uid');
                    echo $this->Form->control('uuid');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
