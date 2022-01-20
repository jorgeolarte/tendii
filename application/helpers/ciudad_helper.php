<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

// if (!function_exists('$this->session->userdata('ciudad')')) {
//     function $this->session->userdata('ciudad')
//     {
//         // Get current CodeIgniter instance
//         $CI = &get_instance();
//         // We need to use $CI->session instead of $this->session
//         $ciudad = $CI->session->userdata('ciudad');
//         if (!isset($ciudad) || $ciudad == '') {
//             return null;
//         } else {
//             return $ciudad;
//         }
//     }
// }

// if (!function_exists('$this->session->userdata('pais')['ISO']')) {
//     function $this->session->userdata('pais')['ISO']
//     {
//         // Get current CodeIgniter instance
//         $CI = &get_instance();
//         // We need to use $CI->session instead of $this->session
//         $pais = $CI->session->userdata('pais');
//         if (!isset($pais) || $pais == '') {
//             return null;
//         } else {
//             return $pais;
//         }
//     }
// }

if (!function_exists('get_ciudades()')) {
    function get_ciudades()
    {
        // Get a reference to the controller object
        $CI = get_instance();
        // You may need to load the model if it hasn't been pre-loaded
        $CI->load->model('ciudades_model');
        // Pasar consulta
        $ciudades = $CI->ciudades_model->get_ciudades();
        // Imprimir detalles
        return $ciudades;
    }
}

if (!function_exists('get_ciudades_activas()')) {
    function get_ciudades_activas()
    {
        // Get a reference to the controller object
        $CI = get_instance();
        // You may need to load the model if it hasn't been pre-loaded
        $CI->load->model('ciudades_model');
        // Pasar consulta
        $ciudades = $CI->ciudades_model->get_ciudades_activas();
        // Imprimir detalles
        return $ciudades;
    }
}

if (!function_exists('get_ciudades_aleatorias()')) {
    function get_ciudades_aleatorias()
    {
        // Get a reference to the controller object
        $CI = get_instance();
        // You may need to load the model if it hasn't been pre-loaded
        $CI->load->model('ciudades_model');
        // Pasar consulta
        $ciudades = $CI->ciudades_model->get_ciudades_aleatorias(5);
        // Imprimir detalles
        return $ciudades;
    }
}

// if (!function_exists('get_bandera()')) {
//     function get_bandera()
//     {
//         // Get a reference to the controller object
//         $CI = get_instance();
//         // You may need to load the model if it hasn't been pre-loaded
//         $CI->load->model('ciudades_model');
//         // Obtener la ciudad de la sesión
//         $ciudad = $CI->session->userdata('ciudad');

//         // Validar si la ciudad pertenece
//         if (get_validar_ciudad()) {
//             // Preguntar si tiene ciudad
//             if (is_null($ciudad) || $ciudad == '') {
//                 return "sin-bandera.png";
//             } else {
//                 // Pasar consulta
//                 $bandera = $CI->ciudades_model->get_bandera($ciudad['slug']);
//                 // Imprimir detalles
//                 return $bandera;
//             }
//         }
//         else {
//             return "sin-bandera.png";
//         }
//     }
// }

// if (!function_exists('get_nombre_ciudad()')) {
//     function get_nombre_ciudad()
//     {
//         // Get a reference to the controller object
//         $CI = get_instance();
//         // You may need to load the model if it hasn't been pre-loaded
//         $CI->load->model('ciudades_model');
//         // Obtener la ciudad de la sesión
//         $ciudad = $CI->session->userdata('ciudad');

//         // Preguntar si tiene ciudad
//         if (is_null($ciudad) || $ciudad == '') {
//             return null;
//         } else {
//             // Pasar consulta
//             $nombre = $CI->ciudades_model->get_nombre($ciudad['slug']);
//             // Imprimir detalles
//             return $nombre;
//         }
//     }
// }

if (!function_exists('get_validar_ciudad()')) {
    function get_validar_ciudad()
    {
        // Get a reference to the controller object
        $CI = get_instance();
        // You may need to load the model if it hasn't been pre-loaded
        $CI->load->model('ciudades_model');
        // Obtener la ciudad de la sesión
        $ciudad = $CI->session->userdata('ciudad');
        $pais = $CI->session->userdata('pais');

        // Validar si la ciudad y el pais corresponden
        if ($CI->ciudades_model->get_validar_ciudad($pais['ISO'], $ciudad['slug']) == 0) {
            // No corresponde
            return false;
        } else {
            // La ciudad si pertenece al pais
            return true;
        }
    }
}

// if (!function_exists('get_bandera_pais()')) {
//     function get_bandera_pais()
//     {
//         // Get a reference to the controller object
//         $CI = get_instance();
//         // You may need to load the model if it hasn't been pre-loaded
//         $CI->load->model('ciudades_model');
//         // Obtener la ciudad de la sesión
//         $pais = $CI->session->userdata('pais');

//         // Preguntar si tiene ciudad
//         if (is_null($pais) || $pais == '') {
//             return "sin-bandera.png";
//         } else {
//             // Pasar consulta
//             $bandera = $CI->ciudades_model->get_bandera_pais($pais['ISO']);
//             // Imprimir detalles
//             return $bandera;
//         }
//     }
// }

// if (!function_exists('get_nombre_pais()')) {
//     function get_nombre_pais()
//     {
//         // Get a reference to the controller object
//         $CI = get_instance();
//         // You may need to load the model if it hasn't been pre-loaded
//         $CI->load->model('ciudades_model');
//         // Obtener la ciudad de la sesión
//         $pais = $CI->session->userdata('pais');

//         // Preguntar si tiene ciudad
//         if (is_null($pais) || $pais == '') {
//             return null;
//         } else {
//             // Pasar consulta
//             $nombre = $CI->ciudades_model->get_nombre_pais($pais['ISO']);
//             // Imprimir detalles
//             return $nombre;
//         }
//     }
// }
