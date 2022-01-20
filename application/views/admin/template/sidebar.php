<!-- Sidebar -->
<div class="align-items-start bg-light border-right" id="sidebar-wrapper">
    <?php $class = (!$this->agent->is_mobile()) ? "sticky-top" : ""; ?>
    <div id="insidebar" class="<?= $class ?>" style="min-height: 100vh">

        <?php if (is_logged_in()) { ?>
            <div class="">
                <div class="sidebar-heading bd-highlight">Administración</div>
                <div class="list-group list-group-flush">
                    <a href="<?= site_url('admin/index') ?>" class="list-group-item list-group-item-action bg-light"><i class="fas fa-tachometer-alt"></i>&nbsp; Tablero</a>
                </div>
                <div class="list-group list-group-flush">
                    <?php $url = (is_null($this->session->userdata('emprendedor')['slug'])) ? 'admin/tienda/nueva' : $this->session->userdata('emprendedor')['slug']; ?>
                    <a href="<?= site_url($url) ?>" class="list-group-item list-group-item-action bg-light"><i class="fas fa-store"></i>&nbsp; Mi tienda</a>
                </div>

                <?php
                // Consultar la ciudad
                $ciudad = $this->ciudades_model->get_ciudades(array('id' => $this->session->userdata('emprendedor')['id_ciudad']));
                // Consultar el departamento
                $departamento = $this->ciudades_model->get_departamentos(array('id' => $ciudad[0]['id_departamento']));
                // Valida si es de Risaralda
                if ($departamento[0]['nombre'] == 'Risaralda') {
                ?>
                    <div class="list-group list-group-flush">
                        <a href="<?= site_url('admin/feria-virtual') ?>" class="list-group-item list-group-item-action bg-info text-white"><span class="animated flash delay-2s"><i class="fas fa-hands-helping"></i>&nbsp; Feria Virtual SENA</span></a>
                    </div>

                <?php } ?>


                <div class="list-group list-group-flush">
                    <a href="<?= site_url('admin/pedidos') ?>" class="list-group-item list-group-item-action bg-light"><i class="fas fa-list-ul"></i>&nbsp; Pedidos</a>
                </div>
                <div class="list-group list-group-flush">
                    <div class="btn-group dropright">
                        <button type="button" class="list-group-item list-group-item-action bg-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-shopping-basket"></i>&nbsp; Productos
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="<?= site_url('admin/productos') ?>"><i class="fas fa-shopping-basket"></i>&nbsp; Productos</a>
                            <a class="dropdown-item" href="<?= site_url('admin/producto/nuevo') ?>"><i class="fas fa-plus"></i>&nbsp; Nuevo producto</a>
                        </div>
                    </div>
                </div>
                <!-- <div class="list-group list-group-flush">
                    <a href="<?= site_url('admin/escuela') ?>" class="list-group-item list-group-item-action bg-light"><i class="fas fa-graduation-cap"></i>&nbsp; Escuela <span class="align-top badge badge-success animated flash infinite slow delay-2s">Nuevo</span></a>
                </div> -->
                <div class="list-group list-group-flush">
                    <div class="btn-group dropright">
                        <button type="button" class="list-group-item list-group-item-action bg-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-cogs"></i>&nbsp; Configuración
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="<?= site_url('admin/ciudades') ?>"><i class="fas fa-truck-loading"></i>&nbsp; Ciudades distribución</a>
                            <a class="dropdown-item" href="<?= site_url('admin/whatsapp') ?>"><i class="fab fa-whatsapp"></i>&nbsp; Notificaciones WS <span class="badge badge-danger animated flash delay-2s">Beta</span></a>
                        </div>
                    </div>
                </div>

                <div class="list-group list-group-flush">
                    <?= form_open('cerrar-sesion', array('method' => 'post')); ?>
                    <button type="submit" class="list-group-item list-group-item-action bg-light"><i class="fas fa-sign-in-alt"></i>&nbsp; Cerrar sesión</button>
                    <?= form_close(); ?>
                </div>
            </div>
        <?php } ?>

        <div class="">
            <?php $url = (is_null($this->session->userdata('emprendedor')['slug'])) ? '/' : $this->session->userdata('emprendedor')['slug']; ?>
            <div class="sidebar-heading bd-highlight">Comparte tu tienda</div>
            <div class="list-group list-group-flush">
                <a href="https://wa.me/<?= $this->session->userdata('pais')['prefijo'] ?><?= $this->session->userdata('emprendedor')['telefono'] ?>?text=<?= urlencode("Hey! Te invito a visitar mi tienda 🏪 ") ?><?= urlencode(site_url($url)); ?>" target="_blank" class="list-group-item list-group-item-action bg-light"><i class="fab fa-whatsapp"></i>&nbsp; Whatsapp</a>
                <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode(site_url($url)); ?>" target="_blank" class="list-group-item list-group-item-action bg-light"><i class="fab fa-facebook"></i>&nbsp; Facebook</a>
            </div>
        </div>

        <div class="">
            <div class="sidebar-heading bd-highlight">Menú</div>
            <div class="list-group list-group-flush">
                <a href="<?= site_url() ?>" class="list-group-item list-group-item-action bg-light"><i class="fas fa-chevron-left"></i>&nbsp; Regresar a la tienda</a>
            </div>
        </div>


    </div>
</div>
<!-- /#sidebar-wrapper -->