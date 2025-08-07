<div class="wrapper" style="margin-top: 44px;">
<div class="content-wrapper">
<body class="hold-transition sidebar-mini">
    <!-- Content Header (Page header) -->
    <section class="content-head">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="margin-left: 20px; margin-top: 20px;">  <i class="nav-icon fas fa-plus"></i> Nouveau</h1>
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
           <?= $this->Form->create($customer) ?>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                     <?= $this->Form->control('name',['label'=>'Nom complet','class'=>'form-control select2','placeholder'=>'Ex: Nom prénom ...']); ?>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                     <label></label>
                     <?= $this->Form->control('phone',['label'=>'Téléphone','class'=>'form-control select2','placeholder'=>'Ex: 690098990']); ?>
                </div>
              </div>
            </div>
              <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                     <?= $this->Form->control('email',['label'=>'Email','class'=>'form-control select2','placeholder'=>'Ex: user@gmail.com (Facultatif)']); ?>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                     <?= $this->Form->control('address',['label'=>'Adresse','class'=>'form-control select2','placeholder'=>'Ex: Odza... (Facultatif)']); ?>
                </div>
              </div>
            </div>
           <?= $this->Form->button(__('Sauvegarder'), ['class' => 'btn btn-primary form-control select2','style'=>'margin-top:25px']) ?>
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
  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.2.0
    </div>
    <strong>Copyright &copy; 2025 <a href="https://adminlte.io">X-technova</a></strong> All rights reserved.
  </footer>
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->


