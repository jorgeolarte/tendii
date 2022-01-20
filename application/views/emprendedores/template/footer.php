<!-- Footer -->
<footer class="pt-md-0 pt-2 pb-3">
    <div class="container-fluid">
        <div class="d-none d-sm-block">


            <div class="row">
                <div class="col-12">
                    <hr>
                </div>
            </div>
            <div class="row small">
                <div class="col-md-3">
                    <h6>Información</h6>
                    <ul class="list-unstyled">
                        <li class="pt-1"><a href="<?= site_url('') ?>" class="text-decoration-none"><i class="fas fa-home"></i>&nbsp; Inicio</a></li>
                        <li class="pt-1"><a href="<?= site_url('login') ?>" class="text-decoration-none"><i class="fas fa-sign-in-alt"></i>&nbsp; Iniciar sesión</li>
                        <li class="pt-1"><a href="<?= site_url('/crear-tienda-online') ?>" class="text-decoration-none"><i class="fa fa-user fa-fw" class="text-decoration-none"></i>&nbsp;Crea tu tienda</a></li>
                        <li class="pt-1"><a href="<?= site_url("{$this->session->userdata('pais')['ISO']}/explorar") ?>" class="text-decoration-none"><i class="far fa-compass"></i>&nbsp; Explorar</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h6>Paises</h6>
                    <ul class="list-unstyled">
                        <li class="pt-1">
                            <a href="<?= site_url('CO/pais') ?>" class="text-decoration-none"><img src="<?= base_url('assets/img/banderas/colombia.png') ?>">&nbsp; Colombia</a>
                        </li>
                        <li class="pt-1">
                            <a href="<?= site_url('SV/pais') ?>" class="text-decoration-none"><img src="<?= base_url('assets/img/banderas/el-salvador.png') ?>">&nbsp; El Salvador</a>
                        </li>
                    </ul>
                    <h6>Cambiar ciudad</h6>
                    <ul class="list-unstyled">
                        <li class="pt-1">
                            <a href="#" class="text-decoration-none" data-toggle="modal" data-target="#modalCiudad">
                                <i class="fas fa-map-marker-alt"></i>&nbsp; <?= $this->session->userdata('ciudad')['nombre'] ?>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <?php if (count(get_categorias_aleatorias()) == 0) { ?>
                        <h6>Encuentranos</h6>
                        <ul class="list-unstyled">
                            <li class="pt-1"><a href="https://facebook.com/Tienda-Emprendedores-104224501268363/" target="_blank" class="text-decoration-none">Facebook</a></li>
                            <li class="pt-1"><a href="https://instagram.com/tienda.emprendedores" target="_blank" class="text-decoration-none">Instagram</a></li>
                            <li class="pt-1"><a href="https://linkedin.com/company/emprendedorescartago" target="_blank" class="text-decoration-none">Linkedin</a></li>
                        </ul>
                    <?php } else { ?>
                        <h6>En tu ciudad</h6>
                        <ul class="list-unstyled">
                            <?php foreach (get_categorias_aleatorias() as $categoria) { ?>
                                <li class="pt-1"><a href="<?= site_url("{$this->session->userdata('pais')['ISO']}/{$categoria['slug']}") ?>" class="text-decoration-none"><?= $categoria['icon'] ?>&nbsp; <?= $categoria['nombre'] ?></a></li>
                            <?php } ?>
                        </ul>
                    <?php }  ?>

                </div>
                <div class="col-md-3">
                    <img src="<?= base_url('assets/img/logo-emprendedores-verde.png') ?>" alt="Emprendedores Cartago" class="w-75">
                    <address class="py-2">
                        <strong>Tienda Emprendedores</strong><br>
                        Calle 14 Nro 2-18 <br>
                        Cartago, Valle del Cauca<br>
                        <abbr title="Telefono">T:</abbr> (313) 636 5886
                    </address>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-center small">
                <p class="mb-0">© 2018-<?= date("yy") ?> Tienda Emprendedores.<br>Hecho con <i class="fa fa-fw fa-heart d-inline text-danger"></i> por ProbetaLab.</p>
            </div>
        </div>
    </div>
</footer>