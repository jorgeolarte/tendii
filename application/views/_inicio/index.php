<?php $this->load->view('inicio/encabezado'); ?>

<!-- Beneficios -->
<div class="text-center bg-primary text-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4 p-4"> <i class="fa fa-users mb-2 fa-5x d-block"></i>
                <h4 class="animated infinite tada slower"><b id="emprendedores"><?= $emprendedores ?> Emprendedores</b></h4>
                <p class="mb-0">Hacemos parte de la comunidad</p>
            </div>
            <div class="col-md-4 p-4 border-right border-left border-light"> <i class="d-block fa fa-handshake mb-2 fa-5x"></i>
                <h4><b>Crea conexiones</b></h4>
                <p class="mb-0">Comparte tus éxitos y frustraciones</p>
            </div>
            <div class="col-md-4 p-4"> <i class="d-block fa fa-chalkboard-teacher mb-2 fa-5x"></i>
                <h4> <b>Aprende</b></h4>
                <p class="mb-0">De las experiencias de los démas</p>
            </div>
        </div>
    </div>
</div>

<!-- ¿Qué hacemos? -->
<div class="py-5">
    <div class="container" id="que-hacemos">
        <div class="row">
            <div class="col-md-12">
                <h1 class="text-center mb-4">¿Qué hacemos?</h1>
                <div class="row" id="networking">
                    <div class="col-lg-5 col-md-6 p-md-4">
                        <img class="img-fluid d-block" src="img/networking.jpg" width="1500">
                    </div>
                    <div class="col-md-6 offset-lg-1 d-flex flex-column justify-content-center py-4">
                        <h2 class="my-3"><b>Networking</b></h2>
                        <p class="lead">Un espacio para crea conexiones de valor con otros emprendedores, compartir tus experiencias y aprender de los demás.</p>
                        <p class="lead"><a href="/6ta-natillada-networking" class="btn btn-danger btn-lg animated infinite flash"><i class="fa fa-user fa-fw"></i> <b>Regístrate para asistir</b></a></p>
                    </div>
                </div>
                <div class="row" id="learning">
                    <div class="col-md-6 d-flex flex-column justify-content-center order-2 order-md-1 py-4">
                        <h2 class="my-3"><b>Escuela De Emprendedores</b></h2>
                        <p class="lead">Hemos creado esta escuela pensando en fortalecer las habilidades para administrar tu negocio, con el propósito de estrechar nuestros lazos y transformar nuestras debilidades en oportunidades.</p>
                        <p class="lead"><a href="/3ra-escuela-pitch-lanzate-a-la-accion" class="btn btn-primary btn-lg"><i class="fas fa-graduation-cap"></i> <b>Abiertas inscripciones</b></a></p>

                    </div>
                    <div class="col-lg-5 col-md-6 p-md-4 offset-lg-1 order-1 order-md-2">
                        <img class="img-fluid d-block" src="img/learning-school.jpg" width="1500">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Testimonios -->
<div id="testimonio" class="py-5" style="background-image: url(img/fondo-testimonio.jpg); background-position: right bottom;  background-size: cover; background-repeat: repeat; background-attachment: fixed;">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="text-center mb-4 text-primary">Testimonio</h1>
            </div>
        </div>
        <div class="row">
            <div id="carouselExampleControls" class="carousel slide carousel-fade" data-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="row">
                            <div class="ml-auto p-3 col-md-2 bg-white">
                                <img class="img-fluid d-block rounded-circle" src="img/claudia.jpg">
                            </div>
                            <div class="py-3 col-md-7 mr-auto bg-white text-dark">
                                <div class="blockquote mb-0 text-secondary px-3">
                                    <p class="">"Compartir con más emprendedores y escuchar de ellos que vale la pena apostarle a nuestras ideas, planear, y trabajar en ellas, me ha confirmado que estamos en el camino correcto, y que cada día hay aprendizajes que nos van a ayudar en el proceso. Ha sido muy enriquecedora la experiencia."</p>
                                    <div class="blockquote-footer"> <b>Claudia Vasquez</b>, Co-Fundadora de Bocado Express.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="row">
                            <div class="ml-auto p-3 col-md-2 bg-white">
                                <img class="img-fluid d-block rounded-circle" src="img/alex-y-carolina.jpg">
                            </div>
                            <div class="py-3 col-md-7 mr-auto bg-white text-dark">
                                <div class="blockquote mb-0 text-secondary px-3">
                                    <p class="">"Ha sido muy grato registrarnos, pues nos ha supuesto una actualización en cuanto a actividades para emprendedores, conferencias, capacitaciones y eventos de networking. Concordamos sobre la importancia de conocer otros emprendedores y aprender de ellos; creando una comunidad fuerte que permita intercambiar experiencias, evitando asi cometer los errores que puedan hacer daño a nuestro emprendimiento y crecimiento."</p>
                                    <div class="blockquote-footer"> <b>Alexander Cano & Carolina Marín</b>, Fundadores Vainilla Scrap.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Anterior</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Siguiente</span>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="p-3 col-md-12 text-center">
                <a class="btn btn-danger btn-lg" href="/#registro"><i class="fa fa-user fa-fw"></i> Regístrate</a>
            </div>
        </div>
    </div>
</div>