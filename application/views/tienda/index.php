<?php
// Carga el encabezado de la página
$this->load->view('tienda/template/header');
?>


<div class="d-flex" id="wrapper">

    <?php $this->load->view('tienda/template/sidebar'); ?>

    <!-- Page Content -->
    <div id="page-content-wrapper">

        <?php $this->load->view('tienda/template/navbar'); ?>

        <?php $this->load->view('genericos/slider'); ?>

        <!-- Menu categoria -->
        <?php $this->load->view('genericos/categorias') ?>

        <?php if (count($categorias) == 0) { ?>
            <div class="container-fluid">
                <div class="row justify-content-md-center">
                    <div class="col-md-8 py-4">
                        <!-- No tienes pedidos -->
                        <div class="alert alert-danger text-center" role="alert">
                            <h4 class="alert-heading">OMG! 🙈</h4>
                            <p>Aún no tenemos productos en la tienda.</p>
                            <img src="https://media.giphy.com/media/sR2YaENch4sog/giphy.gif">
                            <hr>
                            <p class="mb-1 font-weight-bold">¿Eres emprendedor y puedes ofrecerlos?.</p>
                            <a href="<?= site_url('crear-tienda-online') ?>" class="btn btn-lg btn-primary animated flash slow delay-2s">Oprime aquí para empezar a vender</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php } else { ?>
            <?php $impression = array() ?>
            <?php $viewcontent = array() ?>
            <?php foreach ($categorias as $key => $categoria) { ?>
                <script>
                    $(document).ready(function() {
                        $('#<?= $categoria['slug'] ?>').flexslider({
                            animation: "slide",
                            animationLoop: true,
                            controlNav: "thumbnails",
                            itemWidth: 375,
                            itemMargin: 5,
                            minItems: 1.2,
                            maxItems: 5
                        });
                    });
                </script>

                <?php if (count($categoria['productos']) > -10) { ?>

                    <div class="container-fluid py-4">
                        <div class="d-flex pb-2">
                            <h1 class="h3 font-weight-bold">
                                <a href="<?= site_url("{$this->session->userdata('pais')['ISO']}/{$categoria['slug']}") ?>" class="text-decoration-none"><?= $categoria['nombre'] ?></a>
                            </h1>
                            <div class="ml-auto">
                                <a href="<?= site_url("{$this->session->userdata('pais')['ISO']}/{$categoria['slug']}") ?>" class="btn btn-outline-info"><?= $categoria['icon'] ?> Ver más</a>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <!-- Place somewhere in the <body> of your page -->
                                <div id="<?= $categoria['slug'] ?>" class="flexslider carousel">
                                    <ul class="slides">
                                        <?php foreach ($categoria['productos'] as $pos => $producto) { ?>
                                            <?php
                                            // Array tag manager
                                            array_push($impression, array(
                                                'name' => ucwords(mb_strtolower($producto['producto'])), // Name or ID is required.
                                                'id' => $producto['id_producto'],
                                                'price' => $producto['precio'],
                                                'brand' => ucwords(mb_strtolower($producto['emprendimiento'])),
                                                'category' => $producto['categoria'],
                                                //'list': 'Search Results',
                                                'position' => $pos + 1
                                            ));
                                            // Pixel
                                            array_push($viewcontent, array(
                                                'content_name' =>  ucwords(mb_strtolower($producto['producto'])),
                                                'content_category' => $producto['categoria'],
                                                'content_ids' => $producto['id_producto'],
                                                'content_type' => 'product',
                                                'value' => $producto['precio'],
                                                'currency' => 'COP'
                                            ));
                                            ?>
                                            <li>
                                                <div class="card">
                                                    <img src="<?= image(base_url('assets/tienda/' . $producto['imagen']), 'index') ?>" class="card-img-top" alt="<?= $producto['producto'] ?> - <?= $producto['emprendimiento'] ?>">
                                                    <div class="card-body">
                                                        <div class="media">
                                                            <div class="media-body">
                                                                <h5 class="mb-1 font-weight-bold"><?= ucwords(mb_strtolower($producto['producto'])) ?></h5>
                                                            </div>
                                                        </div>
                                                        <?php
                                                        // Mensajes de error
                                                        echo validation_errors();
                                                        // Atributos para agregar al formulario
                                                        $attributes = array('class' => 'justify-content-end mb-0', 'id' => 'form_agregar_producto');
                                                        // Campos ocultos a enviar en el formulario
                                                        $hidden = array(
                                                            'back_url' => current_url(),
                                                            'id_producto' => $producto['id_producto'],
                                                            'precio' => $producto['precio'],
                                                            'id_emprendedor' => $producto['id_emprendedor'],
                                                            'cantidad' => 1
                                                        );
                                                        // Pintar formulario
                                                        echo form_open($this->session->userdata('pais')['ISO'] . '/carrito/agregar', $attributes, $hidden); ?>
                                                        <div class="form-row mt-1">
                                                            <div class="col">
                                                                <label class="font-weight-bold text-primary">$ <?= number_format($producto['precio'], $this->session->userdata('pais')['decimales']); ?></span> <i class="fas fa-tag"></i></label>
                                                            </div>
                                                            <div class="col">
                                                                <button type="submit" class="btn btn-block btn-primary"><i class="fas fa-shopping-cart"></i>&nbsp;Agregar</button>
                                                            </div>
                                                        </div>
                                                        <?= form_close(); ?>

                                                    </div>
                                                </div>
                                            </li>
                                        <?php } ?>
                                        <!-- items mirrored twice, total of 12 -->
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php } ?>
            <?php } ?>

            <script>
                dataLayer.push({
                    'ecommerce': {
                        'currencyCode': 'COP', // Local currency is optional.
                        'impressions': <?= json_encode($impression) ?>
                    }
                });
                fbq('track', 'ViewContent', <?= json_encode($viewcontent) ?>);
            </script>

            <div class="container-fluid py-4">
                <div class="d-flex pb-2">
                    <h1 class="h3 font-weight-bold">
                        <a href="<?= site_url("{$this->session->userdata('pais')['ISO']}/explorar/") ?>" class="text-decoration-none">Tiendas destacadas</a>
                    </h1>
                    <div class="ml-auto">
                        <a href="<?= site_url("{$this->session->userdata('pais')['ISO']}/explorar/") ?>" class="btn btn-info"><i class="fas fa-store"></i>&nbsp; Todas las tiendas</a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <!-- Place somewhere in the <body> of your page -->
                        <div id="tienda" class="flexslider carousel">
                            <ul class="slides">
                                <!-- array_slice($tiendas, 0, 5) -->
                                <?php foreach (array_slice($tiendas, 0, 10) as $pos => $tienda) { ?>
                                    <li>
                                        <div class="card text-center">
                                            <img class="p-3 mx-auto rounded-circle" src="<?= image(base_url('assets/tienda/' . $tienda['logo']), 'perfil') ?>">
                                            <div class="card-body">
                                                <h5 class="card-title font-weight-bold text-truncate"><?= ucwords(mb_strtolower($tienda['emprendimiento'])) ?></h5>
                                                <a href="<?= site_url($tienda['slug']) ?>" class="btn btn-outline-success"><i class="fas fa-store"></i>&nbsp; Ver tienda</a>
                                            </div>
                                        </div>
                                    </li>
                                <?php } ?>
                                <!-- items mirrored twice, total of 12 -->
                            </ul>
                        </div>
                    </div>

                    <script>
                        $(document).ready(function() {
                            $('#tienda').flexslider({
                                animation: "slide",
                                animationLoop: true,
                                controlNav: "thumbnails",
                                itemWidth: 210,
                                itemMargin: 5,
                                minItems: 2,
                                maxItems: 5
                            });
                        });
                    </script>

                </div>
            </div>
        <?php } ?>

        <?php $this->load->view('tienda/template/footer'); ?>
    </div>



</div>
<!-- /#page-content-wrapper -->

<?php
// Carga el encabezado de la página

$this->load->view('tienda/template/end');
?>