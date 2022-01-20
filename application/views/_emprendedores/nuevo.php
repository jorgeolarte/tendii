<?php
// Carga el encabezado de la página
$this->load->view('templates/emprendedores/header-nuevo');
?>

<div class="container">
    <div class="row justify-content-md-center">
        <div class="col-md-6 p-5 bg-white text-center">
            <a href="<?= site_url($this->session->userdata('ciudad')) ?>"><img class="mb-4 img-fluid w-75" src="<?= base_url('assets/img/logo-emprendedores-verde.png') ?>"></a>
            <h1 class="mb-3 h3">Únete a nuestra comunidad</h1>
            <?php
            // Crear atributos
            $attributes = array('id' => 'form_registrar');
            // Pintar formulario
            echo form_open('zona/registrar_emprendedor', $attributes); ?>
            <div class="form-group">
                <label for="inputNombre" class="sr-only">Nombre</label>
                <input type="text" name="nombre" id="inputNombre" class="form-control form-control-lg" placeholder="Escribe tu nombre" value="<?php echo set_value('nombre'); ?>" required>
                <small class="form-text text-danger">
                    <?php echo form_error('nombre'); ?>
                </small>
            </div>
            <div class="form-group">
                <label for="inputEmprendimiento" class="sr-only">Tu emprendimiento</label>
                <input type="text" name="emprendimiento" id="inputEmprendimiento" class="form-control form-control-lg" placeholder="Nombre de tu emprendimiento" value="<?php echo set_value('emprendimiento'); ?>" required>
                <small class="form-text text-danger">
                    <?php echo form_error('emprendimiento'); ?>
                </small>
            </div>
            <div class="form-group">
                <select name="departamento" id="departamento" class="custom-select custom-select-lg" aria-describedby="departamentoHelpBlock" required>
                    <option value="0" selected>Departamento de tu emprendimiento</option>
                    <?php foreach ($departamentos as $departamento) { ?>
                        <option value="<?= $departamento['id'] ?>" <?= set_select('departamento', $departamento['id']); ?>>
                            <?= $departamento['nombre'] ?>
                        </option>
                    <?php } ?>
                </select>
                <small id="departamentoHelpBlock" class="form-text text-danger">
                    <?php echo form_error('departamento'); ?>
                </small>
            </div>
            <div class="form-group">
                <select name="ciudad" id="ciudad" class="custom-select custom-select-lg" aria-describedby="ciudadHelpBlock" required>
                    <option value="0" selected>Ciudad de tu emprendimiento</option>
                    <?php foreach ($ciudades as $ciudad) { ?>
                        <option value="<?= $ciudad['id'] ?>" <?= set_select('ciudad', $ciudad['id']); ?>>
                            <?= $ciudad['nombre'] ?>
                        </option>
                    <?php } ?>
                </select>
                <small id="ciudadHelpBlock" class="form-text text-danger">
                    <?php echo form_error('ciudad'); ?>
                </small>
            </div>
            <div class="form-group">
                <label for="telefono" class="sr-only">Teléfono celular</label>
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text py-0 font-weight-bold"><img src="<?= base_url('assets/img/colombia.png') ?>">&nbsp;+57</div>
                    </div>
                    <input type="text" name="telefono" id="telefono" class="form-control form-control-lg" placeholder="Teléfono celular" value="<?php echo set_value('telefono'); ?>" data-mask="(000) 000 0000" required>
                </div>
                <small class="form-text text-danger">
                    <?php echo form_error('telefono'); ?>
                </small>
            </div>
            <div class="form-group">
                <label for="inputEmail" class="sr-only">Correo electrónico</label>
                <input type="email" name="email" id="inputEmail" class="form-control form-control-lg" placeholder="Correo electrónico" value="<?php echo set_value('email'); ?>" required>
                <small class="form-text text-danger">
                    <?php echo form_error('email'); ?>
                </small>
            </div>
            <div class="form-group mb-2">
                <button type="submit" id="submit_registrar" class="btn btn-lg btn-block btn-danger"><i class="fa fa-user fa-fw"></i>&nbsp; Regístrate</button>
            </div>
            <div class="form-group text-center pt-3 mb-0">
                O también puedes<br>
                <a href="<?= site_url($this->session->userdata('ciudad')) ?>" class="btn  btn-outline-info"><i class="fas fa-store-alt"></i>&nbsp; Regresar a la tienda</a>
                <a href="<?= site_url('/login') ?>" class="btn btn-outline-primary"><i class="fas fa-walking"></i>&nbsp; Iniciar sesión</a>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>

<script>
    $('#submit_registrar').on('click', function(e) {
        e.preventDefault();
        $('#telefono').unmask();
        $("#form_registrar").submit(); // jQuey's submit function applied on form.
    });
</script>

<?php
// Carga los pie de página
$this->load->view('templates/tienda/footer-login');
?>