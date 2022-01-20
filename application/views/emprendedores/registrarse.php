<?php
// Carga el encabezado de la página
$this->load->view('emprendedores/template/header');
?>


<div class="d-flex" id="wrapper">

    <?php $this->load->view('emprendedores/template/sidebar'); ?>

    <!-- Page Content -->
    <div id="page-content-wrapper">

        <?php $this->load->view('emprendedores/template/navbar'); ?>

        <?php
        // echo validation_errors();
        // Crear atributos
        $attributes = array('id' => 'form_registrar_emprendedor');
        // Pintar formulario
        echo form_open('registrarse', $attributes); ?>

        <div class="bg-inscripcion">
            <div class="container-fluid">
                <div class="row align-items-end justify-content-end ">
                    <div class="col-md-7 order-xs-2 text-white">
                        <h1>Bienvenido emprendedor</h1>
                    </div>
                    <div class="col-md-5 order-xs-1">
                        <!-- Modal -->
                        <div class="modal fade" id="registrarseModal" tabindex="-1" role="dialog" aria-labelledby="registrarseModalTitle" aria-hidden="true">

                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="registrarseModalTitle"><i class="fas fa-store"></i>&nbsp; Crea tu tienda</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
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
                                            <input type="email" name="email" id="email" class="form-control form-control-lg" placeholder="Correo electrónico" value="<?php echo set_value('email'); ?>" required readonly>
                                            <small id="emailHelpBlock" class="form-text text-danger">
                                                <?php echo form_error('email'); ?>
                                            </small>
                                        </div>
                                        <div class="text-right">
                                            <button type="button" class="btn btn-lg btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i>&nbsp; Cerrar</button>
                                            <button type="submit" id="submit_registrar" class="btn btn-lg btn-success"><i class="fas fa-user-circle"></i>&nbsp; Regístrate</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <h2 class="h3 text-white" id="creaTuTienda">Empieza a vender online</h2>

                        <div class="form-group">
                            <label for="inputTempEmail" class="sr-only">Correo electrónico</label>
                            <input type="email" name="tempEmail" id="inputTempEmail" class="form-control form-control-lg" placeholder="Correo electrónico" value="<?php echo set_value('email'); ?>" required>
                        </div>

                        <!-- Button trigger modal -->
                        <!-- <button type="button" id="btn-show-modal" class="btn btn-lg btn-block btn-success" data-toggle="modal" data-target="#registrarseModal"> -->
                        <button type="button" id="btn-show-modal" class="btn btn-lg btn-block btn-success">
                            <i class="fas fa-store"></i>&nbsp; Crear mi tienda
                        </button>


                    </div>
                </div>
            </div>

        </div>

        <?= form_close(); ?>

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

                // Si la bandera fue activada
                if (ban) {
                    // Muestra el modal
                    $('#registrarseModal').modal('toggle');
                }

                $('#btn-show-modal').on('click', function(event) {
                    if ($('#inputTempEmail').valid()) {
                        $('#registrarseModal').modal('toggle')
                        $('#email').val($('#inputTempEmail').val());
                    }
                });

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
                    },
                    tempEmail: {
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
                    },
                    tempEmail: {
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


        <div class="container-fluid">
            <h1 class="mt-4">Simple Sidebar</h1>
            <p>The starting state of the menu will appear collapsed on smaller screens, and will appear non-collapsed on larger screens. When toggled using the button below, the menu will change.</p>
            <p>Make sure to keep all page content within the <code>#page-content-wrapper</code>. The top navbar is optional, and just for demonstration. Just create an element with the <code>#menu-toggle</code> ID which will toggle the menu when clicked.</p>
            <?php $this->load->view('emprendedores/template/footer'); ?>
        </div>
    </div>
    <!-- /#page-content-wrapper -->

</div>
<!-- /#wrapper -->

<?php
// Carga el encabezado de la página

$this->load->view('emprendedores/template/end');
?>