<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Motif> $motifs
 */
?>
<div class="motifs index content">
    <?= $this->Html->link(__('New Motif'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Motifs') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('content') ?></th>
                    <th><?= $this->Paginator->sort('create_uid') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th><?= $this->Paginator->sort('uuid') ?></th>
                    <th><?= $this->Paginator->sort('startup_id') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($motifs as $motif): ?>
                <tr>
                    <td><?= $this->Number->format($motif->id) ?></td>
                    <td><?= $this->Number->format($motif->content) ?></td>
                    <td><?= $this->Number->format($motif->create_uid) ?></td>
                    <td><?= h($motif->created) ?></td>
                    <td><?= h($motif->modified) ?></td>
                    <td><?= h($motif->uuid) ?></td>
                    <td><?= $motif->hasValue('startup') ? $this->Html->link($motif->startup->name, ['controller' => 'Startups', 'action' => 'view', $motif->startup->id]) : '' ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $motif->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $motif->id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $motif->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $motif->id),
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