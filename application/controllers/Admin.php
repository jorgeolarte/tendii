<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Pagina principal de la zona de administración
     */
    public function index()
    {
        // Variable porcentaje
        // Tiene tienda?
        $porcentajes['tienda'] = (is_null($this->session->userdata('emprendedor')['slug'])) ? 0 : 25;
        // Ha configurado más ciudades
        $ciudades = $this->emprendedores_model->ciudades_emprendedor($this->session->userdata('emprendedor')['id']);
        $porcentajes['ciudad'] = (count($ciudades) > 1) ? 25 : 0;
        // Tiene habilitado el whatsapp
        $porcentajes['whatsapp'] = ((bool) $this->session->userdata('emprendedor')['whatsapp']) ? 25 : 0;
        // Tiene productos
        $productos = $this->productos_model->get_productos($this->session->userdata('emprendedor')['id'], null, null, null, 0, 25);
        $porcentajes['producto'] = (count($productos) > 0) ? 25 : 0;

        // Asigna variable  a la interfaz
        $data['porcentajes'] = $porcentajes;
        /* Pintar las meta */
        $data['title'] = 'Administración';
        $data['descripcion'] = 'Zona de administración de emprendedor';
        $data['keywords'] = 'dashboard, adminstración, perfil emprendedor';
        // Cargar la vista
        $this->load->view('admin/index', $data);
    }

    /**
     * Página para visualizar los pedidos
     */
    public function pedidos()
    {
        // Consultar el emprendedor
        $emprendedor = $this->session->userdata('emprendedor');
        // Consultar los pedidos del emprendedor
        $data['pedidos'] = $this->compras_model->get_pedido_cliente($emprendedor['id']);
        /* Pintar las meta */
        $data['title'] = 'Tus pedidos';
        $data['descripcion'] = 'Revisa los pedidos que recibiste';
        $data['keywords'] = 'pedidos, lista de pedidos, notificación de pedidos';
        // Cargar la vista
        $this->load->view('admin/pedidos', $data);
    }

    /**
     * Detalle del pedido
     */
    public function detalles_pedido($id_compra)
    {
        // Validar si mandaron el id de la compra
        if (!is_null($id_compra)) {
            // Consultar el emprendedor
            $emprendedor = $this->session->userdata('emprendedor');
            // Consultar el cliente
            $data['cliente'] = $this->compras_model->get_cliente($id_compra);
            // Consultar los pedidos del emprendedor
            $data['detalles'] = $this->compras_model->get_detalles_pedido($emprendedor['id'], $id_compra);
            /* Pintar las meta */
            $data['title'] = 'Detalle del pedido';
            $data['descripcion'] = 'Aquí encuentras la información referente al pedido';
            $data['keywords'] = 'pedidos, lista de pedidos, notificación de pedidos';
            // Cargar la vista
            $this->load->view('admin/detalles_pedido', $data);
        } else {
            // Redirecciono a los pedidos
            $this->pedidos();
        }
    }

    /**
     * Mostrar los videos de la escuela
     */
    public function escuela()
    {

        /* Pintar las meta */
        $data['title'] = 'Escuela de Emprendedores';
        $data['descripcion'] = 'Bienvenido a la Escuela De Emprendedores';
        $data['keywords'] = 'educación, formación, capacitación, emprenderores';
        // Cargar la vista
        $this->load->view('admin/escuela', $data);
    }

    /**
     * Muestra las ciudades de distribución que tiene configurado el emprendedor
     */
    public function ciudades()
    {
        // Obtener la sesiones del pais
        $pais = $this->session->userdata('pais');
        // Eliminar las sesiones
        $this->session->unset_userdata($pais);
        // Consultar el pais
        $paisTemp = $this->ciudades_model->get_paises(array('id' => $this->session->userdata('emprendedor')['id_pais']));
        // Sobreescribir la sesion del pais
        $this->session->set_userdata('pais', $paisTemp[0]);

        // Obtener la sesión de la ciudad
        $ciudad = $this->session->userdata('ciudad');
        // Eliminar las sesiones
        $this->session->unset_userdata($ciudad);
        // Consultar la ciudad del emprendedor
        $ciudadTemp = $this->ciudades_model->get(array('id' => $this->session->userdata('emprendedor')['id_ciudad']));
        // Sobreescribir la sesion del pais
        $this->session->set_userdata('ciudad', $ciudadTemp);

        // Consultar las ciudades del emprendedor
        $ciudades_cobertura = $this->emprendedores_model->ciudades_emprendedor($this->session->userdata('emprendedor')['id']);
        // Asignar a la vista
        $data['coberturas'] = $ciudades_cobertura;

        // ISO
        $data['ISO'] = $this->session->userdata('pais')['ISO'];

        /* Pintar las meta */
        $data['title'] = 'Administrador de ciudades';
        $data['descripcion'] = 'Impactamos en tu zona de influencia, configura las ciudades donde puedes distribuir';
        $data['keywords'] = 'ciudades de distribución, administrador de ciudades';
        // Cargar la vista
        $this->load->view('admin/ciudades', $data);
    }

    /**
     * Agrega una nueva ciudad
     */
    public function agregar_ciudad()
    {
        // Pasa los parametros post a la validación
        $this->form_validation->set_data($this->input->post());
        // XSS filtro
        $params = $this->security->xss_clean($this->input->post());

        // Validar que no se agreguen 2 veces la misma ciudad
        $this->form_validation->set_rules(
            'ciudad',
            'ciudad',
            'trim|required|callback_validar_ciudad[' . $params['ciudad'] . ']',
            array(
                'required'  => 'La %s es obligatoria',
                'validar_ciudad' => 'Ya agregaste la %s en tu configuración'
            )
        );

        // Valida si el formulario fue diligenciado correctamente
        if ($this->form_validation->run() === FALSE) {
            // Redireccionar a la pagina de configuración de ciudades
            $this->ciudades();
        } else {
            // Crear data para insertar
            $data = array(
                'id_emprendedor' => $this->session->userdata('emprendedor')['id'],
                'id_ciudad' => $params['ciudad']
            );
            // Insertar la ciudad
            $this->emprendedores_model->insertar_ciudad($data);
            // Reenviar a la vista de ciudades;
            redirect(site_url('admin/ciudades'));
        }
    }

    /**
     * Valida si el email y telefono son el mismo
     */
    public function validar_ciudad($id_ciudad)
    {
        // Obtener el id del emprendedor
        $id_emprendedor = $this->session->userdata('emprendedor')['id'];
        // Valida si el telefono y email corresponden
        $result = $this->emprendedores_model->validar_ciudad($id_emprendedor, $id_ciudad);
        // Si tiene resultados
        if ($result > 0) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Elimina una ciudad
     */
    public function eliminar_ciudad()
    {
        // Pasa los parametros post a la validación
        $this->form_validation->set_data($this->input->post());
        // XSS filtro
        $params = $this->security->xss_clean($this->input->post());

        // No permitir que se quede sin ciudades configuradas
        $this->form_validation->set_rules(
            'id',
            'ciudad',
            'trim|required|callback_validar_emprendedor',
            array(
                'required'  => 'La %s es obligatoria',
                'validar_emprendedor' => 'Debes tener al menos una %s'
            )
        );

        // Valida si el formulario fue diligenciado correctamente
        if ($this->form_validation->run() === FALSE) {
            // Redireccionar a la pagina de configuración de ciudades
            $this->ciudades();
        } else {
            $this->emprendedores_model->eliminar_ciudad($params['id']);
            // Reenviar a la vista de ciudades;
            redirect(site_url('admin/ciudades'));
        }
    }

    /**
     * Valida si el email y telefono son el mismo
     */
    public function validar_emprendedor()
    {
        // Obtener el id del emprendedor
        $id_emprendedor = $this->session->userdata('emprendedor')['id'];
        // Valida si el telefono y email corresponden
        $result = $this->emprendedores_model->ciudades_emprendedor($id_emprendedor);
        // Si tiene resultados
        if (count($result) == 1) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Lanzar formulario feria virtual
     */
    public function feria_virtual()
    {
        // Consultar la ciudad del emprendedor
        $id_ciudad = $this->session->userdata('emprendedor')['id_ciudad'];
        // Consultar la ciudad
        $ciudad = $this->ciudades_model->get_ciudades(array('id' => $id_ciudad));
        // Consultar el departamento
        $departamento = $this->ciudades_model->get_departamentos(array('id' => $ciudad[0]['id_departamento']));

        // Consultar si el emprendedor se encuentra ya inscrito
        $contar = $this->emprendedores_model->emprendedor_feria(array('id_emprendedor' => $this->session->userdata('emprendedor')['id']));

        // Si tiene registros
        if ($contar > 0) {
            // Redireccionar a la pagina que ya esta lista
            redirect(site_url('admin/feria-virtual/registrado'));
        } else {
            // Validar si esta en risaralda
            if ($departamento[0]['nombre'] == 'Risaralda') {
                $data['title'] = 'Feria Virtual De Negocios';
                $data['descripcion'] = 'Al participar en la feria virtual usted tendrá acceso a la vitrina virtual para ofertar y promocionar sus productos o servicios podrá asistir a la rueda de negocios ';
                $data['keywords'] = 'feria virtual de negocios, Red De Emprendimiento De Risaralda, pereira, promocionar productos, sena';

                // Cargar la vista
                $this->load->view('admin/feria-pereira', $data);
            } else {
                // Redirecciona al tablero
                redirect(site_url('admin/index'));
            }
        }
    }

    /**
     * Guardar el registro en la feria
     */
    public function registro_feria()
    {
        // Pasa los parametros post a la validación
        $this->form_validation->set_data($this->input->post());
        // XSS filtro
        $params = $this->security->xss_clean($this->input->post());

        // Traer la informacion del emprendedor
        $emprendedor = $this->session->userdata('emprendedor');
        // Consultar la ciudad del emprendedor
        $ciudad = $this->ciudades_model->get_ciudades(array('id' => $emprendedor['id_ciudad']));

        $actividades = array(
            '1' => 'Rueda de negocios',
            '2' => 'Mentorias personalizadas (30 minutos por emprendedor)',
            '3' => 'Ambas',
        );

        $permisos = array(
            '1' => 'Registro en Cámara de Comercio',
            '2' => 'Registro Invima',
            '3' => 'Registro ICA',
            '4' => 'Registro de Marca',
            '5' => 'Código de Barras',
            '6' => 'Ninguno',
        );

        // Construir el mensaje de los permisos
        $msj_permiso = '';
        foreach ($params['permisos'] as $permiso) {
            $msj_permiso .= $permisos[$permiso] . ' - ';
        }

        $mentorias = array(
            '1' => 'Bioseguridad',
            '2' => 'Obtener clientes digitales',
            '3' => 'Técnicas de negociación (cierre de negocios)',
            '4' => 'Asesoría empresarial',
            '5' => 'Asesoría Laboral',
            '6' => 'Asesoría Financiera',
            '7' => 'Decretos del gobierno',
            '8' => 'INVIMA',
            '9' => 'ICA',
            '10' => 'Propiedad Industrial (Registro de Marca, Derechos de Autor y Patentes)',
        );

        // Construir el mensaje de los permisos
        $msj_mentoria = '';
        foreach ($params['mentorias'] as $mentoria) {
            $msj_mentoria .= $mentorias[$mentoria] . ' - ';
        }

        // Construir el data para enviar el email
        $data = array(
            "sender" => array(
                "name" => SENDINBLUE_SENDER_NAME,
                "email" => SENDINBLUE_SENDER_EMAIL
            ),
            "to" => array([
                "name" => 'Adriana Chica Giraldo',
                "email" => 'achicag@sena.edu.co'
            ]),
            "templateId" => 8,
            "subject" => "Emprendedor registrado a la Feria Virtual",
            "params" => array(
                "NOMBRE" => $emprendedor['nombre'],
                "EMPRENDIMIENTO" => $emprendedor['emprendimiento'],
                "CIUDAD" => $ciudad[0]['nombre'],
                "TELEFONO" => $emprendedor['telefono'],
                "EMAIL" => $emprendedor['email'],
                "ACTIVIDADES" => $actividades[$params['actividades'][0]],
                "PERMISOS" => $msj_permiso,
                "PRODUCTOS" => $params['productos'],
                "TIPOCLIENTE" => $params['cliente'],
                "MENTORIAS" => $msj_mentoria,
                "DUDAS" => $params['dudas'],
            )
        );

        // Insertar registro en la base de datos
        $this->emprendedores_model->insertar_feria(array(
            'id_emprendedor' => $emprendedor['id'],
            'actividades' => $actividades[$params['actividades'][0]],
            'permisos' => $msj_permiso,
            'productos' => $params['productos'],
            'tipo_cliente' => $params['cliente'],
            'mentorias' => $msj_mentoria,
            'dudas' => $params['dudas'],
        ));

        // Enviar email
        $this->notificaciones_model->email($data);

        // Reenviar a la página de registro recibido
        redirect(site_url('admin/feria-virtual/registrado'));
    }

    public function confirmacion_feria()
    {
        $data['title'] = 'Feria Virtual De Negocios';
        $data['descripcion'] = 'Al participar en la feria virtual usted tendrá acceso a la vitrina virtual para ofertar y promocionar sus productos o servicios podrá asistir a la rueda de negocios ';
        $data['keywords'] = 'feria virtual de negocios, Red De Emprendimiento De Risaralda, pereira, promocionar productos, sena';

        // Cargar la vista
        $this->load->view('admin/feria-pereira-confirmacion', $data);
    }
}
