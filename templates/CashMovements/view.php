<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CashMovement $cashMovement
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Cash Movement'), ['action' => 'edit', $cashMovement->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Cash Movement'), ['action' => 'delete', $cashMovement->id], ['confirm' => __('Are you sure you want to delete # {0}?', $cashMovement->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Cash Movements'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Cash Movement'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="cashMovements view content">
            <h3><?= h($cashMovement->uuid) ?></h3>
            <table>
                <tr>
                    <th><?= __('Cash Box') ?></th>
                    <td><?= $cashMovement->hasValue('cash_box') ? $this->Html->link($cashMovement->cash_box->name, ['controller' => 'CashBoxes', 'action' => 'view', $cashMovement->cash_box->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Type') ?></th>
                    <td><?= h($cashMovement->type) ?></td>
                </tr>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $cashMovement->hasValue('user') ? $this->Html->link($cashMovement->user->firstname, ['controller' => 'Users', 'action' => 'view', $cashMovement->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Justificatif') ?></th>
                    <td><?= h($cashMovement->justificatif) ?></td>
                </tr>
                <tr>
                    <th><?= __('Uuid') ?></th>
                    <td><?= h($cashMovement->uuid) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($cashMovement->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Montant') ?></th>
                    <td><?= $this->Number->format($cashMovement->montant) ?></td>
                </tr>
                <tr>
                    <th><?= __('Create Uid') ?></th>
                    <td><?= $this->Number->format($cashMovement->create_uid) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($cashMovement->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($cashMovement->modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Motif') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($cashMovement->motif)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>