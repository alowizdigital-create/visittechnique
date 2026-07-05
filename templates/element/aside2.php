  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color: #2F4F4F;">
    <!-- Brand Logo -->
    <a href="<?= $this->Url->build(['controller' => 'Contacts', 'action' => 'edit']) ?>" class="brand-link">
        <?= $this->Html->image('xtech.jpg', [
            'class' => 'brand-image img-circle elevation-3',
            'alt' => 'AdminLTE Logo'
        ]) ?>
        <span class="brand-text font-weight-light ml-2 primary" style="font-size: 20px;">DosSMS</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">

      <!-- Sidebar user panel (optional) -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-header"></li>
          <li class="nav-item">
            <a href="/account/login" class="nav-link">
            <i class="nav-icon fas fa-user"></i>
              <p>
                  Connexion
              </p>
            </a>
          </li>
       
          <li class="nav-item">
              <a href="<?= $this->Url->build(['controller' => 'Pages', 'action' => 'display', 'faq']) ?>" class="nav-link">
                  <i class="nav-icon fas fa-question-circle"></i>
                  <p><?= __('FAQ') ?></p>
              </a>
          </li>
          <!-- <li class="nav-header">COMPTES</li> -->
          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
