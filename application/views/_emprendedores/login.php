<?php
// Carga el encabezado de la página
$this->load->view('templates/emprendedores/header-nuevo');
?>

<div class="container">
    <div class="row justify-content-md-center">
        <div class="col-md-6 p-5 bg-white text-center">
            <a href="<?= site_url($this->session->userdata('ciudad')) ?>"><img class="mb-4 img-fluid w-75" src="<?= base_url('assets/img/logo-emprendedores-verde.png') ?>"></a>
            <h1 class="mb-3 h3">Iniciar sesión</h1>
            <?php
            // Pintar formulario
            echo form_open('iniciar_sesion'); ?>
            <div class="form-group">
                <label for="inputEmail" class="sr-only">Correo electrónico</label>
                <input type="email" name="email" id="inputEmail" class="form-control form-control-lg" placeholder="Correo electrónico" value="<?php echo set_value('email'); ?>" required>
                <small class="form-text text-danger">
                    <?php echo form_error('email'); ?>
                </small>
            </div>
            <div class="form-group">
                <label for="inputTelefono" class="sr-only">Teléfono celular</label>
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text py-0 font-weight-bold"><img src="<?= base_url('assets/img/colombia.png') ?>">&nbsp;+57</div>
                    </div>
                    <input type="password" name="telefono" id="inputTelefono" class="form-control form-control-lg" placeholder="Teléfono celular" pattern="\d*" maxlength="10" value="<?php echo set_value('telefono'); ?>" required>
                </div>
                <small class="form-text text-danger">
                    <?php echo form_error('telefono'); ?>
                </small>
            </div>
            <div class="form-group mb-2">
                
                <button type="submit" class="btn btn-lg btn-block btn-primary"><i class="fas fa-walking"></i>&nbsp; Iniciar sesión</button>
            </div>
            <div class="form-group text-center pt-3 mb-0">
                O tambien puedes<br>
                <a href="<?= site_url($this->session->userdata('ciudad'))?>" class="btn  btn-outline-info"><i class="fas fa-store-alt"></i>&nbsp; Regresar a la tienda</a>
                <a href="<?= site_url('/crear-tienda-online') ?>" class="btn btn-outline-danger"><i class="fa fa-user fa-fw"></i>&nbsp; Regístrate</a>
            </div>
            </form>
        </div>
    </div>
</div>

<?php
// Carga los pie de página
$this->load->view('templates/tienda/footer-login');
?>