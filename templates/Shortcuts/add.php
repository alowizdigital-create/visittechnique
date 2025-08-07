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
            <?= $this->Html->link(__('List Shortcuts'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="shortcuts form content">
            <?= $this->Form->create() ?>
            <fieldset>
                <legend><?= __('Add Shortcut') ?></legend>
                <?php
                    echo $this->Form->control('url');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
