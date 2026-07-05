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
            <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'dashboard']) ?>" class="nav-link">
              <i class="nav-icon fas fa-home"></i>
              <p>
                Home
                <!--<span class="badge badge-info right">2</span>-->
              </p>
            </a>
          </li>
           <li class="nav-item">
            <a href="<?= $this->Url->build(['controller' => 'Vehicles', 'action' => 'index']) ?>" class="nav-link">
              <i class="nav-icon fas fa-car"></i>
              <p>
                Véhicules
              </p>
            </a>
          </li>
          <?php if ($userAuth->role == 'admin' ||  $userAuth->role == 'directeur' ) : ?> 

            <li class="nav-item">
            <a href="<?= $this->Url->build(['controller' => 'Discounts', 'action' => 'index']) ?>" class="nav-link">
                <i class="nav-icon fas fa-percentage"></i>
               <p><?= __('Reductions') ?></p>
            </a>
          </li>
          <?php endif; ?>
        
          <li class="nav-item">
            <a href="<?= $this->Url->build(['controller' => 'Cashboxes', 'action' => 'index']) ?>" class="nav-link">
                 <i class="nav-icon fas fa-cash-register"></i>
                <p><?= __('Caisse(s)') ?></p>
                <span class="badge badge-info right"><?= ($notifications) ?? 0 ?></span>
             
            </a>
          </li>
          <?php if ($userAuth->role == 'admin' ||  $userAuth->role == 'directeur' ) : ?> 
          <!--<li class="nav-item">-->
          <!--  <a href="<?= $this->Url->build(['controller' => 'Genders', 'action' => 'index']) ?>" class="nav-link">-->
          <!--      <i class="nav-icon fas fa-car"></i>-->
          <!--      <p><?= __('Genres de véhicules') ?></p>-->
          <!--  </a>-->
          <!--</li>-->
           
            <?php endif; ?>
          <!--<li class="nav-header">COMPTES</li>-->
          
           <li class="nav-item">
              <a href="<?= $this->Url->build(['controller' => 'Messages', 'action' => 'sent']) ?>" class="nav-link">
                  <i class="nav-icon fas fa-bell"></i>
                  <p><?= __('SMS envoyés') ?></p>
              </a>
            </li>
           <li class="nav-item">
                <a href="<?= $this->Url->build(['controller' => 'Messages', 'action' => 'pending']) ?>" class="nav-link ">
                    <i class="nav-icon fas fa-paper-plane"></i>
                    <p><?= __('Les relances') ?></p>
                </a>
            </li>
         
            <li class="nav-item">
            <a href="<?= $this->Url->build(['controller' => 'Messages', 'action' => 'shedule']) ?>" class="nav-link">
                 <i class="nav-icon fas fa-cash-register"></i>
                <p><?= __('SMS rapide') ?></p>
                <span class="badge badge-info right"><?= ($notifications) ?? 0 ?></span>
               
            </a>
          </li>
            <?php if ($userAuth->role == 'admin') : ?>
                <li class="nav-item">
                    <a href="<?= $this->Url->build(['controller' => 'Startups', 'action' => 'index']) ?>" class="nav-link ">
                        <i class="nav-icon fas fa-paper-plane"></i>
                        <p><?= __('Entreprises') ?></p>
                    </a>
                </li>
            <?php endif; ?>
           <?php if ($userAuth->role == 'admin' ||  $userAuth->role == 'directeur' ) : ?> 
             <li class="nav-item">
                <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'collabots']) ?>" class="nav-link ">
                    <i class="nav-icon fas fa-user-friends"></i>
                    <p><?= __('Collaborateurs') ?></p>
                </a>
            </li>
             <?php endif; ?>
             <li class="nav-item">
                <a href="<?= $this->Url->build(['controller' => 'users', 'action' => 'account']) ?>" class="nav-link ">
                <i class="nav-icon fas fa-user"></i>
                <p><?= __('Mon compte') ?></p>
                </a>
            </li>
            <?php if ($userAuth->role == 'admin') : ?>
              <li class="nav-item">
                    <a href="https://dossms.x-technova.com/admin/logout" class="nav-link ">
                   <i class="nav-icon fas fa-sign-out-alt"></i>
                    <p><?= __('Déconnexion') ?></p>
                </a>
            </li>
            <?php else:  ?>
                 <li class="nav-item">
                    <a href="https://dossms.x-technova.com/account/logout" class="nav-link ">
                   <i class="nav-icon fas fa-sign-out-alt"></i>
                    <p><?= __('Déconnexion') ?></p>
                </a>
            </li>
            
            <?php endif; ?>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    
  </aside>
