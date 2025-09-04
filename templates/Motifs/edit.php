<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Motif $motif
 * @var string[]|\Cake\Collection\CollectionInterface $startups
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $motif->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $motif->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Motifs'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="motifs form content">
            <?= $this->Form->create($motif) ?>
            <fieldset>
                <legend><?= __('Edit Motif') ?></legend>
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
