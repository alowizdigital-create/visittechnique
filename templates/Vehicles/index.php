  <body class="hold-transition sidebar-mini" style="padding-top: 35px;">
  <section class="content" >
    <div class="container-fluid">
      <div class="row" >
        <div class="col-12" style="margin-top: 54px;">
          <div class="card">
            <!-- En-tête --> 
            <div class="card-header d-flex justify-content-between align-items-center">
              <h3 class="card-title"><?= __('Liste des vehicules') ?></h3>
                  <div class="ml-auto">
                      <?= $this->Html->link(__('Nouveau vehicule'), ['action' => 'add'], [
                        'class' => 'btn btn-primary text-white',
                        'style' => 'border:none;'
                      ]) ?>
                  </div>
            </div>
            <!-- Table -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-hover table-sm">
                <thead>
                  <tr>
                   <th>#</th>
                      <th><?= __('Immatriculation') ?></th>
                    
                      <th><?= __('Nom client') ?></th>
                        <th><?= __('Numero client') ?></th>
                          <th><?= __('Genre de vehicule') ?></th>
                      <th class="text-center"><?= __('Actions') ?></th>
                  </tr>
                </thead>
                <tbody>
                <?php $count = 1; foreach ($vehicles as $vehicle): ?>
                <tr>
                    <td><?= $count++ ?></td>
                    <td><?= h($vehicle->registration_number) ?></td>
                   <td><?= h($vehicle->customer->name) ?></td>
                   <td><?= h($vehicle->customer->phone) ?></td>
                    <td><?= h($vehicle->gender->name) ?></td>
                    <td class="actions">
                             <?php if ($vehicle->shedule == 1): ?>
                               <!-- <?php debug($vehicle->shedule); ?> -->
                                <a href="<?= $this->Url->Build(['controller'=>'Vehicles','action'=>'index']) ?>" 
                                    id="Relancer" 
                                    class="small-box-footer" 
                                    data-uuid="<?= $vehicle->registration_number ?>" 
                                    data-bs-toggle="modal">
                                    <i class="fas fa-sync"></i>
                                </a>
                            <?php endif; ?>
                            <?php if ($vehicle->shedule == 0): ?>
                                <a href="<?= $this->Url->Build(['controller'=>'Vehicles','action'=>'index']) ?>" 
                                  id="Encaisse" 
                                  class="small-box-footer"  
                                  data-uuid="<?= $vehicle->registration_number ?>" 
                                  data-bs-toggle="modal">
                                    <i class="fas fa-cash-register"></i>
                                </a>
                            <?php endif; ?>
                          <input type="hidden" id="registrationNumber" value="<?= $vehicle->registration_number ?>">
                          <?= $this->Html->link(__('<i class="fas fa-edit" style="color:#000;"></i>'), ['action' => 'edit', $vehicle->id], ['escape' => false,'title'=>'Modifier']) ?>
                          <?= $this->Form->postLink(
                              '<i class="fas fa-trash-alt" style="color:#dc3545;"></i>',
                              ['action' => 'delete', $vehicle->id],
                              [
                                'confirm' => __('Are you sure you want to delete # {0}?', $vehicle->id),
                                'escape' => false,
                                'title' => 'Supprimer',
                              ]
                            ) ?>
                    </td>
                </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
            <!-- Pagination -->
          </div>
        </div>
      </div>
    </div>
  </section>
</div> 
</div>
<footer class="main-footer" style="position: fixed; bottom: 0; left: 0; width: 100%; z-index: 1030; background: #f8f9fa; padding: 10px 20px; border-top: 1px solid #dee2e6;">
  <div class="float-right d-none d-sm-inline">
    <b>Version</b> 3.2.0
  </div>
  <a href="https://wa.me/237653843034" target="_blank" style="margin-left: 20px;"> Contactez-nous sur Whatsapp</a>
</footer>


   
<!-- Modal de relance vehicule  --> 
<div class="modal fade" id="modalRelance" tabindex="-1" aria-labelledby="ModalDetails" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalAdd">Relance client </h5>
      </div>
      <div class="modal-body">
        <?= $this->Form->create(NULL, ['id' => 'newRelance']) ?>
        <fieldset>
           <!-- Matricule -->
          <div class="row mt-2">
            <div class="col-12">
              <?= $this->Form->control('matricule', [
                'label' => 'Immatriculation du vehicule :',
                'class' => 'form-control',
                'placeholder' => 'EX: CM XX90 OICJ ',
                'id' => 'inputRegister',
                'required' => true
              ]) ?>
            </div>
          </div>
        </fieldset>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
          <?= $this->Form->button(__('Relancer'), ['class' => 'btn btn-primary']) ?>
        </div>
        <?= $this->Form->end() ?>
      </div>
    </div>
  </div>
</div>


<!-- Modal de création de vehicule -->
<div class="modal fade" id="detaisModal" tabindex="-1" aria-labelledby="ModalDetails" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <?= $this->Form->create(NULL, ['id' => 'addTasksForm']) ?>
        <fieldset>
            <!-- Numero  -->
          <?= $this->Form->control('customer_id', [
              'label' => 'Client :',
              'options' => $customers,
              'class' => 'form-control select2',
              'empty' => 'Sélectionnez un client',
              'required' => true
          ]) ?>

           <!-- Matricule -->
          <div class="row mt-2">
            <div class="col-12">
              <?= $this->Form->control('matricule', [
                'label' => 'Matricule du vehicule :',
                'class' => 'form-control',
                'placeholder' => 'EX: CM XX90 OICJ ',
                'id' => 'inputRegister',
                'required' => true
              ]) ?>
            </div>
          </div>

          <!-- Genre du véhicule -->
          <div class="row mt-3">
            <div class="col-12">
              <?= $this->Form->control('gender_id', [
                'label' => 'Genre du véhicule :',
                'class' => 'form-control',
                'options' => $genders,
                'id' => 'inputGender',
                'empty' => [0 => 'Selectionnez'],
                'required' => true
              ]) ?>
            </div>
          </div>
        </fieldset>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
          <?= $this->Form->button(__('Enregistrer'), ['class' => 'btn btn-primary']) ?>
        </div>
        <?= $this->Form->end() ?>
      </div>
    </div>
  </div>
</div>

<!-- Modal de vérification de paiement -->
<div class="modal fade" id="confirmPayment" tabindex="-1" aria-labelledby="ModalDetails" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalDetails">Vérification du paiement</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
      </div>
      <div class="modal-body">
      <?= $this->Form->create(null, ['id' => 'confirmPaymentForm']) ?>
      <!-- Les informations de paiements cachées -->
      <fieldset>
            <?= $this->Form->control('gender_id', ['type' => 'hidden', 'id' => 'inputGenderidHidden']) ?>
            <?= $this->Form->control('register', ['type' => 'hidden', 'id' => 'inputRegisterHidden']) ?>
            <?= $this->Form->control('amount', ['type' => 'hidden', 'id' => 'inputAmount']) ?>
            <?= $this->Form->control('discount', ['type' => 'hidden', 'id' => 'inputDiscount']) ?>
      </fieldset>
        <fieldset>
          <div class="row mt-2">
            <div class="col-12">
              <ul class="list-unstyled">
                <h4 style="margin-bottom:10px;">Informations du client</h4>
                <li style="font-size: 18px;"><strong>Nom :</strong> <span id="field-name">-</span></li>
                <li style="font-size: 18px;"><strong>Numéro :</strong> <span id="field-phone">-</span></li>
                <h4 class="for-control" style="margin-top: 30px; margin-bottom:10px;">Informations du véhicule</h4>
                <li style="font-size: 18px;"><strong>Immatriculation :</strong> <span id="field-register">-</span></li>
                <li style="font-size: 18px;"><strong>Genre :</strong> <span id="field-gender">-</span></li>
                <li style="font-size: 18px;"><strong>Réduction appliquée :</strong> <span id="field-discountEnd">-</span> Fcfa</li>
                <!-- <li>
                    <?= $this->Form->control('discount', [
                      'label' => 'Réduction :',
                      'class' => 'form-control discountp',
                      'options' => [],
                      'id' => 'field-discount',
                      'empty' => [0 => 'Selectionnez'],
                    ]) ?>
                </li> -->
                <h4 class="for-control" style="margin-top: 30px; margin-bottom:10px;">Informations de paiement</h4>
                <li style="font-size: 18px;"><strong>Montant à payer :</strong> <span id="field-amount"></span> Fcfa</li>
              </ul>
            </div>
          </div>
        </fieldset>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
          <?= $this->Form->button(__('Confirmer le paiement'), ['class' => 'btn btn-primary']) ?>
        </div>
        <?= $this->Form->end() ?>
      </div>
    </div>
  </div>
</div>




<!-- Modal de vérification de paiement  pour les nouvelles relances-->
<div class="modal fade" id="confirmRelance" tabindex="-1" aria-labelledby="ModalDetails" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalDetails">Vérification du paiement</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
      </div>
      <div class="modal-body">
      <?= $this->Form->create(null, ['id' => 'confirmRelanceForm']) ?>
      <!-- Les informations de paiements cachées -->
      <fieldset>
            <?= $this->Form->control('gender_id', ['type' => 'hidden', 'id' => 'inputGenderidHidden2']) ?>
            <?= $this->Form->control('register', ['type' => 'hidden', 'id' => 'inputRegisterHidden2']) ?>
            <?= $this->Form->control('amount', ['type' => 'hidden', 'id' => 'inputAmount2']) ?>
            <?= $this->Form->control('discount', ['type' => 'hidden', 'id' => 'inputDiscount2']) ?>
      </fieldset>
        <fieldset>
          <div class="row mt-2">
            <div class="col-12">
              <ul class="list-unstyled">
                <h4 style="margin-bottom:10px;">Informations du client</h4>
                <li style="font-size: 18px;"><strong>Nom :</strong> <span id="field-name2">-</span></li>
                <li style="font-size: 18px;"><strong>Numéro :</strong> <span id="field-phone2">-</span></li>
                <h4 class="for-control" style="margin-top: 30px; margin-bottom:10px;">Informations du véhicule</h4>
                <li style="font-size: 18px;"><strong>Immatriculation :</strong> <span id="field-register2">-</span></li>
                <li style="font-size: 18px;"><strong>Genre :</strong> <span id="field-gender2">-</span></li>
                <li style="font-size: 18px;"><strong>Réduction appliquée :</strong> <span id="field-discountEnd2">-</span> Fcfa</li>
                <!-- <li>
                    <?= $this->Form->control('discount', [
                      'label' => 'Réduction :',
                      'class' => 'form-control discountp',
                      'options' => [],
                      'id' => 'field-discount',
                      'empty' => [0 => 'Selectionnez'],
                    ]) ?>
                </li> -->
                <h4 class="for-control" style="margin-top: 30px; margin-bottom:10px;">Informations de paiement</h4>
                <li style="font-size: 18px;"><strong>Montant à payer :</strong> <span id="field-amount2"></span> Fcfa</li>
              </ul>
            </div>
          </div>
        </fieldset>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
          <?= $this->Form->button(__('Confirmer le paiement'), ['class' => 'btn btn-primary']) ?>
        </div>
        <?= $this->Form->end() ?>
      </div>
    </div>
  </div>
</div>


<script>
    $(document).ready(function() {
        // Cibler le formulaire généré par $this->Form->create($vehicle)
        // Comme il n'a pas d'ID, on utilise le sélecteur 'form' (en supposant qu'il est le seul)
        $('form').on('submit', function() {
            // Cibler le bouton de soumission par sa classe ou son type
            const submitButton = $(this).find('.btn-primary'); // Cibler spécifiquement le bouton bleu

            // Vérification pour éviter les erreurs
            if (submitButton.length) {
                // 1. Désactiver le bouton pour empêcher les clics multiples
                submitButton.prop('disabled', true);
                
                // 2. Changer le texte et ajouter une icône de chargement (spinner)
                submitButton.html('<i class="fas fa-spinner fa-spin"></i> Sauvegarde en cours...');
                
                // Le formulaire va continuer sa soumission vers le contrôleur.
            }
        });
    });
</script>


<script>
$(document).ready(function() {
    // PART 1: Handle the initial 'Encaisse' button click
    $(document).on('click', '#Encaisse', function(e) {
      e.preventDefault();
        let immatriculastion = $(this).data('uuid');
      
        var data = {
            matricule: immatriculastion,
            _csrfToken: myToken
        };
        // console.log("Data sent to /rootAjaxnewRelance:", data);
        $.ajax({
            url: '/rootAjaxnewRelance',
            type: 'POST',
            data: data,
            dataType: 'json',
            success: function(result) {
                if (result.code == 100) {
                    $('#detailsModal').modal('hide');
                    toastr.success(result.msg);
                    setTimeout(function() {
                        window.location = '/users/dashboard';
                    }, 2000);
                } else if (result.code == 200) {
                    $('#modalRelance').modal('hide');
                    $('#confirmPayment').modal('show');
                    let finalAmount = result.price - result.discounts;
                    // Populate the modal fields with data from the server
                    $('#field-register').text(result.register);
                    $('#field-gender').text(result.gender);
                    $('#field-discountEnd').text(result.discounts);
                    $('#field-phone').text(result.customerPhone);
                    $('#field-name').text(result.customerName);
                    $('#field-amount').text(finalAmount);
                    // let initialPrice = result.price;
                    // alert(initialPrice);
                    // $('#field-discount').empty().append('<option value="0">Selectionnez</option>');
                    
                    // $.each(result.discounts, function(id, amount) {
                    //     $('#field-discount').append($('<option>', {
                    //         text: amount,
                    //         value: id
                    //     }));
                    // });
                    
                    // $('#field-amount').text(initialPrice);

                    //  let finalAmount = 40000;
                    //  $('#field-amount').text(finalAmount);
                    
                    // $('#field-discountEnd').on('change', function () {
                    //     let selectedText = $(this).find('option:selected').text();
                    //     let discount = parseFloat(selectedText) || 0;
                    //     let finalAmount = initialPrice - discount;
                    //     $('#field-amount').text(finalAmount);
                    // });
                    // Set the values of hidden inputs for the next AJAX call
                    $('#inputGenderidHidden').val(result.gender_id);
                    $('#inputRegisterHidden').val(result.register);
                    $('#inputAmount').val(result.price);
                    $('#inputDiscount').val(result.discounts);
                    // Set the UUID in the hidden input for the next AJAX call
                    $('#inputUuidHidden').val(result.uuid); // Assuming the server returns the UUID
                } else {
                    toastr.error(result.msg);
                    $('#detailsModal').modal('hide');
                }
            },
            error: function(xhr, status, error) {
                toastr.error('Erreur lors de la requête AJAX');
            }
        });
    });

    // PART 2: Handle the 'confirmPaymentForm' submission
    $('#confirmPaymentForm').submit(function(e) {
        e.preventDefault();
        
        const data = {
            register: $('#inputRegisterHidden').val(),
            uuid: $('#inputUuidHidden').val(), // Retrieve the UUID here
            amount: $('#inputAmount').val(),
            discount: $('#inputDiscount').val(),
            gender_id: $('#inputGenderidHidden').val(),
            _csrfToken: myToken
        };
        $.ajax({
            url: '/rootAjaxConfirmPayment',
            type: 'POST',
            data: data,
            dataType: 'json',
            success: function(result) {
                if (result.code == 200) {
                    $('#confirmPayment').modal('hide');
                    toastr.success(result.msg);
                    setTimeout(() => {
                        window.location = '/vehicles/index';
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
});
</script>


<script>
$(document).ready(function() {
    // PART 1: Handle the initial 'Encaisse' button click
    $(document).on('click', '#Relancer', function(e) {
      e.preventDefault();
        let immatriculastion = $(this).data('uuid');
        var data = {
            matricule: immatriculastion,
            _csrfToken: myToken
        };
        // console.log("Data sent to /rootAjaxnewRelance:", data);
        $.ajax({
            url: '/rootAjaxnewRelance',
            type: 'POST',
            data: data,
            dataType: 'json',
            success: function(result) {
                if (result.code == 100) {
                    $('#detailsModal').modal('hide');
                    toastr.success(result.msg);
                    setTimeout(function() {
                        window.location = '/users/dashboard';
                    }, 2000);
                } else if (result.code == 200) {
                    $('#modalRelance').modal('hide');
                    $('#confirmRelance').modal('show');
                    let finalAmount = result.price - result.discounts;
                    // Populate the modal fields with data from the server
                    $('#field-register2').text(result.register);
                    $('#field-gender2').text(result.gender);
                    $('#field-discountEnd2').text(result.discounts);
                    $('#field-phone2').text(result.customerPhone);
                    $('#field-name2').text(result.customerName);
                    $('#field-amount2').text(finalAmount);
                   
                    $('#inputGenderidHidden2').val(result.gender_id);
                    $('#inputRegisterHidden2').val(result.register);
                    $('#inputAmount2').val(result.price);
                    $('#inputDiscount2').val(result.discounts);
                    // Set the UUID in the hidden input for the next AJAX call
                    $('#inputUuidHidden2').val(result.uuid); // Assuming the server returns the UUID
                } else {
                    toastr.error(result.msg);
                    $('#detailsModal').modal('hide');
                }
            },
            error: function(xhr, status, error) {
                toastr.error('Erreur lors de la requête AJAX');
            }
        });
    });

    // PART 2: Handle the 'confirmPaymentForm' submission
    $('#confirmRelanceForm').submit(function(e) {
        e.preventDefault();
        
        const data = {
            register: $('#inputRegisterHidden2').val(),
            uuid: $('#inputUuidHidden2').val(), // Retrieve the UUID here
            amount: $('#inputAmount2').val(),
            discount: $('#inputDiscount2').val(),
            gender_id: $('#inputGenderidHidden2').val(),
            _csrfToken: myToken
        };
        $.ajax({
            url: '/rootAjaxConfirmRelance',
            type: 'POST',
            data: data,
            dataType: 'json',
            success: function(result) {
                if (result.code == 200) {
                    $('#confirmPayment').modal('hide');
                    toastr.success(result.msg);
                    setTimeout(() => {
                        window.location = '/vehicles/index';
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
});
</script>


<script>
$(document).ready(function() {
    $('.select2').select2({
        theme: 'bootstrap4',
        placeholder: "Choisissez un ou plusieurs contacts",
        allowClear: true
    });
     $('.select3').select2({
        theme: 'bootstrap4',
        placeholder: "Choisissez un ou plusieurs groupes",
        allowClear: true
    });
});
</script>


