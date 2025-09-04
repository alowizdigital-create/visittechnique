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
            <?= $this->Html->link(__('List Startups'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="startups form content">
            <?= $this->Form->create($startup) ?>
            <fieldset>
                <legend><?= __('Add Startup') ?></legend>
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
