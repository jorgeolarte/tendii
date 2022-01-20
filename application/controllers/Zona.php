<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Zona extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Ayudas
        $this->load->helper('html');
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('upload');
        $this->load->library('image_lib');

        // Cargar los modelos
        $this->load->model('ciudades_model');
        $this->load->model('notificaciones_model');
        $this->load->model('emprendedores_model');
        $this->load->model('productos_model');
    }

    /**
     * Pinta el formulario para registrar un nuevo emprendedor
     */
    public function nuevo_emprendedor()
    {
        // Consultar las ciudades y departamentos
        $data['paises'] = $this->ciudades_model->get_paises();
        $data['departamentos'] = $this->ciudades_model->get_departamentos();
        $data['ciudades'] = $this->ciudades_model->get_ciudades();
        // Sobrescribir las variables de la nueva página
        $data['title'] = 'Crear tienda online';
        $data['descripcion'] = "Crear tu tienda y empieza a vender online";
        $data['keywords'] = "registro, tienda emprendedores, vender por internet";
        // Cargar la vista
        $this->load->view('emprendedores/registrarse-old', $data);
    }

    /**
     * Registra un nuevo emprendedor
     */
    public function registrar_emprendedor()
    {
        // Pasa los parametros post a la validación
        $this->form_validation->set_data($this->input->post());
        // XSS filtro
        $params = $this->security->xss_clean($this->input->post());

        // Cargar libreria de validacion
        $this->load->helper('form');
        $this->load->library('form_validation');

        // Validacion de reglas de negocio
        $this->form_validation->set_rules(
            'nombre',
            'nombre',
            'trim|required',
            array(
                'required' => 'El %s es obligatorio'
            )
        );

        $this->form_validation->set_rules(
            'emprendimiento',
            'nombre del emprendimiento',
            'trim|required',
            array(
                'required' => 'Ingresa el %s'
            )
        );

        $this->form_validation->set_rules(
            'pais',
            'pais',
            'trim|required',
            array(
                'required' => 'El %s es obligatorio',
            )
        );

        $this->form_validation->set_rules(
            'departamento',
            'departamento',
            'trim|required|greater_than[0]',
            array(
                'required' => 'La %s es obligatorio',
                'greater_than' => 'Debe seleccionar una %s'
            )
        );

        $this->form_validation->set_rules(
            'ciudad',
            'ciudad',
            'trim|required|greater_than[0]',
            array(
                'required' => 'La %s es obligatoria',
                'greater_than' => 'Debe seleccionar una %s'
            )
        );

        $this->form_validation->set_rules(
            'telefono',
            'teléfono',
            'trim|required|numeric|min_length[6]|max_length[14]|is_unique[emprendedores.telefono]',
            array(
                'required'  => 'El %s es obligatorio',
                'numeric'  => 'Ingresa solo números en el %s',
                'min_length'  => 'El número de %s debe tener entre 6 y 14 digitos',
                'max_length'  => 'El número de %s debe tener entre 6 y 14 digitos',
                'is_unique'  => 'El %s ya esta registrado'
            )
        );

        $this->form_validation->set_rules(
            'email',
            'correo electrónico',
            'trim|required|valid_email|is_unique[emprendedores.email]',
            array(
                'required'  => 'El %s es obligatorio',
                'valid_email'  => 'Ingresa un %s valido',
                'is_unique'  => 'El %s ya esta registrado'
            )
        );

        // Valida si el formulario fue diligenciado correctamente
        if ($this->form_validation->run() === FALSE) {
            // Cargar la vista del emprendedor
            $this->nuevo_emprendedor();
        } else {
            // Consultar el pais
            $pais = $this->ciudades_model->get_paises(array('ISO' => $params['pais']));
            // Consultar la ciudad
            $ciudad = $this->ciudades_model->get(array('id' => $params['ciudad']));

            // Crea el slug del emprendimiento
            //$slug = url_title(convert_accented_characters($params['emprendimiento']), 'dash', TRUE);

            // Crea el array para insertar
            $emprendedor = array(
                'id_ciudad' => $ciudad['id'],
                'id_pais' => $pais[0]['id'],
                'nombre' => $params['nombre'],
                // Descripcion no se carga
                'emprendimiento' => $params['emprendimiento'],
                'logo' => 'default.jpg',
                // Slug del emprendimiento no se crea
                'telefono' => $params['telefono'],
                // Whatsapp inactivo
                'email' => $params['email']
                // No se carga las horas
            );
            // Insertar el emprendedor en la tabla
            $resultado = $this->emprendedores_model->insertar($emprendedor);

            // Agregar la ciudad de operacion
            $ciudad_operacion = array(
                'id_emprendedor' => $resultado,
                'id_ciudad' => $ciudad['id']
            );
            // Insertar la ciudad del emprendedor
            $this->emprendedores_model->insertar_ciudad($ciudad_operacion);

            // Si esta en producción
            // Asignar la ciudad al emprendedor
            $emprendedor['ciudad'] = $ciudad['slug'];
            $emprendedor['nombre_ciudad'] = (empty($ciudad['abr'])) ? $pais[0]['ISO'] : $ciudad['abr'];
            // Asignar la ciudad al emprendedor
            $emprendedor['pais'] = $pais[0]['nombre'];
            $emprendedor['nombre_pais'] = $pais[0]['ISO'];
            // Cambiar el telefono y agregar el prefijo
            $emprendedor['prefijo_telefono'] = '+' . $pais[0]['prefijo'] . $emprendedor['telefono'];

            // Crea el usuario en sendinblue
            $this->notificaciones_model->sendinblue($emprendedor);
            // Crea el usuario en el celular de emprendedores
            $this->notificaciones_model->google($emprendedor);
            // Enviar correo de bienvenida
            $this->notificaciones_model->email_bienvenida($emprendedor);

            // Crear la session del emprendedor
            $this->session->set_userdata('emprendedor', $emprendedor);
            // Agregar la sesión del pais y la ciudad
            $this->session->set_userdata('pais', $pais[0]);
            $this->session->set_userdata('ciudad', $ciudad);
            // Redireccionar a la página admin
            $this->iniciar_sesion();
        }
    }

    /**
     * Zona de administración
     */
    public function admin()
    {
        if (is_logged_in()) {
            // Consultar los productos que pertenecen al emprendedor
            $productos = $this->productos_model->get_productos($this->session->userdata('emprendedor')['id'], null, null, null, 0, 25);
            // Asignar variable
            $data['productos'] = $productos;
            // Sobrescribir las variables de la nueva página
            $data['title'] = 'Zona de administración';
            $data['descripcion'] = "Bienvenido a la zona de administración de tu perfil";
            $data['keywords'] = "perfil emprendedor, zona adminstración, dashboard";
            // Cargar la vista
            $this->load->view('admin/index', $data);
        } else {
            // Redireccionar
            //$this->login();
            redirect(site_url('login?url=' . current_url()));
        }
    }

    /**
     * Vista encargada de mostrar los productos
     */
    public function leer_productos()
    {
        if (is_logged_in()) {
            // Consultar los productos que pertenecen al emprendedor
            $productos = $this->productos_model->get_productos($this->session->userdata('emprendedor')['id'], null, null, null, 0, 25);
            // Asignar variable
            $data['productos'] = $productos;
            // Sobrescribir las variables de la nueva página
            $data['title'] = 'Tus productos';
            $data['descripcion'] = "Aquí puedes crear y editar tus productos";
            $data['keywords'] = "productos, configuración productos, nuevo producto, editar producto";
            // Cargar la vista
            $this->load->view('admin/productos', $data);
        } else {
            // Redireccionar
            //$this->login();
            redirect(site_url('login?url=' . current_url()));
        }
    }

    /**
     * Cierra la sesión del usuario
     */
    public function cerrar()
    {
        if (is_logged_in()) {
            $emprendedor = $this->session->userdata('emprendedor');
            // Elimina el emprendedor
            $this->session->unset_userdata($emprendedor);
            // Destruye la sesion
            $this->session->sess_destroy();
        }
        // Redirecciona al login
        redirect(site_url('login'));
    }

    /**
     * Pagina encargada de iniciar sesión
     */
    public function login()
    {
        // Tiene la URL
        if (!is_null($this->input->get('url'))) {
            // Crea la URL para redireccionar
            $this->session->set_tempdata(array('redirectToCurrent' => $this->input->get('url')), 30);
        }
        // Sobrescribir las variables de la nueva página
        $data['title'] = 'Iniciar sesión';
        $data['descripcion'] = "Emprendedor bienvenido al sistema de administración de tu perfil";
        $data['keywords'] = "iniciar sesion, administración de perfil, crear tienda virtual, vender por internet";
        // Cargar la vista
        $this->load->view('emprendedores/iniciar_sesion', $data);
    }

    /**
     * Se encarga de iniciar la sesión del usuario
     */
    public function iniciar_sesion()
    {
        // Pasa los parametros post a la validación
        $this->form_validation->set_data($this->input->post());
        // XSS filtro
        $params = $this->security->xss_clean($this->input->post());
        // Cargar libreria de validacion
        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules(
            'telefono',
            'teléfono',
            'trim|required|numeric|max_length[14]',
            array(
                'required'  => 'El %s es obligatorio',
                'numeric'  => 'Ingresa solo números en el %s',
                'exact_length'  => 'Ingresa un número de %s celular'
            )
        );

        $this->form_validation->set_rules(
            'email',
            'correo electrónico',
            'trim|required|valid_email|callback_login_check[' . $params['telefono'] . ']',
            array(
                'required'  => 'El %s es obligatorio',
                'valid_email'  => 'Ingresa un %s valido',
                'login_check' => 'No corresponde el email y telefono'
            )
        );

        // Valida si el formulario fue diligenciado correctamente
        if ($this->form_validation->run() === FALSE) {
            // Redireccionar a la pagina de inicio de sesion
            $this->login();
        } else {
            // Construir el array de consulta
            $query = array(
                'telefono' => $params['telefono'],
                'email' => $params['email']
            );
            // Consulto el usuario y creo la sesión
            $emprendedor = $this->emprendedores_model->get($query);
            // Creo la sesión del usuario
            $this->session->set_userdata('emprendedor', $emprendedor);

            // Consulto y creo las sesiones de pais
            $this->session->unset_userdata('pais');
            $pais = $this->ciudades_model->get_paises(array('id' => $this->session->userdata('emprendedor')['id_pais']));
            $this->session->set_userdata('pais', $pais[0]);

            // Consulto y creo las sesiones de ciudad
            $this->session->unset_userdata('ciudad');
            $ciudad = $this->ciudades_model->get(array('id' => $this->session->userdata('emprendedor')['id_ciudad']));
            $this->session->set_userdata('ciudad', $ciudad);

            // Validar si tiene la sesion
            if (is_null($this->session->tempdata('redirectToCurrent'))) {
                // Validar si el usuario ya tiene perfil
                if (is_null($emprendedor['slug'])) {
                    // Redirecciona a la administración
                    redirect('admin/index');
                } else {
                    // Redireccionar al perfil
                    redirect(site_url($emprendedor['slug']));
                }
            } else {
                // Asignar variable para poderla destruir
                $url = $this->session->tempdata('redirectToCurrent');
                // Destruir la sesión temporal
                $this->session->unset_tempdata('redirectToCurrent');
                // Redireccionar donde venga el usuario
                redirect($url);
            }
        }
    }

    /**
     * Valida si el email y telefono son el mismo
     */
    public function login_check($email, $telefono)
    {
        // Valida si el telefono y email corresponden
        $result = $this->emprendedores_model->validar($telefono, $email);
        // Si tiene resultados
        if ($result > 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Consulta el país al que corresponde correo
     */
    public function consultar_pais_sesion()
    {
        // Pasa los parametros post a la validación
        $this->form_validation->set_data($this->input->post());
        // XSS filtro
        $params = $this->security->xss_clean($this->input->post());


        // Consultar el emprendedor
        $emprendedor = $this->emprendedores_model->get(array('email' => $params['email']));
        // Validar si existe el correo
        if (is_null($emprendedor)) {
            // Mensaje al usuario
            $response_array['success'] = FALSE;
            $response_array['message'] = 'Correo no existe';
        } else {
            // Consultar el pais del emprendedor
            $pais = $this->ciudades_model->get_paises(array('id' => $emprendedor['id_pais']));
            // Mensaje al usuario
            $response_array['success'] = TRUE;
            $response_array['message'] = '';
            $response_array['ISO'] = $pais[0]['ISO'];
            $response_array['bandera'] = base_url('assets/img/banderas/' . $pais[0]['bandera']);
            $response_array['prefijo'] = $pais[0]['prefijo'];
        }

        echo json_encode($response_array);
    }

    /**
     * Metodo encargado de cargar el logo del emprendedor
     */
    public function cargar_logo()
    {
        if (is_logged_in()) {
            // Pasa los parametros post a la validación
            $this->form_validation->set_data($this->input->post());
            // XSS filtro
            $params = $this->security->xss_clean($this->input->post());
            // Cargar libreria de validacion
            $this->load->helper('form');
            $this->load->library('form_validation');

            $this->form_validation->set_rules(
                'logo',
                'logo',
                'callback_validar_logo'
            );

            // Valida si el formulario fue diligenciado correctamente
            if ($this->form_validation->run() === FALSE) {
                $this->admin();
            } else {
                // Obtengo la foto del producto
                $foto = $this->upload->data('file_name');
                // Consulto el emprendedor
                $emprendedor = $this->emprendedores_model->get(array('id' => $this->session->userdata('emprendedor')['id']));
                // Actualizo el array
                $emprendedor['logo'] = $foto;
                // Actualizar el logo en la sesión
                $this->session->set_userdata('logo', $foto);
                // Insertar el nuevo producto
                $this->emprendedores_model->actualizar($emprendedor);
                // Redireccionar a la pagina de administrador
                $this->admin();
            }
        } else {
            // Redireccion a la página de login
            $this->login();
            //redirect(site_url('login?url=' . current_url()));
        }
    }

    /**
     * Metodo validar la imagen
     */
    public function validar_logo()
    {
        $config = array(
            'upload_path' => './assets/tienda/',
            'encrypt_name' => TRUE,
            'overwrite' => FALSE,
            'create_thumb' => TRUE,
            'maintain_ratio' => TRUE,
            'allowed_types' => "jpg|png|jpeg",
            'max_size' => "5120", // Can be set to particular file size , here it is 2 MB(2048 Kb)
            'min_width' => "500",
            'min_height' => "500",
            // 'max_width' => "10000",
            // 'max_height' => "10000"
        );

        $this->upload->initialize($config);
        $this->load->library('upload', $config);

        if ($this->upload->do_upload('logo')) {
            $data['upload_data'] = array('upload_data' => $this->upload->data());
        } else {
            $data['error'] = array('error' => $this->upload->display_errors());
        }

        if (isset($data['error'])) {
            // Mensaje de error
            $mensaje = '';
            // Recorre todos los posibles errores
            foreach ($data['error'] as $error) {
                // Concatena
                $mensaje .= $error;
            }
            $mensaje = strip_tags(strip_tags($mensaje, "<p>"), "</p>");
            // Adjunta el error a la pantalla
            $this->form_validation->set_message('validar_logo', $mensaje);
            return false;
        } else {
            return true;
        }
    }

    /**************************************
     * Adminitración de productos
     * ************************************
     */

    /**
     * Muestra la vista encargada de cargar el formulario
     */
    public function nuevo_producto()
    {
        if (is_logged_in()) {
            // Consultar el pais del emprendedor
            $pais = $this->ciudades_model->get_paises(array('id' => $this->session->userdata('emprendedor')['id_pais']));
            // Cargar las categorias disponibles
            $data['categorias'] = $this->productos_model->get_categorias_emprendedor();
            // PRecio minimo del producto
            $data['precio_minimo'] = $pais[0]['precio_minimo'];
            $data['step'] = $pais[0]['step'];
            // Sobrescribir las variables de la nueva página
            $data['title'] = 'Crear nuevo producto';
            $data['descripcion'] = "Configura el producto a vender a través de nuestra tienda";
            $data['keywords'] = "crear productos, subir nuevo producto, vender producto, configurar producto";
            // Cargar la vista
            $this->load->view('admin/nuevo_producto', $data);
        } else {
            // Redireccionar
            //$this->login();
            redirect(site_url('login?url=' . current_url()));
        }
    }

    /**
     * Crea el nuevo producto
     */
    public function crear_producto()
    {
        if (is_logged_in()) {
            // Pasa los parametros post a la validación
            $this->form_validation->set_data($this->input->post());
            // XSS filtro
            $params = $this->security->xss_clean($this->input->post());

            // Cargar libreria de validacion
            $this->load->helper('form');
            $this->load->library('form_validation');

            // Validacion de reglas de negocio
            $this->form_validation->set_rules(
                'nombre',
                'nombre',
                'trim|required|max_length[50]',
                array(
                    'required' => 'El %s es obligatorio',
                    'max_length' => 'El %s debe tener 50 caracteres como máximo'
                )
            );

            $this->form_validation->set_rules(
                'categoria',
                'categoria',
                'trim|required|greater_than[0]',
                array(
                    'required' => 'La %s es obligatoria',
                    'greater_than' => 'Debe seleccionar una %s'
                )
            );

            $this->form_validation->set_rules(
                'imagen',
                'imagen',
                'trim|callback_validar_imagen'
            );

            $this->form_validation->set_rules(
                'descripcion',
                'descripción',
                'trim|required|min_length[50]|max_length[240]',
                array(
                    'required' => 'La %s es obligatoria',
                    'min_length' => 'La longitud mínima de la %s es de 50 caracteres',
                    'max_length' => 'La longitud máxima de la %s es de 240 caracteres'
                )
            );

            $this->form_validation->set_rules(
                'precio',
                'precio',
                'trim|required|callback_precio[' . $params['precio'] . ']',
                array(
                    'required' => 'El %s es obligatorio',
                    // 'precio' => 'El %s del producto debe ser mayor'
                )
            );

            // Valida si el formulario fue diligenciado correctamente
            if ($this->form_validation->run() === FALSE) {
                // Redirecciona a la pagina
                $this->nuevo_producto();
            } else {
                // Obtengo la foto del producto
                $foto = $this->upload->data('file_name');

                // Construyo el producto a inserta
                $producto = array(
                    'id_emprendedor' =>  $this->session->userdata('emprendedor')['id'],
                    'id_categoria' => $params['categoria'],
                    'nombre' => $params['nombre'],
                    'imagen' => $foto,
                    'descripcion' => $params['descripcion'],
                    'precio' => $params['precio']
                );
                // Insertar el nuevo producto
                $this->productos_model->insertar($producto);
                // Redireccionar a la pagina de administrador
                redirect(site_url('admin/productos'));
            }
        } else {
            // Redireccion a la página de login
            $this->login();
        }
    }

    /**
     * Metodo validar la imagen
     */
    public function validar_imagen()
    {
        $config = array(
            'upload_path' => './assets/tienda/',
            'encrypt_name' => TRUE,
            'overwrite' => FALSE,
            'create_thumb' => TRUE,
            'maintain_ratio' => TRUE,
            'allowed_types' => "jpg|png|jpeg",
            'max_size' => "5120", // Can be set to particular file size , here it is 2 MB(2048 Kb)
            'min_width' => "500",
            'min_height' => "500",
            // 'max_width' => "10000",
            // 'max_height' => "10000"
        );

        $this->upload->initialize($config);
        $this->load->library('upload', $config);

        if ($this->upload->do_upload('imagen')) {
            $data['upload_data'] = array('upload_data' => $this->upload->data());
        } else {
            $data['error'] = array('error' => $this->upload->display_errors());
        }

        if (isset($data['error'])) {
            // Mensaje de error
            $mensaje = '';
            // Recorre todos los posibles errores
            foreach ($data['error'] as $error) {
                // Concatena
                $mensaje .= $error;
            }
            $mensaje = strip_tags(strip_tags($mensaje, "<p>"), "</p>");
            // Adjunta el error a la pantalla
            $this->form_validation->set_message('validar_imagen', $mensaje);
            return false;
        } else {
            return true;
        }
    }

    /**
     * Valida que el precio este acorde a la configuración
     */
    public function precio($precio)
    {
        // Consultar el pais del emprendedor
        $pais = $this->ciudades_model->get_paises(array('id' => $this->session->userdata('emprendedor')['id_pais']));
        // Si el precio ingresado es menor a la configuración del sitio
        if ($precio < $pais[0]['precio_minimo']) {
            // Crea el mensaje al usuario
            $mensaje = "El precio minimo del producto debe ser $" . number_format($pais[0]['precio_minimo'], $pais[0]['decimales']);
            // Asigna el mensaje 
            $this->form_validation->set_message('precio', $mensaje);
            // Retorna
            return false;
        } else {
            return true;
        }
    }

    /**
     * Actualiza campo del producto
     */
    public function actualizar_producto()
    {
        // Valida si esta logeado
        if (is_logged_in()) {
            // Pasa los parametros post a la validación
            $this->form_validation->set_data($this->input->post());
            // XSS filtro
            $params = $this->security->xss_clean($this->input->post());
            // Cargar libreria de validacion
            $this->load->helper('form');
            $this->load->library('form_validation');

            // Necesito validar de acuerdo a la key

            switch ($params['key']) {
                case "nombre":
                    // Validacion de reglas del nombre
                    $this->form_validation->set_rules(
                        'value',
                        'nombre',
                        'trim|required|min_length[10]|max_length[50]',
                        array(
                            'required' => 'El %s es obligatorio',
                            'min_length' => 'El %s debe tener 10 caracteres como mínimo',
                            'max_length' => 'El %s debe tener 50 caracteres como máximo'
                        )
                    );
                    break;
                case "descripcion":
                    $this->form_validation->set_rules(
                        'value',
                        'descripción',
                        'trim|required|min_length[50]|max_length[240]',
                        array(
                            'required' => 'La %s es obligatoria',
                            'min_length' => 'La longitud mínima de la %s es de 50 caracteres',
                            'max_length' => 'La longitud máxima de la %s es de 240 caracteres'
                        )
                    );
                    break;
                case "precio":
                    $this->form_validation->set_rules(
                        'value',
                        'precio',
                        'trim|required|callback_precio[' . $params['key'] . ']',
                        array(
                            'required' => 'El %s es obligatorio',
                            // 'precio' => 'El %s del producto debe ser mayor'
                        )
                    );
                    break;
            }

            if ($this->form_validation->run() == FALSE) {
                // Mensaje de error
                $response_array['success'] = FALSE;
                $response_array['message'] = strip_tags(validation_errors());
                //echo strip_tags(validation_errors());
            } else {

                // Construye el array a enviar a actualizar
                $data = array(
                    $params['key'] => trim($params['value']),
                );

                // Actualiza el producto
                $this->productos_model->actualizar($params['id'], $data);

                // Mensaje de exito
                $response_array['success'] = TRUE;
            }

            echo json_encode($response_array);
        }
    }

    /**
     * 'Eliminar' el producto del emprendedor
     */
    public function eliminar_producto()
    {
        // El usuario esta activo
        if (is_logged_in()) {
            // Pasa los parametros post a la validación
            $this->form_validation->set_data($this->input->post());
            // XSS filtro
            $params = $this->security->xss_clean($this->input->post());
            // Consulta el producto
            $producto = $this->productos_model->get(array('id' => $params['id']));
            // Modifico el producto
            $producto['estado'] = '0';
            // Actualizo el producto
            $this->productos_model->borrar($producto);
            // Redireccionar a la pagina de administrador
            $this->leer_productos();
        } else {
            // Reenvia a la pagina de login
            $this->login();
        }
    }
}
