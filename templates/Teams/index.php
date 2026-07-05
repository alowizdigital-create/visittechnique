<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Contact $contact
 */
?>

<div class="wrapper" style="margin-top: 74px;">
<!-- <div class="content-wrapper"> -->
<div class="card">
  <div class="card-header">
    <h3 class="card-title"><?= __('Ajouter un contact') ?></h3>
  </div>
  <div class="card-body">
    <?= $this->Form->create($contact) ?>
    <div class="form-group">
      <?= $this->Form->control('name', [
        'label' => 'Nom',
        'class' => 'form-control',
        'placeholder'=>'Ex: Atangana paul'
      ]) ?>
      <?= $this->Form->control('phone', [
        'label' => 'Téléphone',
        'class' => 'form-control',
        'placeholder'=>'Ex: 653321288'
      ]) ?>
      <?= $this->Form->control('email', [
        'label' => 'Email',
        'class' => 'form-control',
        'placeholder'=>'Ex: example@gmail.com'
      ]) ?>
    </div>
  </div>
  <div class="card-footer">
    <?= $this->Form->button(__('Enregistrer'), ['class' => 'btn btn-primary']) ?>
    <?= $this->Form->end() ?>
  </div>
</div>
</div>
