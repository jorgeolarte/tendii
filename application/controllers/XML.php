<?php
defined('BASEPATH') or exit('No direct script access allowed');

class XML extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('productos_model');
    }

    /**
     * Muestra todos los productos en formato XML
     */
    public function productos($slug)
    {
        // Transferir a la vista
        $data['ciudad'] = $slug;
        // Consultar los productos
        $data['productos'] = $this->productos_model->get_productos(null, null, null, $slug, 0, 100);
        // Documento a cargar es XML
        header("Content-Type: text/xml");
        // Lanzar la vista
        $this->load->view('tienda/productos', $data);
    }
}
