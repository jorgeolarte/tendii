  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
      <div class="container">
          <a class="navbar-brand" href="<?= base_url() ?>">
              <img src="<?= asset_url(); ?>img/logo-emprendedores.png" width="175px">
          </a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav ml-auto px-2">
                  <!-- <li class="nav-item">
                      <a class="nav-link" href="<?= site_url() ?>"><i class="fas fa-home"></i>&nbsp; Inicio</a>
                  </li> -->
                  <li class="nav-item">
                      <a class="nav-link" href="<?= site_url($this->session->userdata('ciudad')) ?>"><i class="fas fa-store-alt"></i>&nbsp; Tienda</a>
                  </li>
                  <?php if (is_logged_in()) { ?>
                      <li class="nav-item dropdown">
                          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <i class="fas fa-walking"></i>&nbsp; Zona Emprendedor
                          </a>
                          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                              <a class="dropdown-item" href="<?= site_url('admin') ?>"><i class="fas fa-tachometer-alt"></i>&nbsp; Admin</a>
                              <a class="dropdown-item" href="<?= site_url('admin/nuevo_producto') ?>"><i class="fas fa-plus"></i>&nbsp; Nuevo producto</a>
                              <div class="dropdown-divider"></div>
                              <a class="dropdown-item" href="<?= site_url('cerrar_sesion') ?>"><i class="fas fa-sign-in-alt"></i>&nbsp; Cerrar sesión</a>
                          </div>
                      </li>
                  <?php } else { ?>
                      <li class="nav-item">
                          <a class="nav-link " href="<?= site_url('login') ?>"><i class="fas fa-sign-in-alt"></i>&nbsp; Iniciar sesión</a>
                      </li>
                  <?php } ?>
              </ul>
          </div>
      </div>
  </nav>