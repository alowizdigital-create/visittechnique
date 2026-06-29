<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CashMovement $cashMovement
 */
?>

<div class="row" style="margin-top:70px">
    
    <div class="col-lg-9 col-md-8">
        <div class="card shadow mb-4">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0"><?= __('Détails') ?></h4>
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
                            <td class="fw-bod"><?= __($cashMovement->montant) ?> Fcfa</td>
                        </tr>
                        <tr>
                            <th scope="row"><?= __('Date') ?></th>
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
