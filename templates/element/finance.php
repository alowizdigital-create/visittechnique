<?php
    $plugin = $plugin ?? null;
    $controller = $controller ?? null;
    $action = $action ?? null;
?>
<li class="nav-item <?= ($plugin=='SmsManager') ? 'menu-open':'' ?> ">
  <a href="#" class="nav-link">
   <i class="nav-icon fas fa-money-bill"></i>
    <p>
      <?= __('Finances') ?>
      <i class="fas fa-angle-left right"></i>
    </p>
  </a>
  <ul class="nav nav-treeview small">
       <li class="nav-item ml-3">
          <a href="<?= $this->Url->build(['plugin'=>false, 'controller'=>'Payments', 'action'=>'index']) ?>" 
            class="nav-link <?= ($plugin == 'SmsManager' && $controller=='Messages' && $action=='send') ? 'active':'' ?>">
            <i class="nav-icon fa fa-money-bill"></i>
            <p><?= __('Paiements') ?></p>
          </a>
      </li>
      <li class="nav-item ml-3">
          <a href="<?= $this->Url->build(['plugin'=>false, 'controller'=>'Discounts', 'action'=>'index']) ?>" 
            class="nav-link <?= ($plugin == 'SmsManager' && $controller=='Messages' && $action=='send') ? 'active':'' ?>">
            <i class="nav-icon fa fa-percent"></i>
            <p><?= __('Reductions') ?></p>
          </a>
      </li>
       <li class="nav-item ml-3">
          <a href="<?= $this->Url->build(['plugin'=>false, 'controller'=>'Bills', 'action'=>'index']) ?>" 
            class="nav-link <?= ($plugin == 'SmsManager' && $controller=='Messages' && $action=='send') ? 'active':'' ?>">
            <i class="nav-icon fa fa-file-invoice"></i>
            <p><?= __('Factures') ?></p>
          </a>
      </li>
  </ul>
</li>