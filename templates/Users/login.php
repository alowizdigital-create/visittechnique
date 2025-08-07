<body class="hold-transition login-page" style=" padding-bottom:250px;">
      <div class="login-box">
        <div class="login-logo">
          <a href="../../index2.html"><b>kussala</a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
          <div class="card-body login-card-body">
            <p class="login-box-msg">Sign in to start your session</p>
            <form action="../../index3.html" method="post" id="loginUser">
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
              <div class="row">
                <!-- /.col -->
                <div class="col-12">
                  <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                </div>
                <!-- /.col -->
              </div>
            </form>
            <p class="mb-1" style="margin-top: 50px;">
              <a href="/users/forgotpassword">Mot de passe oublié</a>
            </p>
            <p class="mb-0">
              <a href="/users/add" class="text-center">Creer un compte </a>
            </p>
          </div>
        </div>
      </div>
</body>


<script>
$(document).ready(function() {
        //  Fonction de création de compte utilisateur
        $('#loginUser').submit(function(e) {
            e.preventDefault();
          
            var data = {
                'email':$('#email').val(),
                'password':$('#password').val(),
                '_csrfToken': myToken
            };
            $.ajax({
                url: '/users/login',
                type: 'POST',
                data: data,
                dataType: 'json',
                success: function(result) {
                    if (result.code === 100) {
                       toastr.success(result.msg);
                    setTimeout(function() {
                        window.location = '/users/dashboard';
                        }, 2000);
                    } else{
                    toastr.error(result.msg);
                    }
                }
            });
        });
    });
</script>