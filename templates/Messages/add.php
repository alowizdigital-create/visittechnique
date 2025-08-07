<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Message $message
 * @var \Cake\Collection\CollectionInterface|string[] $inspections
 * @var \Cake\Collection\CollectionInterface|string[] $customers
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Messages'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="messages form content">
            <?= $this->Form->create($message) ?>
            <fieldset>
                <legend><?= __('Add Message') ?></legend>
                <?php
                    echo $this->Form->control('sender_name');
                    echo $this->Form->control('receiver');
                    echo $this->Form->control('content');
                    echo $this->Form->control('create_uid');
                    echo $this->Form->control('write_uid');
                    echo $this->Form->control('uuid');
                    echo $this->Form->control('status');
                    echo $this->Form->control('sent_date');
                    echo $this->Form->control('response_code');
                    echo $this->Form->control('response_body');
                    echo $this->Form->control('parts');
                    echo $this->Form->control('inspection_id', ['options' => $inspections]);
                    echo $this->Form->control('customer_id', ['options' => $customers]);
                    echo $this->Form->control('direction');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
