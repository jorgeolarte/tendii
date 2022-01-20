<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('is_logged_in()')) {
    function is_logged_in() {
        // Get current CodeIgniter instance
        $CI =& get_instance();
        // We need to use $CI->session instead of $this->session
        $user = $CI->session->userdata('emprendedor');
        // Verifica si el usuario existe
        return (is_null($user)) ? false : true;
    }
}

