<?php
class Emprendedores_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    /**
     * Inserta una nueva compra
     */
    public function insertar($data)
    {
        // Insertar un cliente
        $this->db->insert('emprendedores', $data);
        return $this->db->insert_id();
    }

    /**
     * Inserta una nueva compra
     */
    public function insertar_feria($data)
    {
        // Insertar un cliente
        $this->db->insert('feria_pereira', $data);
        return $this->db->insert_id();
    }

    /**
     * Cuenta si el emprendedor esta en la feria
     */
    public function emprendedor_feria($data)
    {
        // Consulta los emprendedores
        $query = $this->db->get_where('feria_pereira', $data);
        // Retornar la consulta
        return count($query->result_array());
    }


    /**
     * Metodo encargado de actualizar el emprendedor
     */
    public function actualizar($data)
    {
        // El id de la compra
        $this->db->where('id', $data['id']);
        // Eliminar dato del array
        unset($data['id']);
        // Ejecutar la actualizacion
        return $this->db->update('emprendedores', $data);
    }

    /**
     * Consulta el emprendedor
     */
    public function get($data)
    {
        // Consulta los emprendedores
        $query = $this->db->get_where('emprendedores', $data);
        // Retornar la consulta
        return $query->row_array();
    }

    /**
     * Validar si el emprendedor existe
     */
    public function validar($telefono, $email)
    {
        // Consulta el telefono
        $this->db->where('telefono', $telefono);
        $this->db->where('email', $email);
        $query = $this->db->get('emprendedores');
        // Retornar la consulta
        return $query->num_rows();
    }

    public function set_emprendedores()
    {
        $this->load->helper('url');

        $data = array(
            'nombre' => $this->input->post('nombre'),
            'emprendimiento' => $this->input->post('emprendimiento'),
            'telefono' => $this->input->post('telefono'),
            'email' => $this->input->post('email')
        );

        return $this->db->insert('emprendedores', $data);
    }



    public function get_emprendedores($telefono = FALSE)
    {
        if ($telefono === FALSE) {
            $query = $this->db->get('emprendedores');
            return $query->result_array();
        }

        $query = $this->db->get_where('emprendedores', array('telefono' => $telefono));
        return $query->row_array();
    }

    /**
     * Consulta las tiendas
     */
    public function get_tiendas($pagina)
    {
        // Columnas a consultar
        $this->db->select('e.id,
            e.nombre,
            e.descripcion,
            e.emprendimiento,
            e.logo,
            e.slug,
            e.telefono,
            e.whatsapp,
            e.email,
            e.hora_inicio,
            e.hora_cierre,
            count(d.id) as numero_ventas
        ');
        $this->db->from('emprendedores AS e');
        $this->db->join('emprendedores_ciudad AS c', 'c.id_emprendedor = e.id');
        $this->db->join('compras_detalle AS d', 'e.id = d.id_emprendedor and d.estado = "2"', 'left');
        $this->db->where('c.id_ciudad =', $this->session->userdata('ciudad')['id']);
        $this->db->where('e.slug is NOT NULL', NULL, false);
        //$this->db->where('d.estado = ', '2');
        $this->db->group_by('e.id,
            e.nombre,
            e.descripcion,
            e.emprendimiento,
            e.logo,
            e.slug,
            e.telefono,
            e.whatsapp,
            e.email,
            e.hora_inicio,
            e.hora_cierre
        ');
        $this->db->order_by('numero_ventas', 'DESC');
        // Limitar la cantidad de resultados de busqueda
        $this->db->limit(25, $pagina * 25);
        // Realizar consulta
        $query = $this->db->get();
        // Devolver los resultados
        return $query->result_array();
    }

    /**
     * Consulta las tiendas
     */
    public function get_count_tiendas()
    {
        // Columnas a consultar
        $this->db->select('e.id,
            e.nombre,
            e.descripcion,
            e.emprendimiento,
            e.logo,
            e.slug,
            e.telefono,
            e.whatsapp,
            e.email,
            e.hora_inicio,
            e.hora_cierre
        ');
        $this->db->from('emprendedores AS e');
        $this->db->join('emprendedores_ciudad AS c', 'c.id_emprendedor = e.id');
        $this->db->where('c.id_ciudad =', $this->session->userdata('ciudad')['id']);
        $this->db->where('e.slug is NOT NULL', NULL, false);
        $this->db->order_by('e.fecha_modificacion');
        // Devolver los resultados
        return $this->db->count_all_results();
    }

    /**
     * Consulta los emprendedores en la ciudad
     */
    public function emprendedores_ciudad($id_ciudad)
    {
        $query = $this->db->get_where('emprendedores_ciudad', array('id_ciudad' => $id_ciudad));
        return $query->result_array();
    }

    /**
     * Validar si el emprendedor ya tiene ciudad la ciudad cargada
     */
    public function validar_ciudad($id_emprendedor, $id_ciudad)
    {
        $query = $this->db->get_where(
            'emprendedores_ciudad',
            array(
                'id_emprendedor' => $id_emprendedor,
                'id_ciudad' => $id_ciudad
            )
        );
        return count($query->result_array());
    }

    /**
     * Consultar las ciudades de cobertura del emprendedor
     */
    public function ciudades_emprendedor($id_emprendedor)
    {
        // Columnas a consultar
        $this->db->select('e.id,
            c.nombre as ciudad,
            c.bandera as bandera,
            d.nombre as departamento
        ');
        $this->db->from('emprendedores_ciudad AS e');
        $this->db->join('ciudades AS c', 'c.id = e.id_ciudad');
        $this->db->join('departamentos AS d', 'd.id = c.id_departamento');
        $this->db->where('e.id_emprendedor =', $id_emprendedor);
        $this->db->order_by('d.codigo, c.orden', 'ASC');
        // Realizar consulta
        $query = $this->db->get();
        // Devolver los resultados
        return $query->result_array();
    }

    /**
     * Inserta ciudad
     */
    public function insertar_ciudad($data)
    {
        // Insertar un cliente
        return $this->db->insert('emprendedores_ciudad', $data);
    }

    /**
     * Elimina la ciudad
     */
    public function eliminar_ciudad ($id)
    {
        // El id de la compra
        $this->db->where('id', $id);
        // Ejecutar la actualizacion
        return $this->db->delete('emprendedores_ciudad');
    }
}
