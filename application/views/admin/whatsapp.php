<?php
// Carga el encabezado de la página
$this->load->view('admin/template/header');
?>

<div class="d-flex" id="wrapper">

    <?php $this->load->view('admin/template/sidebar'); ?>

    <!-- Page Content -->
    <div id="page-content-wrapper">

        <?php $this->load->view('admin/template/navbar'); ?>

        <div class="container-fluid">
            <?php if ($this->agent->is_mobile()) { ?>
                <h1 class="mt-4 d-inline-block">Notificaciones Whatsapp
                    <small class="badge badge-danger align-top">Beta</small></h1>
                <p>Para activar las notificación de los pedidos en tu Whatsapp realiza los siguientes <b>8</b> pasos.</p>
                <p class="font-italic"><b>Whatsapp</b> <span class="badge badge-danger align-top">Beta</span> es un servicio que se encuentra en fase de pruebas, por lo tanto no garantizamos su operatividad el 100% del tiempo. Sugerimos seguir pendiente de las notificación vía <b>correo electrónico</b></p>

                <div class="col-md-8 order-1 order-md-2">
                    <div class="d-flex flex-column mb-3 text-center">
                        <p class="alert alert-success">
                            <b>1.</b> Verifica que estas en el celular del <b>Whatsapp</b> con número <b data-mask="(000) 000 0000"><?= $this->session->userdata('emprendedor')['telefono'] ?></b>
                        </p>
                        <i class="mb-3 fas fa-2x fa-arrow-down"></i>
                        <p class="alert alert-success">
                            <b>2.</b> Abre el siguiente vinculo:&nbsp; <a href="https://bit.ly/wa-tienda" target="_blank" class="bg-info text-white font-weight-bold p-1">https://bit.ly/wa-tienda</a>
                        </p>
                        <i class="mb-3 fas fa-2x fa-arrow-down"></i>
                        <p class="alert alert-success">
                            <b>3.</b> Al abrirlo, automaticamente te dirigirá a la conversación con el número de teléfono <b>+1 (415) 523-8886</b>.<br><br> Se verá de esta manera.
                            <img class="mt-1 img-fluid" src="<?= base_url('assets/img/whatsapp-1.jpeg') ?>">
                        </p>
                        <i class="mb-3 fas fa-2x fa-arrow-down"></i>
                        <p class="alert alert-success">
                            <b>4.</b> Envia la palabra <b class="bg-info text-white font-weight-bold p-1">join farther-oldest</b>
                        </p>
                        <i class="mb-3 fas fa-2x fa-arrow-down"></i>
                        <p class="alert alert-success">
                            <b>5.</b> Su respuesta será como lo ves a continuación.
                            <img class="mt-1 img-fluid" src="<?= base_url('assets/img/whatsapp-2.jpeg') ?>">
                        </p>
                        <i class="mb-3 fas fa-2x fa-arrow-down"></i>
                        <p class="alert alert-success">
                            <b>6.</b> ¿Quieres asegurarte que el servicio se encuentra activo?
                            <a href="#" id="verificacion" data-value="<?= $this->session->userdata('emprendedor')['telefono'] ?>" class="bg-info text-white font-weight-bold p-1">Oprime aquí</a> y te llegara un mensaje de confirmación al Whatsapp
                        </p>
                        <i class="mb-3 fas fa-2x fa-arrow-down"></i>
                        <p class="alert alert-success">
                            <b>7.</b> ¿Recibiste el mensaje?
                            <a href="#" id="confirmacion" data-value="<?= $this->session->userdata('emprendedor')['telefono'] ?>" class="bg-info text-white font-weight-bold p-1">Oprime aquí</a> para activar tu servicio de notificaciones.
                        </p>
                        <i class="mb-3 fas fa-2x fa-arrow-down"></i>
                        <p class="alert alert-success">
                            <b>8. ¡Listo!,</b> ya estas suscrito a las notificaciones vía Whatsapp. <a name="paso8"></a>
                        </p>
                    </div>
                    <script>
                        $("#verificacion").on("click", function(e) {
                            e.preventDefault();
                            telefono = $(this).attr("data-value");
                            $.ajax({
                                type: "POST",
                                dataType: "json",
                                url: "<?= base_url('admin/whatsapp/verificar') ?>",
                                data: {
                                    'telefono': telefono
                                }
                            }).done(function(response) {
                                $("#verificacion").removeClass('bg-info');
                                $("#verificacion").addClass('bg-success');
                            });
                        });

                        $("#confirmacion").on("click", function(e) {
                            e.preventDefault();
                            telefono = $(this).attr("data-value");
                            $.ajax({
                                type: "POST",
                                dataType: "json",
                                url: "<?= base_url('admin/whatsapp/confirmar') ?>",
                                data: {
                                    'telefono': telefono
                                }
                            }).done(function(response) {
                                $("#confirmacion").removeClass('bg-info');
                                $("#confirmacion").addClass('bg-success');
                            });
                        });
                    </script>
                </div>
            <?php } else { ?>
                <div class="row justify-content-md-center">
                    <div class="col-md-6 py-4">
                        <!-- Esta desde el computador -->
                        <div class="alert alert-danger text-center" role="alert">
                            <h4 class="alert-heading">Hey! 📢</h4>
                            <p>Para poder activar las notificaciones de los pedidos por Whatsapp debes ingresar desde tu celular.</p>
                            <img src="https://media.giphy.com/media/3oEdv00Ybb6NH4yOty/giphy.gif">
                        </div>
                    </div>
                </div>

            <?php } ?>
            <?php $this->load->view('admin/template/footer'); ?>
        </div>
    </div>
    <!-- /#page-content-wrapper -->

</div>
<!-- /#wrapper -->

<?php
// Carga el encabezado de la página

$this->load->view('admin/template/end');
?>