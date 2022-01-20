<script src="<?= base_url('assets/js/bootstrap.bundle.min.js'); ?>"></script>

<!--Mascara de telefono y numero-->
<script src="<?= base_url('assets/js/jquery.mask.js'); ?>"></script>
<script src="<?= base_url('assets/js/jquery.filer.min.js'); ?>"></script>
<script src="<?= base_url('assets/js/jquery.flexslider-min.js'); ?>"></script>
<script src="<?= base_url('assets/js/intlTelInput.min.js'); ?>"></script>
<script src="<?= base_url('assets/js/jquery-ui.js'); ?>"></script>
<script src="<?= base_url('assets/js/tienda.js'); ?>"></script>

<script>
    //introJs().setOption('showProgress', true).start();
</script>

<!-- Menu Toggle Script -->
<script>
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