<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CashBox $cashBox
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Cash Boxes'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="cashBoxes form content">
            <?= $this->Form->create($cashBox) ?>
            <fieldset>
                <legend><?= __('Add Cash Box') ?></legend>
                <?php
                    echo $this->Form->control('name');
                    echo $this->Form->control('solde_initial');
                    echo $this->Form->control('solde_actuel');
                    echo $this->Form->control('statut');
                    echo $this->Form->control('responsable_id');
                    echo $this->Form->control('create_uid');
                    echo $this->Form->control('uuid');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
