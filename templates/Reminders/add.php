<div class="wrapper" style="margin-top: 44px;">
<div class="content-wrapper">
<body class="hold-transition sidebar-mini">
    <!-- Content Header (Page header) -->
    <section class="content-head">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
              <br>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- SELECT2 EXAMPLE -->
        <div class="card card-default">
             <!-- <div class="col-sm-6"> -->
          <!-- </div> -->
          <div class="card-header">
            <h4 style="">  <i class="nav-icon fas fa-ring" style="margin-right: 10px;"></i>Rappel </h4>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
           <?= $this->Form->create($reminder) ?>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                     <?= $this->Form->control('name',['label'=>'Nom','class'=>'form-control select2','placeholder'=>'Ex: Nom prénom ...','required'=>true]); ?>
                </div>
              </div>
               <div class="col-md-6">
                <div class="form-group">
                     <?= $this->Form->control('gender_id',['options'=> $genders,'label'=>'Genre de vehicule','class'=>'form-control select2', 'required'=>true, 'placeholder'=>'Ex: Nom prénom ...']); ?>
                </div>
              </div>
            </div>
            <div class="row"> 
              <div class="col-md-3">
                <div class="form-group">
                     <?= $this->Form->control('date_before1',['label'=>'Premiere relance','class'=>'form-control select2','placeholder'=>'Ex: Vehicule lourd']); ?>
                </div>
              </div>
               <div class="col-md-3">
                <div class="form-group">
                     <?= $this->Form->control('date_before2',['label'=>'Genre','class'=>'form-control select2','placeholder'=>'Ex: Vehicule lourd']); ?>
                </div>
              </div>
               <div class="col-md-3">
                <div class="form-group">
                     <?= $this->Form->control('date_before3',['label'=>'Genre','class'=>'form-control select2','placeholder'=>'Ex: Vehicule lourd']); ?>
                </div>
              </div>
               <div class="col-md-3">
                <div class="form-group">
                     <?= $this->Form->control('date_before4',['label'=>'Genre','class'=>'form-control select2','placeholder'=>'Ex: Vehicule lourd']); ?>
                </div>
              </div>
            </div>
             <!-- <div class="row"> 
              <div class="col-md-12"> 
                <div class="form-group">
                     <?= $this->Form->control('days_after',['label'=>'Nombre de jour après','class'=>'form-control select2','placeholder'=>'Ex: Vehicule lourd']); ?>
                </div>
              </div>
            </div> -->
        <div class="col-sm-6">
           <h4 style="">  <i class="nav-icon fas fa-ring" style="margin-right: 10px;"></i>Modèle</h4>
        </div>
      <div class="form-group">
        <?= $this->Form->control('name', [
          'label' => 'Nom du modèle',
            'required' => true,
          'class' => 'form-control'

        ]) ?>
      </div>
      <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <?= $this->Form->control('content', [
                    'label' => 'Contenu du message',
                    'class' => 'form-control',
                    'type' => 'textarea',
                    'required' => true,
                    'id' => 'messageTemplate'
                    ]) ?>
            </div>
            <div class="form-group">
        <label>> Champs disponibles :</label><br>
        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="insertTag('[name]')">Nom</button>
        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="insertTag('[date]')">Date</button>
        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="insertTag('[niu]')">N.I.U</button>
        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="insertTag('[reg]')">Registre de commerce</button>
      </div>
        </div>
      <div class="col-md-6">
      <div class="form-group mt-3 p-3 border rounded bg-light">
        <strong>Aperçu du message :</strong>
        <p id="previewText" class="mt-2 text-muted"></p>
      </div>
      </div>
     </div>
      </div>
     <?= $this->Form->button(__('Sauvegarder'), ['class' => 'btn btn-primary form-control select2','style'=>'margin-bottom:35px; margin-top:-30px']) ?>
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


<script>
    const messageInput = document.getElementById('messageTemplate');
    const preview = document.getElementById('previewText');
    const sampleData = {
      name: "name",
      niu: "NIU",
      reg: "reg",
      date:"date"
    };
    function updatePreview() {
      let msg = messageInput.value;
      for (const key in sampleData) {
        const regex = new RegExp('\\[' + key + '\\]', 'gi');
        msg = msg.replace(regex, sampleData[key]);
      }
      preview.textContent = msg;
    }
    function insertTag(tag) {
      const start = messageInput.selectionStart;
      const end = messageInput.selectionEnd;
      const text = messageInput.value;
      messageInput.value = text.slice(0, start) + tag + text.slice(end);
      messageInput.focus();
      messageInput.setSelectionRange(start + tag.length, start + tag.length);
      updatePreview();
    }
    messageInput.addEventListener('input', updatePreview);
    updatePreview();
</script>










































