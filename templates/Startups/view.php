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
                    <th><?= __('Phone') ?></th>
                    <td><?= h($startup->phone) ?></td>
                </tr>
                <tr>
                    <th><?= __('Mail') ?></th>
                    <td><?= h($startup->mail) ?></td>
                </tr>
                <tr>
                    <th><?= __('Logo') ?></th>
                    <td><?= h($startup->logo) ?></td>
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
                <h4><?= __('Related Accounts') ?></h4>
                <?php if (!empty($startup->accounts)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Username') ?></th>
                            <th><?= __('Password') ?></th>
                            <th><?= __('Passwordshow') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Uuid') ?></th>
                            <th><?= __('Startup Id') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Phone') ?></th>
                            <th><?= __('Role') ?></th>
                            <th><?= __('Write Uid') ?></th>
                            <th><?= __('Create Uid') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($startup->accounts as $account) : ?>
                        <tr>
                            <td><?= h($account->id) ?></td>
                            <td><?= h($account->username) ?></td>
                            <td><?= h($account->password) ?></td>
                            <td><?= h($account->passwordshow) ?></td>
                            <td><?= h($account->created) ?></td>
                            <td><?= h($account->modified) ?></td>
                            <td><?= h($account->uuid) ?></td>
                            <td><?= h($account->startup_id) ?></td>
                            <td><?= h($account->name) ?></td>
                            <td><?= h($account->phone) ?></td>
                            <td><?= h($account->role) ?></td>
                            <td><?= h($account->write_uid) ?></td>
                            <td><?= h($account->create_uid) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Accounts', 'action' => 'view', $account->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Accounts', 'action' => 'edit', $account->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'Accounts', 'action' => 'delete', $account->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $account->id),
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
                <h4><?= __('Related Admins') ?></h4>
                <?php if (!empty($startup->admins)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Email') ?></th>
                            <th><?= __('Password') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Uuid') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Startup Id') ?></th>
                            <th><?= __('Role') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($startup->admins as $admin) : ?>
                        <tr>
                            <td><?= h($admin->id) ?></td>
                            <td><?= h($admin->email) ?></td>
                            <td><?= h($admin->password) ?></td>
                            <td><?= h($admin->created) ?></td>
                            <td><?= h($admin->uuid) ?></td>
                            <td><?= h($admin->modified) ?></td>
                            <td><?= h($admin->startup_id) ?></td>
                            <td><?= h($admin->role) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Admins', 'action' => 'view', $admin->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Admins', 'action' => 'edit', $admin->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'Admins', 'action' => 'delete', $admin->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $admin->id),
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
            <div class="related">
                <h4><?= __('Related Users') ?></h4>
                <?php if (!empty($startup->users)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Firstname') ?></th>
                            <th><?= __('Lastname') ?></th>
                            <th><?= __('Email') ?></th>
                            <th><?= __('Password') ?></th>
                            <th><?= __('Myproject') ?></th>
                            <th><?= __('Startup Id') ?></th>
                            <th><?= __('Role') ?></th>
                            <th><?= __('Verified') ?></th>
                            <th><?= __('Token Expires') ?></th>
                            <th><?= __('Phone') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Create Uid') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Write Uid') ?></th>
                            <th><?= __('Uuid') ?></th>
                            <th><?= __('Username') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($startup->users as $user) : ?>
                        <tr>
                            <td><?= h($user->id) ?></td>
                            <td><?= h($user->firstname) ?></td>
                            <td><?= h($user->lastname) ?></td>
                            <td><?= h($user->email) ?></td>
                            <td><?= h($user->password) ?></td>
                            <td><?= h($user->myproject) ?></td>
                            <td><?= h($user->startup_id) ?></td>
                            <td><?= h($user->role) ?></td>
                            <td><?= h($user->verified) ?></td>
                            <td><?= h($user->token_expires) ?></td>
                            <td><?= h($user->phone) ?></td>
                            <td><?= h($user->created) ?></td>
                            <td><?= h($user->create_uid) ?></td>
                            <td><?= h($user->modified) ?></td>
                            <td><?= h($user->write_uid) ?></td>
                            <td><?= h($user->uuid) ?></td>
                            <td><?= h($user->username) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Users', 'action' => 'view', $user->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Users', 'action' => 'edit', $user->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'Users', 'action' => 'delete', $user->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $user->id),
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