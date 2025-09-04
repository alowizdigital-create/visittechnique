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
            <?= $this->Html->link(__('Edit Startup'), ['action' => 'edit', $startup->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Startup'), ['action' => 'delete', $startup->id], ['confirm' => __('Are you sure you want to delete # {0}?', $startup->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Startups'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Startup'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="startups view content">
            <h3><?= h($startup->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($startup->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Uuid') ?></th>
                    <td><?= h($startup->uuid) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($startup->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Create Uid') ?></th>
                    <td><?= $this->Number->format($startup->create_uid) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($startup->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($startup->modified) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Customers') ?></h4>
                <?php if (!empty($startup->customers)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Phone') ?></th>
                            <th><?= __('Email') ?></th>
                            <th><?= __('Address') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Create Uid') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Write Uid') ?></th>
                            <th><?= __('Uuid') ?></th>
                            <th><?= __('Startup Id') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($startup->customers as $customer) : ?>
                        <tr>
                            <td><?= h($customer->id) ?></td>
                            <td><?= h($customer->name) ?></td>
                            <td><?= h($customer->phone) ?></td>
                            <td><?= h($customer->email) ?></td>
                            <td><?= h($customer->address) ?></td>
                            <td><?= h($customer->created) ?></td>
                            <td><?= h($customer->create_uid) ?></td>
                            <td><?= h($customer->modified) ?></td>
                            <td><?= h($customer->write_uid) ?></td>
                            <td><?= h($customer->uuid) ?></td>
                            <td><?= h($customer->startup_id) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Customers', 'action' => 'view', $customer->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Customers', 'action' => 'edit', $customer->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'Customers', 'action' => 'delete', $customer->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $customer->id),
                                    ]
                                ) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Genders') ?></h4>
                <?php if (!empty($startup->genders)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Frais') ?></th>
                            <th><?= __('Price') ?></th>
                            <th><?= __('Note') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Create Uid') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Write Uid') ?></th>
                            <th><?= __('Uuid') ?></th>
                            <th><?= __('Startup Id') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($startup->genders as $gender) : ?>
                        <tr>
                            <td><?= h($gender->id) ?></td>
                            <td><?= h($gender->name) ?></td>
                            <td><?= h($gender->frais) ?></td>
                            <td><?= h($gender->price) ?></td>
                            <td><?= h($gender->note) ?></td>
                            <td><?= h($gender->created) ?></td>
                            <td><?= h($gender->create_uid) ?></td>
                            <td><?= h($gender->modified) ?></td>
                            <td><?= h($gender->write_uid) ?></td>
                            <td><?= h($gender->uuid) ?></td>
                            <td><?= h($gender->startup_id) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Genders', 'action' => 'view', $gender->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Genders', 'action' => 'edit', $gender->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'Genders', 'action' => 'delete', $gender->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $gender->id),
                                    ]
                                ) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Motifs') ?></h4>
                <?php if (!empty($startup->motifs)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Content') ?></th>
                            <th><?= __('Create Uid') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Uuid') ?></th>
                            <th><?= __('Startup Id') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($startup->motifs as $motif) : ?>
                        <tr>
                            <td><?= h($motif->id) ?></td>
                            <td><?= h($motif->content) ?></td>
                            <td><?= h($motif->create_uid) ?></td>
                            <td><?= h($motif->created) ?></td>
                            <td><?= h($motif->modified) ?></td>
                            <td><?= h($motif->uuid) ?></td>
                            <td><?= h($motif->startup_id) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Motifs', 'action' => 'view', $motif->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Motifs', 'action' => 'edit', $motif->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'Motifs', 'action' => 'delete', $motif->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $motif->id),
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