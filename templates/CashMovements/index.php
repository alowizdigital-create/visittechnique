<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\CashMovement> $cashMovements
 */
?>
<div class="cashMovements index content">
    <?= $this->Html->link(__('New Cash Movement'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Cash Movements') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('cash_box_id') ?></th>
                    <th><?= $this->Paginator->sort('type') ?></th>
                    <th><?= $this->Paginator->sort('montant') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th><?= $this->Paginator->sort('justificatif') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th><?= $this->Paginator->sort('create_uid') ?></th>
                    <th><?= $this->Paginator->sort('uuid') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cashMovements as $cashMovement): ?>
                <tr>
                    <td><?= $this->Number->format($cashMovement->id) ?></td>
                    <td><?= $cashMovement->hasValue('cash_box') ? $this->Html->link($cashMovement->cash_box->name, ['controller' => 'CashBoxes', 'action' => 'view', $cashMovement->cash_box->id]) : '' ?></td>
                    <td><?= h($cashMovement->type) ?></td>
                    <td><?= $this->Number->format($cashMovement->montant) ?></td>
                    <td><?= $cashMovement->hasValue('user') ? $this->Html->link($cashMovement->user->firstname, ['controller' => 'Users', 'action' => 'view', $cashMovement->user->id]) : '' ?></td>
                    <td><?= h($cashMovement->justificatif) ?></td>
                    <td><?= h($cashMovement->created) ?></td>
                    <td><?= h($cashMovement->modified) ?></td>
                    <td><?= $this->Number->format($cashMovement->create_uid) ?></td>
                    <td><?= h($cashMovement->uuid) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $cashMovement->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $cashMovement->id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $cashMovement->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $cashMovement->id),
                            ]
                        ) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>