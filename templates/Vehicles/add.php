<body class="hold-transition sidebar-mini" style="padding-top: 40px;">
    <!-- Content Header (Page header) -->
    <section class="content-head">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="margin-left: 20px; margin-top: 55px;">  <i class="nav-icon fas fa-plus"></i>Nouveau </h1>
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
                          <?=  $this->Form->control('custome', [
                              'label' => 'Client',
                              'class' => 'form-control'
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
                        'placeholder' => 'Ex: 653990089'
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
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
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
