<?php
class Clientes_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function insertar($data)
    {
        // Insrtar un cliente
        return $this->db->insert('clientes', $data);
    }

    /**
     * Consulta el cliente de acuerdo al array pasado
     */
    public function get($data){
        $query = $this->db->get_where('clientes', $data);
        // Retornar la consulta
        return $query->row_array();
    }

    /**
     * Actualiza el usuario
     */
    public function actualizar($data){
        // El id de la compra
        $this->db->where('id', $data['id']);
        // Eliminar dato del array
        unset($data['id']);
        // Ejecutar la actualizacion
        return $this->db->update('clientes', $data);
    }

    /**
     * Inserta la direccion del usuario
     */
    public function insertar_direccion ($data){
        // Insrtar la direccion del cliente
        return $this->db->insert('direcciones', $data);
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
}
