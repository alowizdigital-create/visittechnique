<?php
    $plugin = $plugin ?? null;
    $controller = $controller ?? null;
    $action = $action ?? null;
?>
<li class="nav-item <?= ($plugin=='SmsManager') ? 'menu-open':'' ?> ">
  <a href="#" class="nav-link">
    <i class="nav-icon fa fa-tools"></i>
    <p>
      <?= __('Configurations') ?>
      <i class="fas fa-angle-left right"></i>
    </p>
  </a>
  <ul class="nav nav-treeview small">
    <li class="nav-item ml-3">
      <a href="<?= $this->Url->build(['plugin'=>false, 'controller'=>'Genders', 'action'=>'index']) ?>" 
        class="nav-link <?= ($plugin == 'SmsManager' && $controller=='Messages' && $action=='send') ? 'active':'' ?>">
        <i class="nav-icon fa fa-tags"></i>
        <p><?= __('Genres de véhicules') ?></p>
      </a>
    </li>
  </ul>
  <ul class="nav nav-treeview small">
    <li class="nav-item ml-3">
      <a href="<?= $this->Url->build(['plugin'=>false, 'controller'=>'Templates', 'action'=>'index']) ?>" 
        class="nav-link <?= ($plugin == 'SmsManager' && $controller=='Messages' && $action=='send') ? 'active':'' ?>">
        <i class="nav-icon fa fa-file-alt"></i>
        <p><?= __('Modeles de SMS') ?></p>
      </a>
    </li>
  </ul>
   <ul class="nav nav-treeview small">
    <li class="nav-item ml-3">
      <a href="<?= $this->Url->build(['plugin'=>false, 'controller'=>'Reminders', 'action'=>'index']) ?>" 
        class="nav-link <?= ($plugin == 'SmsManager' && $controller=='Messages' && $action=='send') ? 'active':'' ?>">
        <i class="nav-icon fa fa-bell"></i>
        <p><?= __('Rappels') ?></p>
      </a>
    </li>
  </ul>
   
</li>
