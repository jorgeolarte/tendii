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

        <div class="container-fluid">
            <?php if (count($productos) == 0) { ?>
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
            <?php } else { ?>
                <?php if (isset($categoria)) { ?>
                    <h1 class="h2 mt-4"><small><?= $categoria['icon'] ?></small> <?= $categoria['nombre'] ?></h1>
                <?php } else { ?>
                    <h1 class="h2 mt-4"><?= $title ?></h1>
                    <p>Encontramos <mark><?= ucfirst($termino) ?></mark> en nuestra tienda</p>
                <?php } ?>
                <div class="row">
                    <div class="col-12">
                        <div class="<?= ($this->agent->is_mobile()) ? 'd-flex flex-column' : 'card-columns' ?>">
                            <?php $impression = array() ?>
                            <?php $viewcontent = array() ?>
                            <?php foreach ($productos as $pos => $producto) { ?>
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

                                <?php $data['producto'] = $producto; /* Asigna variable para pasar */?>

                                <?php if ($this->agent->is_mobile()) { ?>
                                    <!-- Vista celular -->
                                    <?php $this->load->view('tienda/template/producto-sm', $data); ?>
                                <?php } else { ?>
                                    <!-- Vista otro tamaño -->
                                    <?php $this->load->view('tienda/template/producto-md', $data); ?>
                                <?php } ?>

                            <?php } ?>
                        </div>

                        <script>
                            dataLayer.push({
                                'ecommerce': {
                                    'currencyCode': 'COP', // Local currency is optional.
                                    'impressions': <?= json_encode($impression) ?>
                                }
                            });
                            fbq('track', 'ViewContent', <?= json_encode($viewcontent) ?>);
                        </script>
                    </div>
                </div>
                <div class="row pt-4">
                    <div class="col-12">
                        <nav aria-label="Page navigation example">
                            <?= $pagination ?>
                        </nav>
                    </div>
                </div>
        </div>
    <?php } ?>

    <?php $this->load->view('tienda/template/footer'); ?>
    </div>
</div>
<!-- /#page-content-wrapper -->

</div>
<!-- /#wrapper -->

<?php
// Carga el encabezado de la página

$this->load->view('tienda/template/end');
?>