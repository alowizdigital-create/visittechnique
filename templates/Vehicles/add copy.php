

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.5.2/dist/select2-bootstrap4.min.css" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

  <body class="hold-transition sidebar-mini" style="padding-top: 35px;">
    <!-- Content Header (Page header) -->
    <section class="content-head">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="margin-left: 20px; margin-top: 20px;">  <i class="nav-icon fas fa-plus"></i>Nouveau </h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- SELECT2 EXAMPLE -->
        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title"></h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
              <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
           <?= $this->Form->create($vehicle) ?>
            <div class="row">
              <div class="col-md-12">
                 <div class="form-group">
                        <!-- <?=  $this->Form->control('customer_id', [
                                    'label' => 'Client',
                                    'options' => $customers,
                                    'id' => 'receiver',
                                    'multiple' => true,
                                    'class' => 'form-control select2'
                          ]); ?> -->
                          <?=  $this->Form->control('customer_id', [
                              'label' => 'Client',
                              'options' => $customerOptions,
                              'id' => 'receiver',
                               'multiple' => true,
                              'class' => 'form-control select2'
                          ]); ?>
                  </div>
              </div>
            </div>
             <div class="row">
               <div class="col-md-12">
                <div class="form-group">
                   <?= $this->Form->control('phone', [
                        'label' => 'Téléphone',
                        'class' => 'form-control',
                        'id' => 'phone',
                        'placeholder' => 'Ex: 650000000'
                    ]); ?>
                </div>
              </div>
               </div>
             <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                      <label></label>
                      <?= $this->Form->control('registration_number',['label'=>'l\'immatriculation','class'=>'form-control','placeholder'=>'Ex: XX 1234 AB']); ?>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                      <?= $this->Form->control('gender_id',['options'=> $genders,'label'=>'Genre','class'=>'form-control','placeholder'=>'Ex: Vehicule lourd']); ?>
                  </div>
                </div>
              </div>
              <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <?= $this->Form->control('date', [
                            'label' => 'Date de la dernière visite',
                            'class' => 'form-control',
                             'type'=> 'date',
                            'id' => 'lastVisitDate',
                            'placeholder' => 'Ex: 650000000'
                        ]); ?>
                    </div>
                  </div>
               </div>
           <?= $this->Form->button(__('Sauvegarder'), ['class' => 'btn btn-primary form-control','style'=>'margin-top:25px']) ?>
            <?= $this->Form->end() ?>
            </div>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
 <footer class="main-footer" style="position: fixed; bottom: 0; left: 0; width: 100%; z-index: 1030; background: #f8f9fa; padding: 10px 20px; border-top: 1px solid #dee2e6;">
  <div class="float-right d-none d-sm-inline">
    <b>Version</b> 3.2.0
  </div>
  <strong>Copyright &copy; 2025 <a href="#">X-technova</a></strong> Tous droits réservés.
</footer>
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>

<!-- Modal Bootstrap -->
<div class="modal fade" id="newCustomerModal" tabindex="-1" role="dialog" aria-labelledby="newCustomerModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form id="addCustomerForm">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Nouveau client</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <input type="hidden" id="newCustomerName" name="name">
            <div class="form-group">
                <label for="email">Numero du client </label>
                <input class="form-control" id="newCustomerPhone" name="phone" required>
            </div>
            <!-- Ajoute d'autres champs nécessaires ici -->
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Valider</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- ./wrapper -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


<script>
$(document).ready(function() {
    // Initialisation du champ client avec ajout de tags
    $('#receiver').select2({
        theme: 'bootstrap4',
        placeholder: "Entrez le nom du client",
        allowClear: true,
        tags: true, // 🔴 Permet la saisie libre
        language: {
            noResults: function () {
                return "Aucun client trouvé. Appuyez sur Entrée pour en créer un.";
            }
        },
        createTag: function(params) {
            var term = $.trim(params.term);
            if (term === '') return null;
            return {
                id: term,
                text: term,
                newTag: true
            };
        }
    });

    // Autres champs
    $('.select3').select2({
        theme: 'bootstrap4',
        placeholder: "Choisissez un ou plusieurs groupes",
        allowClear: true
    });
});


$(document).ready(function() {
    $('#').submit(function(e) {
        e.preventDefault();
        alert('Bonjour');
        var data = {
            name : $('#newCustomerName').val(),
            phone: $('#newCustomerPhone'),
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
 });

$('#addCustomerForm').on('submit', function(e) {
      e.preventDefault();
          var data = {
            name : $('#newCustomerName').val(),
            phone: $('#newCustomerPhone').val(),
            _csrfToken: myToken
        };
    $.ajax({
        url: '<?= $this->Url->build(['controller' => 'Customers', 'action' => 'addAjax']) ?>',
        method: 'POST',
        data: data,
        success: function(result) {
          if (result.code == 200) {
                    toastr.success(result.msg);
                     var newOption = new Option(result.name, result.id, true, true);
                     $('#receiver').val(null).trigger('change');
                     $('#receiver').append(newOption).trigger('change');
                      $('#newCustomerModal').modal('hide');
                } else {
                    toastr.error(result.msg);
                }
        },
        error: function() {
            alert("Une erreur est survenue.");
        }
    });
});
$('#receiver').on('change', function () {
    const selectedId = $(this).val();
    const phone = customerPhones[selectedId];
    $('#phone').val(phone || '');
});

</script>
<script>
  const customerPhones = <?= json_encode(
    collection($customers)->combine('id', 'phone')->toArray()
  ) ?>;
</script>




