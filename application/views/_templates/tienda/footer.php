<!-- Footer -->
<footer class="pt-4 pb-2 border-top d-none d-sm-block">
    <div class="container">
        <div class="row small">

            <div class="col-md-3">
                <h6>Información</h6>
                <ul class="list-unstyled">
                    <li class="pt-1"><a href="<?= site_url('') ?>"><i class="fas fa-home"></i>&nbsp; Inicio</a></li>
                    <li class="pt-1"><a href="<?= site_url($this->session->userdata('ciudad')) ?>"><i class="fas fa-store-alt"></i>&nbsp; Tienda</a></li>
                    <li class="pt-1"><a href="<?= site_url('login') ?>"><i class="fas fa-sign-in-alt"></i>&nbsp; Iniciar sesión</li>
                    <li class="pt-1"><a href="<?= site_url('/crear-tienda-online') ?>"><i class="fa fa-user fa-fw"></i>&nbsp; Regístrate</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <h6>Ciudades</h6>
                <ul class="list-unstyled">
                    <?php foreach (array_slice(get_ciudades_activas(),0,5) as $ciudad) { ?>
                        <li class="pt-1">
                            <a href="<?= site_url($ciudad['slug']) ?>"><?= $ciudad['nombre'] ?></a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
            <div class="col-md-3">
                <?php if (count(get_categorias()) == 0) { ?>
                    <h6>Encuentranos</h6>
                    <ul class="list-unstyled">
                        <li class="pt-1"><a href="https://facebook.com/Tienda-Emprendedores-104224501268363/" target="_blank">Facebook</a></li>
                        <li class="pt-1"><a href="https://instagram.com/tienda.emprendedores" target="_blank">Instagram</a></li>
                        <li class="pt-1"><a href="https://linkedin.com/company/emprendedorescartago" target="_blank">Linkedin</a></li>
                    </ul>
                <?php } else { ?>
                    <h6>En tu ciudad</h6>
                    <ul class="list-unstyled">
                        <?php foreach(get_categorias() as $categoria) { ?>
                            <li class="pt-1"><a href="<?= site_url($this->session->userdata('ciudad') . '/categoria/' . $categoria['slug']) ?>"><?= $categoria['icon'] ?>&nbsp; <?= $categoria['nombre'] ?></a></li>
                        <?php } ?>
                    </ul>
                <?php }  ?>

            </div>
            <div class="col-md-3">
                <img src="<?= base_url('assets/img/logo-emprendedores-verde.png') ?>" alt="Emprendedores Cartago" class="w-75">
                <address class="py-2">
                    <strong>Emprendedores Cartago</strong><br>
                    Calle 14 Nro 2-18 <br>
                    Cartago, Valle del Cauca<br>
                    <abbr title="Telefono">T:</abbr> (313) 636 5886
                </address>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-center small">
                <p class="mb-0">© 2018-<?= date("yy") ?> Emprendedores Cartago.<br>Hecho con <i class="fa fa-fw fa-heart d-inline text-danger"></i> por ProbetaLab.</p>
            </div>
        </div>
    </div>
</footer>

<div id="WAButton"></div>

<!-- <script src="<?= asset_url(); ?>js/jquery-3.4.0.min.js"></script> -->
<script src="<?= asset_url(); ?>js/popper.min.js"></script>
<script src="<?= asset_url(); ?>js/bootstrap.min.js"></script>

<!--Floating WhatsApp javascript
<script src="<?= asset_url(); ?>js/floating-wpp.min.js"></script>-->

<!--Guiar usuario
<script src="<?= base_url('assets/js/intro.min.js'); ?>"></script>-->

<!--Mascara de telefono y numero-->
<script src="<?= asset_url(); ?>js/jquery.mask.js"></script>
<script src="<?= asset_url(); ?>js/jquery.filer.min.js"></script>
<script src="<?= asset_url(); ?>js/tienda.js"></script>

<script>
//introJs().setOption('showProgress', true).start();
</script>