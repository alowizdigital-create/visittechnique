<div class="wrapper">
  <!-- /.navbar -->
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="margin-top:74px">
  <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-4 col-4">
                <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><?= h($vehiclesCount) ?></h3>  
                            <p>Vehicules enregistrés </p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="<?=  $this->Url->Build(['controller'=>'Vehicles','action'=>'index']) ?>" class="small-box-footer"> <?= __('Liste des vehicules') ?><i class="fas fa-arrow-circle-right"></i></a>
                        <a href="<?=  $this->Url->Build(['controller'=>'Vehicles','action'=>'add']) ?>" class="small-box-footer" > <?= __('Nouveau véhicule') ?><i class="fas fa-arrow-circle-right"></i></a>
                    </div>
            </div>
            <div class="col-lg-4 col-4">
                <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3> 600 </h3>
                            <p>SMS envoiyés ce mois </p>
                        </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="<?=  $this->Url->Build(['controller'=>'Messages','action'=>'index']) ?>" class="small-box-footer"> <?= __('Savoir plus') ?><i class="fas fa-arrow-circle-right"></i></a>
                    <a href="<?=  $this->Url->Build(['controller'=>'Vehicles','action'=>'index']) ?>" class="small-box-footer"  data-bs-toggle="modal" data-bs-target="#modalRelance" > <?= __('Relancer un client') ?><i class="fas fa-arrow-circle-right"></i></a>
                  </div>
        </div>
          <div class="col-lg-4 col-4">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
              <h3>56</h3>
              <p>SMS restant </p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="<?=  $this->Url->Build(['controller'=>'Messages','action'=>'index']) ?>" class="small-box-footer"> <?= __(' Voir la liste') ?><i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <!-- ./col -->
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
     
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
                <li>
                    <?= $this->Form->control('discount', [
                      'label' => 'Réduction :',
                      'class' => 'form-control discountp',
                      'options' => [],
                      'id' => 'field-discount',
                      'empty' => [0 => 'Selectionnez'],
                    ]) ?>
                </li>
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


<script>
$(document).ready(function() {
    $('#addTasksForm').submit(function(e) {
        e.preventDefault();
        var data = {
            customer_id: $('#inputCustomer').val(),
            matricule: $('#inputRegister').val(),
            newName : $('#inputNewName').val(),
            newPhone : $('#inputNewPhone').val(),
            _csrfToken: myToken
        };
        $.ajax({
            url: '/rootAjaxaddVehicles',
            type: 'POST',
            data: data,
            dataType: 'json',
            success: function(result) {
                if (result.code == 200) {
                    $('#detailsModal').modal('hide');
                    toastr.success(result.msg);
                    setTimeout(function() {
                        window.location = '/users/dashboard';
                    }, 2000);
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

    // Partie relance véhicule
    $('#newRelance').submit(function(e) {
        e.preventDefault();
      
        var data = {
            matricule: $('#inputRegister').val(),
            _csrfToken: myToken
        };
        console.log(data);
        $.ajax({
            url: '/rootAjaxnewRelance',
            type: 'POST',
            data: data,
            dataType: 'json',
            success: function(result) {
                //  alert('TES');
                if (result.code == 100) {
                    $('#detailsModal').modal('hide');
                    toastr.success(result.msg);
                    setTimeout(function() {
                        window.location = '/users/dashboard';
                    }, 2000);
                } else if (result.code == 200) {
                  // alert('TES');
                    $('#modalRelance').modal('hide');
                    $('#confirmPayment').modal('show');
                    // Remplir dynamiquement les champs dans le modal
                    $('#field-register').text(result.register);
                    $('#field-gender').text(result.gender);
                    // $('#field-discount').text(result.discounts);
                    $('#field-phone').text(result.customerPhone);
                    $('#field-name').text(result.customerName);
                    let initialPrice = result.price; // 89000
                    // Vider les anciennes options
                    $('#field-discount').empty();

                    // Ajouter l'option par défaut
                    $('#field-discount').append('<option value="0">Selectionnez</option>');

                    // Ajouter les réductions reçues
                    $.each(result.discounts, function(id, amount) {
                        $('#field-discount').append(
                            $('<option>', {
                                text: amount,
                                value: id
                              
                            })
                        );
                    });
                    $('#field-amount').text(initialPrice);
                    // Gérer le changement de réduction
                    $('#field-discount').on('change', function () {
                          let selectedText = $(this).find('option:selected').text();
                          // alert('Bokfjf');
                          // console.log(selectedText);
                          let discount = selectedText || 0; // Si vide ou invalide → 0
                          let finalAmount = initialPrice - discount;
                         $('#field-amount').text(finalAmount);
                    });
                      
                    // Inputs cachés
                    $('#inputGenderidHidden').val(result.gender_id);
                    $('#inputRegisterHidden').val(result.register);
                    $('#inputAmount').val(result.price);
                    $('#inputDiscount').val(result.discount);
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
});

// Soumission du paiement
$('#confirmPaymentForm').submit(function(e) {
    e.preventDefault();
    // let selectedText = $('#field-discount option:selected').text();
    const data = {
        register: $('#inputRegisterHidden').val(),
        amount: $('#inputAmount').val(),
        discount:  $('#field-discount option:selected').text(), // si tu as un champ caché comme ça
        gender_id: $('#inputGenderidHidden').val(),
        _csrfToken: myToken
    };
    console.log(data);
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
                    window.location = '/users/dashboard';
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


