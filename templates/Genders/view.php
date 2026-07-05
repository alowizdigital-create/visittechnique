<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Gender $gender
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Gender'), ['action' => 'edit', $gender->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Gender'), ['action' => 'delete', $gender->id], ['confirm' => __('Are you sure you want to delete # {0}?', $gender->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Genders'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Gender'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="genders view content">
            <h3><?= h($gender->name) ?></h3>
            <table>
               
                <tr>
                    <th><?= __('Date de creation') ?></th>
                    <td><?= h($gender->created->nice()) ?></td>
                </tr>
                  <tr>
                    <th><?= __('Durée de la visite') ?></th>
                    <td><?= h($gender->numbermonthvisit) ?> mois</td>
                </tr>
              
            </table>
            <div class="text">
                <strong><?= __('Note') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($gender->note)); ?>
                </blockquote>
            </div>
            <div class="related">
                <h4><?= __('Reduction') ?></h4>
                <?php if (!empty($gender->discounts)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Amount') ?></th>
                            <th><?= __('Note') ?></th>
                            <th><?= __('Date de création') ?></th>
                             <th><?= __('Durée de visite') ?></th>
                        
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($gender->discounts as $discount) : ?>
                        <tr>
                            <td><?= h($discount->amount) ?></td>
                          
                            <td><?= h($discount->note) ?></td>
                            <td><?= h($discount->created->nice()) ?></td>
                          
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Discounts', 'action' => 'view', $discount->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Discounts', 'action' => 'edit', $discount->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'Discounts', 'action' => 'delete', $discount->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $discount->id),
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
