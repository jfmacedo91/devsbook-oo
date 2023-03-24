<aside class="mt-10">
  <nav>
    <a href="<?= $baseURL; ?>">
      <div class="menu-item <?= $activeMenu == 'home' ? 'active' : '' ?>">
        <div class="menu-item-icon">
          <img src="<?= $baseURL; ?>/assets/images/home-run.svg" width="16" height="16" />
        </div>
        <div class="menu-item-text">Home</div>
      </div>
    </a>
    <a href="<?= $baseURL; ?>/perfil.php">
      <div class="menu-item <?= $activeMenu == 'profile' ? 'active' : '' ?>">
        <div class="menu-item-icon">
          <img src="<?= $baseURL; ?>/assets/images/user.svg" width="16" height="16" />
        </div>
        <div class="menu-item-text">Meu Perfil</div>
      </div>
    </a>
    <a href="<?= $baseURL; ?>/amigos.php?tab=following">
      <div class="menu-item <?= $activeMenu == 'friends' ? 'active' : '' ?>">
        <div class="menu-item-icon">
          <img src="<?= $baseURL; ?>/assets/images/friends.svg" width="16" height="16" />
        </div>
        <div class="menu-item-text">Amigos</div>
      </div>
    </a>
    <a href="<?= $baseURL; ?>/fotos.php">
      <div class="menu-item <?= $activeMenu == 'photos' ? 'active' : '' ?>">
        <div class="menu-item-icon">
          <img src="<?= $baseURL; ?>/assets/images/photo.svg" width="16" height="16" />
        </div>
        <div class="menu-item-text">Fotos</div>
      </div>
    </a>
    <div class="menu-splitter"></div>
    <a href="<?= $baseURL; ?>/config.php">
      <div class="menu-item <?= $activeMenu == 'config' ? 'active' : '' ?>">
        <div class="menu-item-icon">
          <img src="<?= $baseURL; ?>/assets/images/settings.svg" width="16" height="16" />
        </div>
        <div class="menu-item-text">Configurações</div>
      </div>
    </a>
    <a href="<?= $baseURL; ?>/logout.php">
      <div class="menu-item">
        <div class="menu-item-icon">
          <img src="<?= $baseURL; ?>/assets/images/power.svg" width="16" height="16" />
        </div>
        <div class="menu-item-text">Sair</div>
      </div>
    </a>
  </nav>
</aside>