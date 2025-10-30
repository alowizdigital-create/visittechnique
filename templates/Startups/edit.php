    

    <section class="content" style="margin-top: 70px;">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="#settings" data-toggle="tab">Nouvelle entreprise</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                    <div class="tab-content">
                        <div class="active tab-pane" id="settings">
                        <?= $this->Form->create($startup, ['class'=>'form-horizontal','type'=>'file']) ?>
                          <div class="form-group row">
                              <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                              <div class="col-sm-10">
                                <?= $this->Form->control('name', ['label' => false, 'type' => '', 'class' => 'form-control','placeholder'=>'Ex: x-technova']) ?>
                              </div>
                          </div>
                          <div class="form-group row">
                              <input type="hidden" id="uuid" name="cashbox_uuid" >
                              <label for="inputPhone" class="col-sm-2 col-form-label">Phone</label>
                              <div class="col-sm-10">
                                <?= $this->Form->control('phone', ['label' => false, 'type' => '', 'class' => 'form-control','placeholder'=>'Ex: 657788990']) ?>
                              </div>
                          </div>
                          <div class="form-group row">
                              <label for="inputRole" class="col-sm-2 col-form-label">Email</label>
                              <div class="col-sm-10">
                                <?= $this->Form->control('mail', ['label' => false, 'type' => '', 'class' => 'form-control','placeholder'=>'Ex: exemple@gmail.com']) ?>
                              </div>
                          </div>
                        <div class="form-group row">
                              <label for="inputRole" class="col-sm-2 col-form-label">Logo</label>
                              <div class="col-sm-10">
                                  <?= $this->Form->control('logo', ['label' => false,'required'=> false, 'type' => 'file', 'class' => 'form-control','placeholder'=>'Ex: exemple@gmail.com']) ?>
                              </div>
                          </div>
                          <div class="form-group row">
                              <div class="offset-sm-2 col-sm-10">
                                    <?= $this->Form->button(__('Sauvegarder'),['class'=>'btn btn-success']) ?>
                                     <?= $this->Form->end() ?>
                              </div>
                          </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- /.col -->
        </div>
      </div>
    </section>
   
