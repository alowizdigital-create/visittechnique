
<body class="">
  <div class="container">
    <!-- Outer Row -->
    <div class="row justify-content-center" style="margin-top: 100px;">
      <div class="col-xl-10 col-lg-12 col-md-9">
        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-6 d-none d-lg-block bg-login-image" style="margin-top: 30px; padding-left:35px; border-radius:50%;">
                <?php echo $this->Html->image('mina.jpg', ['alt' => 'Description de l\'image','style'=>'width:100%;']); ?>
              </div>
              <div class="col-lg-6" style="">
                <div class="p-5">
                <?= $this->Flash->render('default', [
                            'element' => 'flash/custom'
                            ]) ?>
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Sign up to start your session</h1>
                  </div>
                  <?= $this->Form->create(null, ['id' => 'addUser']) ?>
                  <fieldset>
                    <div class="form-group">
                       <?= $this->Form->control('email', ['label'=>'Email*','required' => true , 'class'=>'form-control form-control-user','placeholder'=>'Entrer votre adresse email...','id'=>'email']) ?> 
                    </div>
                    <div class="form-group">
                        <?= $this->Form->control('password', ['label'=>'Mot de passe*','required' => true , 'class'=>'form-control form-control-user','placeholder'=>'Votre mot de passe','id'=>'password']) ?>
                        <p style="font-size: 12px;">Le mot de passe doit comporter au moins 8 caractères comprenant un chiffre et une lettre minuscule.</p>
                    </div>
                  </fieldset>
                    <div class="form-group">
                      <div class="custom-control custom-checkbox small">
                        <input type="checkbox" class="custom-control-input" id="customCheck">
                        <label class="custom-control-label" for="customCheck">Remember Me</label>
                      </div>
                      <div class="custom-control custom-checkbox small">
                        
                      </div>
                    </div>
                    <?= $this->Form->submit(__('Créer'),[ 'class'=>'btn btn-primary mt-2', 'style'=>'']) ?> 
                    <hr>
                    <div class="text-center">
                        <?= $this->Html->link("Forgot password ?", ['action' => 'forgotpassword'], ['style' => '']) ?>
                    </div>
                    <div class="text-center">
                        <?= $this->Html->link("Already have an account ? ", ['action' => 'login'], ['style' => '']) ?>
                    </div>
                    <?= $this->Form->end() ?>
                  <hr>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- SweetAlert2 -->

</body>
</html>

<script>
 $('#addUser').submit(function(e) {
    e.preventDefault();

    let email = $('#email').val();
    let password = $('#password').val();

    let dest_url = "<?= $this->Url->build(['action'=>'add']) ?>";
    dest_url = dest_url.replace(/&amp;/g, '&');

    let data = {
      email: email,
      password: password
    };

    // Appel direct sans confirmation
    fetchAction(dest_url, data, 'reload');
  });
</script>
