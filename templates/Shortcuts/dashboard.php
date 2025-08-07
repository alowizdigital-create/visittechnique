
<div class="wrapper">
 
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-6 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warnin">
                      <div class="inner">
                        <h3><?= $allNumberLink ?></h3>   
                        <p><?=  __(' URLs enregistrées') ?></p>
                      </div>
                      <div class="icon">
                        <i class="ion ion-person-add"></i>
                      </div>
                      <a style="color: #000;" href=" <?=  $this->url->Build(['controller'=>'Shortcuts','action'=>'index']) ?>" class="small-box-footer" >En savoir plus <i class="fas fa-arrow-circle-right"> </i></a>
                    </div>
                  </div>
                  <!-- ./col -->
                  <div class="col-lg-6 col-6">
                    <!-- small box -->
                    <div class="small-box bg-ino">
                      <div class="inner">
                        <h3> <?= $nomberOfClic ?></h3>
                        <p><?= 'Clics sur vos URLs' ?></p>
                      </div>
                      <div class="icon">
                        <i class="ion ion-bag"></i>
                      </div>
                      <a style="color: #000;" href="<?=  $this->url->Build(['controller'=>'Customers','action'=>'index']) ?>" class="small-box-footer"> <?= __('En savoir plus ') ?><i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                  </div>
                  <table id="example1" class="table table-bordered table-striped">
                  <div class="card-header">
                    <h3 class="card-title">Mes URLs</h3> 
                    <button type="button"  style="background-color: #003366;border: #003366; color:#fff" class="btn float-right" data-bs-toggle="modal" data-bs-target="#detailsModal" data-id="123">
                          Raccourcir une URL
                    </button>
                  </div> 
                    <thead>
                        <tr>
                        <th> URLs </th>
                            <th>raccourcis </th>
                            <th> Nombre de clics </th>
                        </tr>
                    </thead>
                    <tbody>  
                      <?php foreach ($shortcuts as $shortcut): ?>
                          <tr>
                              <td><a href="<?= h($shortcut->url) ?>" target="_blank"><?= h($shortcut->url) ?></a></td>
                              
                              <td><a href="http://<?=  h($shortcut->shorturl) ?>" target="_blank"><?= h($shortcut->shorturl) ?></a></td>
                              <td><?= h($shortcut->number_of_clic) ?></td>
                          </tr> 
                      <?php endforeach; ?>
                  </tbody>
                </table>
            </div>   
  
    <!-- /.content -->
  </div>
</div>


<!-- Modal d'enregistrement du client -->
<div class="modal fade" id="detailsModal" tabindex="-1" aria-labelledby="ModalDetails" aria-hidden="true">
  <div class="modal-dialog">
  <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalAdd">Entrez l'URL à raccoucir</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
           <?= $this->Form->create(null,['id'=>'addShortcutForm']) ?> 
            <fieldset>
                  <div class="row">
                    <div class="col-12">
                         <?= $this->Form->control('url',['label' => 'URL','class'=>'form-control','id'=>'inputUrl']) ;?>
                    </div> 
                  </div>
            </fieldset>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <?= $this->Form->button(__('Raccourcir'), ['class' => 'btn btn-primary']) ?>
            </div>
            <?= $this->Form->end() ?>
      </div>
    </div>
  </div>
</div>


<script>
$(document).ready(function() {
       // Raccourcicement d'url par avec ajax
        $('#addShortcutForm').submit(function(e) {
            e.preventDefault();
            var data = {
                'url': $('#inputUrl').val(),
                '_csrfToken': myToken
            };
            $.ajax({
                url: '/rootAjaxShortUrl',
                type: 'POST',
                data: data,
                dataType: 'json',
                success: function(result) {
                    if (result.code == 300) {
                    $('#ModalAdd').modal('hide');
                      toastr.success(result.msg);
                      setTimeout(function() {
                          window.location = '/dashboard';
                          }, 2000);
                    }else
                    {
                        toastr.error(result.msg);
                        $('#ModalAdd').modal('hide');
                        
                    }
                }
            });
        });
    });
</script>



