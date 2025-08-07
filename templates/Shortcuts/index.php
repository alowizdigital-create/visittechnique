
<div class="wrapper">
 
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
            <div class="row">
               
                  <!-- ./col -->
                  
                  </div>
                  <table id="example1" class="table table-bordered table-striped">
                  <div class="card-header">
                    <h3 class="card-title">Mes URLs</h3> 
                    <button type="button"  style="background-color: #003366;border: #003366; color:#fff" class="btn float-right" data-bs-toggle="modal" data-bs-target="#detailsModal" data-id="123">
                          Raccourcir une URL
                    </button>
                  </div> 
                      <thead>
                        <tr style='background-color: #003366; color:#fff' >
                            <th>#</th>
                            <th> <?= __('URL') ?></th>
                            <th><?= __('URL courte') ?></th>
                            <th> <?= __('Nombre de clic') ?></th>
                            <th><?= __('Date de création') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php $count=1; foreach ($shortcuts as $shortcut): ?>
                      <tr>
                          <td><?= $this->Number->format($count) ?></td>
                          <td><?= h($shortcut->url) ?></td>
                          <td><?= h($shortcut->shorturl) ?></td>
                          <td><?= h($shortcut->number_of_clic) ?></td>
                          <td><?= h($shortcut->created->nice()) ?></td>
                          <td class="actions">
                              <?= $this->Html->link(__('Consulter'), ['action' => 'view', $shortcut->id]) ?>
                              <?= $this->Html->link(__('Modifier'), ['action' => 'edit', $shortcut->id]) ?>
                              <?= $this->Form->postLink(__('Supprimer'), ['action' => 'delete', $shortcut->id], ['confirm' => __('Are you sure you want to delete # {0}?', $shortcut->id)]) ?>
                          </td>
                      </tr>
                      <?php $count++; endforeach; ?>
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
       alerte('Bonjour');
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
                          window.location = '/shortcuts/index';
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

