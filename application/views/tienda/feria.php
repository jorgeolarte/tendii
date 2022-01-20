<?php
// Carga el encabezado de la página
$this->load->view('tienda/template/header');
?>


<div class="d-flex" id="wrapper">

    <?php $this->load->view('tienda/template/sidebar'); ?>

    <!-- Page Content -->
    <div id="page-content-wrapper">

        <?php $this->load->view('tienda/template/navbar'); ?>

        <img src="<?= base_url('assets/img/banner-feria-virtual-sena.png') ?>" class="img-fluid" alt="Feria Virtual de Emprendimiento SENA Risaralda 2020">

        <div class="container-fluid">
            <h1 class="mt-4">Feria Virtual De Emprendimiento SENA Risaralda 2020</h1>
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <p>En alianza con el SENA-SBDC (Centro de Desarrollo Empresarial) Regional Risaralda, tenemos el gusto de invitarte a participar en la <mark>PRIMERA FERIA VIRTUAL DE EMPRENDIMIENTO SENA RISARALDA 2020</mark>. Aquí podrás participar de mentorías en temas como: Transformación y reinvención de modelos de negocios, afrontar esta emergencia económica; además de la rueda de negocios en la que habrán compradores de la región dispuestos a unir fuerzas para sacar adelante nuestra economía.</p>
                    <p>Para participar en nuestra feria solo tienes...</p>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card-deck">
                        <div class="card">
                            <div class="card-body">
                                <h2 class="h3 card-title">Crear tu perfil</h2>
                                <p class="card-text">Si aún no tienes tu propia tienda y no te encuentras vendiendo por Internet.</p>
                            </div>
                            <div class="card-footer">
                                <a href="<?= site_url('crear-tienda-online') ?>" class="btn btn-block btn-lg btn-danger font-weight-bold"><i class="fas fa-store"></i>&nbsp; Crea tu tienda</a>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <h2 class="h3 card-title">Ya tienes una cuenta</h2>
                                <p class="card-text">Inicia sesión y dirígete al apartado <mark>Feria Virtual SENA</mark> del menú lateral</p>
                            </div>
                            <div class="card-footer">
                                <a href="<?= site_url('admin/feria-virtual') ?>" class="btn btn-block btn-lg btn-info font-weight-bold"><i class="fas fa-hands-helping"></i>&nbsp; Feria Virtual SENA</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-12">
                    <p class="mb-0">Con la información que diligencies se hará la revisión de condiciones y se te informara la aceptación o no de la participación a la rueda y/o las mentorias.</p>
                    <p>
                        <ul class="list-unstyled text-muted font-italic">
                            <li><b>Condiciones:</b></li>
                            <li>* Aplica únicamente para emprendedores del departamento de Risaralda</li>
                            <li>* Inscripciones hasta el viernes 19 de junio del 2020</li>
                        </ul>
                    </p>
                </div>
            </div>
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