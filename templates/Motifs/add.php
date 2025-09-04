<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Motif $motif
 * @var \Cake\Collection\CollectionInterface|string[] $startups
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Motifs'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="motifs form content">
            <?= $this->Form->create($motif) ?>
            <fieldset>
                <legend><?= __('Add Motif') ?></legend>
                <?php
                    echo $this->Form->control('content');
                    echo $this->Form->control('create_uid');
                    echo $this->Form->control('uuid');
                    echo $this->Form->control('startup_id', ['options' => $startups]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
