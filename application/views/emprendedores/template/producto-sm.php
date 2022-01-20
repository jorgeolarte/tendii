<div class="border-bottom py-3">
    <div class="row">
        <div class="col-4">
            <img src="<?= image(base_url('assets/tienda/' . $producto['imagen']), 'square') ?>" class="img-fluid" alt="<?= $producto['producto'] ?> - <?= $producto['emprendimiento'] ?>">
        </div>
        <div class="col-8">
            <h5 class="mb-0 text-wrap font-weight-bold"><?= ucwords(mb_strtolower($producto['producto'])) ?></h5>

            <?php $url = (!is_null($producto['slug'])) ? site_url($producto['slug']) : '#' ?>
            <?php if ((!is_null($producto['slug']))) { ?>
                <a href="<?= $url ?>"><?= ucwords(mb_strtolower($producto['emprendimiento'])) ?></a>
            <?php  } else { ?>
                <span><?= ucwords(mb_strtolower($producto['emprendimiento'])) ?></span>
            <?php } ?>

            <p class="mb-1"><small class="text-break"><?= ucfirst(mb_strtolower($producto['descripcion'])) ?></small></p>
        
        </div>
    </div>
    <div class="row pt-3">
        <div class="col-12">
            <div class="d-flex align-self-center">
                <div class="lead">
                    <span class="font-weight-bold text-primary">$ <?= number_format($producto['precio'], $this->session->userdata('pais')['decimales']); ?></span> <i class="fas fa-tag text-primary"></i></span>
                </div>
                <div class="ml-auto">
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
                    <button type="submit" class="btn btn-block btn-primary"><i class="fas fa-shopping-cart"></i>&nbsp;Agregar</button>
                    <?= form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>