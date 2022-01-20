<?php if (!(($this->router->fetch_class() == 'perfiles') && ($this->router->fetch_method() == 'index'))) { ?>

    <div id="WAButton"></div>

    <?php
    $nombre = explode(" ", $this->session->userdata('emprendedor')['nombre']);
    ?>

    <script type="text/javascript">
        $(function() {
            $('#WAButton').floatingWhatsApp({
                phone: '573122773702',
                popupMessage: 'Hola <?= $nombre[0] ?>, ¿en qué te podemos ayudar?',
                showPopup: true,
                showOnIE: false,
                headerTitle: '¡Bienvenido!',
                position: "right"
            });
        });
    </script>

<?php } ?>

<script src="<?= base_url('assets/js/bootstrap.bundle.min.js'); ?>"></script>

<!--Mascara de telefono y numero-->
<!-- <script src="<?= base_url('assets/js/jquery.mask.js'); ?>"></script> -->
<script src="<?= base_url('assets/js/additional-methods.min.js'); ?>"></script>
<script src="<?= base_url('assets/js/plyr.js'); ?>"></script>
<script src="<?= base_url('assets/js/floating-wpp.min.js'); ?>"></script>
<script src="<?= base_url('assets/js/tienda.js'); ?>"></script>

<script>
    //introJs().setOption('showProgress', true).start();
</script>

<!-- Menu Toggle Script -->
<script>
    $("#cambiarCiudad").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#insidebar").toggleClass("sticky-top");
        $("#wrapper").toggleClass("toggled");
    });
    $("#navbar-toggler").click(function(e) {
        e.preventDefault();
        $("#insidebar").toggleClass("sticky-top");
        $("#wrapper").toggleClass("toggled");
    });
</script>

</body>

</html>