 <body class="hold-transition sidebar-mini" style="padding-top: 55px;">
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">
            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                    <?= $this->Html->image($userAuth->profile ?? '', [
                        'class' => 'profile-user-img img-fluid img-circle',
                        'alt' => 'AdminLTE Logo'
                    ]) ?>
                </div>
                <h3 class="profile-username text-center"><?php echo htmlspecialchars($userAuth->name); ?></h3>
                <p class="text-muted text-center"><?php echo htmlspecialchars($userAuth->role); ?></p>
                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Téléphone</b> <a class="float-right"><?php echo htmlspecialchars($userAuth->phone); ?></a>
                  </li>
                
                </ul>
                <!-- <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a> -->
              </div>
              <!-- /.card-body -->
            </div>
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="#settings" data-toggle="tab">Réglage</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                              <div class="active tab-pane" id="settings">


                <form class="form-horizontal" id="formUser" type='file' enctype='multipart/form-data'>
                <div class="form-group row">
                    <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                    <div class="col-sm-10">
                        <input type="text" value="<?php echo htmlspecialchars($userAuth->name); ?>" class="form-control" id="name" placeholder="Name">
                    </div>
                </div>
                <div class="form-group row">
                    <input type="hidden" id="uuid" name="cashbox_uuid" value="<?php echo htmlspecialchars($userAuth->uuid); ?>">
                    <label for="inputPhone" class="col-sm-2 col-form-label">Phone</label>
                    <div class="col-sm-10">
                        <input type="tel" value="<?php echo htmlspecialchars($userAuth->phone); ?>" class="form-control" id="phone" placeholder="Phone">
                    </div>
                </div>
               
              <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label">Mot de passe</label>
                <div class="col-sm-10">
                    <div class="input-group">
                       <input type="password" class="form-control" value="<?php echo htmlspecialchars($userAuth->passwordshow ?? ''); ?>" id="password" placeholder="Mot de passe">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                <span class="fa fa-eye"></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
              <div class="form-group row">
                    <label for="inputRole" class="col-sm-2 col-form-label">Photo</label>
                    <div class="col-sm-10">
                        <input type="file" id="file" name="photo" value="" class="form-control" id="inputRole" placeholder="Role">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="offset-sm-2 col-sm-10">
                        <button type="submit" class="btn btn-success">Mettre à jour</button>
                    </div>
                </div>
            </form>
                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
   
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const icon = togglePassword.querySelector('.fa');
        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            if (type === 'text') {
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    });

    $('#formUser').submit(function(e) {
        e.preventDefault();

        // Récupération des valeurs du formulaire
        let name = $('#name').val();
        let password = $('#password').val();
        let phone = $('#phone').val();
        let uuid = $('#uuid').val();
        let fileInput = $('#file')[0];
        let file = fileInput.files[0];

        // Fonction pour envoyer les données
        let sendData = (fileContent = null, fileName = '', fileType = '') => {
            let data = {
                name: name,
                password: password,
                phone: phone,
                uuid: uuid,
            };
            
            // Si un fichier est présent, ajoutez ses données à l'objet
            if (fileContent) {
                data.file_name = fileName;
                data.file_type = fileType;
                data.file_content = fileContent;
            }

            // Construction du message de confirmation dynamique
            let title = "<?= __('Confirmer vous la modification de ces informations') ?>";
            title = title.replace('{0}', phone);
            let dest_url = "<?= $this->Url->build(['action' => 'updateAccount']) ?>";
            dest_url = dest_url.replace(/&amp;/g, '&');
            let message = $(this).attr('data-message');
            let icon = 'warning';

            // Appelle la fonction confirmAction avec les données JSON
            confirmAction(title, message, icon, dest_url, data, 'reload');
        }

        // Vérifie si un fichier a été sélectionné
        if (file) {
            let reader = new FileReader();
            reader.onload = function(evt) {
                let fileBase64 = evt.target.result;
                sendData(fileBase64, file.name, file.type);
            };
            reader.readAsDataURL(file); // Lit le fichier et le convertit en Base64
        } else {
            sendData(); // Pas de fichier, envoi des autres données seulement
        }
    });
</script>