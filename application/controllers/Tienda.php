<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tienda extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        /* Habilita las cookies */
        $this->load->helper('cookie');
        $this->load->helper('html');
        //$this->load->helper('carrito');
        $this->load->library('pagination');

        /* Incluye el modelo */
        $this->load->model('emprendedores_model');
        $this->load->model('ciudades_model');
        $this->load->model('clientes_model');
        $this->load->model('productos_model');

        // Validar si existe el cliente
        if (is_null($this->session->userdata('cliente')['cookie'])) {
            // Generar el codigo del cliente
            $codigo = $this->clientes_model->generar_cookie();
            // Construye el array del usuario
            $cliente = array(
                'cookie' => $codigo,
                'ciudad' => '',
                'pais' => '',
            );
            $this->session->set_userdata('cliente', $cliente);
            // Crear el array para insertar el cliente
            $cliente = array(
                'cookie' => $cliente['cookie'],
                'nombres' => NULL,
                'telefono' => NULL,
                'email' => NULL
            );
            // Guardar el cliente temporal
            $this->clientes_model->insertar($cliente);
        }
    }

    /**
     * Nuevo index
     * Carga los productos por ciudades de impacto
     */
    public function nuevo_index()
    {
        echo "<pre>";
        var_dump($this->uri->segment(2));
        die;

        // Obtener el pais
        $iso = $this->uri->segment(1);
        // Validar si viene el pais
        $iso = is_null($iso) ? 'CO' : $iso;

        // El pais es el mismo que esta en la sesión?
        if ((empty($this->session->userdata('pais')))) {
            // Consultar el pais
            $pais = $this->ciudades_model->get_paises(array('ISO' => $iso));
            // Agrerga el pais
            $this->session->set_userdata('pais', $pais[0]);
        }

        // Si proviene de otro pais
        if (($this->session->userdata('pais')['ISO'] != $iso)) {
            // Consultar el pais
            $pais = $this->ciudades_model->get_paises(array('ISO' => $iso));
            // Agrerga el pais
            $this->session->unset_userdata('pais');
            $this->session->set_userdata('pais', $pais[0]);
            // La ciudad es del mismo pais
            if ($this->session->userdata('ciudad')['id_pais'] != $this->session->userdata('pais')['id']) {
                // Cambio a la ciudad por defecto
                $ciudad = ($iso == 'CO') ? 'pereira' : 'santa-tecla';
                // Consulto la ciudad por defecto
                $defecto = $this->ciudades_model->get(array('slug' => $ciudad));
                // Agrerga la ciudad
                $this->session->set_userdata('ciudad', $defecto);
            }
        }

        // 1. Verifica la ciudad donde se encuentra
        if ((empty($this->session->userdata('ciudad')))) {
            // Si no existe es porque no ha sido creada
            // Ciudad por defecto de acuerdo al pais
            $ciudad = ($iso == 'CO') ? 'pereira' : 'santa-tecla';
            // Consulto la ciudad por defecto
            $defecto = $this->ciudades_model->get(array('slug' => $ciudad));
            // Agrerga la ciudad
            $this->session->set_userdata('ciudad', $defecto);
        }

        // Consultar las categorias activas
        $categorias = $this->productos_model->get_categorias(1);

        // Consultar los productos por categoria
        foreach ($categorias as $pos => $categoria) {
            // Consulta los productos por categoria
            $producto = $this->productos_model->get_productos_emprendedor_ciudad($categoria['id'], $this->session->userdata('ciudad')['id'], 0, 10);
            // echo "<pre>";
            // var_dump($producto);
            // die;

            // Agrega los productos al array
            $categorias[$pos]['productos'] = $producto;
        }

        // Categorias y productos
        $data['categorias'] = $categorias;

        // Tiendas destacadas
        $data['tiendas'] = $this->emprendedores_model->get_tiendas(0);

        /* Pintar las meta */
        $data['title'] = 'Bienvenido';
        $data['descripcion'] = 'La tienda donde compras y apoyas a los emprendedores';
        $data['keywords'] = 'domicilios, tienda de emprendedores, emprendedores';

        // Carga de página
        $this->load->view('tienda/index', $data);
    }

    /**
     * Metodo encargado de pintar el index
     */
    public function categoria($slug_categoria, $pagina = 1)
    {
        // Obtener el pais
        $iso = $this->uri->segment(1);
        // Validar si viene el pais
        $iso = is_null($iso) ? 'CO' : $iso;
        // Si no viene la ciudad
        if ((is_null($this->session->userdata('pais')['ISO'])) || ($this->session->userdata('pais')['ISO'] != $iso)) {
            // Consultar el pais
            $pais = $this->ciudades_model->get_paises(array('ISO' => $iso));
            // Agrerga el pais
            $this->session->set_userdata('pais', $pais[0]);
        }

        // Si no viene la ciudad
        // if ((is_null($this->session->userdata('ciudad'))) || ($this->session->userdata('ciudad') != $slug_ciudad)) {
        //     // Agrerga la ciudad
        //     $this->session->set_userdata('ciudad', $slug_ciudad);
        // }

        // Consultar la categoria
        $categoria = $this->productos_model->get_categoria(array('slug' => $slug_categoria));

        // Correción de la paginación
        $pagina--;

        // Consulto todos productos
        $data['productos'] = $this->productos_model->get_productos(null, $categoria['id'], null, $this->session->userdata('ciudad')['id'], $pagina);
        // Cantidad de productos
        $total_productos = $this->productos_model->count_productos(null, $categoria['id'], null, $this->session->userdata('ciudad')['id']);
        // Consultar las categorias activas
        $data['categorias'] = $this->productos_model->get_categorias(1);
        $data['categoria'] = $categoria;


        // Configurar la paginacion
        $config['base_url'] = site_url("{$this->session->userdata('pais')['ISO']}/{$slug_categoria}");
        $config['uri_segement'] = 3;
        $config['per_page'] = 25;
        $config['use_page_numbers'] = TRUE;
        $config['total_rows'] = $total_productos;
        $config['first_link'] = 'Inicio';
        $config['last_link'] = 'Final';

        // Pagination bootstrap
        $config['attributes'] = array('class' => 'page-link');
        $config['full_tag_open'] = "<ul class='pagination pagination-lg justify-content-center'>";
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a href="#" class="page-link">';
        $config['cur_tag_close'] = '</a></li>';
        $config['first_link'] = '<span aria-hidden="true">&nbsp;<i class="fa fa-angle-double-left"></i></span>';
        $config['last_link'] = '<span aria-hidden="true"><i class="fa fa-angle-double-right"></i>&nbsp;</span>';
        $config['next_link'] = '<span aria-hidden="true"><i class="fa fa-chevron-right"></i>&nbsp;</span>';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = '<span aria-hidden="true">&nbsp;<i class="fa fa-chevron-left"></i></span>';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';

        // Inicializar
        $this->pagination->initialize($config);

        // Mandar la paginacion
        $data['pagination'] = $this->pagination->create_links();

        /* Pintar las meta */
        $data['title'] = $categoria['nombre'];
        $data['descripcion'] = 'Compra ' . $categoria['nombre'] . ' en ' . $this->session->userdata('ciudad')['nombre'];
        $data['keywords'] = 'domicilios en ' . $this->session->userdata('ciudad')['nombre'] . ', ' . $categoria['nombre'] . ' en ' . $this->session->userdata('ciudad')['nombre'] . ', emprendedores de ' . $this->session->userdata('ciudad')['nombre'] . ', ' . $this->session->userdata('ciudad')['nombre'] . ', ' . $categoria['nombre'] . ', tienda de emprendedores';

        // Carga de página
        $this->load->view('tienda/categoria', $data);
    }

    /**
     * Buscar los productos en la tienda
     */
    public function buscar()
    {
        // Obtener el pais
        $iso = $this->uri->segment(1);
        // Validar si viene el pais
        $iso = is_null($iso) ? 'CO' : $iso;
        // Si no viene la ciudad
        if ((is_null($this->session->userdata('pais')['ISO'])) || ($this->session->userdata('pais')['ISO'] != $iso)) {
            // Consultar el pais
            $pais = $this->ciudades_model->get_paises(array('ISO' => $iso));
            // Agrerga el pais
            $this->session->set_userdata('pais', $pais[0]);
        }

        // 1. Verifica la ciudad donde se encuentra
        if ((empty($this->session->userdata('ciudad')))) {
            // Si no existe es porque no ha sido creada
            // Ciudad por defecto de acuerdo al pais
            $ciudad = ($iso == 'CO') ? 'pereira' : 'santa-tecla';
            // Consulto la ciudad por defecto
            $defecto = $this->ciudades_model->get(array('slug' => $ciudad));
            // Agrerga la ciudad
            $this->session->set_userdata('ciudad', $defecto);
        }

        // Obtengo los parametros de la URL
        $termino = $this->input->get('q', TRUE);
        $pagina = $this->input->get('page', TRUE);

        // Correción de la paginación
        $pagina--;

        // Consulto todos productos
        $data['productos'] = $this->productos_model->get_productos(null, null, $termino, $this->session->userdata('ciudad')['id'], $pagina, 25);
        // Cantidad de productos
        $total_productos = $this->productos_model->count_productos(null, null, $termino, $this->session->userdata('ciudad')['id']);
        // Consultar las categorias
        $data['categorias'] = $this->productos_model->get_categorias(1);
        $data['termino'] = $termino;

        // Configurar la paginacion
        $config['base_url'] = site_url($this->session->userdata('pais')['ISO'] . '/buscar/?q=' . $termino);
        $config['uri_segement'] = 2;
        $config['per_page'] = 25;
        $config['use_page_numbers'] = TRUE;
        $config['total_rows'] = $total_productos;
        $config['first_link'] = 'Inicio';
        $config['last_link'] = 'Final';
        $config['enable_query_strings'] = TRUE;
        $config['query_string_segment'] = 'page';
        $config['page_query_string'] = TRUE;

        // Pagination bootstrap
        $config['attributes'] = array('class' => 'page-link');
        $config['full_tag_open'] = "<ul class='pagination pagination-lg justify-content-center'>";
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a href="#" class="page-link">';
        $config['cur_tag_close'] = '</a></li>';
        $config['first_link'] = '<span aria-hidden="true">&nbsp;<i class="fa fa-angle-double-left"></i></span>';
        $config['last_link'] = '<span aria-hidden="true"><i class="fa fa-angle-double-right"></i>&nbsp;</span>';
        $config['next_link'] = '<span aria-hidden="true"><i class="fa fa-chevron-right"></i>&nbsp;</span>';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = '<span aria-hidden="true">&nbsp;<i class="fa fa-chevron-left"></i></span>';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';

        // Inicializar
        $this->pagination->initialize($config);

        // Mandar la paginacion
        $data['pagination'] = $this->pagination->create_links();

        /* Pintar las meta */
        $data['title'] = 'Resultados de busqueda';
        $data['descripcion'] = 'Compra en la tienda virtual de los emprendedores. Pide a domicilio desde tu hogar y apoya a los emprendedores de la ciudad. Te lo llevamos a la puerta';
        $data['keywords'] = 'domicilios en ' . $this->session->userdata('ciudad')['nombre'] . ', tienda, comprar, vender';

        // Carga de página
        $this->load->view('tienda/categoria', $data);
    }

    /**
     * Mostrar recomendaciones de las tiendas
     */
    public function explorar($pagina = 1)
    {
        // Obtener el pais
        $iso = $this->uri->segment(1);
        // Validar si viene el pais
        $iso = is_null($iso) ? 'CO' : $iso;
        // Si no viene la ciudad
        if ((is_null($this->session->userdata('pais')['ISO'])) || ($this->session->userdata('pais')['ISO'] != $iso)) {
            // Consultar el pais
            $pais = $this->ciudades_model->get_paises(array('ISO' => $iso));
            // Agrerga el pais
            $this->session->set_userdata('pais', $pais[0]);
        }

        // Si no viene la ciudad
        // if ((is_null($this->session->userdata('ciudad'))) || ($this->session->userdata('ciudad') != $slug_ciudad)) {
        //     // Agrerga la ciudad
        //     $this->session->set_userdata('ciudad', $slug_ciudad);
        // }

        // Corregir la paginacion
        $pagina--;
        // Consultar las tiendas de la ciudad
        $data['tiendas'] = $this->emprendedores_model->get_tiendas($pagina);
        $total_tiendas = $this->emprendedores_model->get_count_tiendas();

        // Configurar la paginacion
        $config['base_url'] = site_url("{$this->session->userdata('pais')['ISO']}/explorar/");
        $config['uri_segement'] = 1;
        $config['per_page'] = 25;
        $config['use_page_numbers'] = TRUE;
        $config['total_rows'] = $total_tiendas;
        $config['first_link'] = 'Inicio';
        $config['last_link'] = 'Final';

        // Pagination bootstrap
        $config['attributes'] = array('class' => 'page-link');
        $config['full_tag_open'] = "<ul class='pagination pagination-lg justify-content-center'>";
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a href="#" class="page-link">';
        $config['cur_tag_close'] = '</a></li>';
        $config['first_link'] = '<span aria-hidden="true">&nbsp;<i class="fa fa-angle-double-left"></i></span>';
        $config['last_link'] = '<span aria-hidden="true"><i class="fa fa-angle-double-right"></i>&nbsp;</span>';
        $config['next_link'] = '<span aria-hidden="true"><i class="fa fa-chevron-right"></i>&nbsp;</span>';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = '<span aria-hidden="true">&nbsp;<i class="fa fa-chevron-left"></i></span>';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';

        // Inicializar
        $this->pagination->initialize($config);

        // Mandar la paginacion
        $data['pagination'] = $this->pagination->create_links();

        /* Pintar las meta */
        $data['title'] = 'Explorar';
        $data['descripcion'] = 'Descubre las tiendas de los emprendedores que hay en tu ciudad';
        $data['keywords'] = 'domicilios en ' . $this->session->userdata('ciudad')['nombre'] . ', tienda emprendedores';
        // Carga de página
        $this->load->view('tienda/tiendas', $data);
    }

    /**
     * Pinta la ciudad donde se encuentra
     */
    /* public function inicio($iso = null)
    {
        // Si no viene la ciudad
        if ((is_null($this->session->userdata('pais')['ISO'])) || ($this->session->userdata('pais')['ISO'] != $iso)) {
            // Agrerga la ciudad
            $this->session->set_userdata('pais', $iso);
        }

        // Consultar todas las ciudades
        $ciudades = $this->ciudades_model->get_ciudades_activas();
        // Envair las ciudades a la vista
        $data['ciudades'] = $ciudades;
        // Pintar las meta
        $data['title'] = 'Inicio';
        $data['descripcion'] = 'Compra en la tienda virtual de los emprendedores. Pide a domicilio desde tu hogar y apoya a los emprendedores de la ciudad. Te lo llevamos a la puerta';
        $data['keywords'] = 'domicilio, compra en internet, tienda en internet, domicilios';
        // Carga de página
        $this->load->view('tienda/ciudad', $data);
    } */

    /**
     * Verifica si selecciono la ciudad y carga la vista
     */
    /* public function ciudad($iso, $slug, $pagina = 1, $limite = 25)
    {
        // Si no viene la ciudad
        if ((is_null($this->session->userdata('pais')['ISO'])) || ($this->session->userdata('pais')['ISO'] != $iso)) {
            // Agrerga la ciudad
            $this->session->set_userdata('pais', $iso);
        }

        // Si no viene la ciudad
        if ((is_null($this->session->userdata('ciudad'))) || ($this->session->userdata('ciudad') != $slug)) {
            // Agrerga la ciudad
            $this->session->set_userdata('ciudad', $slug);
        }

        // Validar si la ciudad pertenece al país
        if (get_validar_ciudad()) {
            // Si pertenece al país
            // Consulta la ciudad
            $query = array('slug' => $slug);
            $ciudad = $this->ciudades_model->get($query);
            // Validar si intenta acceder por la url
            if (is_null($ciudad)) {
                // Redireccionar a la seleccion de la ciudad
                $this->inicio();
            } else {
                // Agrerga la ciudad
                $this->session->set_userdata('ciudad', $ciudad);
                // Redireccionar a la tienda
                //$this->reindex(null, null, $pagina, $limite);
            }
        } else {
            // Redireccionar a la página de error
            redirect(site_url('404'));
        }
    } */
    
    /**
     * Metodo encargado de pintar el index
     */
    /* public function index($slug = null, $id_categoria = null, $pagina = 1, $limite = 25)
    {
        // Ajustar la paginación
        $pagina--;
        // Consulto todos productos
        $data['productos'] = $this->productos_model->get_productos($slug, $id_categoria, null, $this->session->userdata('ciudad'), $pagina, $limite);

        // Consultar las categorias activas
        $data['categorias'] = $this->productos_model->get_categorias(1);

        // Tiendas destacadas
        $data['tiendas'] = $this->emprendedores_model->get_tiendas(0);

        // Pintar las meta 
        $data['title'] = get_nombre_ciudad();
        $data['descripcion'] = 'Compra en la tienda virtual de los emprendedores. Pide a domicilio en ' . get_nombre_ciudad() . ' desde tu hogar y apoya a los emprendedores de la ciudad. Te lo llevamos a la puerta';
        $data['keywords'] = 'domicilios en ' . get_nombre_ciudad() . ', emprendedores de ' . get_nombre_ciudad() . ', ' . get_nombre_ciudad() . ', tienda de emprendedores';

        // Carga de página
        $this->load->view('tienda/index', $data);
    } */
}
