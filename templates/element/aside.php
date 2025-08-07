<aside class="main-sidebar sidebar-light elevation-1" style="height: 100%; background-color:#fff; color: #228B22; position: fixed;">
  <!-- Brand Logo -->
  <a href="<?= $this->Url->build(['controller' => 'Contacts', 'action' => 'edit']) ?>" class="brand-link text-dark">
    <?= $this->Html->image('xtech.jpg', [
        'class' => 'brand-image img-circle elevation-3', 
        'alt' => 'AdminLTE Logo'
    ]) ?> 
    <span class="brand-text font-weight-light ml-2 primary" style="font-size: 20px;">DosSMS</span>
  </a> 
  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar Menu -->
    <nav class="mt-4">
      <ul class="nav nav-pills nav-sidebar flex-column text-dark" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'dashboard']) ?>" class="nav-link text-dark">
            <i class="nav-icon fas fa-home"></i>
            <p>Accueil</p>
          </a>
        </li>
        <!-- <?= $this->element('history') ?> -->
        <?= $this->element('finance') ?>
        <?= $this->element('sms_setting') ?>
        <li class="nav-item">
          <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'logout']) ?>" class="nav-link text-dark">
            <i class="nav-icon fas fa-sign-out-alt"></i>
            <p>Déconnexion</p>
          </a>
        </li>
         
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>
