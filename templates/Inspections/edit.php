<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Inspection $inspection
 * @var string[]|\Cake\Collection\CollectionInterface $customers
 * @var string[]|\Cake\Collection\CollectionInterface $genders
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $inspection->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $inspection->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Inspections'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="inspections form content">
            <?= $this->Form->create($inspection) ?>
            <fieldset>
                <legend><?= __('Edit Inspection') ?></legend>
                <?php
                    echo $this->Form->control('name');
                    echo $this->Form->control('customer_id', ['options' => $customers]);
                    echo $this->Form->control('gender_id', ['options' => $genders]);
                    echo $this->Form->control('status');
                    echo $this->Form->control('end_date');
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
