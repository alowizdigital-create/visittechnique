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