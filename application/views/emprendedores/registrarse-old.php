<?php
// Carga el encabezado de la página
$this->load->view('emprendedores/template/header');
?>


<div class="d-flex" id="wrapper">

    <?php $this->load->view('emprendedores/template/sidebar'); ?>

    <!-- Page Content -->
    <div id="page-content-wrapper">

        <?php $this->load->view('emprendedores/template/navbar'); ?>

        <div class="container-fluid bg-inscripcion">

            <div class="row justify-content-md-center">
                <div class="col-md-6 bg-white p-4 text-center">
                    <a href="<?= site_url($this->session->userdata('ciudad')) ?>"><img class="img-fluid w-50" src="<?= base_url('assets/img/logo-emprendedores-verde.png') ?>"></a>
                    <h1 class="h3 mt-4 text-center">Crea tu tienda</h1>
                    <?php
                    // echo validation_errors();
                    // Crear atributos
                    $attributes = array('id' => 'form_registrar_emprendedor');
                    // Pintar formulario
                    echo form_open('registrarse', $attributes); ?>
                    <div class="form-group">
                        <label for="inputNombre" class="sr-only">Nombre</label>
                        <input type="text" name="nombre" id="inputNombre" class="form-control form-control-lg" placeholder="Escribe tu nombre" value="<?php echo set_value('nombre'); ?>" required>
                        <small id="nombreHelpBlock" class="form-text text-danger">
                            <?php echo form_error('nombre'); ?>
                        </small>
                    </div>
                    <div class="form-group">
                        <label for="inputEmprendimiento" class="sr-only">Tu emprendimiento</label>
                        <input type="text" name="emprendimiento" id="inputEmprendimiento" class="form-control form-control-lg" placeholder="Nombre de tu emprendimiento" value="<?php echo set_value('emprendimiento'); ?>" required>
                        <small id="emprendimientoHelpBlock" class="form-text text-danger">
                            <?php echo form_error('emprendimiento'); ?>
                        </small>
                    </div>
                    <div class="form-group">
                        <label for="pais" class="sr-only">País</label>
                        <select class="form-control form-control-lg" name="pais" id="pais">
                            <option selected value="">País</option>
                            <option value="CO">Colombia</option>
                            <option value="SV">El Salvador</option>
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
                    <div class="form-group">
                        <label for="telefono" class="sr-only">Teléfono celular</label>
                        <input type="tel" name="telefono" id="telefono" class="form-control form-control-lg" placeholder="Teléfono celular" value="<?php echo set_value('telefono'); ?>" required>
                        <small id="telefonoHelpBlock" class="form-text text-danger">
                            <?php echo form_error('telefono'); ?>
                        </small>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail" class="sr-only">Correo electrónico</label>
                        <input type="email" name="email" id="email" class="form-control form-control-lg" placeholder="Correo electrónico" value="<?php echo set_value('email'); ?>" required>
                        <small id="emailHelpBlock" class="form-text text-danger">
                            <?php echo form_error('email'); ?>
                        </small>
                    </div>
                    <div class="form-group mb-2">
                        <button type="submit" id="submit_registrar" class="btn btn-lg btn-block btn-success"><i class="fas fa-user-circle"></i>&nbsp; Regístrate</button>
                    </div>
                    <?= form_close(); ?>
                </div>
                <script>
                    $(document).ready(function() {

                        // Bandera para mostrar si hay error
                        var ban = false;
                        // Evalua los mensajes de error
                        var divs = document.querySelectorAll('small[id$="HelpBlock"]').forEach(function(el) {
                            if (!isEmpty(el.innerHTML)) {
                                ban = true;
                            }
                        });

                        // Formatea el valor y verifica si esta vacio
                        function isEmpty(value) {
                            return typeof value == 'string' && !value.trim() || typeof value == 'undefined' || value === null;
                        }

                        // Variable del telefono
                        var telefono = document.querySelector("#telefono");

                        // Inicialización del telefono
                        var iti = window.intlTelInput(telefono, {
                            // any initialisation options go here
                            autoPlaceholder: "Teléfono de contacto",
                            //customContainer: "form-control",
                            separateDialCode: true,
                            nationalMode: true,
                            onlyCountries: ["co", "sv"],
                            initialCountry: "auto",
                            geoIpLookup: function(success, failure) {
                                $.get("https://ipinfo.io", function() {}, "jsonp").always(function(resp) {
                                    var countryCode = (resp && resp.country) ? resp.country : "";
                                    success(countryCode);
                                });
                            },
                            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.1/js/utils.min.js"
                        });

                        // Validación propia del telefono
                        jQuery.validator.addMethod("custom_telefono", function(value, element) {
                            return iti.isValidNumber();
                        }, function() {
                            var errorMap = ["Número invalido", "Código de país invalido", "Número teléfono muy corto", "Número teléfono muy largo", "Número invalido"];
                            var errorCode = iti.getValidationError();
                            return errorMap[errorCode];
                        });

                        // Almacena las ciudades del país
                        var ciudades = 0;

                        // De dispara cuando se cambia el pais
                        $('#pais').on('change', function() {
                            iti.setCountry($('#pais').val());
                            consultar_departamento($('#pais').val());
                        });

                        // Consulta los departamentos
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

                        // Dispara el evento cuando se cambia el departamento
                        $('#departamento').on('change', function() {
                            consultar_ciudades($('#departamento').val());
                        });

                        // Consultar las ciudades
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

                    // Validar el formulario
                    $("#form_registrar_emprendedor").validate({
                        rules: {
                            nombre: {
                                required: true,
                                rangelength: [10, 500]
                            },
                            emprendimiento: {
                                required: true,
                                rangelength: [3, 200]
                            },
                            pais: {
                                required: true
                            },
                            departamento: {
                                min: 1
                            },
                            ciudad: {
                                min: 1
                            },
                            telefono: {
                                required: true,
                                rangelength: [6, 14],
                                custom_telefono: true
                            },
                            email: {
                                required: true,
                                email: true
                            }
                        },
                        messages: {
                            nombre: {
                                required: "Nombre es obligatorio",
                                rangelength: jQuery.validator.format("El nombre debe estar entre {0} y {1} caracteres"),
                            },
                            emprendimiento: {
                                required: "Ingresa el nombre de tu obligatorio",
                                rangelength: jQuery.validator.format("El emprendimiento debe estar entre {0} y {1} caracteres"),
                            },
                            pais: {
                                required: "Seleccione un país"
                            },
                            departamento: {
                                min: "Seleccione un departamento"
                            },
                            ciudad: {
                                min: "Seleccione una ciudad"
                            },
                            telefono: {
                                required: "El teléfono es obligatorio",
                                rangelength: "El número de teléfono debe tener entre {0} y {1} digitos",
                            },
                            email: {
                                required: "Email es obligatorio",
                                email: "Ingrese un email valido"
                            }
                        },
                        validClass: "is-valid",
                        errorClass: "is-invalid",
                        errorElement: "small",
                        submitHandler: function(form) {
                            // do other things for a valid form
                            //$('#telefono').unmask();
                            form.submit();
                        }
                    });
                </script>
            </div>

            <?php //$this->load->view('tienda/template/footer'); 
            ?>
        </div>
    </div>
    <!-- /#page-content-wrapper -->

</div>
<!-- /#wrapper -->

<?php
// Carga el encabezado de la página

$this->load->view('emprendedores/template/end');
?>