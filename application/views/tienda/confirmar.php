<?php
// Carga el encabezado de la página
$this->load->view('tienda/template/header');
?>


<div class="d-flex" id="wrapper">

    <?php $this->load->view('tienda/template/sidebar'); ?>

    <!-- Page Content -->
    <div id="page-content-wrapper">

        <?php $this->load->view('tienda/template/navbar'); ?>

        <div class="container-fluid">
            <h1 class="mt-4">Confirmar compra</h1>
            <p class="mb-1">Tu pedido será entregado en <mark><?= $ciudad['nombre'] ?> <img class="align-top" src="<?= base_url('assets/img/banderas/' . $ciudad['bandera']) ?>"></mark></p>
            <p>Diligencia el siguiente formulario para enviar los productos</p>
            <div class="row">
                <div class="col-md-9 order-md-1 ">
                    <?php
                    // Crear atributos
                    $attributes = array('id' => 'form_confirmar');
                    // Campos ocultos
                    $hidden = array(
                        'iso' => '',
                        'id_compra' => $compra['id'],
                        'id_pais' => $pais['id'],
                        'id_ciudad' => $ciudad['id']
                    );
                    // Pintar formulario
                    echo form_open("{$this->session->userdata('pais')['ISO']}/carrito/enviar", $attributes, $hidden); ?>
                    <div class="row bg-light p-4">
                        <div class="col-md-6">
                            <h2 class="h3">Tus datos</h2>
                            <div class="form-group mb-2">
                                <label for="nombre" class="col-form-label">Nombre *</label>
                                <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Tu nombre completo" value="<?php echo set_value('nombre'); ?>" required>
                                <small class="form-text text-muted">
                                    <?php echo form_error('nombre'); ?>
                                </small>
                            </div>
                            <div class="form-group mb-2">
                                <label for="" class="col-form-label">Teléfono *</label><br>
                                <input type="tel" name="telefono" id="telefono" class="form-control" placeholder="Teléfono de contacto" value="<?php echo set_value('telefono'); ?>" required>
                                <small class="form-text text-danger">
                                    <?php echo form_error('telefono'); ?>
                                </small>
                            </div>
                            <div class="form-group mb-2">
                                <label for="email" class="col-form-label">Correo electrónico *</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="Correo electrónico" value="<?php echo set_value('email'); ?>" required>
                                <small class="form-text text-danger">
                                    <?php echo form_error('email'); ?>
                                </small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h2 class="h3" data-toggle="tooltip" data-placement="top" title="La dirección de entrega debe pertenecer a <?= $ciudad['nombre'] ?>">Dirección de entrega</h2>
                            <div class="form-group mb-2">
                                <label for="ciudad" class="col-form-label">Ciudad de entrega *</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><img src="<?= base_url('assets/img/banderas/' . $ciudad['bandera']) ?>"></span>
                                    </div>
                                    <input type="text" name="ciudad" id="ciudad" class="form-control" placeholder="Ciudad donde se debe entregar" value="<?= $ciudad['nombre']; ?>" readonly>
                                </div>
                                <small class="form-text text-danger">
                                    <?php echo form_error('ciudad'); ?>
                                </small>
                            </div>
                            <div class="form-group mb-2">
                                <label for="barrio" class="col-form-label">Barrio *</label>
                                <input type="text" name="barrio" id="barrio" class="form-control" placeholder="Barrio donde se debe entregar" value="<?php echo set_value('barrio'); ?>" required>
                                <small class="form-text text-danger">
                                    <?php echo form_error('barrio'); ?>
                                </small>
                            </div>
                            <div class="form-group mb-2">
                                <label for="direccion" class="col-form-label">Dirección *</label>
                                <input type="text" name="direccion" id="direccion" class="form-control" placeholder="Dirección de entrega" value="<?php echo set_value('direccion'); ?>" required data-toggle="tooltip" data-placement="top" title="La dirección de entrega debe pertenecer a <?= $ciudad['nombre'] ?>">
                                <small class="form-text text-danger">
                                    <?php echo form_error('direccion'); ?>
                                </small>
                            </div>
                            <div class="form-group mb-2">
                                <label for="observaciones" class="col-form-label">Observaciones</label>
                                <textarea name="observaciones" id="observaciones" class="form-control" placeholder="¿Tienes alguna observación acerca de la entrega?" rows="5" value="<?php echo set_value('observaciones'); ?>"></textarea>
                            </div>
                            <div class="text-right pt-2">
                                <button type="submit" id="submit_confirmar" class="btn btn-lg btn-success"><i class="fas fa-shopping-basket"></i>&nbsp; Confirmar pedido</button>
                                <small class="form-text text-muted">
                                    <ul class="list-unstyled pt-2">
                                        <li>Los campos con asterisco (*) son obligatorios</li>
                                        <li>No compartimos tu información con terceros</li>
                                        <li>Tus datos están ha salvo con nosotros</li>
                                    </ul>
                                </small>
                            </div>
                        </div>
                    </div>
                    <?= form_close(); ?>
                    <script>
                        $(document).ready(function() {
                            var input = document.querySelector("#telefono");

                            var iti = window.intlTelInput(input, {
                                // any initialisation options go here
                                autoPlaceholder: "Teléfono de contacto",
                                //customContainer: "form-control",
                                separateDialCode: true,
                                preferredCountries: ["co", "sv"],
                                initialCountry: "auto",
                                geoIpLookup: function(success, failure) {
                                    $.get("https://ipinfo.io", function() {}, "jsonp").always(function(resp) {
                                        var countryCode = (resp && resp.country) ? resp.country : "";
                                        success(countryCode);
                                    });
                                },
                                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.1/js/utils.min.js"
                            });

                            iti.setCountry('sv');

                            // Validación propia del telefono
                            jQuery.validator.addMethod("custom_telefono", function(value, element) {
                                return iti.isValidNumber();
                            }, function() {
                                var errorMap = ["Número invalido", "Código de país invalido", "Número teléfono muy corto", "Número teléfono muy largo", "Número invalido"];
                                var errorCode = iti.getValidationError();
                                return errorMap[errorCode];
                            });

                            input.addEventListener('change', function() {
                                console.log(iti.getSelectedCountryData().iso2);
                                $("input[name=iso]").val(iti.getSelectedCountryData().iso2);
                            });
                        });

                        $("#form_confirmar").validate({
                            rules: {
                                nombre: {
                                    required: true,
                                    rangelength: [10, 500]
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
                                barrio: {
                                    required: true,
                                    rangelength: [3, 500]
                                },
                                direccion: {
                                    required: true,
                                    rangelength: [3, 500]
                                }
                            },
                            messages: {
                                nombre: {
                                    required: "Nombre es obligatorio",
                                    rangelength: jQuery.validator.format("El nombre debe estar entre {0} y {1} caracteres"),
                                },
                                telefono: {
                                    required: "El teléfono es obligatorio",
                                    rangelength: "El número de teléfono debe tener entre {0} y {1} digitos",
                                },
                                email: {
                                    required: "Email es obligatorio",
                                    email: "Ingrese un email valido"
                                },
                                barrio: {
                                    required: "Ingresa el nombre del barrio",
                                    rangelength: jQuery.validator.format("El nombre del barrio debe estar entre {0} y {1} caracteres"),
                                },
                                direccion: {
                                    required: "Ingresa la dirección de entrega",
                                    rangelength: jQuery.validator.format("La dirección debe estar entre {0} y {1} caracteres"),
                                },
                            },
                            validClass: "is-valid",
                            errorClass: "is-invalid",
                            errorElement: "small",
                            submitHandler: function(form) {
                                //form.preventDefault();
                                // do other things for a valid form
                                //$('#telefono').unmask();
                                form.submit();
                            }
                        });
                    </script>
                </div>
                <div class="col-md-3 order-md-2 p-4">
                    <h3>Tu carrito</h3>
                    <ul class="list-group">
                        <?php $products = array() ?>
                        <?php foreach ($detalles as $pos => $detalle) { ?>
                            <?php
                            // Array tag manager
                            $data = array(
                                "id" => $detalle['id_producto'],
                                "name" => ucwords(mb_strtolower($detalle['nombre_producto'])),
                                "price" => $detalle['valor_detalle'],
                                "brand" => ucwords(mb_strtolower($detalle['emprendimiento_emprendedor'])),
                                "category" => $detalle['nombre_categoria'],
                                'position' => $pos + 1,
                                "quantity" => $detalle['cantidad_detalle']
                            );
                            array_push($products, $data);
                            ?>
                            <li class="list-group-item d-flex justify-content-between lh-condensed">
                                <div>
                                    <h6 class="mb-0"><?= ucfirst(mb_strtolower($detalle['nombre_producto'])); ?></h6>
                                    <small class="text-muted"><?= ucwords(mb_strtolower($detalle['emprendimiento_emprendedor'])); ?></small>
                                </div>
                                <span class="text-muted">$<?= number_format($detalle['subtotal_detalle'], $this->session->userdata('pais')['decimales']); ?></span>
                            </li>
                        <?php } ?>

                        <li class="list-group-item d-flex justify-content-between lh-condensed">
                            <span class="font-weight-bold">Total</span>
                            <strong class="text-success">$<?= number_format($detalles[0]['total_compra'], $this->session->userdata('pais')['decimales']) ?></strong>
                        </li>
                    </ul>
                    <p class="mt-2 text-danger"><small>* Tu pedido será entregado en <mark><?= $ciudad['nombre'] ?> <img class="align-top" src="<?= base_url('assets/img/banderas/' . $ciudad['bandera']) ?>" width="16px"></mark></small></p>
                    <script>
                        dataLayer.push({
                            "event": "checkout",
                            "ecommerce": {
                                "checkout": {
                                    "actionField": {
                                        "step": 2
                                    },
                                    "products": <?= json_encode($products) ?>
                                }
                            }
                        });
                    </script>
                </div>
            </div>
            <?php $this->load->view('admin/template/footer'); ?>
        </div>
    </div>
</div>
<!-- /#page-content-wrapper -->

</div>
<!-- /#wrapper -->

<?php
// Carga el encabezado de la página

$this->load->view('tienda/template/end');
?>