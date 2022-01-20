<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Eventos extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('eventos_model');
        $this->load->helper('url_helper');
    }

    public function index()
    {
        $data['eventos'] = $this->eventos_model->get_eventos();
        $data['nombre'] = 'News archive';

        $this->load->view('eventos/index', $data);
    }

    public function view($slug = NULL)
    {
        $data['eventos_item'] = $this->eventos_model->get_eventos($slug);

        if (empty($data['eventos_item'])) {
            show_404();
        }

        $data['title'] = $data['eventos_item']['nombre'];

        $this->load->view('eventos/view', $data);
    }
}
