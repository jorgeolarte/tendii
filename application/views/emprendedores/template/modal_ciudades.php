<!-- Modal -->
<?php
// Mensajes de error
// echo validation_errors();
// Atributos para agregar al formulario
$attributes = array('class' => '', 'id' => 'form_cambiar_ciudad');
// Campos ocultos a enviar en el formulario
$hidden = array('back_url' => current_url());
// Pintar formulario
echo form_open('/ciudad', $attributes, $hidden); ?>
<div class="modal fade" id="modalCiudad" tabindex="-1" role="dialog" aria-labelledby="modalCiudadLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCiudadLabel">Cambiar ciudad</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="paisCiudad" class="sr-only">País</label>
                    <select class="custom-select" name="paisCiudad" id="paisCiudad">
                        <option selected value="">País</option>
                        <option value="CO">Colombia</option>
                        <option value="SV">El Salvador</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="departamentoCiudad" class="sr-only">Departamento</label>
                    <select class="custom-select" name="departamentoCiudad" id="departamentoCiudad" disabled>
                        <option selected>Departamento</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="ciudadCiudad" class="sr-only">Ciudad</label>
                    <select class="custom-select" name="ciudadCiudad" id="ciudadCiudad" disabled required>
                        <option selected>Ciudad</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i>&nbsp; Cerrar</button>
                <button type="submit" class="btn btn-success"><i class="fas fa-globe-americas"></i>&nbsp; Cambiar ciudad</button>
            </div>
        </div>
    </div>
</div>
<?= form_close(); ?>

<script>
    $('#paisCiudad').on('change', function() {
        var id_departamento = $(this).val();
        console.log(id_departamento);
        consultar_departamento($('#paisCiudad').val());
    });

    function consultar_departamento(iso) {
        //var id_departamento = $('#departamento').val();
        if (iso != '') {
            $.ajax({
                url: '<?= site_url("controles/departamentos") ?>',
                method: "POST",
                data: {
                    iso: iso,
                    todos: false
                },
                success: function(data) {
                    $('#departamentoCiudad').html(data);
                    $('#departamentoCiudad').prop("disabled", false);
                }
            });
        }
    }

    $('#departamentoCiudad').on('change', function() {
        var id_departamento = $(this).val();
        console.log(id_departamento);
        consultar_ciudades($('#departamentoCiudad').val());
    });

    function consultar_ciudades(id_departamento) {
        //var id_departamento = $('#departamento').val();
        if (id_departamento != '') {
            $.ajax({
                url: '<?= site_url("controles/ciudades") ?>',
                method: "POST",
                data: {
                    id_departamento: id_departamento,
                    todos: false
                },
                success: function(data) {
                    $('#ciudadCiudad').html(data);
                    $('#ciudadCiudad').prop("disabled", false);
                }
            });
        }
    }

    $("#form_cambiar_ciudad").validate({
        rules: {
            paisCiudad: {
                required: true
            },
            departamentoCiudad: {
                min: 1
            },
            ciudadCiudad: {
                min: 1
            }
        },
        messages: {
            paisCiudad: {
                required: "Seleccione un país"
            },
            departamentoCiudad: {
                min: "Seleccione un departamento"
            },
            ciudadCiudad: {
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