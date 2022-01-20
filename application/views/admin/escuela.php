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
            <h1 class="h2 mt-4">Escuela de Emprendedores <small class="align-top"><i class="fas fa-graduation-cap"></i></small></h1>
            <p class="mb-1">Hola <mark><?= $this->session->userdata('nombre') ?></mark> 😁</p>
            <p>Bienvenido al area donde esperamos ayudarte a crecer en tu emprendimiento.</p>
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div id="player" style="--plyr-color-main: #1ac266;" data-plyr-provider="youtube" data-plyr-embed-id="jEqXW7CrImY">
                            <track kind="captions" label="Español" src="<?= base_url('assets/videos/gastos-hormiga.vtt') ?>" srclang="es" default />
                        </div>
                        <div class="card-body">
                            <h5 class="card-title font-weight-bold">Gastos Hormiga</h5>
                            <p class="card-text">
                                ¿Sabías que si organizas tus finanzas organizas tu vida?<br>
                                De manera muy sencilla te mostramos el camino, conversaremos de temas financieros y como incorporar buenas prácticas.
                            </p>
                            <p class="card-text">
                                <p class="mb-1 font-weight-bold">Anlleli Romero</p>
                                <p class="text-muted">Directora Financiera<br>
                                    Contadora Publica
                                </p>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-light">
                        <img class="img-fluid" src="https://media.giphy.com/media/bEVKYB487Lqxy/giphy.gif">
                        <div class="card-body">
                            <h5 class="card-title font-weight-bold">Próximamente...</h5>
                            <p class="card-text">Espera nuevos videos que te ayudaran a sacarla del estadio con tu emprendimiento.</p>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                $(document).ready(function() {
                    const player = new Plyr('#player', {
                        title: 'Gastos Hormiga',
                        controls: [
                            'play-large', // The large play button in the center
                            //'restart', // Restart playback
                            //'rewind', // Rewind by the seek time (default 10 seconds)
                            'play', // Play/pause playback
                            //'fast-forward', // Fast forward by the seek time (default 10 seconds)
                            'progress', // The progress bar and scrubber for playback and buffering
                            'current-time', // The current time of playback
                            'duration', // The full duration of the media
                            'mute', // Toggle mute
                            'volume', // Volume control
                            'captions', // Toggle captions
                            'settings', // Settings menu
                            //'pip', // Picture-in-picture (currently Safari only)
                            //'airplay', // Airplay (currently Safari only)
                            //'download', // Show a download button with a link to either the current source or a custom URL you specify in your options
                            'fullscreen', // Toggle fullscreen
                        ],
                        settings: [
                            'captions',
                            //'quality', 
                            //'speed', 
                            //'loop'
                        ],
                        autoplay: false,
                        disableContextMenu: false,
                        hideControls: true,
                        displayDuration: false,
                        poster: '<?= base_url('assets/videos/gastos-hormiga.jpg') ?>',
                        //invertTime: false,
                        //fullscreen: { enabled: false, fallback: 'force', iosNative: false, container: null },
                        tooltips: {
                            controls: true,
                            seek: true
                        },
                        tracks: [{
                            kind: 'captions',
                            label: 'Español',
                            srclang: 'es',
                            src: '<?= base_url('assets/videos/gastos-hormiga.vtt') ?>',
                            default: true,
                        }],
                        captions: {
                            active: true,
                            language: 'es',
                            update: false
                        },
                        previewThumbnails: {
                            enabled: true,
                            //src: '<?= base_url('assets/videos/gastos-hormiga.vtt') ?>'
                            src: '<?= base_url('assets/videos/gastos-hormiga.jpg') ?>'
                        },
                    });
                });
            </script>

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