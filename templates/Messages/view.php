<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Message $message
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Message'), ['action' => 'edit', $message->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Message'), ['action' => 'delete', $message->id], ['confirm' => __('Are you sure you want to delete # {0}?', $message->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Messages'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Message'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="messages view content">
            <h3><?= h($message->sender_name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Sender Name') ?></th>
                    <td><?= h($message->sender_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Receiver') ?></th>
                    <td><?= h($message->receiver) ?></td>
                </tr>
                <tr>
                    <th><?= __('Uuid') ?></th>
                    <td><?= h($message->uuid) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($message->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Inspection') ?></th>
                    <td><?= $message->hasValue('inspection') ? $this->Html->link($message->inspection->name, ['controller' => 'Inspections', 'action' => 'view', $message->inspection->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Customer') ?></th>
                    <td><?= $message->hasValue('customer') ? $this->Html->link($message->customer->name, ['controller' => 'Customers', 'action' => 'view', $message->customer->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Direction') ?></th>
                    <td><?= h($message->direction) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($message->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Create Uid') ?></th>
                    <td><?= $this->Number->format($message->create_uid) ?></td>
                </tr>
                <tr>
                    <th><?= __('Write Uid') ?></th>
                    <td><?= $this->Number->format($message->write_uid) ?></td>
                </tr>
                <tr>
                    <th><?= __('Response Code') ?></th>
                    <td><?= $this->Number->format($message->response_code) ?></td>
                </tr>
                <tr>
                    <th><?= __('Parts') ?></th>
                    <td><?= $this->Number->format($message->parts) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($message->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($message->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Sent Date') ?></th>
                    <td><?= h($message->sent_date) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Content') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($message->content)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Response Body') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($message->response_body)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>