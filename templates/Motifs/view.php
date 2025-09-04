<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Motif $motif
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Motif'), ['action' => 'edit', $motif->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Motif'), ['action' => 'delete', $motif->id], ['confirm' => __('Are you sure you want to delete # {0}?', $motif->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Motifs'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Motif'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="motifs view content">
            <h3><?= h($motif->uuid) ?></h3>
            <table>
                <tr>
                    <th><?= __('Uuid') ?></th>
                    <td><?= h($motif->uuid) ?></td>
                </tr>
                <tr>
                    <th><?= __('Startup') ?></th>
                    <td><?= $motif->hasValue('startup') ? $this->Html->link($motif->startup->name, ['controller' => 'Startups', 'action' => 'view', $motif->startup->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($motif->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Content') ?></th>
                    <td><?= $this->Number->format($motif->content) ?></td>
                </tr>
                <tr>
                    <th><?= __('Create Uid') ?></th>
                    <td><?= $this->Number->format($motif->create_uid) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($motif->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($motif->modified) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Cash Movements') ?></h4>
                <?php if (!empty($motif->cash_movements)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Cash Box Id') ?></th>
                            <th><?= __('Type') ?></th>
                            <th><?= __('Montant') ?></th>
                            <th><?= __('Motif Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Justificatif') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Create Uid') ?></th>
                            <th><?= __('Uuid') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($motif->cash_movements as $cashMovement) : ?>
                        <tr>
                            <td><?= h($cashMovement->id) ?></td>
                            <td><?= h($cashMovement->cash_box_id) ?></td>
                            <td><?= h($cashMovement->type) ?></td>
                            <td><?= h($cashMovement->montant) ?></td>
                            <td><?= h($cashMovement->motif_id) ?></td>
                            <td><?= h($cashMovement->user_id) ?></td>
                            <td><?= h($cashMovement->justificatif) ?></td>
                            <td><?= h($cashMovement->created) ?></td>
                            <td><?= h($cashMovement->modified) ?></td>
                            <td><?= h($cashMovement->create_uid) ?></td>
                            <td><?= h($cashMovement->uuid) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'CashMovements', 'action' => 'view', $cashMovement->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'CashMovements', 'action' => 'edit', $cashMovement->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'CashMovements', 'action' => 'delete', $cashMovement->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $cashMovement->id),
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