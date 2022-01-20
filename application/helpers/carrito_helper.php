<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('contar()')) {
    function contar()
    {
        // Get a reference to the controller object
        $CI = get_instance();
        // You may need to load the model if it hasn't been pre-loaded
        $CI->load->model('clientes_model');
        $CI->load->model('compras_model');
        // 1 Consultar la cookie
        $cookie = $CI->session->userdata('cliente');

        // Valida si existe un valor
        if (isset($cookie['cookie'])) {
            // 1.1 traer el ID del cliente
            $cliente = $CI->clientes_model->get(array("cookie" => $cookie['cookie']));
            // Construir el query para consultar
            $query = array(
                'id_cliente' => $cliente['id'],
                //'ciudad' => $this->session->userdata('ciudad'),
                'id_pais' => $CI->session->userdata('pais')['id'],
                'id_ciudad' => NULL,
                //'pais' => NULL,
                'estado' => '1'
            );
            // Pasar consulta
            $detalles = $CI->compras_model->get_detalles($query);
            // Imprimir detalles
            return count($detalles);
        } else {
            return 0;
        }
    }
}

if (!function_exists('pedidos()')) {
    function pedidos()
    {
        // Get a reference to the controller object
        $CI = get_instance();
        // You may need to load the model if it hasn't been pre-loaded
        $CI->load->model('ciudades_model');
        $CI->load->model('compras_model');
        // 1 Consultar la cookie
        $emprendedor = $CI->session->get_userdata('emprendedor');
        // Valida si existe un valor
        if (isset($emprendedor['id'])) {
            // 1.1 traer el ID del cliente
            $ventas = $CI->compras_model->get_pedidos($emprendedor['id']);
            // Enviar
            return count($ventas);
        } else {
            // Retorna 0
            return 0;
        }
    }
}

if (!function_exists('contar_productos()')) {
    function contar_productos()
    {
        // Get a reference to the controller object
        $CI = get_instance();
        // You may need to load the model if it hasn't been pre-loaded
        $CI->load->model('productos_model');
        // Consultar los productos que pertenecen al emprendedor
        $productos = $CI->productos_model->get_productos($CI->session->userdata('cliente')['id'], null, null, null, 0, 25);
        // Retorna la cantidad de productos
        return count($productos);
    }
}
