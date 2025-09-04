<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Startup $startup
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $startup->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $startup->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Startups'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="startups form content">
            <?= $this->Form->create($startup) ?>
            <fieldset>
                <legend><?= __('Edit Startup') ?></legend>
                <?php
                    echo $this->Form->control('name');
                    echo $this->Form->control('create_uid');
                    echo $this->Form->control('uuid');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
