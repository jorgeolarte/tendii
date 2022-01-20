<?php
class Eventos_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function get_eventos($slug = FALSE)
    {
        if ($slug === FALSE) {
            $query = $this->db->get('eventos');
            return $query->result_array();
        }

        $query = $this->db->get_where('eventos', array('slug' => $slug));
        return $query->row_array();
    }
}
