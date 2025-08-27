<!-- Content Wrapper -->
  
<div class="wrapper" style="margin-top: 84px;">

<div class="content-wrapper">
    <section class="content">
      <div class="container-fluid" >
            <p class="text-center font-weight-bold" style="font-size: 16px; color: #007bff;">
            <i class="fas fa-search"></i> Trouvez rapidement un dossier en saisissant un mot-clé, 
            en choisissant une période (date), ou en filtrant par sexe :<br>
            <span class="text-secondary">Nom, prénom, nom complet, numéro de dossier, ou année de consultation.</span>
            </p>
     <h5></h5>
        <!-- Filtres de recherche -->
        <?= $this->Form->create(null, ['type' => 'get', 'class' => 'form-inline mb-3']) ?>
          <div class="form-group mr-2" style="padding-left: 50px;">
            <?= $this->Form->control('search', ['label' => false, 'class' => 'form-control', 'placeholder' => 'Mot-clé']) ?>
          </div>
          <div class="form-group mr-2">
            <?= $this->Form->control('from', ['label' => false, 'type' => 'date', 'class' => 'form-control']) ?>
          </div>
          <div class="form-group mr-2">
            <?= $this->Form->control('to', ['label' => false, 'type' => 'date', 'class' => 'form-control']) ?>
          </div>
          <div class="form-group mr-2">
            <?= $this->Form->control('sexe', [
              'label' => false,
              'class' => 'form-control',
              'options' => ['M' => 'Masculin', 'F' => 'Féminin'],
              'empty' => 'Tous les sexes'
            ]) ?>
          </div>
          <div class="form-group mr-2">
            <?= $this->Form->button('Rechercher', ['class' => 'btn btn-primary']) ?>
          </div>
        <?= $this->Form->end() ?>

        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Dossiers médicaux</h3>
              </div>

              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>Type</th>
                      <th>Type</th>
                      <th>Montant</th>
                      <th class="actions">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($cashMovs as $cashMov): ?>
                      <tr>
                         <td><?= h($cashMov->type) ?></td>
                        <td><?= h($cashMov->type) ?></td>
                        <td><?= $this->Number->format($cashMov->montant) ?></td>
                        <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $cashMov->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $cashMov->id]) ?>
                            <?= $this->Form->postLink(
                                __('Delete'),
                                ['action' => 'delete', $cashMov->id],
                                [
                                    'method' => 'delete',
                                    'confirm' => __('Are you sure you want to delete # {0}?', $cashMov->id),
                                ]
                            ) ?>
                        </td>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                  <tfoot>
                    <tr>
                      <th></th><th></th><th></th><th></th>
                    </tr>
                  </tfoot>
                </table>
              </div>
              <div class="card-footer clearfix">
                <ul class="pagination pagination-sm m-0 float-right">
                  <?= $this->Paginator->numbers() ?>
                </ul>
              </div>

            </div>
          </div>
        </div>

      </div>
    </section>

    <section class="content">
        <div class="row">
               <div class="col-md-4">
            <!-- Info Boxes Style 2 -->
            <div class="info-box mb-3 bg-warning">
              <span class="info-box-icon"><i class="fas fa-tag"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Etat initiale</span> 
                <span class="info-box-number"><?= h($amountInit); ?> Fcfa</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            <div class="info-box mb-3 bg-success">
              <span class="info-box-icon"><i class="far fa-heart"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Entré(e)s</span>
                <span class="info-box-number"><?= h($amountInput); ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            <div class="info-box mb-3 bg-danger">
              <span class="info-box-icon"><i class="fas fa-cloud-download-alt"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Sortie(s)</span>
                <span class="info-box-number"><?= h($amountInout); ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            <div class="info-box mb-3 bg-info">
              <span class="info-box-icon"><i class="fas fa-tag"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Etat actuel</span>
                <span class="info-box-number"><?= h($amountCash); ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
          </div>
          <!-- Left col -->
          <div class="col-md-8">
            <!-- MAP & BOX PANE -->
              <div class="card-body">
              <?= $this->Form->create($cashMovement) ?>
                    <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                                <?=  $this->Form->control('montant', [
                                    'label' => 'Montant',
                                    'id' => 'receiver',
                                    'class' => 'form-control'
                                ]); ?>
                        </div>
                    </div>
                    </div>
                    <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                        <?= $this->Form->control('type', [
                                'label' => 'Type de  transaction',
                                'options'=> ['Entrée', 'Sortie'],
                                'class' => 'form-control',
                                'placeholder' => 'Ex: 650000000'
                            ]); ?>
                        </div>
                    </div>
                       <div class="col-md-12">
                        <div class="form-group">
                        <?= $this->Form->control('justificatif', [
                                'label' => 'Justification',
                                'class' => 'form-control',
                                 'required' => true,
                                'placeholder' => 'Ex: 650000000'
                            ]); ?>
                        </div>
                    </div>
                    </div>
                  
                <?= $this->Form->button(__('Sauvegarder'), ['class' => 'btn btn-primary form-control','style'=>'margin-top:25px']) ?>
                    <?= $this->Form->end() ?>
                    </div>
                </div>
          </div>
        </div>
        <!-- /.row -->
      </div><!--/. container-fluid -->
    </section>
  </div>
</div>









