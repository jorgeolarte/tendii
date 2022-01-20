<?php
class Productos_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    /**
     * Contar los resultados
     */
    public function count_productos($id_emprendedor = null, $id_categoria = null, $termino = null, $id_ciudad = null)
    {
        if (!is_null($id_ciudad)) {
            // Consulta emprendedores por ciudad
            $this->db->distinct()
                ->select('e.id_emprendedor')
                ->from('emprendedores_ciudad AS e')
                ->where('e.id_ciudad = ', $id_ciudad);
            $queryEmprendedores = $this->db->get_compiled_select();
        }

        $this->db->from('productos AS p');
        $this->db->join('emprendedores AS e', 'p.id_emprendedor = e.id');
        $this->db->join('categorias AS c', 'p.id_categoria = c.id');
        $this->db->join('ciudades AS x', 'e.id_ciudad = x.id');

        // Validar si viene el id del emprendedor
        if (!is_null($id_emprendedor)) {
            // Consulto por el id del emprendedor
            $this->db->where('p.id_emprendedor =', $id_emprendedor);
        }
        // Validar si viene el id de la categoria
        if (!is_null($id_categoria)) {
            // Consulto por el id de la categoria
            $this->db->where('p.id_categoria =', $id_categoria);
        }
        // Validar si viene la ciudad
        if (!is_null($id_ciudad)) {
            // Consulto por el id de la ciudad
            //$this->db->where('x.id =', $id_ciudad);
            // Productos de los emprendedores en la ciudad
            $this->db->where_in('p.id_emprendedor', $queryEmprendedores, false);
        }
        // Validar si viene el termino de busqueda
        if (!is_null($termino)) {
            $this->db->group_start();
            // Columnas por las cuales se desea filter
            $this->db->like('p.nombre', $termino);
            $this->db->or_like('p.descripcion', $termino);
            $this->db->group_end();
        }
        // Productos que esten activos
        $this->db->where('p.estado =', 1);
        // Devolver los resultados
        return $this->db->count_all_results();
    }

    public function get_productos_emprendedor_ciudad($id_categoria, $id_ciudad, $pagina = 1, $limite = 25)
    {
        // Consulta emprendedores por ciudad
        $this->db->distinct()
            ->select('e.id_emprendedor')
            ->from('emprendedores_ciudad AS e')
            ->where('e.id_ciudad = ', $id_ciudad);
        $queryEmprendedores = $this->db->get_compiled_select();

        // Columnas a consultar
        $this->db->select('e.id as id_emprendedor, 
            e.emprendimiento as emprendimiento,
            e.logo as logo,
            e.slug as slug,
            p.id as id_producto,
            p.nombre as producto,
            p.imagen as imagen,
            p.descripcion as descripcion,
            p.precio as precio,
            c.id as id_categoria,
            c.nombre as categoria,
            c.icon as icon');
        $this->db->from('productos AS p');
        $this->db->join('emprendedores AS e', 'p.id_emprendedor = e.id');
        $this->db->join('categorias AS c', 'p.id_categoria = c.id');
        // Productos que esten activos
        $this->db->where('p.estado =', 1);
        // De la categoria
        $this->db->where('p.id_categoria =', $id_categoria);
        // Ordenar descendentemente por la fecha que se toma
        $this->db->order_by('p.fecha_creacion', 'DESC');
        // Productos de los emprendedores en la ciudad
        $this->db->where_in('p.id_emprendedor', $queryEmprendedores, false);
        // Limitar la cantidad de resultados de busqueda
        $this->db->limit($limite, $pagina);
        // Realizar consulta
        $query = $this->db->get();

        // Devolver los resultados
        return $query->result_array();
    }

    /**
     * Consulta los productos de la tienda
     */
    public function get_productos($id_emprendedor = null, $id_categoria = null, $termino = null, $id_ciudad = null, $pagina = 1, $limite = 25)
    {
        if (!is_null($id_ciudad)) {
            // Consulta emprendedores por ciudad
            $this->db->distinct()
                ->select('e.id_emprendedor')
                ->from('emprendedores_ciudad AS e')
                ->where('e.id_ciudad = ', $id_ciudad);
            $queryEmprendedores = $this->db->get_compiled_select();
        }

        // Columnas a consultar
        $this->db->select('e.id as id_emprendedor, 
            e.emprendimiento as emprendimiento,
            e.logo as logo,
            e.slug as slug,
            p.id as id_producto,
            p.nombre as producto,
            p.imagen as imagen,
            p.descripcion as descripcion,
            p.precio as precio,
            c.id as id_categoria,
            c.nombre as categoria,
            c.icon as icon');
        $this->db->from('productos AS p');
        $this->db->join('emprendedores AS e', 'p.id_emprendedor = e.id');
        $this->db->join('categorias AS c', 'p.id_categoria = c.id');
        //$this->db->join('ciudades AS x', 'e.id_ciudad = x.id');

        // Validar si viene el id del emprendedor
        if (!is_null($id_emprendedor)) {
            // Consulto por el id del emprendedor
            $this->db->where('p.id_emprendedor =', $id_emprendedor);
        }
        // Validar si viene el id de la categoria
        if (!is_null($id_categoria)) {
            // Consulto por el id de la categoria
            $this->db->where('p.id_categoria =', $id_categoria);
        }
        // Validar si viene la ciudad
        if (!is_null($id_ciudad)) {
            // Consulto por el id de la ciudad
            //$this->db->where('x.id =', $id_ciudad);
            // Productos de los emprendedores en la ciudad
            $this->db->where_in('p.id_emprendedor', $queryEmprendedores, false);
        }
        // Validar si viene el termino de busqueda
        if (!is_null($termino)) {
            $this->db->group_start();
            // Columnas por las cuales se desea filter
            $this->db->like('p.nombre', $termino);
            $this->db->or_like('p.descripcion', $termino);
            $this->db->or_like('e.nombre', $termino);
            $this->db->or_like('c.nombre', $termino);
            $this->db->group_end();
        }
        // Productos que esten activos
        $this->db->where('p.estado =', 1);
        // Ordenar descendentemente por la fecha que se toma
        $this->db->order_by('p.fecha_creacion', 'DESC');
        // Limitar la cantidad de resultados de busqueda
        $this->db->limit($limite, $pagina * $limite);
        // Realizar consulta
        $query = $this->db->get();

        // Devolver los resultados
        return $query->result_array();
    }

    /**
     * Consultar la categoria
     */
    public function get_categoria($data)
    {
        // Consulta las compras
        $query = $this->db->get_where('categorias', $data);
        // Retornar la consulta
        return $query->row_array();
    }

    public function get_categorias_emprendedor()
    {
        // Consulta las compras
        $query = $this->db->get('categorias');
        // Retornar la consulta
        return $query->result_array();
    }

    /**
     * Consulta las categorias
     */
    public function get_categorias($estado = null)
    {
        if (!is_null($this->session->userdata('ciudad')['id'])) {
            // Consulta emprendedores por ciudad
            $this->db->distinct()
                ->select('e.id_emprendedor')
                ->from('emprendedores_ciudad AS e')
                ->where('e.id_ciudad = ', $this->session->userdata('ciudad')['id']);
            $queryEmprendedores = $this->db->get_compiled_select();
        }

        $this->db->select('c.id,
            c.nombre,
            c.descripcion,
            c.icon,
            c.slug,
            count(p.id) as cantidad');
        $this->db->from('categorias AS c');
        $this->db->join('productos AS p', 'p.id_categoria = c.id', 'left');
        $this->db->join('emprendedores AS e', 'p.id_emprendedor = e.id');
        //$this->db->join('ciudades AS x', 'e.id_ciudad = x.id');

        // Se envio el parametro
        if (!is_null($estado)) {
            // Productos activos
            $this->db->where('p.estado', $estado);
        }
        
        //$this->db->where('x.slug', $this->session->userdata('ciudad')['slug']);

        // Validar si viene la ciudad
        if (!is_null($this->session->userdata('ciudad')['id'])) {
            // Consulto por el id de la ciudad
            //$this->db->where('x.id =', $id_ciudad);
            // Productos de los emprendedores en la ciudad
            $this->db->where_in('p.id_emprendedor', $queryEmprendedores, false);
        }

        // Agrupar los resultados
        $this->db->group_by(array('c.id', 'c.nombre', 'c.descripcion', 'c.icon'));
        // Ordenar descendentemente por la fecha que se toma
        $query = $this->db->order_by('c.orden', 'ASC');
        // Realizar consulta
        $query = $this->db->get();
        // Retornar la consulta
        return $query->result_array();
    }

    /**
     * Consulta las categorias
     */
    public function get_categorias_aleatorias($cantidad = null)
    {
        $this->db->select('c.id,
            c.nombre,
            c.descripcion,
            c.icon,
            c.slug,
            count(p.id) as cantidad');
        $this->db->from('categorias AS c');
        $this->db->join('productos AS p', 'p.id_categoria = c.id', 'left');
        $this->db->join('emprendedores AS e', 'p.id_emprendedor = e.id');
        $this->db->join('ciudades AS x', 'e.id_ciudad = x.id');
        // Productos activos
        $this->db->where('p.estado', '1');
        $this->db->where('x.slug', $this->session->userdata('ciudad')['slug']);
        // Agrupar los resultados
        $this->db->group_by(array('c.id', 'c.nombre', 'c.descripcion', 'c.icon'));
        // Ordenar descendentemente por la fecha que se toma
        $this->db->order_by('c.orden', 'RANDOM');
        // Limite
        $this->db->limit($cantidad);
        // Realizar consulta
        $query = $this->db->get();
        // Retornar la consulta
        return $query->result_array();
    }

    /**
     * Obtiene los productos
     */
    public function get($data)
    {
        // Consulta las compras
        $query = $this->db->get_where('productos', $data);
        // Retornar la consulta
        return $query->row_array();
    }

    /**
     * Inserta un nuevo product
     */
    public function insertar($data)
    {
        // Insrtar un cliente
        return $this->db->insert('productos', $data);
    }

    /**
     * 'Elimina' el producto de la BD
     */
    public function borrar($data)
    {
        // El id de la compra
        $this->db->where('id', $data['id']);
        // Eliminar dato del array
        unset($data['id']);
        // Ejecutar la actualizacion
        return $this->db->update('productos', $data);
    }

    public function generar_cookie($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function buscar($termino)
    {
        // Tabla a buscar
        $this->db->from('productos');
        // Columnas por las cuales se desea filter
        $this->db->like('nombre', $termino);
        $this->db->or_like('descripcion', $termino);
        // Realizar la consulta
        $query = $this->db->get();
        // Retornar resultados
        return $query->result_array();
    }

    /**
     * Actualiza el producto
     */
    public function actualizar($id, $data)
    {
        // Actualiza el producto
        return $this->db
            ->where('id', $id)
            ->update('productos', $data);
    }
}
