<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Whatsapp extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('notificaciones_model');
    }
    
    public function index()
    {
        // Documento a cargar es XML
        //header("Content-Type: text/xml");
        //$this->load->library('simplexml');
        $mensaje = '<?xml version="1.0" encoding="UTF-8"?>';
        $mensaje .= '<Response>';
        $mensaje .= '<Message>';
        $mensaje .= '<Body>Hello World</Body>';
        $mensaje .= '</Message>';
        $mensaje .= '</Response>';

        echo $mensaje;
        // Lanzar la vista
        //$this->load->view('tienda/whatsapp');
    }

    public function enviar()
    {
        // $nombre = "Olga Janeth Duque";
        // $telefono =	"3166175813";

        // $nombre ="Luis Carlos Vasquez";
        // $telefono =	"3219586374";

        $nombre ="Jorge Olarte";
        $telefono = "3017516045";

        // $nombre ="Andrea Paola Salazar Morales";
        // $telefono = "3176720946";

        // $nombre ="Tatiana Sánchez";
        // $telefono = "3505356635";

        // $nombre ="Carolina ríos Arango";
        // $telefono = "3164622165";

        // $mensaje = '_¡Felicitaciones ' . $nombre . '!_  ' . chr(10) . chr(10) ;
        // $mensaje .= 'Has activado el servicio de notificaciones de la _Tienda De Emprendedores_. *#JuntosSomosMasFuertes* 💪🤓';

        $mensaje = 'Your *nuevo pedido* code is *ingresa 👉 _' . site_url('') . '_ 👈 para conocer los detalles de tu pedido*';

        $this->notificaciones_model->whatsapp($telefono, $mensaje);
    }

    public function sendinblue()
    {
        $this->notificaciones_model->email_cliente();
    }
}
