<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Inicio extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('emprendedores_model');
    }

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     *	- or -
     * 		http://example.com/index.php/welcome/index
     *	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    public function index()
    {
        // Configuración de la página
        $data['title'] = 'Bienvenido';
        $data['descripcion'] = "Confiamos en las capacidades que tienen los emprendedores de ser los futuros empresarios de la ciudad";
        $data['keywords'] = "emprendedores, emprender, aprender, emprendimiento, emprendedores cartago, tienda de emprendedores, cartago, cartago valle del cauca";

        // Consulta la cantidad de emprendedores que existen
        $data['emprendedores'] = count($this->emprendedores_model->get_emprendedores());

        $this->_load_index($data);
    }

    public function no_encontrado()
    {
        $data['title'] = 'Página no encontrada';
        $data['descripcion'] = "404 - Página no encontrada";
        $data['keywords'] = "no encontrado, 404";
        $this->load->view('genericos/404', $data);
    }

    private function _load_index($data)
    {
        // Carga de página
        $this->load->view('templates/header', $data);
        $this->load->view('templates/navbar', $data);
        $this->load->view('inicio/index', $data);
        $this->load->view('templates/followus', $data);
        $this->load->view('templates/footer', $data);
    }

    /**
     * Carga la pagina de la feria
     */
    public function feria()
    {
        $data['title'] = 'Feria Virtual de Emprendimiento SENA Risaralda 2020';
        $data['descripcion'] = 'Nos encontramos actualizando nuestra plataforma';
        $data['keywords'] = 'tienda emprendedores, feria virtual, sena, risaralda, 2020';
        $this->load->view('tienda/feria', $data);
    }

    /**
     * Página de mantenimiento
     */
    public function mantenimiento()
    {
        $data['title'] = 'Mantenimiento';
        $data['descripcion'] = 'Nos encontramos actualizando nuestra plataforma';
        $data['keywords'] = 'tienda de emprendedores, compra, te llevamos a domicilio, quedate en casa';
        $this->load->view('tienda/mantenimiento', $data);
    }

    /**
     * Página que se carga mientras se define la ruta del cliente
     */
    public function cargando()
    {
        // Tiene la URL
        if (!is_null($this->input->get('url'))) {
            // Crea la URL para redireccionar
            $this->session->set_tempdata(array('redirectToCurrent' => $this->input->get('url')), 30);
        }

        $data['title'] = 'Bienvenido';
        $data['descripcion'] = 'Tienda de Emprendedores';
        $data['keywords'] = 'tienda de emprendedores, compra, te llevamos a domicilio, quedate en casa';
        $this->load->view('tienda/cargando', $data);
    }

    /**
     * Seleccionar el pais
     */
    public function pais()
    {
        // Consultar todas las ciudades
        $paises = $this->ciudades_model->get_paises();
        // Envair las ciudades a la vista
        $data['paises'] = $paises;

        $data['title'] = 'Bienvenido';
        $data['descripcion'] = 'Impacta con tu emprendimiento en la zona de influencia';
        $data['keywords'] = 'tendii, tienda de emprendedores';
        $this->load->view('tienda/pais', $data);
    }
}
