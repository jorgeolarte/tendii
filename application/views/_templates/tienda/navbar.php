  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
      <div class="container">
          <div class="d-flex flex-grow-1">
              <a href="<?= base_url() ?>" class="navbar-brand">
                  <img src="<?= asset_url(); ?>img/logo-emprendedores.png" class="d-none d-sm-block" width="175px">
                  <img src="<?= base_url('assets/img/isotipo.png'); ?>" class="d-block d-sm-none" width="46px">
                  <img class="bandera d-none d-sm-block" src="<?= base_url('assets/img/banderas/' . $this->session->userdata('ciudad')['bandera']); ?>">
              </a>
              <?php
                // Atributos para agregar al formulario
                $attributes = array('method' => 'get', 'class' => 'mr-2 my-auto w-100 d-inline-block order-1');
                // Pintar formulario
                echo form_open($this->session->userdata('ciudad') . '/buscar', $attributes); ?>
              <div class="input-group">
                  <input type="text" name="q" class="form-control border border-right-0" placeholder="Buscar...">
                  <span class="input-group-append">
                      <button class="btn btn-outline-light border border-left-0" type="submit">
                          <i class="fa fa-search"></i>
                      </button>
                  </span>
                  <?php if (is_logged_in()) { ?>
                      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarEmprendedor" aria-controls="navbarEmprendedor" aria-expanded="false" aria-label="Toggle navigation">
                          <span class="navbar-toggler-icon"></span>
                      </button>
                  <?php } ?>
              </div>

              <?= form_close(); ?>
          </div>

          <div class=" collapse navbar-collapse flex-shrink-1 flex-grow-0 order-last" id="navbarEmprendedor">
              <ul class="d-block d-sm-none navbar-nav ml-auto px-2">
                  <?php if (is_logged_in()) { ?>
                      <li class="nav-item">
                          <a class="nav-link " href="<?= site_url('admin/nuevo_producto') ?>"><i class="fas fa-plus"></i>&nbsp; Nuevo producto</a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link " href="<?= site_url('cerrar_sesion') ?>"><i class="fas fa-sign-in-alt"></i>&nbsp; Cerrar sesión</a>
                      </li>
                  <?php } ?>
              </ul>
          </div>

          <div class="collapse navbar-collapse flex-shrink-1 flex-grow-0 order-last" id="navbarSupportedContent">
              <ul class="navbar-nav ml-auto px-2">
                  <li class="nav-item">
                      <a class="nav-link" href="<?= site_url($this->session->userdata('ciudad')) ?>"><i class="fas fa-store-alt"></i>&nbsp; Tienda</a>
                  </li>
                  <?php if (count(get_categorias()) > 0) { ?>
                      <li class="nav-item dropdown">
                          <a class="nav-link dropdown-toggle" href="#" id="dropdownCategorias" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <i class="far fa-folder-open"></i>&nbsp; Categorias
                          </a>
                          <div class="dropdown-menu" aria-labelledby="dropdownCategorias">
                              <?php foreach (get_categorias() as $categoria) { ?>
                                  <a class="dropdown-item" href="<?= site_url($this->session->userdata('ciudad') . '/categoria/' . $categoria['slug']) ?>"><?= $categoria['icon'] ?>&nbsp; <?= $categoria['nombre'] ?></a>
                              <?php } ?>
                          </div>
                      </li>
                  <?php } ?>
                  <?php if (is_logged_in()) { ?>
                      <li class="nav-item dropdown">
                          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <i class="fas fa-user-circle"></i>&nbsp; Perfil
                          </a>
                          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                              <?php if (is_null($this->session->userdata('slug'))) { ?>
                                  <a class="dropdown-item" href="<?= site_url('admin') ?>"><i class="far fa-id-card"></i>&nbsp; Administración</a>
                              <?php } else { ?>
                                  <a class="dropdown-item" href="<?= site_url($this->session->userdata('slug')) ?>"><i class="far fa-id-card"></i>&nbsp; Mi página</a>
                              <?php } ?>
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
              <form class="my-1 form-inline text-light">
                  <a id="btn-carrito" class="btn btn-lg btn-danger" href="<?= site_url('carrito') ?>">
                      <i class="fas fa-shopping-cart"></i>&nbsp;(<span id="contador" count="<?= contar() ?>" class="badge"><?= contar() ?></span>)
                  </a>
              </form>
          </div>
      </div>
  </nav>

  <!-- The overlay -->
  <div id="myNav" class="overlay">

      <!-- Button to close the overlay navigation -->
      <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>

      <!-- Overlay content -->
      <div class="overlay-content">
          <a href="<?= site_url($this->session->userdata('ciudad')) ?>">Todos</a>
          <?php foreach (get_categorias() as $categoria) { ?>
              <a href="<?= site_url($this->session->userdata('ciudad') . '/categoria/' . $categoria['slug']) ?>"><?= $categoria['icon'] ?>&nbsp; <?= $categoria['nombre'] ?></a>
          <?php } ?>
      </div>

  </div>

  <script>
      /* Open when someone clicks on the span element */
      function openNav() {
          document.getElementById("myNav").style.width = "100%";
      }

      /* Close when someone clicks on the "x" symbol inside the overlay */
      function closeNav() {
          document.getElementById("myNav").style.width = "0%";
      }
  </script>

  <div class="bg-primary fixed-bottom d-block d-sm-none">
      <div class="icon-bar">
          <a class="active" href="<?= site_url($this->session->userdata('ciudad')) ?>"><i class="fas fa-home"></i>
              <img class="bandera-sm d-block d-sm-none" src="<?= base_url('assets/img/banderas/' . $this->session->userdata('ciudad')['bandera']); ?>">
          </a>
          <a href="#" onclick="openNav()"><i class="far fa-folder-open"></i></a>
          <a class="bg-danger" href="<?= site_url('carrito') ?>"><i class="fas fa-shopping-cart"></i></a>
          <a href="<?= site_url() ?>"><i class="fas fa-map-marked-alt"></i></a>
          <?php if (is_logged_in()) { ?>
              <?php if (is_null($this->session->userdata('slug'))) { ?>
                  <a href="<?= site_url('admin') ?>">
                      <img class="rounded-circle bg-white" src="<?= image(site_url('assets/tienda/' . $this->session->userdata('logo')), 'navbar'); ?>" alt="<?= $this->session->userdata('Emprendimiento'); ?>">
                  </a>
              <?php } else { ?>
                  <a href="<?= site_url($this->session->userdata('slug')) ?>">
                      <img class="rounded-circle bg-white" src="<?= image(site_url('assets/tienda/' . $this->session->userdata('logo')), 'navbar'); ?>" alt="<?= $this->session->userdata('Emprendimiento'); ?>">
                  </a>
              <?php } ?>
          <?php } else { ?>
              <a href="<?= site_url('login') ?>">
                  <i class="fas fa-user-circle"></i>
              </a>
          <?php } ?>
      </div>
  </div>