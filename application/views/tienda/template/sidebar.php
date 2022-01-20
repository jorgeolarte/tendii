<!-- Sidebar -->
<div class="align-items-start bg-light border-right" id="sidebar-wrapper">
    <?php $class = (!$this->agent->is_mobile()) ? "sticky-top" : ""; ?>
    <div id="insidebar" class="<?= $class ?>" style="min-height: 100vh">

        <div class="">
            <div class="sidebar-heading bd-highlight">Menú</div>

            <?php if (!is_null($this->session->userdata('ciudad'))) { ?>
                <?php if (get_validar_ciudad()) { ?>
                    <div class="list-group list-group-flush">
                        <a href="<?= site_url($this->session->userdata('pais')['ISO']) ?>" class="list-group-item list-group-item-action bg-light"><img width="12px" src="<?= base_url('assets/img/banderas/' . $this->session->userdata('ciudad')['bandera']) ?>">&nbsp; <?= $this->session->userdata('ciudad')['nombre'] ?></a>
                    </div>
                <?php } ?>
            <?php } ?>

            <?php if (is_logged_in()) { ?>
                <?php $url = (is_null($this->session->userdata('emprendedor')['slug'])) ? 'admin/tienda/nueva' : $this->session->userdata('emprendedor')['slug']; ?>
                <div class="list-group list-group-flush">
                    <a href="<?= site_url($url) ?>" class="list-group-item list-group-item-action bg-light"><i class="fas fa-user-circle"></i>&nbsp; Mi perfil</a>
                </div>
            <?php } ?>

            <?php if (contar() > 0) { ?>
                <div class="list-group list-group-flush">
                    <a href="<?= site_url($this->session->userdata('pais')['ISO'] . '/carrito') ?>" class="list-group-item list-group-item-action bg-light text-danger animated flash slow delay-2s"><i class="fas fa-shopping-cart"></i>&nbsp; Mi carrito <span class="small align-top badge badge-danger"><?= contar() ?></span></a>
                </div>
            <?php } else { ?>
                <div class="list-group list-group-flush">
                    <a href="#" disabled tabindex="-1" aria-disabled="true" class="list-group-item list-group-item-action disabled"><i class="fas fa-shopping-cart"></i>&nbsp; Mi carrito</a>
                </div>
            <?php } ?>

            <?php if (!is_null($this->session->userdata('ciudad'))) { ?>
                <?php if (get_validar_ciudad()) { ?>
                    <div class="list-group list-group-flush">
                        <a href="<?= site_url("{$this->session->userdata('pais')['ISO']}/explorar") ?>" class="list-group-item list-group-item-action bg-light"><i class="far fa-compass"></i>&nbsp; Explorar</a>
                    </div>
                <?php } ?>
            <?php } ?>

            <div class="list-group list-group-flush">
                <div class="btn-group dropright">
                    <button type="button" class="list-group-item list-group-item-action bg-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-globe-americas"></i>&nbsp; Cambiar de país
                    </button>

                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <a class="dropdown-item" href="<?= site_url('CO/pais') ?>"><img src="<?= base_url('assets/img/banderas/colombia.png') ?>">&nbsp; Colombia</a>
                        <a class="dropdown-item" href="<?= site_url('SV/pais') ?>"><img src="<?= base_url('assets/img/banderas/el-salvador.png') ?>">&nbsp; El Salvador</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" id="cambiarCiudad" href="#" data-toggle="modal" data-target="#modalCiudad"><i class="fas fa-map-marker-alt"></i>&nbsp; Cambiar ciudad</a>
                    </div>
                </div>
            </div>

            <div class="list-group list-group-flush">
                <a href="<?= site_url('feria-virtual') ?>" class="list-group-item list-group-item-action bg-info text-white"><span class="animated flash delay-2s"><i class="fas fa-hands-helping"></i>&nbsp; Feria Virtual SENA</span></a>
            </div>

            <?php if (get_validar_ciudad()) { ?>
                <?php if (count(get_categorias()) > 0) { ?>
                    <div class="list-group list-group-flush">
                        <a class="list-group-item list-group-item-action bg-light" data-toggle="collapse" href="#collapseCategorias" role="button" aria-expanded="false" aria-controls="collapseCategorias"><i class="far fa-bookmark"></i>&nbsp; Categorias</a>
                    </div>

                    <div class="collapse" id="collapseCategorias">
                        <?php foreach (get_categorias() as $categoria) { ?>
                            <div class="list-group list-group-flush">
                                <a href="<?= site_url("{$this->session->userdata('pais')['ISO']}/{$categoria['slug']}") ?>" class="list-group-item list-group-item-action bg-light"><?= $categoria['icon'] ?>&nbsp; <?= $categoria['nombre'] ?></a>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>

        <?php if (!is_logged_in()) { ?>
            <div class="">
                <div class="sidebar-heading bd-highlight">¿Emprendedor?</div>
                <div class="list-group list-group-flush">
                    <a href="<?= site_url('crear-tienda-online') ?>" class="list-group-item list-group-item-action bg-light"><i class="fas fa-store"></i>&nbsp; Crea tu tienda</a>
                    <a href="<?= site_url('login') ?>" class="list-group-item list-group-item-action bg-light"><i class="fas fa-sign-in-alt"></i>&nbsp; Iniciar sesión</a>
                </div>
            </div>
        <?php } ?>


    </div>
</div>
<!-- /#sidebar-wrapper -->