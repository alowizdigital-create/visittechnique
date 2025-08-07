
<body class="hold-transition login-page" style=" padding-bottom:250px;">
<div class="login-box">
  <div class="login-logo">
    <a href="../../index2.html"><b>kussala</a>
  </div>
  <!-- /.login-logo -->
  <div class="card" style="">
    <div class="card-body login-card-body" style="">
      <p class="login-box-msg">Sign up to kussala</p>
      <form action="../../index3.html" method="post" id="addUser">
        <div class="input-group mb-3">
          <input type="email" class="form-control" required  placeholder="Email" id="email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" required placeholder="Password" id="password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
          <div class="input-group mb-3">
          <input type="password" class="form-control" required placeholder="Password confirm" id="password2">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
          <p style="font-size: 12px;">Le mot de passe doit comporter au moins 8 caractères comprenant un chiffre et une lettre minuscule.</p>
        </div>
        <div class="row">
          <!-- /.col -->
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Sign up</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
      <div class="row">
         <P class="col-12" style="">Already have an account ? <a href="/users/login" class="text-center">Sign in </a></P>
      </div>
    </div>
  </div>
</div>
</body>
<script>
  $('#addUser').submit(function(e) {
    e.preventDefault();
    let email = $('#email').val();
    let password = $('#password').val();
     let password2 = $('#password2').val();
    let dest_url = "<?= $this->Url->build(['action'=>'forgotpassword']) ?>";
    dest_url = dest_url.replace(/&amp;/g, '&');
    let data = {
        email: email,
        password: password,
        password2: password2
    };
    let title = "<?= __('Merci de confirmer') ?>";
    let message = $(this).attr('data-message');
    let icon = 'warning';
    confirmAction(title, message, icon, dest_url, data, 'reload');
  });
</script>
