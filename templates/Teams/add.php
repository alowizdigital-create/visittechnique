<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SmsGroup $smsGroup
 */
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.5.2/dist/select2-bootstrap4.min.css" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<div class="wrapper" style="margin-top: 74px;">

    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><?= __('Créer un groupe de contacts') ?></h3>
      </div>
      <?= $this->Form->create($team) ?>
      <div class="card-body">
        <div class="form-group">
          <?= $this->Form->control('name', [
            'label' => 'Nom du groupe',
            'class' => 'form-control'
          ]) ?>
        </div>
        <div class="form-group">
          <?= $this->Form->control('note', [
            'label' => 'Note',
            'class' => 'form-control',
            'required' => false
          ]) ?>
        </div>
        <div class="form-group">
            <?=  $this->Form->control('contacts._ids', [
                    'label' => 'Associer des contacts',
                    'options' => $contacts, 
                    'id' => 'receiver',
                    'multiple' => true,
                    'class' => 'form-control select2'
                ]); ?>
        </div>
      </div>
      <div class="card-footer">
        <?= $this->Form->button(__('Enregistrer'), ['class' => 'btn btn-primary']) ?>
      </div>
      <?= $this->Form->end() ?>
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    $('.select2').select2({
        theme: 'bootstrap4',
        placeholder: "Choisissez un ou plusieurs contacts",
        allowClear: true
    });
});
</script>
