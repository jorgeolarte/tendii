<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Controles extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        /* Incluye el modelo */
        $this->load->model('ciudades_model');
    }

    /**
     * Obtiene las ciudades por departamento
     */
    public function ciudades()
    {
        // Mandaron el id del departamento
        if ($this->input->post('id_departamento')) {
            // Obtener variables de los parametros
            $id_departamento = $this->input->post('id_departamento');
            $todos = $this->input->post('todos');

            // array a consultar
            $data = array(
                'id_departamento' => $id_departamento
            );

            // Consulta las ciudades
            $ciudades = ((bool)$todos) ? $this->ciudades_model->get_ciudades($data) : $this->ciudades_model->get_ciudades_departamento_activas($data);
            // Primer elemento del select            
            $select = '<option value="0">Ciudad</option>';
            // Recorrre las ciudades del departamento
            foreach ($ciudades as $pos => $ciudad) {
                $select .= '<option value="' . $ciudad['id'] . '">' . $ciudad['nombre'] . '</option>';
            }
            echo $select;
        } else {
            $select = '<option value="0">Ciudad</option>';
            echo $select;
        }
    }

    /**
     * Obtiene las ciudades por departamento
     */
    public function departamentos()
    {
        // Mandaron el id del departamento
        if ($this->input->post('iso')) {
            // Asignar a variable
            $iso = $this->input->post('iso');
            $todos = $this->input->post('todos');

            // Consultar el pais
            $pais = $this->ciudades_model->get_paises(array('ISO' => $iso));

            // array a consultar
            $data = array(
                'id_pais' => $pais[0]['id']
            );

            var_dump((bool)$todos);

            // Consulta los departamentos
            $departamentos = ((bool)$todos) ? $this->ciudades_model->get_departamentos($data) : $this->ciudades_model->get_departamentos_activos($data);
            //$departamentos = $this->ciudades_model->get_departamentos_activos($data);
            // Pinta inicio del select
            $select = '<option value="0">Departamento</option>';
            // Recorrre las ciudades del departamento
            foreach ($departamentos as $pos => $departamento) {
                $select .= '<option value="' . $departamento['id'] . '">' . $departamento['nombre'] . '</option>';
            }
            echo $select;
        } else {
            $select = '<option value="0">Departamento</option>';
            echo $select;
        }
    }

    public function ciudades_paises()
    {
        // Mandaron el id del departamento
        if ($this->input->post('id_pais')) {
            // array a consultar
            $data = array(
                'id_pais' => $this->input->post('id_pais')
            );
            // Consulta las ciudades
            $ciudades = $this->ciudades_model->get_ciudades($data);
            echo json_encode($ciudades);
        } else {
            echo json_encode('');
        }
    }
}
