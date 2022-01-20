<nav class="navbar navbar-expand-lg sticky-top navbar-dark bg-primary">
    <div class="container-fluid">

        <div class="d-flex flex-grow-1">

            <a id="menu-toggle" href="#" class="navbar-brand">
                <img src="<?= asset_url(); ?>img/logo-emprendedores.png" class="d-none d-sm-block" width="175px">
                <img src="<?= base_url('assets/img/isotipo.png'); ?>" class="d-block d-sm-none animated infinite pulse delay-2s" width="46px">
                <img class="bandera d-none d-sm-block" src="<?= base_url('assets/img/banderas/' . $this->session->userdata('ciudad')['bandera']); ?>">
            </a>

            <?php if (!is_null($this->session->userdata('ciudad'))) { ?>
                <?php // Atributos para agregar al formulario
                $attributes = array('id' => 'form_buscar_md', 'method' => 'get', 'class' => 'mr-2 my-auto w-100 d-inline-block order-2');
                // Pintar formulario
                echo form_open($this->session->userdata('pais')['ISO'] . '/buscar', $attributes); ?>
                <div class="input-group">
                    <input type="text" name="q" class="form-control border border-right-0" placeholder="Estoy buscando...">
                    <span class="input-group-append">
                        <button class="btn btn-outline-light border border-left-0" type="submit">
                            <i class="fa fa-search"></i>
                        </button>
                    </span>
                </div>
                <?= form_close(); ?>
                <script>
                    $("#form_buscar_md").validate({
                        rules: {
                            q: {
                                required: true,
                                rangelength: [3, 200]
                            }
                        },
                        messages: {
                            q: {
                                required: "Ingrese un termino de busqueda",
                                rangelength: jQuery.validator.format("El nombre debe estar entre {0} y {1} caracteres"),
                            }
                        },
                        validClass: "is-valid",
                        errorClass: "is-invalid",
                        errorPlacement: function(error, element) {},
                        submitHandler: function(form) {
                            form.submit();
                        }
                    });
                </script>
            <?php  } ?>

            <div class="mr-2 my-auto order-2">
                <button id="navbar-toggler" class="navbar-toggler" type="button">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>

        </div>

        <div class="collapse navbar-collapse flex-shrink-1 flex-grow-0 order-last" id="navbarSupportedContent">

            <ul class="navbar-nav mt-2 mt-lg-0 mx-2 ml-auto">
                <li class="nav-item">
                    <a href="#" class="nav-link" data-toggle="modal" data-target="#modalCiudad">
                        <i class="fas fa-map-marker-alt"></i>&nbsp; <?= $this->session->userdata('ciudad')['nombre'] ?>
                    </a>
                </li>
                <li class="nav-item active">
                    <a href="<?= site_url($this->session->userdata('pais')['ISO'] . '/carrito') ?>" id="btn-carrito" class="nav-link btn btn-danger"><i class="fas fa-shopping-cart"></i>&nbsp;(<span id="contador" count="<?= contar() ?>" class="badge"><?= contar() ?></span>)</a>
                </li>
            </ul>

        </div>
    </div>
</nav>