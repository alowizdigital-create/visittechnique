
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="../../index2.html"><b>kussala</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-mg">  <?= h($email) ?> votre lien de validation est obsolete cliquez sur le bouton ci dessous pour recevoir un nouveau lien en email pour la verification.
      </p>
      <div class="social-auth-links text-center mb-3">
        <a href="http://kussala.com/users/getvalidlink/<?= h($email) ?>" class="btn btn-block btn-primary">
             Recevoir l'email 
        </a>
      </div>
      <!-- /.social-auth-links -->
      <p class="mb-1">
        <a href="/users/login">Connexion</a>
      </p>
      <p class="mb-0">
        <a href="/users/add" class="text-center">Creer un compte </a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
</body>
</html>
