
        <body class="hold-transition sidebar-mini" style="padding-top: 25px;">
  <section class="content" >
    <div class="container-fluid">
     <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12" style="margin-top: 54px;">
                        <div class="card">
                            <!-- En-tête -->
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h3 class="card-title"> <i class="nav-icon fas fa-list" style="margin: 10px;"></i> <?= __('Mes collaborateurs') ?></h3>
                                <div class="ml-auto">
                                    <?= $this->Html->link(__('Nouveau'), ['action' => 'add'], [
                                        'class' => 'btn btn-primary text-white',
                                        'id' => 'newCollabot',
                                        'style' => 'border:none;',
                                         'data-bs-toggle'=>"modal",
                                          'data-bs-target'=>"#modalRelance"
                                    ]) ?>
                                </div>
                            </div>
                            <!-- Corps de la carte -->
                            <div class="card-body">
                                <div class="row">
                                    <?php foreach ($collabots as $collabot): ?>
                                        <div class="col-md-4">
                                            <div class="card card-primary card-outline">
                                                <div class="card-body box-profile">
                                                    <div class="text-center">
                                                        <img class="profile-user-img img-fluid img-circle"
                                                            src="https://placehold.co/128x128/0056b3/ffffff?text=U"
                                                            alt="User profile picture">
                                                    </div>
                                                    <h3 class="profile-username text-center"><?= h($collabot->name) ?> </h3>
                                                    <!-- Remplacez 'profession' par le bon champ si nécessaire -->
                                                    <p class="text-muted text-center"><?= h($collabot->role) ?></p>
                                                    <ul class="list-group list-group-unbordered mb-3">
                                                        <li class="list-group-item">
                                                            <b>Nom</b> <a class="float-right"><?= h($collabot->name) ?></a>
                                                        </li>
                                                        <li class="list-group-item">
                                                            <b>Téléphone</b> <a class="float-right"><?= h($collabot->phone) ?></a>
                                                        </li>
                                                         <li class="list-group-item">
                                                            <b>Mot de passe</b> <a class="float-right"><?= h($collabot->passwordshow) ?></a>
                                                        </li>
                                                    </ul>
                                                    <div class="d-flex justify-content-between">
                                                          <?= $this->Form->postLink(
                                                            'Supprimer',
                                                            ['action' => 'delete', $collabot->id],
                                                            [
                                                              'confirm' => __('Are you sure you want to delete # {0}?', $collabot->id),
                                                              'escape' => false,
                                                              'title' => 'Supprimer',
                                                              'class' => 'btn btn-danger'
                                                            ]
                                                          ) ?>
                                                        <?= $this->Html->link(__('Modifier'), ['action' => 'edit', $collabot->id], ['class' => 'btn btn-secondary','escape' => false,'title'=>'Modifier']) ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <!-- Pagination -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
  </section>
</div> 
</div>
<footer class="main-footer" style="position: fixed; bottom: 0; left: 0; width: 100%; z-index: 1030; background: #f8f9fa; padding: 10px 20px; border-top: 1px solid #dee2e6;">
  <div class="float-right d-none d-sm-inline">
    <b>Version</b> 3.2.0
  </div>
  <strong>Copyright &copy; 2025 <a href="#">X-technova</a></strong> Tous droits réservés.
</footer>

<!-- Modal de transfere de caisse  --> 
<div class="modal fade" id="modalRelance" tabindex="-1" aria-labelledby="ModalDetails" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalAdd">  <i class="nav-icon fas fa-user-friends" style="margin-right: 10px;"></i> Nouveau collaborateur</h5>
      </div>
      <div class="modal-body">
        <?= $this->Form->create(NULL, ['id' => 'newRelance']) ?>
        <fieldset>
           <!-- Matricule -->
          <div class="row mt-2">
             <input type="hidden" id="cashbox_uuid" name="cashbox_uuid" value="">
            <div class="col-12">
              <?= $this->Form->control('name', [
                'label' => 'Nom complet :',
                'class' => 'form-control',
                'placeholder' => 'EX: Atangana didier',
                'id' => 'name',
                'required' => true
              ]) ?>
            </div>
          </div>
          
           <div class="row mt-2">
             <input type="hidden" id="cashbox_uuid" name="cashbox_uuid" value="">
            <div class="col-12">
              <?= $this->Form->control('phone', [
                'label' => 'Téléphone* :',
                'class' => 'form-control',
                'placeholder' => 'EX: 656789090',
                'id' => 'phone',
                'required' => true
              ]) ?>
            </div>
          </div>
           <div class="row mt-2">
            <div class="col-12">
              <?= $this->Form->control('role', [
                'label' => 'Role :',
                'class' => 'form-control',
                'options'=> ['Directeur','Comptable','caissier(e)','Sécretaire'],
                'placeholder' => 'EX: CM XX90 OICJ ',
                'id' => 'role',
                'required' => true
              ]) ?>
            </div>
          </div>
          <p style="margin-top:20px"><small style="color: red; margin-top:20px"><i class="nav-icon fas fa-bell" style="margin: 1px;"></i> <?= __('Mes collaborateurs') ?></h3>Les champs marqués d'une * doivent contenir des informations operationnelles</small></p>
        </fieldset>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
          <?= $this->Form->button(__('Sauvegarder'), ['class' => 'btn btn-primary']) ?>
        </div>
        <?= $this->Form->end() ?>
      </div>
    </div>
  </div>
</div>

<script>
    // Écouteur d'événement pour le clic sur les liens "Transférer"
    $(document).on('click', '[data-bs-target="#modalRelance"]', function() {
        // const cashboxUuid = $(this).data('uuid');
        // $('#cashbox_uuid').val(cashboxUuid);
    });

    // Gestionnaire de soumission du formulaire
    $('#newRelance').submit(function(e) {
        e.preventDefault();
        // Récupération des valeurs du formulaire
        let name = $('#name').val();
        let email = $('#email').val();
        let phone = $('#phone').val();
        let role = $('#role').val();

        alert(name);

        // Construction du message de confirmation dynamique
        let title = "<?= __('Le numero {0} est il operationnel') ?>";
        title = title.replace('{0}', phone);
        title = title.replace('{1}', email);

        let dest_url = "<?= $this->Url->build(['action' => 'addCollabot']) ?>";
        dest_url = dest_url.replace(/&amp;/g, '&');
        
        let data = {
            name: name,
            email: email,
            phone: phone,
            role: role,
        };
        
        let message = $(this).attr('data-message');
        let icon = 'warning';
        
        confirmAction(title, message, icon, dest_url, data, 'reload');
    });
</script>
