<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Inspection $inspection
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Inspection'), ['action' => 'edit', $inspection->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Inspection'), ['action' => 'delete', $inspection->id], ['confirm' => __('Are you sure you want to delete # {0}?', $inspection->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Inspections'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Inspection'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="inspections view content">
            <h3><?= h($inspection->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($inspection->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Customer') ?></th>
                    <td><?= $inspection->hasValue('customer') ? $this->Html->link($inspection->customer->name, ['controller' => 'Customers', 'action' => 'view', $inspection->customer->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Gender') ?></th>
                    <td><?= $inspection->hasValue('gender') ? $this->Html->link($inspection->gender->name, ['controller' => 'Genders', 'action' => 'view', $inspection->gender->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($inspection->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Uuid') ?></th>
                    <td><?= h($inspection->uuid) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($inspection->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Create Uid') ?></th>
                    <td><?= $this->Number->format($inspection->create_uid) ?></td>
                </tr>
                <tr>
                    <th><?= __('Write Uid') ?></th>
                    <td><?= $this->Number->format($inspection->write_uid) ?></td>
                </tr>
                <tr>
                    <th><?= __('End Date') ?></th>
                    <td><?= h($inspection->end_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($inspection->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($inspection->modified) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Messages') ?></h4>
                <?php if (!empty($inspection->messages)) : ?>
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
                        <?php foreach ($inspection->messages as $message) : ?>
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
                <h4><?= __('Related Payments') ?></h4>
                <?php if (!empty($inspection->payments)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Inspection Id') ?></th>
                            <th><?= __('Amount') ?></th>
                            <th><?= __('Note') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Create Uid') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Write Uid') ?></th>
                            <th><?= __('Uuid') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($inspection->payments as $payment) : ?>
                        <tr>
                            <td><?= h($payment->id) ?></td>
                            <td><?= h($payment->inspection_id) ?></td>
                            <td><?= h($payment->amount) ?></td>
                            <td><?= h($payment->note) ?></td>
                            <td><?= h($payment->created) ?></td>
                            <td><?= h($payment->create_uid) ?></td>
                            <td><?= h($payment->modified) ?></td>
                            <td><?= h($payment->write_uid) ?></td>
                            <td><?= h($payment->uuid) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Payments', 'action' => 'view', $payment->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Payments', 'action' => 'edit', $payment->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'Payments', 'action' => 'delete', $payment->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $payment->id),
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
