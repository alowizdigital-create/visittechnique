<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Vehicle $vehicle
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Vehicle'), ['action' => 'edit', $vehicle->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Vehicle'), ['action' => 'delete', $vehicle->id], ['confirm' => __('Are you sure you want to delete # {0}?', $vehicle->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Vehicles'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Vehicle'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="vehicles view content">
            <h3><?= h($vehicle->registration_number) ?></h3>
            <table>
                <tr>
                    <th><?= __('Customer') ?></th>
                    <td><?= $vehicle->hasValue('customer') ? $this->Html->link($vehicle->customer->name, ['controller' => 'Customers', 'action' => 'view', $vehicle->customer->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Registration Number') ?></th>
                    <td><?= h($vehicle->registration_number) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($vehicle->created->nice()) ?></td>
                </tr>
                <tr>
                    <th><?= __('Date de dernière visite') ?></th>
                    <td><?= h($vehicle->lastvisitdate) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>