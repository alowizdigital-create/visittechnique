<?php
    $plugin = $plugin ?? null;
    $controller = $controller ?? null;
    $action = $action ?? null;
?>
<li class="nav-item <?= ($plugin=='SmsManager') ? 'menu-open':'' ?> ">
  <a href="#" class="nav-link">
    <i class="nav-icon fa fa-list"></i>
    <p>
      <?= __('Historiques') ?>
      <i class="fas fa-angle-left right"></i>
    </p>
  </a>
  <ul class="nav nav-treeview small">
    <li class="nav-item ml-3">
      <a href="<?= $this->Url->build(['plugin'=>false, 'controller'=>'Customers', 'action'=>'index']) ?>" 
        class="nav-link <?= ($plugin == 'SmsManager' && $controller=='Messages' && $action=='send') ? 'active':'' ?>">
        <i class="nav-icon fa fa-users"></i>
      
        <p><?= __('Clients') ?></p>
      </a>
    </li>
  </ul>
  <ul class="nav nav-treeview small">
    <li class="nav-item ml-3">
      <a href="<?= $this->Url->build(['plugin'=>false, 'controller'=>'Vehicles', 'action'=>'index']) ?>" 
        class="nav-link <?= ($plugin == 'SmsManager' && $controller=='Messages' && $action=='send') ? 'active':'' ?>">
        <i class="nav-icon fa fa-car"></i>
        <p><?= __('Véhicules') ?></p>
      </a>
    </li>
  </ul>
  <ul class="nav nav-treeview small">
    <li class="nav-item ml-3">
      <a href="<?= $this->Url->build(['plugin'=>false, 'controller'=>'Inspections', 'action'=>'index']) ?>" 
        class="nav-link <?= ($plugin == 'SmsManager' && $controller=='Messages' && $action=='send') ? 'active':'' ?>">
        <i class="nav-icon fa fa-wrench"></i>
        <p><?= __('Visites techniques') ?></p>
      </a>
    </li>
  </ul>
   <ul class="nav nav-treeview small">
    <li class="nav-item ml-3">
      <a href="<?= $this->Url->build(['plugin'=>false, 'controller'=>'Messages', 'action'=>'index']) ?>" 
        class="nav-link <?= ($plugin == 'SmsManager' && $controller=='Messages' && $action=='send') ? 'active':'' ?>">
        <i class="nav-icon fa fa-paper-plane"></i>
        <p><?= __('Relances') ?></p>
      </a>
    </li>
  </ul>
   
</li>