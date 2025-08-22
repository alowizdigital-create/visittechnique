<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CashBox $cashBox
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Cash Box'), ['action' => 'edit', $cashBox->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Cash Box'), ['action' => 'delete', $cashBox->id], ['confirm' => __('Are you sure you want to delete # {0}?', $cashBox->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Cash Boxes'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Cash Box'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="cashBoxes view content">
            <h3><?= h($cashBox->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($cashBox->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Statut') ?></th>
                    <td><?= h($cashBox->statut) ?></td>
                </tr>
                <tr>
                    <th><?= __('Uuid') ?></th>
                    <td><?= h($cashBox->uuid) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($cashBox->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Solde Initial') ?></th>
                    <td><?= $this->Number->format($cashBox->solde_initial) ?></td>
                </tr>
                <tr>
                    <th><?= __('Solde Actuel') ?></th>
                    <td><?= $this->Number->format($cashBox->solde_actuel) ?></td>
                </tr>
                <tr>
                    <th><?= __('Responsable Id') ?></th>
                    <td><?= $this->Number->format($cashBox->responsable_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Create Uid') ?></th>
                    <td><?= $this->Number->format($cashBox->create_uid) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($cashBox->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($cashBox->modified) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Cash Movements') ?></h4>
                <?php if (!empty($cashBox->cash_movements)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Cash Box Id') ?></th>
                            <th><?= __('Type') ?></th>
                            <th><?= __('Montant') ?></th>
                            <th><?= __('Motif') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Justificatif') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Create Uid') ?></th>
                            <th><?= __('Uuid') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($cashBox->cash_movements as $cashMovement) : ?>
                        <tr>
                            <td><?= h($cashMovement->id) ?></td>
                            <td><?= h($cashMovement->cash_box_id) ?></td>
                            <td><?= h($cashMovement->type) ?></td>
                            <td><?= h($cashMovement->montant) ?></td>
                            <td><?= h($cashMovement->motif) ?></td>
                            <td><?= h($cashMovement->user_id) ?></td>
                            <td><?= h($cashMovement->justificatif) ?></td>
                            <td><?= h($cashMovement->created) ?></td>
                            <td><?= h($cashMovement->modified) ?></td>
                            <td><?= h($cashMovement->create_uid) ?></td>
                            <td><?= h($cashMovement->uuid) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'CashMovements', 'action' => 'view', $cashMovement->]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'CashMovements', 'action' => 'edit', $cashMovement->]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'CashMovements', 'action' => 'delete', $cashMovement->],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $cashMovement->),
                                    ]
                                ) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>