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
            <h1 class="mt-4">Ciudades de distribución</h1>
            <p>Configura las ciudades donde puedes entregar tus productos.</p>
            <div class="row">
                <div class="col-md-8 order-md-1">
                    <table class="table table-hover">
                        <caption>Estas son las ciudades donde puedes distribuir</caption>
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Departamento</th>
                                <th scope="col" colspan="2">Ciudad</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($coberturas as $pos => $cobertura) { ?>
                                <tr>
                                    <?php
                                    // Crear atributos
                                    $attributes = array('method' => 'post');
                                    // Campo oculto
                                    $hidden = array('id' => $cobertura['id']);
                                    // Pintar formulario
                                    echo form_open('admin/ciudades/eliminar', $attributes, $hidden); ?>
                                    <td><?= $cobertura['id']; ?></td>
                                    <td><span class="text-wrap"><?= $cobertura['departamento']; ?></span></td>
                                    <td><img src="<?= base_url('assets/img/banderas/' . $cobertura["bandera"]); ?>"></td>
                                    <td><?= $cobertura['ciudad']; ?></td>
                                    <td>
                                        <!-- <?= validation_errors('<span class="small text-danger">', '</span>') ?> -->
                                        <?php if (count($coberturas) > 1) { ?>
                                            <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></button>
                                        <?php } ?>
                                    </td>
                                    <?= form_close(); ?>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-4 order-md-2 p-5 bg-light">
                    <?php
                    // Crear atributos
                    $attributes = array('id' => 'form_agregar_ciudad', 'method' => 'post');
                    // Pintar formulario
                    echo form_open('admin/ciudades/agregar', $attributes); ?>
                    <h2 class="h3">Agregar ciudad</h2>
                    <p class="mb-2">¿En ciudades puedes distribuir tus productos?</p>
                    <div class="form-group">
                        <label for="pais" class="sr-only">País</label>
                        <select class="form-control form-control-lg" name="pais" id="pais" disabled>
                            <option <?= ($this->session->set_userdata('pais')['ISO'] == 'CO') ? 'selected' : '' ?> value="CO">Colombia</option>
                            <option <?= ($this->session->set_userdata('pais')['ISO'] == 'SV') ? 'selected' : '' ?> value="SV">El Salvador</option>
                        </select>
                        <small id="paisHelpBlock" class="form-text text-danger">
                            <?php echo form_error('pais'); ?>
                        </small>
                    </div>
                    <div class="form-group">
                        <label for="departamento" class="sr-only">Departamento</label>
                        <select class="form-control form-control-lg" name="departamento" id="departamento" disabled>
                            <option selected value="">Departamento</option>
                        </select>
                        <small id="departamentoHelpBlock" class="form-text text-danger">
                            <?php echo form_error('departamento'); ?>
                        </small>
                    </div>
                    <div class="form-group">
                        <label for="ciudad" class="sr-only">Ciudad</label>
                        <select class="form-control form-control-lg" name="ciudad" id="ciudad" disabled>
                            <option selected value="">Ciudad</option>
                        </select>
                        <small id="ciudadHelpBlock" class="form-text text-danger">
                            <?php echo form_error('ciudad'); ?>
                        </small>
                    </div>
                    <div class="">
                        <button type="submit" id="submit_ciudad" class="btn btn-lg btn-success btn-block"><i class="fas fa-plus"></i>&nbsp; Añadir ciudad</button>
                    </div>
                    <?= form_close(); ?>
                    <script>
                        $(document).ready(function() {

                            // Selecciona el pais por defecto del emprendedor
                            $('#pais').val('<?= $ISO ?>');

                            // Si cambia de pais
                            $('#pais').on('change', function() {
                                console.log('<?= $ISO ?>');
                                consultar_departamento($('#pais').val());
                            }).change();

                            function consultar_departamento(iso) {
                                //var id_departamento = $('#departamento').val();
                                if (iso != '') {
                                    $.ajax({
                                        url: '<?= site_url("controles/departamentos") ?>',
                                        method: "POST",
                                        data: {
                                            iso: iso,
                                            todos: 1
                                        },
                                        success: function(data) {
                                            $('#departamento').html(data);
                                            $('#departamento').prop("disabled", false);
                                        }
                                    });
                                }
                            }

                            $('#departamento').on('change', function() {
                                consultar_ciudades($('#departamento').val());
                            });

                            function consultar_ciudades(id_departamento) {
                                //var id_departamento = $('#departamento').val();
                                if (id_departamento != '') {
                                    $.ajax({
                                        url: '<?= site_url("controles/ciudades") ?>',
                                        method: "POST",
                                        data: {
                                            id_departamento: id_departamento,
                                            todos: 1
                                        },
                                        success: function(data) {
                                            $('#ciudad').html(data);
                                            $('#ciudad').prop("disabled", false);
                                        }
                                    });
                                }
                            }
                        });

                        $("#form_agregar_ciudad").validate({
                            rules: {
                                pais: {
                                    required: true
                                },
                                departamento: {
                                    min: 1
                                },
                                ciudad: {
                                    min: 1
                                }
                            },
                            messages: {
                                pais: {
                                    required: "Seleccione un país"
                                },
                                departamento: {
                                    min: "Seleccione un departamento"
                                },
                                ciudad: {
                                    min: "Seleccione una ciudad"
                                }
                            },
                            validClass: "is-valid",
                            errorClass: "is-invalid",
                            errorElement: "small",
                            submitHandler: function(form) {
                                // do other things for a valid form
                                form.submit();
                            }
                        });
                    </script>
                </div>
            </div>
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