<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pais extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        /* Incluye el modelo */
        $this->load->model('ciudades_model');
    }

    /**
     * Homologa el pais y redirecciona a la ciudad
     */
    public function redireccionar()
    {
        // Obtener el pais
        $iso2 = $this->input->post('iso2');
        // Validar si viene el pais
        $iso2 = is_null($iso2) ? 'CO' : $iso2;

        // Construyo el array de busqueda
        $data = array(
            'iso2' => $iso2
        );

        // Consulto los paises que tienen esa caracteristica
        $paises = $this->ciudades_model->get_paises($data);

        // Variable para almacenar la direccion de retorno
        $return_url = null;

        // El pais existe en nuestra base
        if (count($paises) > 0) {
            // Agrerga el pais a la session
            $this->session->unset_userdata('pais');
            $this->session->set_userdata('pais', $paises[0]);
            // Verificar si mando ciudad
            if (!is_null($this->input->post('ciudad'))) {
                // Consultar la ciudad
                $ciudades = $this->ciudades_model->get_like_ciudades($this->input->post('ciudad'));
                // Validar si la ciudad se encuentra activa
                if (count($ciudades) > 0) {
                    // Ciudad pertenece al pais
                    if ($ciudades[0]['id_pais'] == $paises[0]['id']) {
                        // Agrerga la ciudad a la session
                        $this->session->unset_userdata('ciudad');
                        $this->session->set_userdata('ciudad', $ciudades[0]);
                    } else {
                        // Cambio a la ciudad por defecto
                        $ciudad = ($paises[0]['ISO'] == 'CO') ? 'pereira' : 'santa-tecla';
                        // Consulto la ciudad por defecto
                        $defecto = $this->ciudades_model->get(array('slug' => $ciudad));
                        // Agrerga la ciudad
                        $this->session->unset_userdata('ciudad');
                        $this->session->set_userdata('ciudad', $defecto);
                    }
                } else {
                    // Cambio a la ciudad por defecto
                    $ciudad = ($paises[0]['ISO'] == 'CO') ? 'pereira' : 'santa-tecla';
                    // Consulto la ciudad por defecto
                    $defecto = $this->ciudades_model->get(array('slug' => $ciudad));
                    // Agrerga la ciudad
                    $this->session->unset_userdata('ciudad');
                    $this->session->set_userdata('ciudad', $defecto);
                }
            }

            // Retornar la URL del país
            $return_url = site_url($paises[0]['ISO'] . '/' . $this->session->userdata('ciudad')['slug']);
        } else {
            // Consultar el pais por defecto
            $pais = $this->ciudades_model->get_paises(array('ISO' => 'CO'));
            // Agrerga el pais
            $this->session->unset_userdata('pais');
            $this->session->set_userdata('pais', $pais[0]);
            // Consulto la ciudad por defecto
            $defecto = $this->ciudades_model->get(array('slug' => 'pereira'));
            // Agrerga la ciudad
            $this->session->unset_userdata('ciudad');
            $this->session->set_userdata('ciudad', $defecto);
            // Redirecciona 
            $return_url = site_url('CO' . '/' . $this->session->userdata('ciudad')['slug']);
        }

        // Si debo redireccionar donde dice el cliente
        if ((bool) $this->input->post('redirect')) {
            // Obtener la url del cliente
            echo $this->input->post('url');
        } else {
            // Redireccionar de acuerdo a lo que dijo el algoritmo
            echo $return_url;
        }
    }

    /**
     * Cambiar de ciudad
     */
    public function cambiar_ciudad()
    {
        // Pasa los parametros post a la validación
        $this->form_validation->set_data($this->input->post());
        // XSS filtro
        $params = $this->security->xss_clean($this->input->post());

        // Consulta la información de la ciudad
        $ciudad = $this->ciudades_model->get(array('id' => $params['ciudadCiudad']));
        // Consultar pais
        $pais = $this->ciudades_model->get_paises(array('id' => $ciudad['id_pais']));

        // Sobrescribo la sesión del pais
        $this->session->unset_userdata('pais');
        $this->session->set_userdata('pais', $pais[0]);
        // Sobrescribo la sesión de la ciudad
        $this->session->unset_userdata('ciudad');
        $this->session->set_userdata('ciudad', $ciudad);

        // Redirecciono a la página donde estaba
        redirect(site_url($pais[0]['ISO']));
    }

    /**
     * Cambiar de ciudad
     */
    public function cambiar_pais()
    {
        // Obtener el pais
        $iso = $this->uri->segment(1);
        $iso2 = "";
        // Validar si viene el pais
        switch ($iso) {
            case 'CO':
                $iso2 = 'COL';
                break;
            case 'SV':
                $iso2 = 'SLV';
                break;
            case null:
                $iso2 = 'COL';
                break;
        }

        // Variables a usar en la interfaz
        $data['iso'] = $iso;
        $data['iso2'] = $iso2;
        $data['title'] = 'Bienvenido';
        $data['descripcion'] = 'Tienda de Emprendedores';
        $data['keywords'] = 'tienda de emprendedores, compra, te llevamos a domicilio, quedate en casa';
        // Vista para cambiar de pais
        $this->load->view('tienda/cambiar-pais', $data);
    }
}
