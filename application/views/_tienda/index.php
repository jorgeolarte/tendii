<?php
// Carga el encabezado de la página
$this->load->view('templates/tienda/header');
// Carga el menu superior de la pagina
$this->load->view('templates/tienda/navbar');
?>

<?php
// Hay productos para mostrar
if (count($productos) > 0) {
    // Carga el slider
    $this->load->view('tienda/slider');
    // Encabezado página
    $this->load->view('templates/title');
}
?>

<?php if (count($categorias) > 0) { ?>
    <div id="categorias" class="bg-white border-top border-bottom border-light">
        <section class="container">
            <div class="row">
                <div class="col-md-12">

                    <ul class="navbuttons nav nav-fill mb-0">
                        <li class="nav-item">
                            <a class="nav-link active" href="<?= site_url($this->session->userdata('ciudad')) ?>">Todos</a>
                        </li>
                        <?php foreach ($categorias as $categoria) { ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= site_url($this->session->userdata('ciudad') . "/categoria/" . $categoria['slug']) ?>"><?= $categoria['icon']; ?>&nbsp; <?= $categoria['nombre']; ?> (<?= $categoria['cantidad']; ?>)</a>
                            </li>
                        <?php } ?>
                    </ul>

                </div>
            </div>
        </section>
    </div>
<?php } ?>

<?php if (count($productos) == 0) { ?>
    <section class="container pt-5 pb-3">
        <div class="row justify-content-md-center">
            <div class="col-md-9">
                <div class="jumbotron">
                    <h1>Aún no tenemos productos <i class="text-danger fas fa-heart-broken"></i></h1>
                    <p class="lead">Estamos trabajando para que emprendedores de tu ciudad se vinculen.</p>
                    <hr class="my-4">
                    <h2 class="h4">¿Eres emprendedor?</h2>
                    <p>Sé el primero de tu ciudad en registrarte, publicar y vender tus productos</p>
                    <a class="btn btn-danger btn-lg" href="<?= site_url('crear-tienda-online') ?>" role="button"><i class="fa fa-user fa-fw"></i>&nbsp; Regístrate</a>
                </div>
            </div>
        </div>
    </section>
<?php } else { ?>
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
                                    <?php if (!is_null($producto['slug'])) { ?>
                                        <a href="<?= site_url($producto['slug']) ?>" class="align-self-center mr-3">
                                            <img class="rounded-circle mr-3" src="<?= image(base_url('assets/tienda/' . $producto['logo']), "square") ?>" alt="<?= $producto['emprendimiento'] ?>">
                                        </a>
                                    <?php } else { ?>
                                        <img class="rounded-circle mr-3" src="<?= image(base_url('assets/tienda/' . $producto['logo']), "square") ?>" alt="<?= $producto['emprendimiento'] ?>">
                                    <?php } ?>
                                    <div class="media-body">
                                        <h5 class="mb-0"><?= ucwords(mb_strtolower($producto['producto'])) ?></h5>
                                        <p class="mb-0">
                                            <?php if (!is_null($producto['slug'])) { ?>
                                                <a class="text-decoration-none" href="<?= site_url($producto['slug']) ?>"><?= ucwords(mb_strtolower($producto['emprendimiento'])) ?></a>
                                            <?php } else { ?>
                                                <?= ucwords(mb_strtolower($producto['emprendimiento'])) ?>
                                            <?php } ?>
                                        </p>
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
            <div class="col-md-12">
                <nav aria-label="Page navigation example">
                    <?= $pagination ?>
                </nav>
            </div>
        </div>
    </section>

    <section class="bg-inscripcion text-white text-center">
        <div class="container py-4">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="h1">¿Eres emprendedor?</h2>
                    <p class="lead mb-0">Únete a nuestra comunidad</p>
                    <p class="lead mb-1 font-weight-bold">Publica tus productos</p>
                    <p class="lead mb-0"><a href="<?= site_url('crear-tienda-online') ?>" class="btn btn-lg btn-success px-5 py-3"><i class="fas fa-running"></i>&nbsp; Regístrate</a></p>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container py-5">
            <div class="row text-center border-between">
                <div class="col-md-4 px-4">
                    <div class="p-3">
                        <span class="fa-stack fa-4x text-primary">
                            <i class="fas fa-circle fa-stack-2x"></i>
                            <i class="fas fa-handshake fa-stack-1x fa-inverse"></i>
                        </span>
                    </div>
                    <h6 class="h5">Apoya al emprendedor</h6>
                    <p class="small">Comprando productos 100% de tu ciudad, hechos con amor y dedicación</p>
                </div>
                <div class="col-md-4 px-4">
                    <div class="p-3">
                        <span class="fa-stack fa-4x text-primary">
                            <i class="fas fa-circle fa-stack-2x"></i>
                            <i class="fas fa-hand-holding-usd fa-stack-1x fa-inverse"></i>
                        </span>
                    </div>
                    <h6 class="h5">Paga contra entrega</h6>
                    <p class="small">Paga en el momento que el emprendedor te entrega el producto en la puerta de tu casa</p>
                </div>
                <div class="col-md-4 px-4">
                    <div class="p-3">
                        <span class="fa-stack fa-4x text-primary">
                            <i class="fas fa-circle fa-stack-2x"></i>
                            <i class="fas fa-truck fa-stack-1x fa-inverse"></i>
                        </span>
                    </div>
                    <h6 class="h5">A la puerta de tu casa</h6>
                    <p class="small">Entregamos tu pedido en la puerta de tu casa</p>
                </div>
            </div>
            <div class="row pt-4">
                <div class="col-md-12 text-center">
                    <a href="#productos" class="btn btn-lg btn-outline-success">Empieza tu compra</a>
                </div>
            </div>
        </div>
    </section>
<?php } ?>


<?php
// Carga los pie de página
$this->load->view('templates/main/followus');
$this->load->view('templates/tienda/footer');
?>