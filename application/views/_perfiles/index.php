<?php
// Carga el encabezado de la página
$this->load->view('templates/tienda/header');
// Carga el menu superior de la pagina
$this->load->view('templates/tienda/navbar');
// Carga el menu superior de la pagina
$this->load->view('perfiles/top.php');
?>

<section id="productos" class="container py-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card-columns">
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
                    <div class="card">
                        <div class="inner">
                            <img src="<?= image(base_url('assets/tienda/' . $producto['imagen']), 'large') ?>" class="card-img-top" alt="<?= $producto['producto'] ?> - <?= $producto['emprendimiento'] ?>">
                        </div>
                        <div class="card-body">
                            <div class="media">
                                <img class="align-self-center mr-3 rounded-circle w-25" src="<?= image(base_url('assets/tienda/' . $producto['logo']), "square") ?>" alt="<?= $producto['emprendimiento'] ?>">
                                <div class="media-body">
                                    <h5 class="mb-0"><?= ucwords(mb_strtolower($producto['producto'])) ?></h5>
                                    <p class="mb-0"><?= ucwords(mb_strtolower($producto['emprendimiento'])) ?></p>
                                    <p class="mb-0 small"><?= $producto['icon'] ?>&nbsp; <?= $producto['categoria'] ?></p>
                                </div>
                            </div>
                            <p class="card-text pt-2"><?= ucfirst(mb_strtolower($producto['descripcion'])) ?></p>
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
                            echo form_open('carrito/agregar', $attributes, $hidden); ?>
                            <div class="form-row">
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
            </div>
        </div>
    </div>
</section>

<?php
// Carga los pie de página
$this->load->view('templates/main/followus');
$this->load->view('templates/tienda/footer');
?>