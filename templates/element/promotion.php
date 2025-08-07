<nav class="navbar navbar-expand-lg navbar-custom">
    <div class="container">
        <a class="navbar-brand" href="#"><span style="color: rgb(187, 154, 7) !important;;">PS GROUP</span></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/"> <?= __('Accueil') ?></a>
                </li>
                <li class="nav-item">
                    <?php if (!empty($user)): ?>
                        <a class="nav-link" href="/users/dashboard">  <?= __('Tableau de bord') ?></a>
                    <?php endif; ?>
                </li>
                <li class="nav-item">
                    <?php if (empty($user)): ?>
                        <a class="nav-link" href="/users/login">  <?= __('Connexion') ?></a>
                    <?php endif; ?>
                </li>
                <li class="nav-item">
                    <?php if (!empty($user)): ?>
                        <a class="nav-link" href="/users/logout">  <?= __('Deconnexion') ?></a>
                    <?php endif; ?>
                </li>
            </ul>
        </div>
    </div>
</nav>

