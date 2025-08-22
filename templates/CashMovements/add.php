<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CashMovement $cashMovement
 * @var \Cake\Collection\CollectionInterface|string[] $cashBoxes
 * @var \Cake\Collection\CollectionInterface|string[] $users
 */
?>

<div class="wrapper" style="margin-top: 84px;">
<div class="content-wrapper">
<body class="hold-transition sidebar-mini">
   <section class="content-head">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="margin-left: 20px; margin-top: 20px;">  <i class="nav-icon fas fa-plus"></i>Ma caisse</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
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
    <!-- /.content -->
  </div>
</div>








