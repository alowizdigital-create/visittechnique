<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Startup> $startups
 */
?>
<div class="startups index content">
    <?= $this->Html->link(__('New Startup'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Startups') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('create_uid') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th><?= $this->Paginator->sort('uuid') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($startups as $startup): ?>
                <tr>
                    <td><?= $this->Number->format($startup->id) ?></td>
                    <td><?= h($startup->name) ?></td>
                    <td><?= $this->Number->format($startup->create_uid) ?></td>
                    <td><?= h($startup->created) ?></td>
                    <td><?= h($startup->modified) ?></td>
                    <td><?= h($startup->uuid) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $startup->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $startup->id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $startup->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $startup->id),
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