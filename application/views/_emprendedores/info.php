<section class="container py-4">
    <div class="row">
        <div class="col-4">
            <img data-step="1" data-disable-interaction="1" data-intro='Bienvenido <?= $this->session->userdata('nombre') ?>. Te invitamos a conocer tu area de administración' class="rounded-circle mx-auto d-block img-fluid" src="<?= image(base_url('assets/tienda/' . $this->session->userdata('logo')), 'perfil') ?>" alt="<?= $this->session->userdata('emprendimiento') ?>">
        </div>
        <div class="col-8">
            <h1 class="h2 mb-1"><?= ucwords(mb_strtolower($this->session->userdata('emprendimiento'))) ?></h1>
            <p class="lead mb-1"><?= $this->session->userdata('nombre') ?></p>
            <?php if (!is_null($this->session->userdata('descripcion'))) { ?>
                <p class="mb-1"><?= $this->session->userdata('descripcion') ?></p>
            <?php } ?>
            <?php if (!is_null($this->session->userdata('hora_inicio'))) { ?>
                <p><i class="fas fa-truck"></i> de <span class="font-weight-bold" data-mask="00:00"><?= $this->session->userdata('hora_inicio') ?></span> a <span class="font-weight-bold" data-mask="00:00"><?= $this->session->userdata('hora_cierre') ?></span></p>
            <?php } ?>

            <div class="small">
                <p class="mb-1">
                    <i class="fas fa-phone"></i>&nbsp; <?= $this->session->userdata('telefono') ?>
                </p>
                <p class="mb-1">
                    <i class="fas fa-envelope"></i>&nbsp; <?= $this->session->userdata('email') ?>
                </p>
            </div>

        </div>
    </div>
</section>

<section class="bg-light py-2">
    <div class="d-flex justify-content-center text-center small">
        <div class="mx-3">
            <span class="lead"><?= contar_productos() ?></span><br>
            <span data-toggle="tooltip" data-placement="bottom" title="Cantidad de productos configurados en la tienda">productos</span>
        </div>
        <div class="mx-3">
            <span class="lead"><?= pedidos() ?></span><br>
            <span data-toggle="tooltip" data-placement="bottom" title="Cantidad de pedidos recibidos en la tienda">pedidos</span>
        </div>
        <div class="mx-3">
            <span class="lead">0</span><br>
            <span data-toggle="tooltip" data-placement="bottom" title="Cantidad de veces que tu productos han tenido intención de ser comprados">intenciones</span>
        </div>
    </div>
</section>