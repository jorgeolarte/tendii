<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Perfiles extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Librerias
        $this->load->library('upload');
        $this->load->library('image_lib');

        /* Incluye el modelo */
        $this->load->model('ciudades_model');
        $this->load->model('clientes_model');
        $this->load->model('notificaciones_model');
        $this->load->model('emprendedores_model');
        $this->load->model('productos_model');

        // Validar si existe el cliente
        if (is_null($this->session->userdata('cliente')['cookie'])) {
            // Generar el codigo del cliente
            $codigo = $this->clientes_model->generar_cookie();
            // Construye el array del usuario
            $cliente = array(
                'cookie' => $codigo,
                'ciudad' => '',
            );
            $this->session->set_userdata('cliente', $cliente);
            // Crear el arrar para insertar el cliente
            $cliente = array(
                'cookie' => $cliente['cookie'],
                'nombres' => NULL,
                'telefono' => NULL,
                'email' => NULL
            );
            // Guardar el cliente temporal
            $this->clientes_model->insertar($cliente);
        }

        // Validar si no tiene pais
        if (is_null($this->session->userdata('pais'))) {
            // Redirecciona a la página principal
            redirect(site_url('?url=' . current_url()));
        }
    }

    /**
     * Muestra el perfil del emprendedor
     */
    public function index($slug = null)
    {
        // Capturo el estado de creación de la tienda
        $data['status'] = $this->input->get();

        // Consulta a quien pertenece el perfil
        $emprendedor = $this->emprendedores_model->get(array('slug' => $slug));

        // El perfil existe
        if (!is_null($emprendedor)) {
            // Lanza la vista que carga el perfil del emprendedorç
            $data['emprendedor'] = $emprendedor;
            // Consultar los productos del emprendedor
            $productos = $this->productos_model->get_productos($emprendedor['id'], null, null, null, 0, 25);
            // Asignar productos a la vista
            $data['productos'] = $productos;
            // Cuantos productos tiene el emprendedor
            $data['contar_productos'] = count($productos);

            // Sobrescribir las variables de la nueva página
            $data['title'] = $emprendedor['emprendimiento'];
            // Validar si el emprendedor tiene cargada la descripción
            $data['descripcion'] = (is_null($emprendedor['descripcion'])) ?
                "Bienvenido al perfil del emprendedor" :
                $emprendedor['descripcion'];
            // Keywords
            $data['keywords'] = 'tienda emprendedores, domicilios, comprar online, ' . $emprendedor['emprendimiento'] . ', ecommerce, comprar en internet, domicilios en ' . $this->session->userdata('ciudad')['nombre'];
            // Enviar el thumbnail
            $data['thumbnail'] = $emprendedor['logo'];
            // Bandera para saber si es el perfil
            $data['es_perfil'] = false;

            // Quien inicio sesión
            $sesion = $this->session->userdata('emprendedor');

            // Verificar si existe
            if (isset($sesion['id'])) {
                if ($emprendedor['id'] == $sesion['id']) {
                    $data['es_perfil'] = true;
                }
            }

            // Cargar la vista
            $this->load->view('admin/perfil', $data);
        } else {
            // Lanza la vista que dice que el emprendimiento no existe
            redirect(site_url('404'));
        }
    }

    /**
     * Redireccionar las tiendas antiguas
     */
    public function reindex($slug)
    {
        // Redirecciona a la nueva URL
        redirect(site_url($slug));
    }

    /**
     * Crear nuevo perfil
     * 
     * Metodo encargado de mostrar el formulario para crear
     * un nuevo perfil del emprendedor
     */
    public function nuevo()
    {
        // Validar si esta logueado
        if (is_logged_in()) {
            // Obtener el id del emprendedor
            $id_emprendedor = $this->session->userdata('emprendedor')['id'];
            // Consultar el emprendedor
            $emprendedor = $this->emprendedores_model->get(array('id' => $id_emprendedor));
            // Validar si no tiene el perfil creado
            if (is_null($emprendedor['slug'])) {
                // Lanzar el formulario para que lo cree
                $data['title'] = $emprendedor['emprendimiento'];
                $data['descripcion'] = "Bienvenido a la página para la creación de tu tienda";
                $data['keywords'] = "tienda virtual, ventas, ecommerce, ventas online";
                // Lanzar el formulario
                $this->load->view('admin/crear_tienda', $data);
            } else {
                // Redireccionar a la página de modificación del perfil
                $this->actualizar();
            }
        } else {
            // Redirecciona a la página de la ciudad
            redirect(site_url($this->session->userdata('ciudad')));
        }
    }

    /**
     * Guardar la información del usuario
     * cuando se haya enviado el formulario
     */
    public function crear()
    {
        // Validar si esta autenticado
        if (is_logged_in()) {
            // Pasa los parametros post a la validación
            $this->form_validation->set_data($this->input->post());
            // XSS filtro
            $params = $this->security->xss_clean($this->input->post());
            // Cargar libreria de validacion
            $this->load->helper('form');
            $this->load->library('form_validation');

            $this->form_validation->set_rules(
                'imagen',
                'imagen',
                'callback_validar_logo'
            );

            // Validacion de reglas de negocio
            $this->form_validation->set_rules(
                'slug',
                'nombre de usuario',
                'trim|required|max_length[30]|callback_validar_nombre_form',
                array(
                    'required' => 'El %s es obligatorio',
                    'max_length' => 'El %s debe tener 30 caracteres como máximo'
                )
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
                'hora_inicio',
                'hora de inicio',
                'trim|required|callback_es_hora',
                array(
                    'required' => 'La %s es obligatoria'
                )
            );

            $this->form_validation->set_rules(
                'hora_cierre',
                'hora de cierre',
                'trim|required|callback_es_hora|callback_rango_horas[' . $params['hora_inicio'] . ']',
                array(
                    'required' => 'La %s es obligatoria'
                )
            );

            // Valida si el formulario fue diligenciado correctamente
            if ($this->form_validation->run() === FALSE) {
                // Recarga la vista
                $this->nuevo();
            } else {
                // Obtener el emprendedor
                $perfil = $this->session->userdata('emprendedor');
                // Obtengo la foto del producto
                $foto = $this->upload->data('file_name');

                // Actualizo el array con los datos nuevos
                $perfil['logo'] = $foto;
                $perfil['slug'] = strtolower($params['slug']);
                $perfil['descripcion'] = $params['descripcion'];
                $perfil['hora_inicio'] = $params['hora_inicio'];
                $perfil['hora_cierre'] = $params['hora_cierre'];

                // Manejo del tiempo
                $unixTimestamp = time();
                $perfil['fecha_modificacion'] = date("Y-m-d H:i:s", $unixTimestamp);

                // Eliminar la sesión del emprendedor
                $this->session->unset_userdata('emprendedor');
                // Volverla a la sesión con los datos actualizados
                $this->session->set_userdata('emprendedor', $perfil);
                // Actualiza el emprendedor
                $this->emprendedores_model->actualizar($perfil);
                // Redirecciona a la página de perfil
                redirect(site_url('admin/index'));
            }
        } else {
            // Redirecciona a la página de la ciudad
            redirect(site_url($this->session->userdata('pais')['ISO']));
        }
    }

    /**
     * Valida si la hora es correcta
     */
    public function es_hora($hora)
    {
        // Saber si entro a un error
        $ban = true;
        // Descomponer la hora
        $temp = explode(":", $hora);

        // Variable para almacenar el mensaje
        $mensaje = '';

        // Validar que sea una hora
        if ($temp[0] < 0 || $temp[0] >= 24) {
            // Hora incorrecta
            $mensaje .= 'Hora debe estar entre 00 y 23. ';
            // Cambiar la bandera
            $ban = false;
        }

        if ($temp[1] < 0 || $temp[1] >= 60) {
            // Hora incorrecta
            $mensaje .= 'Minutos deben estar entre 00 y 59';
            // Cambiar la bandera
            $ban = false;
        }

        $this->form_validation->set_message('es_hora', $mensaje);
        // Retorna si todo fue bien o mal
        return $ban;
    }

    /**
     * Valida si los rangos coinciden
     */
    public function rango_horas($hora_cierre, $hora_inicio)
    {
        // Saber si entro a un error
        $ban = true;

        // Divide las horas
        $tempInicio = explode(":", $hora_inicio);
        $tempCierre = explode(":", $hora_cierre);

        // Variable para almacenar el mensaje
        $mensaje = '';

        // Validar la hora de inicio no sea superior a la de cierre
        if ($tempInicio[0] > $tempCierre[0]) {
            // Hora incorrecta
            $mensaje .= 'La hora de inicio no puede ser superior a la de cierre. ';
            // Cambiar la bandera
            $ban = false;
        } elseif ($tempInicio[0] == $tempCierre[0]) {
            // Validar los minutos
            if ($tempInicio[1] >= $tempCierre[1]) {
                // Hora incorrecta
                $mensaje .= 'La hora de inicio no puede ser superior a la de cierre. ';
                // Cambiar la bandera
                $ban = false;
            }
        }

        $this->form_validation->set_message('rango_horas', $mensaje);
        // Retorna si todo fue bien o mal
        return $ban;
    }

    /**
     * Validar disponibilidad del nombre de usuario
     */
    public function validar_nombre_form($slug)
    {
        // Llamar la funcion que se encarga de validar el nombre
        $respuesta = $this->validar_nombre($slug);
        // Asigna mensaje
        $this->form_validation->set_message('validar_nombre_form', $respuesta['message']);
        // Retorna si todo fue bien o mal
        return $respuesta['success'];
    }

    /**
     * Validar disponibilidad del nombre de usuario
     */
    public function validar_nombre_ajax()
    {
        // Validar que recibo el slug
        if ($this->input->post('slug')) {
            // Llamar la funcion que se encarga de validar el nombre
            $respuesta = $this->validar_nombre($this->input->post('slug'));
        } else {
            // En caso que no se haya enviado
            $respuesta['success'] = FALSE;
            $respuesta['message'] = "Enviar el nombre del usuario";
        }
        // Mostrar la respuesta
        echo json_encode($respuesta);
    }

    /**
     * Logica para validar el nombre
     */
    private function validar_nombre($slug)
    {
        // Saber si entro a un error
        $ban = true;

        // Variable para almacenar el mensaje
        $mensaje = '';

        // ¿Slug valido?
        if (preg_match("/^[a-z0-9]+(-?[a-z0-9]+)*$/i", $slug)) {
            // Validar que no sea una palabra reservada
            if (in_array($slug, RESERVERD_WORDS)) {
                $mensaje .=  "Nombre de usuario no está disponible";
                $ban = false;
            } else {
                // Consultar emprendedor con slug
                $emprendedor = $this->emprendedores_model->get(array('slug' => $slug));
                // Validar que el nombre no este asignado a otra persona
                if (is_null($emprendedor)) {
                    $mensaje .=  "Nombre de usuario disponible";
                } else {
                    $mensaje .=  "El usuario ya existe. Intenta con otro nombre";
                    $ban = false;
                }
            }
        } else {
            $ban = false;
            $mensaje .=  "El nombre de usuario invalido. Reemplaza los espacios e intenta con letras, numeros y/o guiones medios";
        }

        // Retorna si todo fue bien o mal
        return array(
            'success' => $ban,
            'message' => $mensaje
        );
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
            'min_width' => "250",
            'min_height' => "250",
            'max_width' => "10000",
            'max_height' => "10000"
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
            $this->form_validation->set_message('validar_logo', $mensaje);
            return false;
        } else {
            return true;
        }
    }

    /**
     * Metodo encargado de actualizar el perfil del emprendedor
     */
    public function actualizar()
    {
        echo "Pagina para actualizar perfil";
    }

    /**
     * Lanza la vista encargada de mostrar los pasos para activar el whatsapp
     */
    public function whatsapp()
    {
        if (is_logged_in()) {
            // Lanzar el formulario para que lo cree
            $data['title'] = 'Notificaciones Whatsapp';
            $data['descripcion'] = "Sigue las instrucciones para activar las notificaciones de los pedidos a través de Whatsapp";
            $data['keywords'] = "notificaciones whatsapp, pedidos, chatbot, automatico, bot";
            // Lanzar el formulario
            $this->load->view('admin/whatsapp', $data);
        } else {
            // Redirecciona al login
            //redirect(site_url('login'));
            redirect(site_url('login?url=' . current_url()));
        }
    }

    /**
     * Envia mensaje de verificación al usuario
     */
    public function verificar_envio()
    {
        $response_array['success'] = TRUE;

        // Validar que el cliente este logeado
        if (is_logged_in()) {
            // Pasa los parametros post a la validación
            $this->form_validation->set_data($this->input->post());
            // XSS filtro
            $params = $this->security->xss_clean($this->input->post());

            // Cargar libreria de validacion
            $this->load->helper('form');
            $this->load->library('form_validation');
            // Validar el numero del telefono
            $this->form_validation->set_rules(
                'telefono',
                'teléfono',
                'trim|required|numeric|exact_length[10]',
                array(
                    'required'  => 'El %s es obligatorio',
                    'numeric'  => 'Ingresa solo números en el %s',
                    'exact_length'  => 'El número de %s debe tener 10 digitos'
                )
            );
            // Valida si el formulario fue diligenciado correctamente
            if ($this->form_validation->run() === FALSE) {
                // Devuelve los errores
                $response_array['success'] = FALSE;
                $response_array['message'] = strip_tags(validation_errors());
            } else {
                // Buscar el emprendedor
                $emprendedor = $this->emprendedores_model->get(array('telefono' => $params['telefono']));
                // Pais del emprendedor
                $pais = $this->ciudades_model->get_paises(array('id' => $emprendedor['id_pais']));
                // Nuevo telefono que tiene el prefijo
                $telefono = '+' . $pais[0]['prefijo'] . $params['telefono'];
                // Enviar el mensaje por whatsapp
                $this->notificaciones_model->whatsapp($telefono, 'Hey _' . $emprendedor['nombre'] . '_ estas a punto de activar las notificaciones de pedidos. Oprime en el siguiente link para confirmar activación 👉 ' . site_url('admin/whatsapp/confirmar/' . $params['telefono']));
                // reenvia a la vista del whatsapp
                $response_array['message'] = 'Enviado mensaje...';
            }
        } else {
            $response_array['success'] = FALSE;
            $response_array['message'] = "Debes iniciar sesión";
        }

        echo json_encode($response_array);
    }

    /**
     * Envia mensaje de verificación al usuario
     */
    public function confirmar_envio()
    {
        $response_array['success'] = TRUE;

        // Validar que el cliente este logeado
        if (is_logged_in()) {
            // Pasa los parametros post a la validación
            $this->form_validation->set_data($this->input->post());
            // XSS filtro
            $params = $this->security->xss_clean($this->input->post());

            // Cargar libreria de validacion
            $this->load->helper('form');
            $this->load->library('form_validation');
            // Validar el numero del telefono
            $this->form_validation->set_rules(
                'telefono',
                'teléfono',
                'trim|required|numeric|exact_length[10]',
                array(
                    'required'  => 'El %s es obligatorio',
                    'numeric'  => 'Ingresa solo números en el %s',
                    'exact_length'  => 'El número de %s debe tener 10 digitos'
                )
            );
            // Valida si el formulario fue diligenciado correctamente
            if ($this->form_validation->run() === FALSE) {
                // Devuelve los errores
                $response_array['success'] = FALSE;
                $response_array['message'] = strip_tags(validation_errors());
            } else {
                // Buscar el emprendedor
                $emprendedor = $this->emprendedores_model->get(array('telefono' => $params['telefono']));

                // Pais del emprendedor
                $pais = $this->ciudades_model->get_paises(array('id' => $emprendedor['id_pais']));
                // Nuevo telefono que tiene el prefijo
                $telefono = '+' . $pais[0]['prefijo'] . $params['telefono'];

                // Cambiar el estado de la columna del whatsapp
                $emprendedor['whatsapp'] = true;
                $this->session->userdata('emprendedor')['whatsapp'] = true;
                // Actualizar el usuario
                $this->emprendedores_model->actualizar($emprendedor);

                // Enviar el mensaje por whatsapp
                $this->notificaciones_model->whatsapp($telefono, '*¡Felicitaciones!* Haz activado las notificaciones de pedidos por Whatsapp.');
                // reenvia a la vista del whatsapp
                $response_array['message'] = 'Enviado mensaje...';
            }
        } else {
            $response_array['success'] = FALSE;
            $response_array['message'] = "Debes iniciar sesión";
        }

        echo json_encode($response_array);
    }

    /**
     * El usuario confirma el mensaje desde el Whatsapp
     */
    public function confirmar_mensaje($telefono)
    {
        // Validar que haya iniciado sesion    
        if (is_logged_in()) {
            // Busco el emprendedor con el telefono
            $emprendedor_url = $this->emprendedores_model->get(array('telefono' => $telefono));
            // Verifico que el emprendedor se el mismo de la sesión
            if ($this->session->userdata('emprendedor')['id'] == $emprendedor_url['id']) {
                // Actualizo el estado del whatsapp
                $emprendedor_url['whatsapp'] = true;
                $this->session->userdata('emprendedor')['whatsapp'] = true;
                // Actualizar el usuario
                $this->emprendedores_model->actualizar($emprendedor_url);

                // Pais del emprendedor
                $pais = $this->ciudades_model->get_paises(array('id' => $emprendedor_url['id_pais']));
                // Nuevo telefono que tiene el prefijo
                $telefono = '+' . $pais[0]['prefijo'] . $emprendedor_url['telefono'];

                // Enviar el mensaje por whatsapp
                $this->notificaciones_model->whatsapp($telefono, '*¡Felicitaciones!* Haz activado las notificaciones de pedidos por Whatsapp.');
                // Redirecciona a la página
                redirect(site_url('admin/index/#whatsapp'));
            } else {
                // Redirecciona al login
                redirect(site_url('login?url=' . current_url()));
            }
        } else {
            // Redirecciona al login
            redirect(site_url('login?url=' . current_url()));
        }
    }
}
