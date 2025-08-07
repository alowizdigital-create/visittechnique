<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Shortcut $shortcut
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $shortcut->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $shortcut->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Shortcuts'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="shortcuts form content">
            <?= $this->Form->create($shortcut) ?>
            <fieldset>
                <legend><?= __('Edit Shortcut') ?></legend>
                <?php
                    echo $this->Form->control('url');
                    echo $this->Form->control('shorturl');
                    echo $this->Form->control('uuid');
                    echo $this->Form->control('create_uid');
                    echo $this->Form->control('write_uid');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
