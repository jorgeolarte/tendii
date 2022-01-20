<section class="container py-4">
    <div class="row">
        <div class="col-4">
            <img data-step="1" data-disable-interaction="1" data-intro='Bienvenido <?= $emprendedor['nombre'] ?>. Te invitamos a conocer tu area de administración' class="rounded-circle mx-auto d-block img-fluid" src="<?= image(base_url('assets/tienda/' . $emprendedor['logo']), 'perfil') ?>" alt="<?= $emprendedor['emprendimiento'] ?>">
        </div>
        <div class="col-8">
            <h1 class="h2 mb-1"><?= ucwords(mb_strtolower($emprendedor['emprendimiento'])) ?></h1>
            <p class="lead mb-1"><?= $emprendedor['nombre'] ?></p>
            <?php if (!is_null($emprendedor['descripcion'])) { ?>
                <p class="mb-1 d-none d-sm-block"><?= $emprendedor['descripcion'] ?></p>
            <?php } ?>
            <?php if (!is_null($emprendedor['hora_inicio'])) { ?>
                <p><i class="fas fa-truck"></i> de <span class="font-weight-bold" data-mask="00:00"><?= $emprendedor['hora_inicio'] ?></span> a <span class="font-weight-bold" data-mask="00:00"><?= $emprendedor['hora_cierre'] ?></span></p>
            <?php } ?>
            <?php if ($emprendedor['id'] == $this->session->userdata('emprendedor')['id']) { ?>
                <div class="d-none d-sm-block">
                    <a href="<?= site_url('admin') ?>" class="btn btn-sm btn-outline-info"><i class="fas fa-cog"></i>&nbsp; Editar productos</a>
                </div>
            <?php } ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <p class="mb-1 d-block d-sm-none"><?= $emprendedor['descripcion'] ?></p>
            <?php if ($emprendedor['id'] == $this->session->userdata('emprendedor')['id']) { ?>
                <div class="d-flex justify-content-between d-block d-sm-none">
                    <a href="<?= site_url('admin') ?>" class="btn btn-sm btn-outline-info "><i class="fas fa-cog"></i>&nbsp; Editar productos</a>
                    <?php if (!$this->session->userdata('whatsapp')) { ?>
                        <a href="<?= site_url('admin/whatsapp') ?>" class="btn btn-sm btn-outline-primary animated flash delay-2s"><i class="fas fa-check-double"></i>&nbsp; Notificaciones Whatsapp</a>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>

    </div>
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