<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Customer $customer
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Customer'), ['action' => 'edit', $customer->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Customer'), ['action' => 'delete', $customer->id], ['confirm' => __('Are you sure you want to delete # {0}?', $customer->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Customers'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Customer'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="customers view content">
            <h3><?= h($customer->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($customer->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Phone') ?></th>
                    <td><?= h($customer->phone) ?></td>
                </tr>
                <tr>
                    <th><?= __('Email') ?></th>
                    <td><?= h($customer->email) ?></td>
                </tr>
                <tr>
                    <th><?= __('Address') ?></th>
                    <td><?= h($customer->address) ?></td>
                </tr>
                <tr>
                    <th><?= __('Uuid') ?></th>
                    <td><?= h($customer->uuid) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($customer->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Create Uid') ?></th>
                    <td><?= $this->Number->format($customer->create_uid) ?></td>
                </tr>
                <tr>
                    <th><?= __('Write Uid') ?></th>
                    <td><?= $this->Number->format($customer->write_uid) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($customer->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($customer->modified) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Inspections') ?></h4>
                <?php if (!empty($customer->inspections)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Customer Id') ?></th>
                            <th><?= __('Gender Id') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('End Date') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Create Uid') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Write Uid') ?></th>
                            <th><?= __('Uuid') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($customer->inspections as $inspection) : ?>
                        <tr>
                            <td><?= h($inspection->id) ?></td>
                            <td><?= h($inspection->name) ?></td>
                            <td><?= h($inspection->customer_id) ?></td>
                            <td><?= h($inspection->gender_id) ?></td>
                            <td><?= h($inspection->status) ?></td>
                            <td><?= h($inspection->end_date) ?></td>
                            <td><?= h($inspection->created) ?></td>
                            <td><?= h($inspection->create_uid) ?></td>
                            <td><?= h($inspection->modified) ?></td>
                            <td><?= h($inspection->write_uid) ?></td>
                            <td><?= h($inspection->uuid) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Inspections', 'action' => 'view', $inspection->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Inspections', 'action' => 'edit', $inspection->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'Inspections', 'action' => 'delete', $inspection->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $inspection->id),
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
                <h4><?= __('Related Messages') ?></h4>
                <?php if (!empty($customer->messages)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Sender Name') ?></th>
                            <th><?= __('Receiver') ?></th>
                            <th><?= __('Content') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Create Uid') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Write Uid') ?></th>
                            <th><?= __('Uuid') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Sent Date') ?></th>
                            <th><?= __('Response Code') ?></th>
                            <th><?= __('Response Body') ?></th>
                            <th><?= __('Parts') ?></th>
                            <th><?= __('Inspection Id') ?></th>
                            <th><?= __('Customer Id') ?></th>
                            <th><?= __('Direction') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($customer->messages as $message) : ?>
                        <tr>
                            <td><?= h($message->id) ?></td>
                            <td><?= h($message->sender_name) ?></td>
                            <td><?= h($message->receiver) ?></td>
                            <td><?= h($message->content) ?></td>
                            <td><?= h($message->created) ?></td>
                            <td><?= h($message->create_uid) ?></td>
                            <td><?= h($message->modified) ?></td>
                            <td><?= h($message->write_uid) ?></td>
                            <td><?= h($message->uuid) ?></td>
                            <td><?= h($message->status) ?></td>
                            <td><?= h($message->sent_date) ?></td>
                            <td><?= h($message->response_code) ?></td>
                            <td><?= h($message->response_body) ?></td>
                            <td><?= h($message->parts) ?></td>
                            <td><?= h($message->inspection_id) ?></td>
                            <td><?= h($message->customer_id) ?></td>
                            <td><?= h($message->direction) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Messages', 'action' => 'view', $message->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Messages', 'action' => 'edit', $message->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'Messages', 'action' => 'delete', $message->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $message->id),
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
                <h4><?= __('Related Vehicles') ?></h4>
                <?php if (!empty($customer->vehicles)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Customer Id') ?></th>
                            <th><?= __('Registration Number') ?></th>
                            <th><?= __('Brand') ?></th>
                            <th><?= __('Model') ?></th>
                            <th><?= __('Year') ?></th>
                            <th><?= __('Type') ?></th>
                            <th><?= __('Weight') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Create Uid') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Write Uid') ?></th>
                            <th><?= __('Uuid') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($customer->vehicles as $vehicle) : ?>
                        <tr>
                            <td><?= h($vehicle->id) ?></td>
                            <td><?= h($vehicle->customer_id) ?></td>
                            <td><?= h($vehicle->registration_number) ?></td>
                            <td><?= h($vehicle->brand) ?></td>
                            <td><?= h($vehicle->model) ?></td>
                            <td><?= h($vehicle->year) ?></td>
                            <td><?= h($vehicle->type) ?></td>
                            <td><?= h($vehicle->weight) ?></td>
                            <td><?= h($vehicle->created) ?></td>
                            <td><?= h($vehicle->create_uid) ?></td>
                            <td><?= h($vehicle->modified) ?></td>
                            <td><?= h($vehicle->write_uid) ?></td>
                            <td><?= h($vehicle->uuid) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Vehicles', 'action' => 'view', $vehicle->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Vehicles', 'action' => 'edit', $vehicle->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'Vehicles', 'action' => 'delete', $vehicle->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $vehicle->id),
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