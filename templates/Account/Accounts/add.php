<div class="users form content">
    <?= $this->Form->create($account) ?>
    <fieldset>
        <legend><?= __('Créer votre compte') ?></legend>
        <?= $this->Form->control('username', ['required' => true, 'label' => 'Nom d\'utilisateur']) ?>
        <?= $this->Form->control('password', ['required' => true, 'label' => 'Mot de passe']) ?>
    </fieldset>
    <?= $this->Form->button(__('Créer le compte')) ?>
    <?= $this->Form->end() ?>
</div>
