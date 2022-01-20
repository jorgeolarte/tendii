<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('get_categorias()')) {
    function get_categorias()
    {
        // Get a reference to the controller object
        $CI = get_instance();
        // You may need to load the model if it hasn't been pre-loaded
        $CI->load->model('productos_model');
        // Pasar consulta
        $categorias = $CI->productos_model->get_categorias('1');
        // Imprimir detalles
        return $categorias;
    }
}


if (!function_exists('get_categorias_aleatorias()')) {
    function get_categorias_aleatorias()
    {
        // Get a reference to the controller object
        $CI = get_instance();
        // You may need to load the model if it hasn't been pre-loaded
        $CI->load->model('productos_model');
        // Pasar consulta
        $categorias = $CI->productos_model->get_categorias_aleatorias(5);
        // Imprimir detalles
        return $categorias;
    }
}

if (!function_exists('get_productos_categoria()')) {
    function get_productos_categoria($id_categoria)
    {
        // Get a reference to the controller object
        $CI = get_instance();
        // You may need to load the model if it hasn't been pre-loaded
        $CI->load->model('productos_model');
        // Pasar consulta
        $productos = $CI->productos_model->get_productos(null, $id_categoria, null, $this->session->userdata('ciudad'), 0, 6);
        // Imprimir detalles
        return $productos;
    }
}