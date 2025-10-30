<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CashMovement $cashMovement
 */
?>
<div class="row">
    <div class="col-lg-3 col-md-4">
        <div class="card bg-light mb-3">
            <div class="card-header">
                <h5 class="mb-0 text-dark"><?= __('Actions') ?></h5>
            </div>
            <div class="list-group list-group-flush">
                <?= $this->Html->link(
                    __('Modifier Mouvement'), 
                    ['action' => 'edit', $cashMovement->id], 
                    ['class' => 'list-group-item list-group-item-action list-group-item-info'] // Classe pour bouton d'édition
                ) ?>
                <?= $this->Form->postLink(
                    __('Supprimer Mouvement'), 
                    ['action' => 'delete', $cashMovement->id], 
                    ['confirm' => __('Êtes-vous sûr de vouloir supprimer le mouvement # {0}?', $cashMovement->id), 'class' => 'list-group-item list-group-item-action list-group-item-danger'] // Classe pour bouton de suppression
                ) ?>
            </div>
            <div class="list-group list-group-flush border-top">
                <?= $this->Html->link(
                    __('Liste des Mouvements'), 
                    ['action' => 'index'], 
                    ['class' => 'list-group-item list-group-item-action']
                ) ?>
                <?= $this->Html->link(
                    __('Nouveau Mouvement'), 
                    ['action' => 'add'], 
                    ['class' => 'list-group-item list-group-item-action']
                ) ?>
            </div>
        </div>
    </div>
    
    <div class="col-lg-9 col-md-8">
        <div class="card shadow mb-4">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0"><?= __('Détails du Mouvement de Caisse') ?></h4>
            </div>
            <div class="card-body">
                
                <table class="table table-bordered table-sm">
                    <tbody>
                        <tr>
                            <th scope="row" class="w-25"><?= __('Type') ?></th>
                            <td>
                                <?php
                                $type = h($cashMovement->type);
                                $badgeClass = ($type === 'entree') ? 'bg-success' : 'bg-danger';
                                echo '<span class="badge ' . $badgeClass . '">' . strtoupper($type) . '</span>';
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row"><?= __('Montant') ?></th>
                            <td class="fw-bold"><?= $this->Number->currency($cashMovement->montant) ?></td>
                        </tr>
                        <tr>
                            <th scope="row"><?= __('Créé le') ?></th>
                            <td><?= h($cashMovement->created->nice()) ?></td>
                        </tr>
                        </tbody>
                </table>
                
                <h5 class="mt-4 border-bottom pb-2"><?= __('Rapport / Justificatif') ?></h5>
                <div class="alert alert-secondary text-justify" role="alert">
                    <?= $this->Text->autoParagraph(h($cashMovement->justificatif)); ?>
                </div>

            </div>
        </div>
    </div>
</div>