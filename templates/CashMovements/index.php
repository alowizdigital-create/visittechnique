<div class="wrapper" style="margin-top: 44px;">
    <div class="content-wrapper">
        <body class="hold-transition sidebar-mini">
  <section class="content-head">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h3 style="margin-left: 20px; margin-top: 20px;">
            <i class="nav-icon fas fa-box"></i> Gestion des caisses
          </h3>
        </div>
      </div>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">

      <!-- Filtres de recherche -->
      <?= $this->Form->create(null, ['type' => 'get', 'class' => 'form-inline mb-3']) ?>
        <div class="form-group mr-2" style="padding-left: 50px;">
          <?= $this->Form->control('search', [
            'label' => false,
            'class' => 'form-control',
            'placeholder' => 'Mot-clé',
            'value' => $search ?? ''
          ]) ?>
        </div>
        <div class="form-group mr-2">
          <?= $this->Form->control('from', [
            'label' => false,
            'type' => 'date',
            'class' => 'form-control',
            'value' => $from ?? ''
          ]) ?>
        </div>
        <div class="form-group mr-2">
          <?= $this->Form->control('to', [
            'label' => false,
            'type' => 'date',
            'class' => 'form-control',
            'value' => $to ?? ''
          ]) ?>
        </div>
        <div class="form-group mr-2">
          <?= $this->Form->button('Rechercher', ['class' => 'btn btn-primary']) ?>
        </div>
      <?= $this->Form->end() ?>

      <!-- Tableau -->
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Les opérations de la caisse</h3>
            </div>
            <div class="card-body">
              <table class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th><?= $this->Paginator->sort('type', 'Type') ?></th>
                    <th><?= $this->Paginator->sort('cash_box_id', 'Caisse') ?></th>
                    <th><?= $this->Paginator->sort('user_id', 'Utilisateur') ?></th>
                    <th><?= $this->Paginator->sort('montant', 'Montant') ?></th>
                    <th><?= $this->Paginator->sort('created', 'Date') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($cashMovements as $cashMovement): ?>
                    <tr>
                      <td><?= h($cashMovement->type) ?></td>
                      <td><?= $cashMovement->cash_box->name ?? '' ?></td>
                      <td><?= $cashMovement->user->firstname . ' ' . $cashMovement->user->lastname ?? '' ?></td>
                      <td><?= $this->Number->format($cashMovement->montant) ?></td>
                      <td><?= $cashMovement->created?->i18nFormat('dd/MM/yyyy HH:mm') ?></td>
                      <td class="actions">
                        <?= $this->Html->link(__('Voir'), ['action' => 'view', $cashMovement->id]) ?>
                        <?= $this->Html->link(__('Modifier'), ['action' => 'edit', $cashMovement->id]) ?>
                        <?= $this->Form->postLink(
                            __('Supprimer'),
                            ['action' => 'delete', $cashMovement->id],
                            ['confirm' => __('Êtes-vous sûr de vouloir supprimer # {0}?', $cashMovement->id)]
                        ) ?>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
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
</div>
