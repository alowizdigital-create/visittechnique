<!-- Content Wrapper -->
  
<div class="wrapper" style="margin-top: 44px;">
    <div class="content-wrapper">
        <body class="hold-transition sidebar-mini">
    <section class="content">
      <div class="container-fluid" >
     <h5></h5>
        <!-- Filtres de recherche -->
        <?= $this->Form->create(null, ['type' => 'get', 'class' => 'form-inline mb-3']) ?>
          <div class="form-group mr-2" style="padding-left: 50px;">
            <?= $this->Form->control('search', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Mot-clé']) ?>
          </div>
          <div class="form-group mr-2">
            <?= $this->Form->control('from', ['label' => false, 'type' => 'date', 'class' => 'form-control']) ?>
          </div>
          <div class="form-group mr-2">
            <?= $this->Form->control('to', ['label' => false, 'type' => 'date', 'class' => 'form-control']) ?>
          </div>
          <div class="form-group mr-2">
            <?= $this->Form->control('sexe', [
              'label' => false,
              'class' => 'form-control',
              'options' => ['M' => 'Masculin', 'F' => 'Féminin'],
              'empty' => 'Tous les sexes'
            ]) ?>
          </div>
          <div class="form-group mr-2">
            <?= $this->Form->button('Rechercher', ['class' => 'btn btn-primary']) ?>
          </div>
        <?= $this->Form->end() ?>
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Les operations de la caisse</h3>
              </div>
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>Opérations</th>
                      <th>Contact payeur</th>
                      <th>Montant</th>
                      <th class="actions">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($cashMovs as $cashMov): ?>
                      <tr>
                         <td><?= h($cashMov->type) ?></td>
                        <td><?= h($cashMov->type) ?></td>
                        <td><?= $this->Number->format($cashMov->montant) ?></td>
                        <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $cashMov->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $cashMov->id]) ?>
                            <?= $this->Form->postLink(
                                __('Delete'),
                                ['action' => 'delete', $cashMov->id],
                                [
                                    'method' => 'delete',
                                    'confirm' => __('Are you sure you want to delete # {0}?', $cashMov->id),
                                ]
                            ) ?>
                        </td>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                  <tfoot>
                    <tr>
                      <th></th><th></th><th></th><th></th>
                    </tr>
                  </tfoot>
                </table>
              </div>
              <div class="card-footer clearfix">
                <ul class="pagination pagination-sm m-0 float-right">
                  <?= $this->Paginator->numbers() ?>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
        <div class="row">
               <div class="col-md-4">
            <!-- Info Boxes Style 2 -->
            <div class="info-box mb-3 bg-warning">
              <span class="info-box-icon"><i class="fas fa-tag"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Etat initiale</span> 
                <span class="info-box-number"><?= h($amountInit); ?> Fcfa</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            <div class="info-box mb-3 bg-success">
              <span class="info-box-icon"><i class="far fa-heart"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Entré(e)s</span>
                <span class="info-box-number"><?= h($amountInput); ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            <div class="info-box mb-3 bg-danger">
              <span class="info-box-icon"><i class="fas fa-cloud-download-alt"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Sortie(s)</span>
                <span class="info-box-number"><?= h($amountInout); ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            <div class="info-box mb-3 bg-info">
              <span class="info-box-icon"><i class="fas fa-tag"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Etat actuel</span>
                <span class="info-box-number"><?= h($amountCash); ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
          </div>
          <!-- Left col -->
          <div class="col-md-8">
            <!-- MAP & BOX PANE -->
              <div class="card-body">
              <?= $this->Form->create(null) ?>
                    <div class="row">
                      <div class="col-md-12">
                            <div class="form-group">
                                    <?=  $this->Form->control('montant', [
                                        'label' => 'Montant',
                                        'id' => 'receiver',
                                        'class' => 'form-control'
                                    ]); ?>
                            </div>
                      </div>
                    </div>
                    <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                        <?= $this->Form->control('type', [
                                'label' => 'Type d\'operation',
                                'options'=> ['Entrée', 'Sortie'],
                                'class' => 'form-control',
                                'placeholder' => 'Ex: 650000000'
                            ]); ?>
                        </div>
                    </div>
                     <div class="col-md-6">
                        <div class="form-group">
                        <?= $this->Form->control('motif', [
                                'label' => 'Selectionnez un motif',
                                'options'=> $motifs,
                                'class' => 'form-control',
                                'placeholder' => 'Ex: 650000000'
                            ]); ?>
                        </div>
                    </div>
                     <!-- <div class="col-md-12">
                        <div class="form-group">
                        <?= $this->Form->control('justificatif', [
                                'label' => 'Contact payeur',
                                'class' => 'form-control',
                                'options' => $customers,
                                 'required' => true,
                                'placeholder' => 'Ex: 650000000'
                            ]); ?>
                        </div> -->
                       <div class="col-md-12">
                        <div class="form-group">
                        <?= $this->Form->control('justificatif', [
                                'label' => 'Note',
                                'type' => 'textarea',
                                'class' => 'form-control',
                                 'required' => true,
                                'placeholder' => '...'
                            ]); ?>
                        </div>
                    </div>
                    </div>
                <?= $this->Form->button(__('Sauvegarder'), ['class' => 'btn btn-primary form-control','style'=>'margin-top:25px']) ?>
                    <?= $this->Form->end() ?>
                    </div>
                </div>
          </div>
        </div>
        <!-- /.row -->
      </div><!--/. container-fluid -->
    </section>
  </div>
</div>









     <body class="hold-transition sidebar-mini" style="padding-top: 50px;">
     <section class="content-head">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h3 style="margin-left: 20px; margin-top: 20px;">  <i class="nav-icon fas fa-box"></i>Gestion des caisses </h3>
          </div>
        </div>
      </div><!-- /.container-fluid -->
  <section class="content">
    <div class="container-fluid">
      <!-- Filtres de recherche -->
      <?= $this->Form->create(null, ['type' => 'get', 'class' => 'form-inline mb-3']) ?>
        <div class="form-group mr-2" style="padding-left: 50px;">
          <?= $this->Form->control('search', [
            'label' => false,
            'class' => 'form-control',
            'placeholder' => 'Mot-clé',
            'value' => $search ?? ''
          ]) ?>
        </div>
        <div class="form-group mr-2">
          <?= $this->Form->control('from', [
            'label' => false,
            'type' => 'date',
            'class' => 'form-control',
            'value' => $from ?? ''
          ]) ?>
        </div>
        <div class="form-group mr-2">
          <?= $this->Form->control('to', [
            'label' => false,
            'type' => 'date',
            'class' => 'form-control',
            'value' => $to ?? ''
          ]) ?>
        </div>
        <div class="form-group mr-2">
          <?= $this->Form->button('Rechercher', ['class' => 'btn btn-primary']) ?>
        </div>
      <?= $this->Form->end() ?>

      <!-- Tableau -->
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Les opérations de la caisse</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-hover table-sm">
                <thead>
                  <tr>
                    <th><?= $this->Paginator->sort('type', 'Type') ?></th>
                    <th><?= $this->Paginator->sort('cash_box_id', 'Caisse') ?></th>
                    <th><?= $this->Paginator->sort('user_id', 'Utilisateur') ?></th>
                    <th><?= $this->Paginator->sort('montant', 'Montant') ?></th>
                    <th><?= $this->Paginator->sort('created', 'Date') ?></th>
                    <th><?= $this->Paginator->sort('created', 'Consulter') ?></th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($cashMovements as $cashMovement): ?>
                    <tr>
                      <td><?= h($cashMovement->type) ?></td>
                      <td><?= $cashMovement->cash_box->name ?? '' ?></td>
                      <td><?= $cashMovement->account->username ?? '' ?></td>
                      <td><?= $this->Number->format($cashMovement->montant) ?></td>
                      <td><?= $cashMovement->created?->i18nFormat('dd/MM/yyyy HH:mm') ?></td>
                      <td>
                        <a href="<?=  $this->Url->Build(['controller'=>'CashMovements','action'=>'view', $cashMovement->uuid]) ?>"  class="small-box-footer" > <?= __('  ') ?><i class="fas fa-eye"></i></a>
                       </td>
                    </tr>
                  <?php endforeach; ?>
                </tfoot>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
   <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <!-- En-tête -->
            <div class="card-header d-flex justify-content-between align-items-center">
              <h3 class="card-title m-0"> <i class="nav-icon fas fa-list"></i> <?= __('Liste de caisses') ?></h3>
                 <?php if ($userData->role == 'admin' || $userData->role == 'directeur'): ?>
                                <div class="ml-auto">
                          <a href="<?=  $this->Url->Build(['controller'=>'Cashboxes']) ?>"  class="btn btn-sm btn-primary text-white"  data-bs-toggle="modal" data-bs-target="#newcahbox" > <?= __('Nouvelle caisse') ?><i class="btn btn-sm btn-primary text-white"></i></a>
                               
                          </div>
                <?php endif; ?>
            </div>
            <!-- Tableau -->
            <div class="card-body">
              <!-- <table class="table table-bordered table-striped"> -->
              <table class="table table-bordered table-hover table-sm">
                <thead>
                  <tr>
                    <th>#</th>
                    <th><?= __('Nom de la caisse') ?></th>
                    <th><?= __('solde actuel') ?></th>
                    <th><?= __('statut') ?></th>
                    <th><?= __('Actions') ?></th>
                  </tr>
                </thead>
                <tbody>
                  <?php $count = 1; foreach ($cashBoxes as $cashBox): ?>
                    <tr>
                      <td><?= $count ?></td>
                       <td><?= h($cashBox->name) ?></td>
                      <td><?= h($cashBox->solde_actuel) ?></td>
                      <td><?= h($cashBox->statut) ?></td>
                      <td class="actions">
                          <a href="<?=  $this->Url->Build(['controller'=>'Cashboxes']) ?>" data-uuid="<?= $cashBox->uuid ?>"  class="small-box-footer"  data-bs-toggle="modal" data-bs-target="#modalRelance" > <?= __('Transferer') ?><i class="fas fa-arrow-circle-right"></i></a>
                          <?php if ($cashBox->statut !== 'close') : ?>
                              <?= $this->Html->link(__('Ouvrir'), ['action' => 'transactions', $cashBox->uuid]) ?>
                              <?= $this->Html->link(__('Fermer'), ['action' => 'close', $cashBox->uuid]) ?>
                           <?php endif; ?> 
                        </td>
                    </tr>
                  <?php $count++; endforeach; ?>
                </tbody>
              
                </tfoot>
              </table>
            </div>
            <!-- Pagination -->
          </div>
        </div>
      </div>
    </div>
  </section>
     <div class="card-body">
      <table class="table table-bordered table-hover table-sm">
          <tbody>
                <tr>
                    <th style="justify-content: center; align-items:center; color:green;" >
                        <?= __('Entrée(s)') ?>
                        <br>
                        <br>
                        <?=  $amountInput ?>
                    </th>
                    <th style="justify-content: center; align-items:center; color:red;" >
                         <?= __('Sortie(s)') ?>
                         <br>
                         <br>
                         <?= $amountInout ?>
                    </th>
                    <th style="justify-content: center; align-items:center; color:blue;">
                      <?= __('Solde actuel') ?>
                      <br>
                      <br>
                      <?=  $amountActuel ?>
                    </th>
                </tr>
          </tbody>
      </table>
    </div>
</div>
</div>
 

<!-- Modal de transfert de caisse  --> 
<div class="modal fade" id="modalRelance" tabindex="-1" aria-labelledby="ModalDetails" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalAdd">Transfert d'argent</h5>
      </div>
      <div class="modal-body">
        <?= $this->Form->create(NULL, ['id' => 'newRelance']) ?>
        <fieldset>
           <!-- Matricule -->
          <div class="row mt-2">
             <input type="hidden" id="cashbox_uuid" name="cashbox_uuid" value="">
            <div class="col-12">
              <?= $this->Form->control('montant', [
                'label' => 'Montant :',
                'class' => 'form-control',
                'placeholder' => 'EX: 50 000',
                'id' => 'amount',
                'required' => true
              ]) ?>
            </div>
          </div>
           <div class="row mt-2">
            <div class="col-12">
              <?= $this->Form->control('recepteur', [
                'label' => 'Recepteur :',
                'class' => 'form-control',
                'options'=> $myCollabots,
                'placeholder' => 'EX: CM XX90 OICJ ',
                'id' => 'receiver',
                'required' => true
              ]) ?>
            </div>
          </div>
           <div class="row mt-2">
            <div class="col-12">
              <?= $this->Form->control('commentaire', [
                'label' => 'Rapport :',
                'class' => 'form-control',
                'placeholder' => ' ',
                'type'=>'textarea',
                'id' => 'commentaire',
                'required' => true
              ]) ?>
            </div>
          </div>
        </fieldset>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
          <?= $this->Form->button(__('Transferer'), ['class' => 'btn btn-primary']) ?>
        </div>
        <?= $this->Form->end() ?>
      </div>
    </div>
  </div>
</div>


<!-- Modal de creation de caisses  --> 


<div class="modal fade" id="newcahbox" tabindex="-1" aria-labelledby="ModalDetails" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalAdd">Creer une caisse</h5>
      </div>
      <div class="modal-body">
        <?= $this->Form->create(NULL, ['id' => 'newCashboxes']) ?>
        <fieldset>
           <!-- Matricule -->
          <div class="row mt-2">
             <input type="hidden" id="cashbox_uuid" name="cashbox_uuid" value="">
            <div class="col-12">
              <?= $this->Form->control('name', [
                'label' => 'Nom de la caisse :',
                'class' => 'form-control',
                'placeholder' => 'EX: Caisse de serge Mbarga',
                'id' => 'name',
                'required' => true
              ]) ?>
            </div>
          </div>
           <div class="row mt-2">
            <div class="col-12">
              <?= $this->Form->control('responsable_id', [
                'label' => 'Recepteur :',
                'class' => 'form-control',
                'options'=> $responsables,
                'placeholder' => 'EX: CM XX90 OICJ ',
                'id' => 'responsable',
                'required' => true
              ]) ?>
            </div>
          </div>
          
        </fieldset>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
          <?= $this->Form->button(__('Créer'), ['class' => 'btn btn-primary']) ?>
        </div>
        <?= $this->Form->end() ?>
      </div>
    </div>
  </div>
</div>



<script>
    // Écouteur d'événement pour le clic sur les liens "Transférer"
    $(document).on('click', '[data-bs-target="#modalRelance"]', function() {
        const cashboxUuid = $(this).data('uuid');
        $('#cashbox_uuid').val(cashboxUuid);
    });

    // Gestionnaire de soumission du formulaire
    $('#newRelance').submit(function(e) {
        e.preventDefault();
        // Récupération des valeurs du formulaire
        let cashbox_uuid = $('#cashbox_uuid').val();
        let amount = $('#amount').val();
        let commit = $('#commentaire').val();
        let receiver_name = $('#receiver option:selected').text(); // Récupère le nom de l'utilisateur
        // Construction du message de confirmation dynamique
        let title = "<?= __('Vous allez effectuer un transfert de {0} Fcfa vers la caisse de {1}') ?>";
        title = title.replace('{0}', amount);
        title = title.replace('{1}', receiver_name);

        let dest_url = "<?= $this->Url->build(['action' => 'shareCashBox']) ?>";
        dest_url = dest_url.replace(/&amp;/g, '&');
        
        let data = {
            cashbox_uuid: cashbox_uuid,
            amount: amount,
            commit: commit,
            receiver: $('#receiver').val(), // Passe l'ID de l'utilisateur
        };
        console.log(data);
        let message = $(this).attr('data-message');
        let icon = 'warning';
        
        confirmAction(title, message, icon, dest_url, data, 'reload');
    });

    $('#newCashboxes').submit(function(e) {
    e.preventDefault();
   
    const data = {
        name: $('#name').val(),
        responsable: $('#responsable').val(),
        _csrfToken: myToken
    };
   
    $.ajax({
        url: '/rootNewCashbox',
        type: 'POST',
        data: data,
        dataType: 'json',
        success: function(result) {
            if (result.code == 200) {
                $('#confirmPayment').modal('hide');
                toastr.success(result.msg);
                setTimeout(() => {
                    window.location = '/cashboxes/index';
                }, 2000);
            } else {
                toastr.error(result.msg || 'Échec du paiement');
            }
        },
        error: function(xhr, status, error) {
            toastr.error('Erreur lors de la confirmation du paiement');
        }
    });
});
</script>




<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Caisses - Design Responsive</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        /* === VARIABLES GLOBALES === */
        :root {
            --color-primary: #4f46e5;
            --color-primary-dark: #4338ca;
            --color-success: #10b981;
            --color-danger: #ef4444;
            --color-warning: #f59e0b;
            --color-text-base: #1f2937;
            --color-text-light: #6b7280;
            --color-bg-light: #f9fafb;
            --border-radius: 0.5rem;
            --spacing-sm: 0.5rem;
            --spacing-md: 1rem;
            --spacing-lg: 1.5rem;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--color-bg-light);
            line-height: 1.5;
            color: var(--color-text-base);
        }

        /* === CONTENEUR GÉNÉRAL === */
        .main-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: var(--spacing-lg);
        }

        /* === ENTÊTE DE PAGE === */
        .page-header {
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: var(--spacing-md);
            margin-bottom: var(--spacing-lg);
        }
        .page-header h1 {
            font-size: 1.875rem;
            font-weight: 800;
            color: var(--color-text-base);
            display: flex;
            align-items: center;
        }
        .page-header h1 svg {
            color: var(--color-primary);
            margin-right: var(--spacing-sm);
            width: 28px;
            height: 28px;
        }

        /* === CARTES STATISTIQUES === */
        .stats-grid {
            display: grid;
            gap: var(--spacing-lg);
            margin-bottom: var(--spacing-lg);
        }
        @media (min-width: 768px) {
            .stats-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }
        .stat-card {
            background-color: white;
            padding: var(--spacing-lg);
            border-radius: var(--border-radius);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1),
                        0 2px 4px -2px rgba(0, 0, 0, 0.1);
            border-left: 4px solid;
        }
        .stat-card p:first-child {
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--color-text-light);
            margin-bottom: 0.25rem;
        }

        .stat-card p:last-child {
            font-size: 1.5rem;
            font-weight: 700;
            margin-top: 0.25rem;
        }
        .stat-input { border-left-color: var(--color-success); }
        .stat-input p:last-child { color: var(--color-success); }
        .stat-output { border-left-color: var(--color-danger); }
        .stat-output p:last-child { color: var(--color-danger); }
        .stat-current { border-left-color: var(--color-primary); }
        .stat-current p:last-child { color: var(--color-primary); }

        /* === CARTES GÉNÉRALES === */
        .card {
            background-color: white;
            padding: var(--spacing-lg);
            border-radius: var(--border-radius);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1),
                        0 4px 6px -4px rgba(0, 0, 0, 0.1);
            margin-bottom: var(--spacing-lg);
        }
        .card-header {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: var(--spacing-md);
            margin-bottom: var(--spacing-md);
        }
        @media (min-width: 640px) {
            .card-header {
                flex-direction: row;
                justify-content: space-between;
                align-items: center;
            }
        }
        .card-header h2 {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--color-text-base);
            display: flex;
            align-items: center;
            margin-bottom: var(--spacing-sm);
        }
        .card-header h2 svg {
            margin-right: 0.5rem;
            width: 20px;
            height: 20px;
            color: var(--color-text-light);
        }

        /* === FORMULAIRES DE FILTRE === */
        .filter-form {
            display: flex;
            flex-direction: column;
            gap: var(--spacing-md);
            padding: var(--spacing-md);
            background-color: #f3f4f6;
            border-radius: var(--border-radius);
            border: 1px solid #e5e7eb;
            margin-bottom: var(--spacing-lg);
        }

        @media (min-width: 768px) {
            .filter-form {
                flex-direction: row;
                align-items: flex-end;
            }
            .form-group-flex {
                flex: 1;
            }
        }
        .form-group label {
            display: block;
            font-size: 0.75rem;
            font-weight: 500;
            color: var(--color-text-base);
            margin-bottom: 0.25rem;
        }
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #d1d5db;
            border-radius: var(--border-radius);
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }
        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            border-color: var(--color-primary);
            outline: none;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        /* === BOUTONS === */
        .btn {
            padding: 0.5rem 1rem;
            border-radius: var(--border-radius);
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            border: none;
        }
        .btn-primary {
            background-color: var(--color-primary);
            color: white;
        }
        .btn-primary:hover {
            background-color: var(--color-primary-dark);
        }
        .btn-secondary {
            background-color: #e5e7eb;
            color: var(--color-text-base);
        }
        .btn-secondary:hover {
            background-color: #d1d5db;
        }
        .btn-icon-sm svg {
            width: 16px;
            height: 16px;
            margin-right: 0.25rem;
            vertical-align: middle;
        }
        .btn-small {
            padding: 0.3rem 0.6rem;
            font-size: 0.75rem;
            border-radius: 0.375rem;
        }

        /* === TABLEAUX RESPONSIVES (CAISSES + OPÉRATIONS) === */
        #cashbox-table-container,
        #operations-table-container {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            border-radius: 10px;
            background-color: white;
            margin-bottom: var(--spacing-lg);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        #cashbox-table-container::-webkit-scrollbar,
        #operations-table-container::-webkit-scrollbar {
            height: 6px;
        }

        #cashbox-table-container::-webkit-scrollbar-thumb,
        #operations-table-container::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 10px;
        }

        #cashbox-table-container .data-table,
        #operations-table-container .data-table {
            width: 100%;
            min-width: 900px;
            border-collapse: collapse;
            table-layout: auto;
        }

        .data-table th,
        .data-table td {
            padding: 12px 16px;
            text-align: left;
            border-bottom: 1px solid #f3f4f6;
            white-space: nowrap;
        }

        .data-table th {
            background-color: #f9fafb;
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--color-text-light);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .data-table tbody tr:hover {
            background-color: #f3f4f6;
        }

        .data-table td {
            font-size: 0.875rem;
            color: var(--color-text-base);
        }

        /* === STATUTS & TYPES === */
        .status-open, .status-close {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .status-open { background-color: #d1fae5; color: #059669; }
        .status-close { background-color: #fee2e2; color: #dc2626; }

        .type-depot, .type-retrait, .type-transfert { font-weight: 700; }
        .type-depot { color: var(--color-success); }
        .type-retrait { color: var(--color-danger); }
        .type-transfert { color: var(--color-primary); }

        /* === ACTIONS === */
        .actions-cell button, .actions-cell a {
            margin-right: 0.5rem;
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
            border-radius: 0.375rem;
            border: 1px solid;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
        }
        .actions-cell .transfer-btn { border-color: var(--color-primary); color: var(--color-primary); background-color: #eef2ff; }
        .actions-cell .open-btn { border-color: var(--color-success); color: var(--color-success); }
        .actions-cell .close-btn { border-color: var(--color-danger); color: var(--color-danger); }
        .actions-cell .view-btn { border-color: var(--color-text-light); color: var(--color-text-light); }

        /* === MODALES === */
        .modal-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            transition: opacity 0.3s ease;
            /* Rendre visible la modale */
            opacity: 0;
            pointer-events: none;
        }
        .modal-backdrop.active {
            opacity: 1;
            pointer-events: auto;
        }

        .modal-content {
            background-color: white;
            padding: var(--spacing-lg);
            border-radius: var(--border-radius);
            width: 90%;
            max-width: 500px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            transform: scale(0.9);
            transition: transform 0.3s ease;
        }
        .modal-backdrop.active .modal-content {
             transform: scale(1);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: var(--spacing-md);
            margin-bottom: var(--spacing-md);
        }
        .modal-header h5 {
            font-size: 1.125rem;
            font-weight: 700;
        }
        .modal-close-btn {
            background: none;
            border: none;
            cursor: pointer;
            color: var(--color-text-light);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem;
        }
        .modal-footer {
            display: flex;
            justify-content: flex-end;
            margin-top: var(--spacing-lg);
            gap: var(--spacing-sm);
        }
    </style>

</head>

<body>

    <div id="custom-alert" class="modal-backdrop" onclick="this.classList.remove('active')">
        <div class="modal-content" style="max-width: 400px;" onclick="event.stopPropagation()">
            <h4 id="alert-title" style="font-size: 1.25rem; font-weight: 700; margin-bottom: 0.5rem;">Action</h4>
            <p id="alert-message" style="color: var(--color-text-light); margin-bottom: 1rem;">L'action a été simulée.</p>
            <button class="btn btn-primary" style="width: 100%;" onclick="document.getElementById('custom-alert').classList.remove('active')">
                Fermer
            </button>
        </div>
    </div>

    <div class="main-container">

        <header class="page-header">
            <h1>
                <i data-lucide="wallet"></i> Gestion des caisses
            </h1>
        </header>

        <div class="stats-grid">
            <div class="stat-card stat-input">
                <p>Entrée(s)</p>
                <p id="stat-input"><?= $this->Number->format($amountInput) ?? 0 ?></p>
            </div>
            <div class="stat-card stat-output">
                <p>Sortie(s)</p>
                <p id="stat-output"><?= $this->Number->format($amountInout) ?? 0 ?></p>
            </div>
            <div class="stat-card stat-current">
                <p>Solde actuel</p>
                <p id="stat-current"><?= $this->Number->format($amountActuel) ?? 0 ?></p>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h2>
                    <i data-lucide="list-checks"></i> Liste de caisses
                </h2>
                <?php if ($userData->role == 'admin' || $userData->role == 'directeur'): ?>
                          <a href="<?=  $this->Url->Build(['controller'=>'Cashboxes']) ?>"  class="btn btn-primary btn-small btn-icon-sm"  data-bs-toggle="modal" data-bs-target="#newcahbox" > <?= __('Nouvelle caisse') ?><i data-lucide="plus"></i></a>
                <?php endif; ?>
            </div>

            <div class="table-container" id="cashbox-table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nom de la caisse</th>
                            <th>Solde actuel</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="cashbox-list-body">
                        <?php $count = 1; foreach ($cashBoxes as $cashBox): ?>
                            <tr>
                                <td><?= $count ?></td>
                                <td><?= h($cashBox->name) ?></td>
                                <td><?= $this->Number->format($cashBox->solde_actuel) ?></td>
                                <td>
                                    <span class="status-<?= h($cashBox->statut) ?>">
                                        <?= h($cashBox->statut) ?>
                                    </span>
                                </td>
                                <td class="actions-cell">
                                    <!-- <button type="button" data-uuid="<?= $cashBox->uuid ?>" onclick="prepareTransfer(this)" class="transfer-btn btn-small">
                                        <i data-lucide="arrow-right"></i> Transferer
                                    </button> -->
                          <a href="<?=  $this->Url->Build(['controller'=>'Cashboxes']) ?>" data-uuid="<?= $cashBox->uuid ?>"  class="transfer-btn btn-small"  data-bs-toggle="modal" data-bs-target="#modalRelance" > <?= __('Transferer') ?></a>


                                    <?php if ($cashBox->statut !== 'close') : ?>
                                        <?= $this->Html->link(__('Ouvrir'), ['action' => 'transactions', $cashBox->uuid], ['class' => 'open-btn btn-small']) ?>
                                        <?= $this->Html->link(__('Fermer'), ['action' => 'close', $cashBox->uuid], ['class' => 'close-btn btn-small']) ?>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php $count++; endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h2>
                    <i data-lucide="trending-up"></i> Les opérations de la caisse
                </h2>
            </div>

            <?= $this->Form->create(null, ['type' => 'get', 'id' => 'filter-form', 'class' => 'filter-form']) ?>
                <div class="form-group form-group-flex">
                    <label for="search">Mot-clé (Type, Origine...)</label>
                    <?= $this->Form->control('search', [
                        'label' => false,
                        'class' => 'form-control',
                        'placeholder' => 'Mot-clé',
                        'value' => $search ?? ''
                    ]) ?>
                </div>

                <div class="form-group">
                    <label for="from">Date de début</label>
                    <?= $this->Form->control('from', [
                        'label' => false,
                        'type' => 'date',
                        'class' => 'form-control',
                        'value' => $from ?? ''
                    ]) ?>
                </div>

                <div class="form-group">
                    <label for="to">Date de fin</label>
                    <?= $this->Form->control('to', [
                        'label' => false,
                        'type' => 'date',
                        'class' => 'form-control',
                        'value' => $to ?? ''
                    ]) ?>
                </div>

                <button type="submit" class="btn btn-primary btn-icon-sm">
                    <i data-lucide="search"></i> Rechercher
                </button>
            <?= $this->Form->end() ?>


            <div class="table-container" id="operations-table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th><?= $this->Paginator->sort('type', 'Type') ?></th>
                            <th><?= $this->Paginator->sort('cash_box_id', 'Caisse') ?></th>
                            <th><?= $this->Paginator->sort('user_id', 'Utilisateur') ?></th>
                            <th><?= $this->Paginator->sort('montant', 'Montant') ?></th>
                            <th><?= $this->Paginator->sort('created', 'Date') ?></th>
                            <th>Consulter</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cashMovements as $cashMovement): ?>
                            <tr>
                                <td>
                                    <span class="type-<?= strtolower(h($cashMovement->type)) ?>">
                                        <?= h($cashMovement->type) ?>
                                    </span>
                                </td>
                                <td><?= $cashMovement->cash_box->name ?? '' ?></td>
                                <td><?= $cashMovement->account->username ?? '' ?></td>
                                <td><?= $this->Number->format($cashMovement->montant) ?></td>
                                <td><?= $cashMovement->created?->i18nFormat('dd/MM/yyyy HH:mm') ?></td>
                                <td class="actions-cell">
                                    <a href="<?= $this->Url->Build(['controller'=>'CashMovements','action'=>'view', $cashMovement->uuid]) ?>" class="view-btn btn-small" >
                                        <i data-lucide="eye" style="width: 14px; height: 14px;"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div style="margin-top: var(--spacing-md); font-size: 0.875rem; color: var(--color-text-light); text-align: center;">
                <div>Page 1 sur 10</div>
            </div>

        </div>

    </div>

    
<div class="modal fade" id="newcahbox" tabindex="-1" aria-labelledby="ModalDetails" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalAdd">Creer une caisse</h5>
      </div>
      <div class="modal-body">
        <?= $this->Form->create(NULL, ['id' => 'newCashboxes']) ?>
        <fieldset>
           <!-- Matricule -->
          <div class="row mt-2">
             <input type="hidden" id="cashbox_uuid" name="cashbox_uuid" value="">
            <div class="col-12">
              <?= $this->Form->control('name', [
                'label' => 'Nom de la caisse :',
                'class' => 'form-control',
                'placeholder' => 'EX: Caisse de serge Mbarga',
                'id' => 'name',
                'required' => true
              ]) ?>
            </div>
          </div>
           <div class="row mt-2">
            <div class="col-12">
              <?= $this->Form->control('responsable_id', [
                'label' => 'Recepteur :',
                'class' => 'form-control',
                'options'=> $responsables,
                'placeholder' => 'EX: CM XX90 OICJ ',
                'id' => 'responsable',
                'required' => true
              ]) ?>
            </div>
          </div>
          
        </fieldset>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
          <?= $this->Form->button(__('Créer'), ['class' => 'btn btn-primary']) ?>
        </div>
        <?= $this->Form->end() ?>
      </div>
    </div>
  </div>
</div>

    
<!-- Modal de transfert de caisse  --> 


<div class="modal fade" id="modalRelance" tabindex="-1" aria-labelledby="ModalDetails" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalAdd">Transfert d'argent</h5>
      </div>
      <div class="modal-body">
        <?= $this->Form->create(NULL, ['id' => 'newRelance']) ?>
        <fieldset>
           <!-- Matricule -->
          <div class="row mt-2">
             <input type="hidden" id="cashbox_uuid" name="cashbox_uuid" value="">
            <div class="col-12">
              <?= $this->Form->control('montant', [
                'label' => 'Montant :',
                'class' => 'form-control',
                'placeholder' => 'EX: 50 000',
                'id' => 'amount',
                'required' => true
              ]) ?>
            </div>
          </div>
           <div class="row mt-2">
            <div class="col-12">
              <?= $this->Form->control('recepteur', [
                'label' => 'Recepteur :',
                'class' => 'form-control',
                'options'=> $myCollabots,
                'placeholder' => 'EX: CM XX90 OICJ ',
                'id' => 'receiver',
                'required' => true
              ]) ?>
            </div>
          </div>
           <div class="row mt-2">
            <div class="col-12">
              <?= $this->Form->control('commentaire', [
                'label' => 'Rapport :',
                'class' => 'form-control',
                'placeholder' => ' ',
                'type'=>'textarea',
                'id' => 'commentaire',
                'required' => true
              ]) ?>
            </div>
          </div>
        </fieldset>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
          <?= $this->Form->button(__('Transfere'), ['class' => 'btn btn-primary']) ?>
        </div>
        <?= $this->Form->end() ?>
      </div>
    </div>
  </div>
</div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <script>
        // Initialise les icônes Lucide après le chargement du DOM
        lucide.createIcons();

        // Fonctions de gestion des modales
        function openModal(id) {
            document.getElementById(id).classList.add('active');
        }

        function closeModal(id) {
            document.getElementById(id).classList.remove('active');
        }

          // Écouteur d'événement pour le clic sur les liens "Transférer"
    $(document).on('click', '[data-bs-target="#modalRelance"]', function() {
        const cashboxUuid = $(this).data('uuid');
        $('#cashbox_uuid').val(cashboxUuid);
    });


    // Gestionnaire de soumission du formulaire
    $('#newRelance').submit(function(e) {
        e.preventDefault();
        // Récupération des valeurs du formulaire
        let cashbox_uuid = $('#cashbox_uuid').val();
        let amount = $('#amount').val();
        let commit = $('#commentaire').val();
        let receiver_name = $('#receiver option:selected').text(); // Récupère le nom de l'utilisateur
        // Construction du message de confirmation dynamique
        let title = "<?= __('Vous allez effectuer un transfert de {0} Fcfa vers la caisse de {1}') ?>";
        title = title.replace('{0}', amount);
        title = title.replace('{1}', receiver_name);

        let dest_url = "<?= $this->Url->build(['action' => 'shareCashBox']) ?>";
        dest_url = dest_url.replace(/&amp;/g, '&');
        
        let data = {
            cashbox_uuid: cashbox_uuid,
            amount: amount,
            commit: commit,
            receiver: $('#receiver').val(), // Passe l'ID de l'utilisateur
        };
        console.log(data);
        let message = $(this).attr('data-message');
        let icon = 'warning';
        
        confirmAction(title, message, icon, dest_url, data, 'reload');
    });

    $('#newCashboxes').submit(function(e) {
    e.preventDefault();
   
    const data = {
        name: $('#name').val(),
        responsable: $('#responsable').val(),
        _csrfToken: myToken
    };
   
    $.ajax({
        url: '/rootNewCashbox',
        type: 'POST',
        data: data,
        dataType: 'json',
        success: function(result) {
            if (result.code == 200) {
                $('#confirmPayment').modal('hide');
                toastr.success(result.msg);
                setTimeout(() => {
                    window.location = '/cashboxes/index';
                }, 2000);
            } else {
                toastr.error(result.msg || 'Échec du paiement');
            }
        },
        error: function(xhr, status, error) {
            toastr.error('Erreur lors de la confirmation du paiement');
        }
    });
});

       
    </script>

    

<script>
    // Écouteur d'événement pour le clic sur les liens "Transférer"
    $(document).on('click', '[data-bs-target="#modalRelance"]', function() {
        const cashboxUuid = $(this).data('uuid');
        $('#cashbox_uuid').val(cashboxUuid);
    });

    // Gestionnaire de soumission du formulaire
    $('#newRelance').submit(function(e) {
        e.preventDefault();
        // Récupération des valeurs du formulaire
        let cashbox_uuid = $('#cashbox_uuid').val();
        let amount = $('#amount').val();
        let commit = $('#commentaire').val();
        let receiver_name = $('#receiver option:selected').text(); // Récupère le nom de l'utilisateur
        // Construction du message de confirmation dynamique
        let title = "<?= __('Vous allez effectuer un transfert de {0} Fcfa vers la caisse de {1}') ?>";
        title = title.replace('{0}', amount);
        title = title.replace('{1}', receiver_name);

        let dest_url = "<?= $this->Url->build(['action' => 'shareCashBox']) ?>";
        dest_url = dest_url.replace(/&amp;/g, '&');
        
        let data = {
            cashbox_uuid: cashbox_uuid,
            amount: amount,
            commit: commit,
            receiver: $('#receiver').val(), // Passe l'ID de l'utilisateur
        };
        console.log(data);
        let message = $(this).attr('data-message');
        let icon = 'warning';
        
        confirmAction(title, message, icon, dest_url, data, 'reload');
    });

    $('#newCashboxes').submit(function(e) {
    e.preventDefault();
   
    const data = {
        name: $('#name').val(),
        responsable: $('#responsable').val(),
        _csrfToken: myToken
    };
   
    $.ajax({
        url: '/rootNewCashbox',
        type: 'POST',
        data: data,
        dataType: 'json',
        success: function(result) {
            if (result.code == 200) {
                $('#confirmPayment').modal('hide');
                toastr.success(result.msg);
                setTimeout(() => {
                    window.location = '/cashboxes/index';
                }, 2000);
            } else {
                toastr.error(result.msg || 'Échec du paiement');
            }
        },
        error: function(xhr, status, error) {
            toastr.error('Erreur lors de la confirmation du paiement');
        }
    });
});
</script>

</body>
</html>



  
