<?php
class Ciudades_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function get_departamentos($data = null)
    {
        $this->db->order_by('nombre', 'ASC');
        $query = $this->db->get_where('departamentos',$data);
        // Retornar la consulta
        return $query->result_array();
    }

    /**
     * Consultar los departamentos que estan activos
     */
    public function get_departamentos_activos($data = null)
    {
        // Solo una ciudad
        $this->db->distinct();
        // Columnas a consultar
        $this->db->select('d.id,
            d.id_pais,
            d.nombre,
            d.nombre');
        $this->db->from('emprendedores_ciudad AS e');
        $this->db->join('ciudades AS c', 'e.id_ciudad = c.id');
        $this->db->join('departamentos AS d', 'c.id_departamento = d.id');
        $this->db->join('productos AS p', 'p.id_emprendedor = e.id_emprendedor');

        // $this->db->join('ciudades AS c', 'c.id_departamento = d.id');
        // $this->db->join('emprendedores AS e', 'e.id_ciudad = c.id');
        // $this->db->join('productos AS p', 'p.id_emprendedor = e.id');

        // Productos que esten activos
        $this->db->where('p.estado =', '1');

        // Productos que esten activos
        $this->db->where('d.id_pais =', $data['id_pais']);

        // Ordendar las ciudades
        $this->db->order_by('d.nombre', 'ASC');
        // Realizar la consulta
        $query = $this->db->get();
        // Retornar la consulta
        return $query->result_array();
    }

    /**
     * Consulta las ciudades por departamentos que tienen productos
     */
    public function get_ciudades_departamento_activas($data = null)
    {
        // Solo una ciudad
        $this->db->distinct();
        // Columnas a consultar
        $this->db->select('c.id,
            c.nombre,
            c.slug,
            c.abr,
            c.bandera,
            c.orden,
            c.estado');
        $this->db->from('emprendedores_ciudad AS x');
        $this->db->join('ciudades AS c', 'c.id = x.id_ciudad');
        $this->db->join('productos AS p', 'p.id_emprendedor = x.id_emprendedor');
        // Productos que esten activos
        $this->db->where('p.estado =', '1');
        // Ciudades del departamento
        $this->db->where('c.id_departamento =', $data['id_departamento']);
        // Ordendar las ciudades
        $this->db->order_by('c.orden', 'ASC');
        // Realizar la consulta
        $query = $this->db->get();
        // Retornar la consulta
        return $query->result_array();
    }

    /**
     * Consulta el cliente de acuerdo al array pasado
     */
    public function get($data)
    {
        $query = $this->db->get_where('ciudades', $data);
        // Retornar la consulta
        return $query->row_array();
    }

    /**
     * Consulta el cliente de acuerdo al array pasado
     */
    public function get_ciudades($data = null)
    {
        $this->db->order_by('orden', 'ASC');
        $query = $this->db->get_where('ciudades', $data);
        // Retornar la consulta
        return $query->result_array();
    }

    /**
     * Consulta el cliente de acuerdo al array pasado
     */
    public function get_like_ciudades($ciudad)
    {
        // Solo una ciudad
        $this->db->distinct();
        // Columnas a consultar
        $this->db->select('c.id,
            c.id_pais,
            c.id_departamento,
            c.nombre,
            c.slug,
            c.abr,
            c.bandera,
            c.orden,
            c.estado');
        $this->db->from('ciudades AS c');
        $this->db->join('emprendedores AS e', 'e.id_ciudad = c.id');
        $this->db->join('productos AS p', 'p.id_emprendedor = e.id');
        // Ordendar las ciudades
        $this->db->order_by('c.orden', 'RANDOM');
        // Productos que esten activos
        $this->db->where('c.estado =', '1');
        // Que se parezca
        $this->db->like('c.nombre', $ciudad);
        // Realizar la consulta
        $query = $this->db->get();
        // Retornar la consulta
        return $query->result_array();
    }


    /**
     * Consulta los paises
     */
    public function get_paises($data = null)
    {
        $this->db->order_by('id', 'ASC');
        $query = $this->db->get_where('paises', $data);
        // Retornar la consulta
        return $query->result_array();
    }

    /**
     * Consulta el cliente de acuerdo al array pasado
     */
    public function get_ciudades_aleatorias($cantidad)
    {
        // Solo una ciudad
        $this->db->distinct();
        // Columnas a consultar
        $this->db->select('c.id,
            c.nombre,
            c.slug,
            c.abr,
            c.bandera,
            c.orden,
            c.estado');
        $this->db->from('ciudades AS c');
        $this->db->join('emprendedores AS e', 'e.id_ciudad = c.id');
        $this->db->join('productos AS p', 'p.id_emprendedor = e.id');
        // Ordendar las ciudades
        $this->db->order_by('c.orden', 'RANDOM');
        // Productos que esten activos
        $this->db->where('c.estado =', '1');
        // Limite
        $this->db->limit($cantidad);
        // Realizar la consulta
        $query = $this->db->get();
        // Retornar la consulta
        return $query->result_array();
    }

    public function get_bandera($slug)
    {
        // Consultar la ciudad
        $query = $this->db->get_where('ciudades', array('slug' => $slug));
        // Resultado
        $resultado = $query->row();
        // Retornar
        return $resultado->bandera;
    }

    public function get_bandera_pais($iso)
    {
        // Consultar la ciudad
        $query = $this->db->get_where('paises', array('ISO' => $iso));
        // Resultado
        $resultado = $query->row();
        // Retornar
        return $resultado->bandera;
    }

    /**
     * Valida si el pais pertenece a la ciudad
     */
    public function get_validar_ciudad($iso, $slug)
    {
        $this->db->from('ciudades AS c');
        $this->db->join('paises AS p', 'p.id = c.id_pais');
        // Consultar el pais
        $this->db->where('c.slug =', $slug);
        // Consultar el pais
        $this->db->where('p.ISO =', $iso);
        // Realizar la consulta
        $query = $this->db->get();
        // Retornar la consulta
        return $query->num_rows();
    }

    public function get_nombre($slug)
    {
        // Consultar la ciudad
        $query = $this->db->get_where('ciudades', array('slug' => $slug));
        // Resultado
        $resultado = $query->row();
        // Retornar
        return $resultado->nombre;
    }

    public function get_nombre_pais($iso)
    {
        // Consultar la ciudad
        $query = $this->db->get_where('paises', array('ISO' => $iso));
        // Resultado
        $resultado = $query->row();
        // Retornar
        return $resultado->nombre;
    }

    /**
     * Consulta el cliente de acuerdo al array pasado
     */
    public function get_ciudades_activas()
    {
        // Solo una ciudad
        $this->db->distinct();
        // Columnas a consultar
        $this->db->select('c.id,
            c.nombre,
            c.slug,
            c.abr,
            c.bandera,
            c.orden,
            c.estado');
        $this->db->from('ciudades AS c');
        $this->db->join('emprendedores AS e', 'e.id_ciudad = c.id');
        $this->db->join('productos AS p', 'p.id_emprendedor = e.id');
        $this->db->join('paises AS x', 'c.id_pais = x.id');
        // Ordendar las ciudades
        $this->db->order_by('c.orden', 'ASC');
        // Productos que esten activos
        $this->db->where('c.estado =', '1');
        // Productos que esten activos
        $this->db->where('x.ISO =', $this->session->userdata('pais')['ISO']);
        // Limite de resultados
        //$this->db->limit(5, 0);
        // Realizar la consulta
        $query = $this->db->get();
        // Retornar la consulta
        return $query->result_array();
    }
}
