
<div class="wrapper">
  <!-- /.navbar -->
  <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" style='margin-top:74px' >
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <!-- En-tête -->
            <div class="card-header d-flex justify-content-between align-items-center">
              <h3 class="card-title m-0"><?= __('Mes caisses') ?></h3>
              <div class="ml-auto">
                    <?= $this->Html->link(__('Nouvelle caisse'), ['action' => 'newCashBoxAndCashMouvement'], [
                        'class' => 'btn btn-sm btn-primary text-white',
                    ]) ?>
               </div>
            </div>
            <!-- Tableau -->
            <div class="card-body">
              <table class="table table-bordered table-hover table-sm">
                <thead>
                  <tr>
                    <th>#</th>
                    <th><?= __('solde initial') ?></th>
                    <th><?= __('solde actuel') ?></th>
                    <th><?= __('statut') ?></th>
                    <th><?= __('Date') ?></th>
                  </tr>
                </thead>
                <tbody>
                  <?php $count = 1; foreach ($cashBoxes as $cashBox): ?>
                    <tr>
                      <td><?= $count ?></td>
                      <td><?= h($cashBox->solde_initial) ?></td>
                       <td><?= h($cashBox->solde_actuel) ?></td>
                        <td><?= h($cashBox->statut) ?></td>
                      <td><?= h($cashBox->created->nice()) ?></td>
                    </tr>
                  <?php $count++; endforeach; ?>
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

