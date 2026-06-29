   <body class="hold-transition sidebar-mini" style="padding-top: 25px;">
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
           <?= $this->Form->create($inspection) ?>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                     <?= $this->Form->control('vehicle_id',['options'=> $vehicles,'label'=>'Vehicule','class'=>'form-control select2','placeholder'=>'Ex: Nom prénom ...']); ?>
                </div>
              </div>
             
            </div>
             <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                     <?= $this->Form->control('end_date',['label'=>'Date de fin','class'=>'form-control select2','placeholder'=>'Ex: Vehicule lourd']); ?>
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
<!-- ./wrapper -->

