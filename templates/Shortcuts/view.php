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
            <?= $this->Html->link(__('Edit Shortcut'), ['action' => 'edit', $shortcut->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Shortcut'), ['action' => 'delete', $shortcut->id], ['confirm' => __('Are you sure you want to delete # {0}?', $shortcut->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Shortcuts'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Shortcut'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="shortcuts view content">
            <h3><?= h($shortcut->url) ?></h3>
            <table>
                <tr>
                    <th><?= __('Url') ?></th>
                    <td><?= h($shortcut->url) ?></td>
                </tr>
                <tr>
                    <th><?= __('Shorturl') ?></th>
                    <td><?= h($shortcut->shorturl) ?></td>
                </tr>
                <tr>
                    <th><?= __('Uuid') ?></th>
                    <td><?= h($shortcut->uuid) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($shortcut->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Create Uid') ?></th>
                    <td><?= $this->Number->format($shortcut->create_uid) ?></td>
                </tr>
                <tr>
                    <th><?= __('Write Uid') ?></th>
                    <td><?= $this->Number->format($shortcut->write_uid) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($shortcut->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($shortcut->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>