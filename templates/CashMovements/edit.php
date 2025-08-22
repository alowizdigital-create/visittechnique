<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CashMovement $cashMovement
 * @var string[]|\Cake\Collection\CollectionInterface $cashBoxes
 * @var string[]|\Cake\Collection\CollectionInterface $users
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $cashMovement->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $cashMovement->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Cash Movements'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="cashMovements form content">
            <?= $this->Form->create($cashMovement) ?>
            <fieldset>
                <legend><?= __('Edit Cash Movement') ?></legend>
                <?php
                    echo $this->Form->control('cash_box_id', ['options' => $cashBoxes]);
                    echo $this->Form->control('type');
                    echo $this->Form->control('montant');
                    echo $this->Form->control('motif');
                    echo $this->Form->control('user_id', ['options' => $users]);
                    echo $this->Form->control('justificatif');
                    echo $this->Form->control('create_uid');
                    echo $this->Form->control('uuid');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
