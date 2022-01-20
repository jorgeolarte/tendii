<?php
class Compras_model extends CI_Model
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
        return $this->db->insert('compras', $data);
    }

    /**
     * Actualiza la cantidad de productos en el carrito de compra
     */
    public function actualizar($data)
    {
        // El id de la compra
        $this->db->where('id', $data['id']);
        // Eliminar dato del array
        unset($data['id']);
        // Ejecutar la actualizacion
        return $this->db->update('compras', $data);
    }

    /**
     * Obtiene las compras
     */
    public function get($data)
    {
        // Consulta las compras
        $query = $this->db->get_where('compras', $data);
        // Retornar la consulta
        return $query->result_array();
    }

    /**
     * Inserta detalle de compra
     */
    public function insertar_detalle($data)
    {
        // Insertar un cliente
        return $this->db->insert('compras_detalle', $data);
    }

    /**
     * Actualiza la cantidad de productos en el carrito de compra
     */
    public function actualizar_detalle($data)
    {
        // Ejecutar la actualizacion
        return $this->db->replace('compras_detalle', $data);
    }

    /**
     * Obtiene los detalles de la compra
     */
    public function get_detalle($data)
    {
        // Consulta las compras
        $query = $this->db->get_where('compras_detalle', $data);
        // Retornar la consulta
        return $query->row_array();
    }

    /**
     * Obtiene los detalles de la compra
     */
    public function get_detalles($data)
    {
        // Columnas a consultar
        $this->db->select('d.id,
            d.id_compra,
            d.id_cliente,
            d.id_emprendedor,
            d.id_producto,
            d.cantidad,
            d.valor_unitario,
            d.subtotal,
            d.estado,
            d.fecha_creacion,
            d.fecha_modificacion
        ');
        $this->db->from('compras_detalle AS d');
        $this->db->join('emprendedores AS e', 'd.id_emprendedor = e.id');
        // Validar si quiero consultar el cliente
        if (isset($data['id_cliente'])) {
            // Productos del cliente
            $this->db->where('d.id_cliente =', $data['id_cliente']);
        }
        if (isset($data['id_compra'])) {
            // Productos del cliente
            $this->db->where('d.id_compra =', $data['id_compra']);
        }
        if (!is_null($data['id_ciudad'])) {
            // Desde que exista la ciudad
            $this->db->where('d.id_ciudad =', $data['id_ciudad']);
        }
        if (!is_null($data['id_pais'])) {
            // Desde que exista la ciudad
            $this->db->where('d.id_pais =', $data['id_pais']);
        }
        // Productos activos
        $this->db->where('d.estado = ', $data['estado']);
        // Realizar consulta
        $query = $this->db->get();
        // Devolver los resultados
        return $query->result_array();
    }

    /**
     * Consulta los pedidos recibidos
     */
    public function get_pedidos($id_emprendedor)
    {
        // Solo una compra
        $this->db->distinct();
        // Columnas a consultar
        $this->db->select('c.id,
            c.id_cliente,
            c.total,
            c.estado,
            c.fecha_creacion,
            c.fecha_compra
            ');
        $this->db->from('compras AS c');
        $this->db->join('compras_detalle AS d', 'd.id_compra = c.id');
        // Productos de la ciudad
        $this->db->where('d.id_emprendedor =', $id_emprendedor);
        $this->db->where('d.estado =', '2');
        $this->db->where('c.estado =', '2');
        // Realizar consulta
        $query = $this->db->get();
        // Devolver los resultados
        return $query->result_array();
    }

    public function get_pedido_cliente($id_emprendedor)
    {
        // Solo una compra
        $this->db->distinct();
        // Columnas a consultar
        $this->db->select('c.id as id_compra,
            d.id_cliente AS id_cliente,
            x.nombres as cliente,
            x.telefono as telefono,
            z.nombre as ciudad,
            w.direccion as direccion,
            w.barrio as barrio,
            w.observaciones as observaciones,
            x.fecha_creacion');
        $this->db->from('compras AS c');
        $this->db->join('compras_detalle AS d', 'd.id_compra = c.id');
        $this->db->join('productos AS p', 'd.id_producto = p.id');
        $this->db->join('clientes AS x', 'd.id_cliente = x.id');
        $this->db->join('direcciones AS w', 'w.id_cliente = x.id');
        $this->db->join('ciudades AS z', 'w.id_ciudad = z.id');
        // Productos de la ciudad
        $this->db->where('d.id_emprendedor =', $id_emprendedor);
        $this->db->where('d.estado =', '2');
        $this->db->where('c.estado =', '2');
        $this->db->order_by('x.fecha_creacion');
        // Realizar consulta
        $query = $this->db->get();
        // Devolver los resultados
        return $query->result_array();
    }

    public function get_cliente($id_compra)
    {
        // Solo una compra
        $this->db->distinct();
        // Columnas a consultar
        $this->db->select('c.id as id_compra,
            d.id_cliente AS id_cliente,
            x.nombres as cliente,
            x.telefono as telefono,
            w.direccion as direccion,
            w.barrio as barrio,
            z.nombre as ciudad,
            w.observaciones as observaciones,
            x.fecha_creacion');
        $this->db->from('compras AS c');
        $this->db->join('compras_detalle AS d', 'd.id_compra = c.id');
        $this->db->join('productos AS p', 'd.id_producto = p.id');
        $this->db->join('clientes AS x', 'd.id_cliente = x.id');
        $this->db->join('direcciones AS w', 'w.id_cliente = x.id');
        $this->db->join('ciudades AS z', 'w.id_ciudad = z.id');
        $this->db->where('d.id_compra =', $id_compra);
        $this->db->where('d.estado =', '2');
        $this->db->where('c.estado =', '2');
        $this->db->order_by('x.fecha_creacion');
        // Realizar consulta
        $query = $this->db->get();
        // Devolver los resultados
        return $query->row_array();
    }

    public function get_detalles_pedido($id_emprendedor, $id_compra)
    {
        // Columnas a consultar
        $this->db->select('c.id AS id_compra,
            d.id_cliente AS id_cliente,
            x.nombres as cliente,
            x.telefono as telefono,
            z.nombre as ciudad,
            w.direccion as direccion,
            w.barrio as barrio,
            w.observaciones as observaciones,
            d.id_producto AS id_producto,
            p.nombre as producto,
            d.cantidad as cantidad,
            d.valor_unitario as valor_unitario,
            d.subtotal as subtotal,
            d.fecha_modificacion as fecha_pedido
            ');
        $this->db->from('compras AS c');
        $this->db->join('compras_detalle AS d', 'd.id_compra = c.id');
        $this->db->join('productos AS p', 'd.id_producto = p.id');
        $this->db->join('clientes AS x', 'd.id_cliente = x.id');
        $this->db->join('direcciones AS w', 'w.id_cliente = x.id');
        $this->db->join('ciudades AS z', 'w.id_ciudad = z.id');
        // Productos de la ciudad
        $this->db->where('d.id_emprendedor =', $id_emprendedor);
        $this->db->where('d.id_compra =', $id_compra);
        $this->db->where('d.estado =', '2');
        $this->db->where('c.estado =', '2');
        // Realizar consulta
        $query = $this->db->get();
        // Devolver los resultados
        return $query->result_array();
    }

    /**
     * Devuelve la información del carrito
     */
    public function get_carrito($id_compra = null, $id_detalle = null, $id_emprendedor = null, $id_ciudad)
    {
        // Columnas a consultar
        $this->db->select('c.id as id_compra,
            total as total_compra,
            x.id as id_cliente,
            x.nombres as nombres_cliente,
            x.telefono as telefono_cliente,
            x.email as email_cliente,
            e.id as id_emprendedor,
            e.nombre as nombre_emprendedor,
            e.emprendimiento as emprendimiento_emprendedor,
            e.logo as logo_emprendedor,
            e.telefono as telefono_emprendedor,
            e.email as email_emprendedor,
            p.id as id_producto,
            p.nombre as nombre_producto,
            p.imagen as imagen_producto,
            p.descripcion as descripcion_producto,
            d.id as id_detalle,
            d.cantidad as cantidad_detalle,
            d.valor_unitario as valor_detalle,
            d.subtotal as subtotal_detalle,
            z.id as id_categoria,
            z.nombre as nombre_categoria
            ');
        $this->db->from('compras_detalle AS d');
        $this->db->join('compras AS c', 'd.id_compra = c.id');
        $this->db->join('clientes AS x', 'd.id_cliente = x.id');
        $this->db->join('emprendedores AS e', 'd.id_emprendedor = e.id');
        $this->db->join('productos AS p', 'd.id_producto = p.id');
        $this->db->join('categorias AS z', 'p.id_categoria = z.id');
        //$this->db->join('ciudades AS w', 'e.id_ciudad = w.id');
        // Validar si viene la compra
        if (!is_null($id_compra)) {
            // Productos del carrito
            $this->db->where('d.id_compra =', $id_compra);
        } else if (!is_null($id_detalle)) {
            // Detalle del carrito
            $this->db->where('d.id =', $id_detalle);
        }
        if (!is_null($id_emprendedor)) {
            // Detalle del carrito
            $this->db->where('d.id_emprendedor =', $id_emprendedor);
        }
        // if (!is_null($slug_ciudad)) {
        //     // Productos de la ciudad
        //     $this->db->where('w.slug =', $slug_ciudad);
        // }
        // Productos activos
        $this->db->where('d.estado =', '1');
        // Ordenar descendentemente por la fecha que se toma
        $this->db->order_by('d.fecha_creacion', 'DESC');
        // Realizar consulta
        $query = $this->db->get();
        // Devolver los resultados
        return $query->result_array();
    }

    /**
     * Devuelve la información del carrito
     */
    public function get_emprendedores($id_compra)
    {
        // Distinct
        $this->db->distinct();
        // Columnas a consultar
        $this->db->select('e.id,
            e.id_ciudad,
            e.id_pais,
            e.nombre,
            e.emprendimiento,
            e.logo,
            e.telefono,
            e.email,
            e.whatsapp
            ');
        $this->db->from('compras_detalle AS d');
        $this->db->join('compras AS c', 'd.id_compra = c.id');
        $this->db->join('emprendedores AS e', 'd.id_emprendedor = e.id');
        // $this->db->join('emprendedores_ciudad AS x', 'x.id_ciudad = e.id');
        // Productos del carrito
        $this->db->where('d.id_compra =', $id_compra);
        // Si se envio la ciudad
        // if (!is_null($this->session->userdata('ciudad'))) {
        //     // Productos de la ciudad
        //     $this->db->where('x.slug =', $this->session->userdata('ciudad'));
        // }
        // Productos activos
        $this->db->where('d.estado =', '1');
        // Realizar consulta
        $query = $this->db->get();
        // Devolver los resultados
        return $query->result_array();
    }

    /**
     * Eliminar producto carrito
     */
    public function borrar_detalle($id_detalle)
    {
        // Array para modificar el estado
        $update = array('estado' => '0');
        // Cual es el detalle que se va a desactivar
        $this->db->where('id', $id_detalle);
        // Realizar actualización
        return $this->db->update('compras_detalle', $update);
    }
}
