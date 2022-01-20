<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Modelos de compras
        $this->load->model('emprendedores_model');
        $this->load->model('ciudades_model');
        $this->load->model('compras_model');
        $this->load->model('notificaciones_model');
        $this->load->model('productos_model');

        // Validar que esta logeado
        if (!is_logged_in()) {
            //redirect(site_url('login'));
            redirect(site_url('login?url=' . current_url()));
        }
    }
}
