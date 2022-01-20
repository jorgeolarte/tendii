<div class="card">

    <div class="card-body py-2">
        <div class="card-text flex">
            <?php $url = (!is_null($producto['slug'])) ? site_url($producto['slug']) : '#' ?>
            <a href="<?= $url ?>" class="align-self-center text-decoration-none">
                <img class="rounded-circle mr-2" src="<?= image(base_url('assets/tienda/' . $producto['logo']), "navbar") ?>" alt="<?= $producto['emprendimiento'] ?>">
            </a>
            <?php if ((!is_null($producto['slug']))) { ?>
                <a href="<?= $url ?>"><?= ucwords(mb_strtolower($producto['emprendimiento'])) ?></a>
            <?php  } else { ?>
                <span><?= ucwords(mb_strtolower($producto['emprendimiento'])) ?></span>
            <?php } ?>
        </div>
    </div>
    <div class="inner">
        <img src="<?= image(base_url('assets/tienda/' . $producto['imagen']), 'large') ?>" class="card-img-top" alt="<?= $producto['producto'] ?> - <?= $producto['emprendimiento'] ?>">
    </div>
    <div class="card-body">
        <div class="media">
            <div class="media-body">
                <h5 class="mb-1 font-weight-bold"><?= ucwords(mb_strtolower($producto['producto'])) ?></h5>
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
        echo form_open($this->session->userdata('pais')['ISO'] . '/carrito/agregar', $attributes, $hidden); ?>
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