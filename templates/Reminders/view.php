<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Reminder $reminder
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Reminder'), ['action' => 'edit', $reminder->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Reminder'), ['action' => 'delete', $reminder->id], ['confirm' => __('Are you sure you want to delete # {0}?', $reminder->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Reminders'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Reminder'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="reminders view content">
            <h3><?= h($reminder->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Gender') ?></th>
                    <td><?= $reminder->hasValue('gender') ? $this->Html->link($reminder->gender->name, ['controller' => 'Genders', 'action' => 'view', $reminder->gender->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Template') ?></th>
                    <td><?= $reminder->hasValue('template') ? $this->Html->link($reminder->template->name, ['controller' => 'Templates', 'action' => 'view', $reminder->template->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Uuid') ?></th>
                    <td><?= h($reminder->uuid) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($reminder->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Date Before1') ?></th>
                    <td><?= $this->Number->format($reminder->date_before1) ?></td>
                </tr>
                <tr>
                    <th><?= __('Date Before2') ?></th>
                    <td><?= $this->Number->format($reminder->date_before2) ?></td>
                </tr>
                <tr>
                    <th><?= __('Date Before3') ?></th>
                    <td><?= $this->Number->format($reminder->date_before3) ?></td>
                </tr>
                <tr>
                    <th><?= __('Date Before4') ?></th>
                    <td><?= $this->Number->format($reminder->date_before4) ?></td>
                </tr>
                <tr>
                    <th><?= __('Days After') ?></th>
                    <td><?= $this->Number->format($reminder->days_after) ?></td>
                </tr>
                <tr>
                    <th><?= __('Create Uid') ?></th>
                    <td><?= $this->Number->format($reminder->create_uid) ?></td>
                </tr>
                <tr>
                    <th><?= __('Write Uid') ?></th>
                    <td><?= $this->Number->format($reminder->write_uid) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($reminder->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($reminder->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>