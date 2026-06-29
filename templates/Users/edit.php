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
               <?= $this->Form->create($account) ?>
                <form class="form-horizontal" id="formUser" type='file' enctype='multipart/form-data'>
                <div class="form-group row">
                    <div class="col-sm-12">
                         <?php   echo $this->Form->control('name',['class'=>'form-control']); ?>
                    </div>
                </div>
                 <div class="form-group row">
                    <div class="col-sm-12">
                         <?php   echo $this->Form->control('phone',['class'=>'form-control']); ?>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-12">
                         <?php   echo $this->Form->control('role',['class'=>'form-control']); ?>
                    </div>
                </div>
                  <div class="form-group row">
                    <div class="col-sm-12">
                         <?php   echo $this->Form->control('passwordshow',['class'=>'form-control']); ?>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class=" col-sm-12">
                    <?= $this->Form->button(__('Mettre à jour',['class'=>'btn btn-success'],['class'=>'btn btn-success']),['class'=>'btn btn-success']) ?>
                </div>
            </div>
           <?= $this->Form->end() ?>
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
   
