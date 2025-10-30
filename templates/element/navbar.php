<style>
/* CSS pour le sélecteur d'entreprise */
.company-selector-container {
    width: 100%;
    background-color: #ffffff;
    border-radius: 8px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    padding: 10px;
}

.company-item {
    display: flex;
    align-items: center;
    padding: 12px 10px;
    border-radius: 6px;
    cursor: pointer;
    transition: background-color 0.2s ease, transform 0.2s ease;
    text-decoration: none; /* Enlève le soulignement du lien */
    color: inherit; /* Utilise la couleur du texte par défaut */
}

.company-item:hover {
    background-color: #f4f6f8;
    transform: translateY(-2px); /* Crée un léger effet de "décollement" */
}

.company-item.active {
    background-color: #e6f3ff; /* Un fond plus doux pour l'élément actif */
}

.company-item.active .status-dot {
    background-color: #28a745; /* Vert pour l'entreprise active */
    transform: scale(1);
}

.company-logo {
    width: 40px;
    height: 40px;
    margin-right: 15px;
    border-radius: 8px; /* Carré arrondi pour un look plus moderne */
    object-fit: cover; /* Assure que l'image remplit l'espace sans déformation */
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Ombre légère pour l'image */
}

.company-info {
    flex-grow: 1;
}

.company-name {
    font-weight: 600;
    font-size: 1.1rem;
    color: #333;
    line-height: 1.2;
}

.company-subtitle {
    font-size: 0.9rem;
    color: #777;
}

.status-dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background-color: transparent; /* Invisible par défaut */
    margin-left: 10px;
    transform: scale(0.8);
    transition: background-color 0.3s ease, transform 0.3s ease;
}

.add-company-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 15px 10px 10px;
    border-top: 1px solid #eee;
    margin-top: 10px;
    color: #dc3545;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    transition: color 0.2s ease, transform 0.2s ease;
}

.add-company-btn:hover {
    color: #c82333;
    transform: translateY(-2px);
}

.add-company-btn .icon {
    font-size: 1.5rem;
    margin-right: 8px;
    line-height: 1;
}
</style>


<nav class="main-header navbar navbar-expand navbar-white navbar-light" style="position: fixed; top: 0; left: 0; right: 0; z-index: 1030; background-color: #FFF;">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
         <li class="nav-item" style="margin-left: 10px; margin-right:  10px;">
            <?= $this->Html->image($startupLogo ?? '', [
                'class' => 'img-circle elevation-2',
                'alt' => 'User Image',
                'style' => 'height:35px;width:35px; color: #2F4F4F;'
            ]) ?>
        </li>
        <h5 style="padding-top: 4px;" ><?= h($startupLoginName ?? '') ?></h5>
    </ul>
    <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="/cashBoxes/index">
          <i class="far fa-bell"></i>
          <span class="badge badge-danger navbar-badge"><?= ($notifications) ?? 0 ?></span>
        </a>
       
      </li>
    <li class="nav-item d-flex align-items-center">
        <span style="height: 25px; width: 2px; background-color: #ced4da; margin: 0 10px;"></span>
    </li>
    <li class="nav-item">
          <?php if ($userAuth->role == 'admin') : ?>
                <a href="#" class="btn btn-outline-primary" style="border-radius: 50px; margin-top:7px" data-bs-toggle="modal" data-bs-target="#modalChangeAccount">
                    <i class="nav-icon fas fa-home"></i>
                </a>
            <?php endif; ?>
    </li>
    <li class="nav-item d-flex align-items-center">
        <span style="height: 25px; width: 2px; background-color: #ced4da; margin: 0 10px;"></span>
    </li>
    <!-- <li class="nav-item d-flex align-items-center me-3">
        <span class="badge badge-warnin p-2" style="background-color: #2F4F4F;">
            Il vous reste : <strong class="text-info">6789</strong> SMS
        </span>
    </li> -->
   
    <li class="nav-item">
        <li class="nav-item">
            <?= $this->Html->image($userAuth->profile ?? '', [
                'class' => 'img-circle elevation-2',
                'alt' => 'User Image',
                'style' => 'height:35px;width:35px; color: #2F4F4F;'
            ]) ?>
        </li>
        <li class="nav-item text-dark" style="color: #2F4F4F; margin:10px;">
            <a href="#" class="d-block text-dar" style="color: #2F4F4F;"><?= h($userAuth->name ?? '') ?></a>
        </li>
    </li>
</ul>
</nav>

<div class="modal fade" id="modalChangeAccount" tabindex="-1" aria-labelledby="ModalDetails" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalAdd">Sélectionner une entreprise</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="company-selector-container">
          <?php 
          if (!empty($companies)): 
          ?>
             <?php foreach ($companies as $company): ?>
            <?php
       
            // Build the URL for the link
            $url = $this->Url->build([
                'controller' => 'Companies',
                'action' => 'switch',
                $company->uuid
            ]);
            ?>
            <a href="<?= $url ?>" 
            class="company-item "
            data-uuid="<?= h($company->uuid) ?>">
                <?= $this->Html->image($company->logo ?? '', [
                    'class' => 'company-logo',
                    'alt' => 'User Image',
                    'style' => 'height:35px;width:35px; color: #2F4F4F;'
                ]) ?>
                <div class="company-info">
                    <div class="company-name"><?= h($company->name) ?></div>
                </div>
                <div class="status-dot"></div>
            </a>
        <?php endforeach; ?>
          <?php else: ?>
              <p>Aucune entreprise trouvée.</p>
          <?php endif; ?>
          
          <a href="/startups/add" class="add-company-btn">
              <span class="icon">+</span>
              <span>Ajouter un établissement</span>
          </a>
        </div>
      </div>
    </div>
  </div>
</div>


<script>
    $(document).ready(function() {
    // 1. Listen for a click event on any company item
    $('.company-item').on('click', function(e) {
        // Prevents the browser from navigating to the URL of the link
        e.preventDefault();
        const companyUuid = $(this).data('uuid');
      
        if (!companyUuid) {
            console.error("UUID not found for this item.");
            return;
        }
        $('#modalChangeAccount').modal('hide');
        var data = {
                    'uuid':companyUuid,
                    '_csrfToken': myToken
                };
       $.ajax({
            url: '/updateloginStardtup',
            type: 'POST',
            data: data,
            dataType: 'json',
            success: function(result) {
                if (result.code === 105) {
                    toastr.success(result.msg);
                    setTimeout(function() {
                       window.location.reload();
                    }, 1000);
                } else {
                    toastr.error(result.msg);
                }
            },
            error: function(xhr, status, error) {
                // Gérer les erreurs de la requête AJAX
                toastr.error("Une erreur s'est produite lors de la connexion. Veuillez réessayer.");
            },
            complete: function() {
                // Réactiver le bouton une fois la requête terminée (succès ou échec)
                loginButton.prop('disabled', false).text('Se connecter');
            }
        });
    });
});
</script>
