<section class="container-fluid py-4">
    <div class="row">
        <div class="col-4">
            <img data-step="1" data-disable-interaction="1" data-intro='Bienvenido <?= $emprendedor['nombre'] ?>. Te invitamos a conocer tu area de administración' class="rounded-circle mx-auto d-block img-fluid" src="<?= image(base_url('assets/tienda/' . $emprendedor['logo']), 'perfil') ?>" alt="<?= $emprendedor['emprendimiento'] ?>">
        </div>
        <div class="col-8">
            <h1 class="h2 mb-1"><?= ucwords(mb_strtolower($emprendedor['emprendimiento'])) ?></h1>
            <!-- <p class="lead mb-1"><?= $emprendedor['nombre'] ?></p> -->
            <?php if (!is_null($emprendedor['descripcion'])) { ?>
                <p class="mb-1 d-none d-sm-block"><?= $emprendedor['descripcion'] ?></p>
            <?php } ?>
            <?php if (!is_null($emprendedor['hora_inicio'])) { ?>
                <p><i class="fas fa-truck"></i> de <span class="font-weight-bold" data-mask="00:00"><?= $emprendedor['hora_inicio'] ?></span> a <span class="font-weight-bold" data-mask="00:00"><?= $emprendedor['hora_cierre'] ?></span></p>
            <?php } ?>
        </div>
    </div>
    <?php if (!is_null($emprendedor['descripcion'])) { ?>
        <div class="row">
            <div class="col-12">
                <p class="mb-1 d-block d-sm-none"><?= $emprendedor['descripcion'] ?></p>
            </div>
        </div>
    <?php } ?>

</section>

<section class="bg-light py-2">
    <div class="d-flex justify-content-center text-center small">
        <div class="mx-3">
            <span class="lead"><?= $contar_productos ?></span><br>
            <span data-toggle="tooltip" data-placement="bottom" title="Cantidad de productos configurados en la tienda">productos</span>
        </div>
        <div class="mx-3">
            <span class="lead">0</span><br>
            <span data-toggle="tooltip" data-placement="bottom" title="Cantidad de pedidos recibidos en la tienda">pedidos</span>
        </div>
        <div class="mx-3">
            <span class="lead">0</span><br>
            <span data-toggle="tooltip" data-placement="bottom" title="Cantidad de veces que tu productos han tenido intención de ser comprados">intenciones</span>
        </div>
    </div>
</section>