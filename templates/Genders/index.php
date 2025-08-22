<div class="wrapper" style="margin-top: 44px;">
  <div class="content-wrapper" >
  <section class="content" >
    <div class="container-fluid">
      <div class="row" >
        <div class="col-12" style="margin-top: 54px;">
          <div class="card">
            <!-- En-tête -->
            <div class="card-header d-flex justify-content-between align-items-center">
              <h3 class="card-title"><?= __('Liste de genre') ?></h3>
               <div class="ml-auto">
                    <?= $this->Html->link(__('Nouveau genre'), ['action' => 'add'], [
                      'class' => 'btn btn-primary text-white',
                      'style' => 'border:none;'
                    ]) ?>
                  </div>
            </div>
            <!-- Table -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-hover table-sm">
                <thead>
                  <tr>
                    <th>#</th>
                    <th><?= __('Nom') ?></th>
                  
                      <th><?= __('Frais de visite') ?></th>
                    <th class="text-center"><?= __('Actions') ?></th>
                  </tr>
                </thead>
                <tbody>
                <?php $count = 1; foreach ($genders as $gender): ?>
                <tr>
                    <td><?= $count++ ?></td>
                    <td><?= h($gender->name) ?></td>
                  
                     <td><?= h($gender->price) ?></td>
                    <td class="actions">
                          <?= $this->Html->link(__('<i class="fas fa-eye" style="color:#000;"></i>'), ['action' => 'view', $gender->id], ['escape' => false, 'title'=>'Consulter']) ?>
                          <?= $this->Html->link(__('<i class="fas fa-edit" style="color:#000;"></i>'), ['action' => 'edit', $gender->id], ['escape' => false,'title'=>'Modifier']) ?>
                         <?= $this->Form->postLink(
                              '<i class="fas fa-trash-alt" style="color:#dc3545;"></i>',
                              ['action' => 'delete', $gender->id],
                              [
                                'confirm' => __('Are you sure you want to delete # {0}?', $gender->id),
                                'escape' => false,
                                'title' => 'Supprimer',
                              ]
                            ) ?>
                    </td>
                </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
            <!-- Pagination -->
          </div>
        </div>
      </div>
    </div>
  </section>
</div> 
</div>
<footer class="main-footer" style="position: fixed; bottom: 0; left: 0; width: 100%; z-index: 1030; background: #f8f9fa; padding: 10px 20px; border-top: 1px solid #dee2e6;">
  <div class="float-right d-none d-sm-inline">
    <b>Version</b> 3.2.0
  </div>
  <strong>Copyright &copy; 2025 <a href="#">X-technova</a></strong> Tous droits réservés.
</footer>




