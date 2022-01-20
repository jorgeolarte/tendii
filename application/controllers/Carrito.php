<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Carrito extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        /* Habilita las cookies */
        $this->load->helper('cookie');
        $this->load->helper('html');
        $this->load->helper('file');

        // Validar si tiene la cookie creada
        if (is_null($this->session->userdata('cliente')['cookie'])) {
            // Recargar el controlador tienda/index
            redirect(site_url($this->session->userdata('pais')['ISO'] . '/' . $this->session->userdata('ciudad')));
        } else {
            /* Incluye el modelo */
            $this->load->model('ciudades_model');
            $this->load->model('clientes_model');
            $this->load->model('compras_model');
            $this->load->model('notificaciones_model');
            $this->load->model('productos_model');
        }
    }

    /**
     * Mostrar el carrito de compra
     */
    public function index()
    {
        // Obtener el pais
        $iso = $this->uri->segment(1);
        // Validar si viene el pais
        $iso = is_null($iso) ? 'CO' : $iso;
        // Validar que viene la ciudad
        if (is_null($this->session->userdata('ciudad'))) {
            // No viene la ciudad
            // Redireccionar al pais
            redirect(site_url($iso));
        } else {
            // Si no viene la ciudad
            if ((is_null($this->session->userdata('pais')['ISO'])) || ($this->session->userdata('pais')['ISO'] != $iso)) {
                // Consultar el pais
                $pais = $this->ciudades_model->get_paises(array('ISO' => $iso));

                var_dump($this->session->userdata('pais'));
                die;

                // Agrerga el pais
                $this->session->set_userdata('pais', $pais[0]);
            }

            // Agregar producto al carrito
            // 1 Consultar la cookie
            $cookie = $this->session->userdata('cliente');
            // 1.1 traer el ID del cliente
            $cliente = $this->clientes_model->get(array("cookie" => $cookie['cookie']));

            // Consultar el pais
            //$pais = $this->ciudades_model->get_paises(array('ISO' => $this->session->userdata('pais')['ISO']));
            // Consultar el ID de la ciudad
            //$ciudades = $this->ciudades_model->get_ciudades(array('slug' => $this->session->userdata('ciudad')));

            // 2. Consultar si el cliente tiene una compra activa
            $compras = $this->compras_model->get(
                array(
                    'id_cliente' => $cliente['id'],
                    'id_pais' => $this->session->userdata('pais')['id'],
                    //'id_ciudad' => $this->session->userdata('ciudad')['id'],
                    'estado' => '1'
                )
            );

            // Valida si hay compras
            if (count($compras) == 0) {
                // Redireccionar a la tienda
                //redirect(site_url($this->session->userdata('pais')['ISO']));
                // Limpia las variables
                $compras = array();
                $compras['total'] = 0;
            } else {
                foreach ($compras as $pos => $compra) {
                    // Consultar todas los detalles de compra
                    $compras[$pos]['confirmar'] = ($compra['total'] >= $this->session->userdata('pais')['valor_minimo']) ? true : false;
                    $compras[$pos]['detalles'] =  $this->compras_model->get_carrito($compra['id'], null, null, null);
                    $compras[$pos]['ciudad'] =  $this->ciudades_model->get(array('id' => $compra['id_ciudad']));
                    //$compras[$pos]['detalles'] = array();
                    //array_push($compras[$pos]['detalles'], $this->compras_model->get_carrito($compra['id'], null, null, null));
                }
            }

            // Agregar las variables a la vista
            $data['compras'] = $compras;
            $data['pais'] = $this->session->userdata('pais');

            /* Pintar las meta */
            $data['title'] = 'Carrito de compra';
            $data['descripcion'] = 'Lista de productos de tu carrito de compras';
            $data['keywords'] = 'domicilio en ' . $this->session->userdata('ciudad')['nombre'] . ', tienda en internet,  como vender en internet';

            // Carga de página
            $this->load->view('tienda/carrito', $data);
        }
    }

    /**
     * Cargar carrito de compra
     */
    public function agregar()
    {
        // Obtener el pais
        $iso = $this->uri->segment(1);
        // Validar si viene el pais
        $iso = is_null($iso) ? 'CO' : $iso;
        // Validar que viene la ciudad
        if (is_null($this->session->userdata('ciudad'))) {
            // No viene la ciudad
            // Redireccionar al pais
            redirect(site_url($iso));
        } else {
            // Si no viene la ciudad
            if ((is_null($this->session->userdata('pais')['ISO'])) || ($this->session->userdata('pais')['ISO'] != $iso)) {

                echo "<pre>";
                var_dump($this->session->userdata('pais'));
                var_dump($iso);
                die;

                // Consultar el pais
                $pais = $this->ciudades_model->get_paises(array('ISO' => $iso));
                // Agrerga el pais
                $this->session->set_userdata('pais', $pais[0]);
            }

            // Pasa los parametros post a la validación
            $this->form_validation->set_data($this->input->post());
            // XSS filtro
            $params = $this->security->xss_clean($this->input->post());
            // Cargar libreria de validacion
            $this->load->helper('form');
            $this->load->library('form_validation');

            // Validacion de reglas de negocio
            $this->form_validation->set_rules(
                'cantidad',
                'cantidad',
                'required|numeric|greater_than_equal_to[1]',
                array(
                    'required'                  => 'Debe enviar la %s de productos agregar',
                    'numeric'                   => 'Ingrese una %s valida',
                    'greater_than_equal_to'     => 'La %s de productos debe ser mayor a 0'
                )
            );

            // Validar si los datos enviados son correctos
            if ($this->form_validation->run() === FALSE) {
                var_dump(validation_errors());
                var_dump($this->form_validation->error_array());
                var_dump($params);
            } else {
                // Obtengo la url anterior
                $this->session->back_url = $params['back_url'];
                // Consultar el codigo del cliente
                $cookie = $this->session->userdata('cliente');

                // Consultar el ID del pais
                // $pais = $this->ciudades_model->get_paises(array('ISO' => $this->session->userdata('pais')['ISO']));
                // Consultar el ID de la ciudad
                // $ciudades = $this->ciudades_model->get_ciudades(array('slug' => $this->session->userdata('ciudad')['slug']));

                // 1.1 traer el ID del cliente
                $cliente = $this->clientes_model->get(array("cookie" => $cookie['cookie']));

                // Construir el array para insertar la compra
                $query = array(
                    'id_cliente' => $cliente['id'],
                    'id_pais' => $this->session->userdata('pais')['id'],
                    'id_ciudad' => $this->session->userdata('ciudad')['id']
                );

                // 2. Consultar si el cliente tiene una compra activa
                $compra = $this->compras_model->get($query);

                // Valida si tiene datos la compra
                if (count($compra) == 0) {
                    // 3 Inserta la compra
                    $this->compras_model->insertar($query);
                    // Consulta la compra
                    $compra = $this->compras_model->get($query);
                }

                // 4 Crear el detalle de la compra
                // Construir el query de busqueda
                $query = array(
                    'id_compra' => $compra[0]['id'],
                    'id_cliente' => $cliente['id'],
                    'id_producto' => $params['id_producto'],
                    'id_pais' => $this->session->userdata('pais')['id'],
                    'id_ciudad' => $this->session->userdata('ciudad')['id'],
                    'estado' => '1'
                );
                $detallx = $this->compras_model->get_detalle($query);

                // Valido si la compra ya tiene el producto
                if (!is_null($detallx)) {
                    // Si es asi, actualizo el detalle cantidad
                    $detallx['cantidad'] = $detallx['cantidad'] + 1;
                    $detallx['subtotal'] = $detallx['cantidad'] * $params['precio'];
                    $detallx['estado'] = '1';
                    // Conversión entre fechas
                    $unixTimestamp = time();
                    $detallx['fecha_modificacion'] = date("Y-m-d H:i:s", $unixTimestamp);
                    // Actualizo el detalle
                    $this->compras_model->actualizar_detalle($detallx);
                } else {
                    // Sino, termino de construir el array a insertar
                    $query['id_emprendedor'] = $params['id_emprendedor'];
                    $query['cantidad'] = $params['cantidad'];
                    $query['valor_unitario'] = $params['precio'];
                    $query['subtotal'] = $params['cantidad'] * $params['precio'];
                    $query['estado'] = '1';
                    // Enviar a insertar
                    $this->compras_model->insertar_detalle($query);
                    // Consultar el detalle
                    $detallx = $this->compras_model->get_detalle($query);
                }

                // Actualizar el precio total de la compra
                // Query de consulta
                $query = array(
                    'id_cliente' => $cliente['id'],
                    'id_ciudad' => $this->session->userdata('ciudad')['id'],
                    'id_pais' => $this->session->userdata('pais')['id'],
                    'estado' => '1'
                );
                // Consultar todas los detalles de compra
                $detalles = $this->compras_model->get_detalles($query);

                // Variable total
                $total = 0;
                // Calculo el total de la factura
                foreach ($detalles as $detalle) {
                    $total += $detalle['subtotal'];
                }

                // Actualizo el valor de la factura
                $compra[0]['total'] = $total;
                // Actualizo la compra
                $this->compras_model->actualizar($compra[0]);

                // Agregar las variables a la vista
                $data['compra'] = $compra[0];
                // Trae toda la información del detalle
                $data['detalles'] = $this->compras_model->get_carrito(null, $detallx['id'], null, $this->session->userdata('ciudad')['slug']);
                /* Pintar las meta */
                $data['title'] = 'Producto agregado';
                $data['descripcion'] = 'Tu producto ha sido agregado al carrito';
                $data['keywords'] = 'agregar productos, carrito de compra, domicilios en ' . $this->session->userdata('ciudad')['nombre'] . ', vender en internet';
                // Carga de página
                $this->load->view('tienda/agregado', $data);
            }
        }
    }

    /**
     * Confirmar la compra
     */
    public function confirmar()
    {
        // Pasa los parametros post a la validación
        $this->form_validation->set_data($this->input->post());
        // XSS filtro
        $params = $this->security->xss_clean($this->input->post());

        // Consultar la información del pais
        $pais = $this->ciudades_model->get_paises(array('id' => $params['id_pais']));
        // Consultar el ID de la ciudad
        $ciudades = $this->ciudades_model->get_ciudades(array('id' => $params['id_ciudad']));

        // var_dump($ciudades);
        // die;

        // 1 Consultar la cookie
        $cookie = $this->session->userdata('cliente');
        // 1.1 traer el ID del cliente
        $cliente = $this->clientes_model->get(array("cookie" => $cookie['cookie']));
        // Construir el array para insertar la compra
        $query = array(
            'id_cliente' => $cliente['id'],
            'id_pais' => $pais[0]['id'],
            'id_ciudad' => $ciudades[0]['id'],
            'estado' => '1'
        );
        // 2. Consultar si el cliente tiene una compra activa
        $compra = $this->compras_model->get($query);

        // Valida si tiene datos la compra
        if (count($compra) == 0) {
            // Redireccionar al carrito
            redirect($this->session->userdata('pais')['ISO'] . '/carrito');
        } else {
            // Validar que el precio de la compra sea superior al valor minimo
            if ($compra[0]['total'] >= $pais[0]['valor_minimo']) {
                // Agregar las variables a la vista
                $data['compra'] = $compra[0];
                // Trae toda la información del detalle
                $data['detalles'] = $this->compras_model->get_carrito($compra[0]['id'], null, null, $this->session->userdata('ciudad')['slug']);
                // Si al realizar la consulta no tiene productos
                if (count($data['detalles']) == 0) {
                    // Redireccionar a la ciudad
                    redirect(site_url($this->session->userdata('ciudad')));
                } else {
                    $data['pais'] = $pais[0];
                    $data['ciudad'] = $ciudades[0];
                    /* Pintar las meta */
                    $data['title'] = 'Confirmar compra';
                    $data['descripcion'] = 'Diligencia el siguiente formulario para enviar los productos';
                    $data['keywords'] = 'confirmar compra, compra a emprendedores, carrito de compra, domicilios en ' . $ciudades[0]['nombre'] . ', emprendedores de ' . $ciudades[0]['nombre'];
                    // Carga de página
                    $this->load->view('tienda/confirmar', $data);
                }
            } else {
                // Redireccionar al carrito
                redirect($this->session->userdata('pais')['ISO'] . '/carrito');
            }
        }
    }

    /**
     * Metodo encargado de guardar el pedido
     */
    public function enviar()
    {
        // Pasa los parametros post a la validación
        $this->form_validation->set_data($this->input->post());
        // XSS filtro
        $params = $this->security->xss_clean($this->input->post());

        // Consultar la información del pais donde se esta comprando
        $pais = $this->ciudades_model->get_paises(array('id' => $params['id_pais']));
        // Consultar el ID de la ciudad
        $ciudad = $this->ciudades_model->get_ciudades(array('id' => $params['id_ciudad']));

        // Cargar libreria de validacion
        $this->load->helper('form');
        $this->load->library('form_validation');

        // Validacion de reglas de negocio
        $this->form_validation->set_rules(
            'nombre',
            'nombre',
            'trim|required',
            array(
                'required'  => 'Necesitamos tu %s para despachar el pedido'
            )
        );

        $this->form_validation->set_rules(
            'telefono',
            'teléfono',
            'trim|required',
            array(
                'required'  => 'El %s es obligatorio'
            )
        );

        $this->form_validation->set_rules(
            'email',
            'correo electrónico',
            'trim|required|valid_email',
            array(
                'required'  => 'El %s es obligatorio',
                'valid_email'  => 'Ingresa un %s valido'
            )
        );

        $this->form_validation->set_rules(
            'barrio',
            'barrio',
            'trim|required',
            array(
                'required'  => 'El %s es obligatorio'
            )
        );

        $this->form_validation->set_rules(
            'direccion',
            'dirección',
            'trim|required',
            array(
                'required'  => 'La %s es obligatoria'
            )
        );

        // Validar si los datos enviados son correctos
        if ($this->form_validation->run() === FALSE) {
            // Redirecciono a confirmar
            redirect("{$this->session->userdata('pais')['ISO']}/carrito/confirmar");
        } else {
            // 1 Consultar la cookie
            $cookie = $this->session->userdata('cliente');
            // 1.1 traer el ID del cliente
            $cliente = $this->clientes_model->get(array("cookie" => $cookie['cookie']));
            // Carga el modelo del usuario
            $cliente['nombres'] = $params['nombre'];
            $cliente['telefono'] = $params['telefono'];
            $cliente['email'] = $params['email'];
            $cliente['ISO'] = $params['iso'];
            // Conversión entre fechas
            $unixTimestamp = time();
            $cliente['fecha_creacion'] = date("Y-m-d H:i:s", $unixTimestamp);
            // Actualiza el usuario
            $this->clientes_model->actualizar($cliente);
            // Creo el array de dirección del cliente
            $direccion = array(
                'id_cliente' => $cliente['id'],
                'id_pais' => $pais[0]['id'],
                'id_ciudad' => $ciudad[0]['id'],
                'direccion' => $params['direccion'],
                'barrio' => $params['barrio'],
                'observaciones' => $params['observaciones']
            );
            // Crear la direccion
            $this->clientes_model->insertar_direccion($direccion);

            // 2. Consultar si el cliente tiene una compra activa
            $compra = $this->compras_model->get(
                array(
                    'id_cliente' => $cliente['id'],
                    'id_pais' => $pais[0]['id'],
                    'id_ciudad' => $ciudad[0]['id'],
                    'estado' => '1'
                )
            );

            // Cargar los detalles de la compra
            $detalles = $this->compras_model->get_carrito($compra[0]['id'], null, null, $ciudad[0]['slug']);

            // Construye el email para enviar al cliente
            $data_cliente = $this->data_cliente($cliente, $direccion, $detalles);
            // Enviar email al cliente
            $this->notificaciones_model->email($data_cliente);

            // Notificación vía Whatsapp a mi telefono
            $mensaje = 'Your *nuevo pedido* code is *ingresa 👉 _' . site_url('admin/pedido/' . $compra[0]['id']) . '_ 👈 para conocer los detalles de tu pedido*';
            $this->notificaciones_model->whatsapp('+573017516045', $mensaje);

            // Consultar los emprendedores que hay en la compra
            $emprendedores = $this->compras_model->get_emprendedores($compra[0]['id']);

            // Recorrer todos los emprendedores
            foreach ($emprendedores as $emprendedor) {
                // Construir el array
                $data_emprendedor = $this->data_emprendedor($emprendedor['nombre'], $emprendedor['email'], $emprendedor['emprendimiento'], site_url('admin/pedido/' . $compra[0]['id']));
                // Enviar email al emprendedor
                $this->notificaciones_model->email($data_emprendedor);
                // Si tiene el whatsapp activo
                if ($emprendedor['whatsapp'] == 1) {
                    // Consulto el pais del emprendedor
                    $pais_e = $this->ciudades_model->get_paises(array('id' => $emprendedor['id_pais']));
                    // Construyo el telefono
                    $pre_telefono = '+' . $pais_e[0]['prefijo'] . $emprendedor['telefono'];
                    // Mensaje notificacion whatsapp
                    $mensaje = 'Your *' . $emprendedor['emprendimiento']  . '* code is *ingresa 👉 _' . site_url('admin/pedido/' . $compra[0]['id']) . '_ 👈 para conocer los detalles de tu pedido*';
                    // Texto whatsapp emprendedor
                    $this->notificaciones_model->whatsapp($pre_telefono, $mensaje);
                }
            }

            // Eliminar la cookie
            $sesion_cliente = $this->session->userdata('cliente');
            // Elimina el emprendedor
            $this->session->unset_userdata($sesion_cliente);
            // Destruye la sesion
            $this->session->sess_destroy();

            // Actualiza los detalles
            foreach ($detalles as $detalle) {
                // Consultar el detalle
                $resultado = $this->compras_model->get_detalle(array('id' => $detalle['id_detalle']));
                // Cambio el estado
                $resultado['estado'] = '2';
                $resultado['fecha_modificacion'] = date("Y-m-d H:i:s", $unixTimestamp);
                // Actualizo el detalle
                $this->compras_model->actualizar_detalle($resultado);
            }

            // Cambiar el estado y la fecha de compra de la compra
            $compra[0]['estado'] = '2';
            $compra[0]['fecha_compra'] = date("Y-m-d H:i:s", $unixTimestamp);
            // Actualizar la compra
            $this->compras_model->actualizar($compra[0]);

            // Enviar información a la vista
            $data['detalles'] = $detalles;
            // Redireccionar a la vista final
            $data['title'] = 'Pedido confirmado';
            $data['descripcion'] = 'Diligencia el siguiente formulario para enviar los productos';
            $data['keywords'] = 'domicilios en ' . $ciudad[0]['nombre'] . ', confirmación del pedido, emprendedores en ' . $ciudad[0]['nombre'] . ', tienda virtual, comprar por internet';

            // Carga de página
            $this->load->view('tienda/enviar', $data);
        }
    }

    /**
     * Borrar elemento del carrito
     */
    public function borrar()
    {
        // Pasa los parametros post a la validación
        $this->form_validation->set_data($this->input->post());
        // XSS filtro
        $params = $this->security->xss_clean($this->input->post());
        // Cargar libreria de validacion
        $this->load->helper('form');
        $this->load->library('form_validation');
        // Cambiar el estado del producto
        $this->compras_model->borrar_detalle($params['id_detalle']);
        // Recalcular el total de la compra
        $this->calcular_total($params['id_detalle']);
        // Redireccionar a la principal
        redirect($params['back_url']);
    }

    /**
     * Metodo agrega 1 elemento a la venta
     */
    public function mas()
    {
        // Pasa los parametros post a la validación
        $this->form_validation->set_data($this->input->post());
        // XSS filtro
        $params = $this->security->xss_clean($this->input->post());
        // Cargar libreria de validacion
        $this->load->helper('form');
        $this->load->library('form_validation');
        // Consulto el detalle
        $detalle = $this->compras_model->get_detalle(array('id' => $params['id_detalle']));
        // Actualizo la cantidad del detalle
        $detalle['cantidad'] += 1;
        // Actualizo el subtotal
        $detalle['subtotal'] = $detalle['cantidad'] * $detalle['valor_unitario'];
        // Conversión entre fechas
        $unixTimestamp = time();
        $detalle['fecha_modificacion'] = date("Y-m-d H:i:s", $unixTimestamp);
        // Actualizo el detalle
        $this->compras_model->actualizar_detalle($detalle);
        // Recalculo el total de la compra
        $this->calcular_total($params['id_detalle']);
        // Redireccionar a la principal
        redirect($params['back_url']);
    }

    /**
     * Quita un elemento al detalle de la compra
     */
    public function menos()
    {
        // Pasa los parametros post a la validación
        $this->form_validation->set_data($this->input->post());
        // XSS filtro
        $params = $this->security->xss_clean($this->input->post());
        // Cargar libreria de validacion
        $this->load->helper('form');
        $this->load->library('form_validation');

        // Consulto el detalle
        $detalle = $this->compras_model->get_detalle(array('id' => $params['id_detalle']));
        // Actualizo la cantidad del detalle
        $detalle['cantidad'] -= 1;
        // Actualizo el subtotal
        $detalle['subtotal'] = $detalle['cantidad'] * $detalle['valor_unitario'];
        // Conversión entre fechas
        $unixTimestamp = time();
        $detalle['fecha_modificacion'] = date("Y-m-d H:i:s", $unixTimestamp);
        // Actualizo el detalle
        $this->compras_model->actualizar_detalle($detalle);
        // Valido si la cantidad es igual a  0
        if ($detalle['cantidad'] == 0) {
            // Borro el elemento del carrito
            $this->compras_model->borrar_detalle($params['id_detalle']);
        }
        // Recalculo el total de la compra
        $this->calcular_total($params['id_detalle']);
        // Redireccionar a la principal
        redirect($params['back_url']);
    }

    /**
     * Recalcula el total del carrito
     */
    private function calcular_total($id_detalle)
    {
        // Si no viene la ciudad
        if ((is_null($this->session->userdata('pais')['ISO'])) || ($this->session->userdata('pais')['ISO'] != $this->uri->segment(1))) {
            // Agrerga la ciudad
            $this->session->set_userdata('pais', $this->uri->segment(1));
        }

        // Consulta el detalle de la factura
        $detalle = $this->compras_model->get_detalle(array('id' => $id_detalle));
        // Consulto todos los detalles que se encuentren activos
        $detalles = $this->compras_model->get_detalles(
            array(
                'id_compra' => $detalle['id_compra'],
                //'pais' => $this->session->userdata('pais')['ISO'],
                //'ciudad' => $this->session->userdata('ciudad'), 
                'estado' => '1'

            )
        );

        // Variable para calcular el total
        $total = 0;

        // Recalculo el total
        foreach ($detalles as $d) {
            // Acumulo el total
            $total += $d['subtotal'];
        }
        // Construyo el array a modificar
        $compra = array(
            'id' => $detalle['id_compra'],
            'total' => $total
        );
        // Actualizo la compra
        $this->compras_model->actualizar($compra);
    }

    /**
     * Metodo encargado de construir el array para enviar el correo
     */
    private function data_cliente($cliente, $direccion, $detalles)
    {
        // Calcula el total a pagar
        $total = 0;
        foreach ($detalles as $detalle) {
            $total = number_format($detalle['total_compra'], $this->session->userdata('pais')['decimales']);
        }

        // construye el array a enviar
        $data = array(
            "sender" => array(
                "name" => "Tienda Emprendedores",
                "email" => "info@tiendaemprendedores.com"
            ),
            "to" => array([
                "name" => $cliente['nombres'],
                "email" => $cliente['email']
            ]),
            "templateId" => 5,
            "subject" => "Confirmación de tu pedido",
            "params" => array(
                "NOMBRES" => $cliente['nombres'],
                "DETALLES" => $detalles,
                "TOTAL_COMPRA" => $total,
                "BARRIO" => $direccion['barrio'],
                "DIRECCION" => $direccion['direccion'],
                "OBSERVACIONES" => $direccion['observaciones'],
            )
        );

        return $data;
    }

    /**
     * Construye el data para enviar el email del emprendedor
     */
    private function data_emprendedor($nombre, $email, $emprendimiento, $url)
    {
        $data = array(
            "sender" => array(
                "name" => "Tienda Emprendedores",
                "email" => "info@tiendaemprendedores.com"
            ),
            "to" => array([
                "name" => $nombre,
                "email" => $email
            ]),
            "templateId" => 2,
            "subject" => $emprendimiento . ": Tienes un nuevo pedido",
            "params" => array(
                "LINK" => $url . "?utm_source=sendinblue&utm_medium=email&utm_campaign=notificacion_pedido",
                "EMPRENDIMIENTO" => $emprendimiento
            )
        );

        return $data;
    }

    /**
     * METODO OBSOLETO
     * Construye el texto para el email del cliente
     */
    // private function texto_cliente($cliente, $direccion, $detalles)
    // {
    //     // Lee el archivo 
    //     $template = file_get_contents(base_url('assets/mensajes/email-cliente.txt'));

    //     $tr = '';
    //     $total = 0;
    //     foreach ($detalles as $detalle) {
    //         $tr .= "<tr>";
    //         $tr .= "<td>" . $detalle['nombre_producto'] . "<br>" . $detalle['emprendimiento_emprendedor'] . "</td>";
    //         $tr .= "<td>" . $detalle['cantidad_detalle'] . "</td>";
    //         $tr .= "<td>$" . number_format($detalle['valor_detalle']) . "</td>";
    //         $tr .= "<td>$" . number_format($detalle['subtotal_detalle']) . "</td>";
    //         $tr .= "</tr>";
    //         $total = number_format($detalle['total_compra']);
    //     }

    //     // Reemplazar los textos
    //     $template = str_replace("{{cliente}}", $cliente['nombres'], $template);
    //     $template = str_replace("{{detalles}}", $tr, $template);
    //     $template = str_replace("{{total}}", $total, $template);

    //     // Texto de la direccion
    //     $template = str_replace("{{barrio}}", $direccion['barrio'], $template);
    //     $template = str_replace("{{direccion}}", $direccion['direccion'], $template);
    //     $template = str_replace("{{observaciones}}", $direccion['observaciones'], $template);

    //     // Retorna el texto
    //     return $template;
    // }

    /**
     * METODO OBSOLETO
     * Construye el texto para el email del cliente
     */
    // private function whatsapp_cliente($cliente, $direccion, $detalles)
    // {
    //     // Lee el archivo 
    //     $template = file_get_contents(base_url('assets/mensajes/whatsapp-cliente.txt'));

    //     $tr = '';
    //     $total = 0;
    //     foreach ($detalles as $detalle) {
    //         $tr .= $detalle['nombre_producto'] . " / " . $detalle['emprendimiento_emprendedor'] . "     |     ";
    //         $tr .= $detalle['cantidad_detalle'] . "     |     ";
    //         $tr .= "$" . number_format($detalle['valor_detalle']) . "     |     ";
    //         $tr .= "$" . number_format($detalle['subtotal_detalle']) . "     |     ";
    //         $total = number_format($detalle['total_compra']);
    //     }

    //     // Reemplazar los textos
    //     $template = str_replace("{{cliente}}", $cliente['nombres'], $template);
    //     $template = str_replace("{{detalles}}", $tr, $template);
    //     $template = str_replace("{{total}}", $total, $template);

    //     // Texto de la direccion
    //     $template = str_replace("{{barrio}}", $direccion['barrio'], $template);
    //     $template = str_replace("{{direccion}}", $direccion['direccion'], $template);
    //     $template = str_replace("{{observaciones}}", $direccion['observaciones'], $template);

    //     // Retorna el texto
    //     return $template;
    // }

    /**
     * METODO OBSOLETO
     * Construye el texto a enviar al emprendedor
     */
    // private function texto_emprendedor($emprendedor, $cliente, $direccion, $detalles)
    // {
    //     // Lee el archivo 
    //     $template = file_get_contents(base_url('assets/mensajes/email-emprendedor.txt'));

    //     $tr = '';
    //     $total = 0;
    //     foreach ($detalles as $detalle) {
    //         $tr .= "<tr>";
    //         $tr .= "<td>" . $detalle['nombre_producto'] . "<br>" . $detalle['emprendimiento_emprendedor'] . "</td>";
    //         $tr .= "<td>" . $detalle['cantidad_detalle'] . "</td>";
    //         $tr .= "<td>$" . number_format($detalle['valor_detalle']) . "</td>";
    //         $tr .= "<td>$" . number_format($detalle['subtotal_detalle']) . "</td>";
    //         $tr .= "</tr>";
    //         $total += $detalle['subtotal_detalle'];
    //     }

    //     // Datos del emprendedor
    //     $template = str_replace("{{emprendedor}}", $emprendedor['nombre'], $template);

    //     // Textos del detalle de la compra
    //     $template = str_replace("{{detalles}}", $tr, $template);
    //     $template = str_replace("{{total}}", number_format($total), $template);

    //     // Textos del cliente 
    //     $template = str_replace("{{cliente}}", $cliente['nombres'], $template);
    //     $template = str_replace("{{telefono}}", $cliente['telefono'], $template);

    //     // Texto de la direccion
    //     $template = str_replace("{{barrio}}", $direccion['barrio'], $template);
    //     $template = str_replace("{{direccion}}", $direccion['direccion'], $template);
    //     $template = str_replace("{{observaciones}}", $direccion['observaciones'], $template);

    //     // Retorna el texto
    //     return $template;
    // }

    /**
     * METODO OBSOLETO
     * Construye el texto a enviar al emprendedor
     */
    // private function whatsapp_emprendedor($emprendedor, $cliente, $direccion, $detalles)
    // {
    //     // Lee el archivo 
    //     $template = file_get_contents(base_url('assets/mensajes/whatsapp-emprendedor.txt'));

    //     // $template = '*TIENES UN NUEVO PEDIDO*

    //     // Hey {{emprendedor}}

    //     // A continuacion la información del pedido

    //     // *Producto    |   Cantidad    |   Unidad  |   Precio*
    //     // {{detalles}}

    //     // *Total a pagar: ${{total}}*

    //     // *INFORMACIÓN DEL CLIENTE*
    //     // Nombre: *{{cliente}}*
    //     // Teléfono: *{{telefono}}*

    //     // Debes entregar el pedido en
    //     // - Barrio: *{{barrio}}*
    //     // - Dirección: *{{direccion}}*
    //     // - Observaciones: *{{observaciones}}*';

    //     $tr = '';
    //     $total = 0;
    //     foreach ($detalles as $detalle) {
    //         $tr .= $detalle['nombre_producto'] . " / " . $detalle['emprendimiento_emprendedor'] . "    |   ";
    //         $tr .= $detalle['cantidad_detalle'] . "    |   ";
    //         $tr .= "$" . number_format($detalle['valor_detalle']) . "    |   ";
    //         $tr .= "$" . number_format($detalle['subtotal_detalle']) . "    |   ";
    //         $total += $detalle['subtotal_detalle'];
    //     }

    //     // Datos del emprendedor
    //     $template = str_replace("{{emprendedor}}", $emprendedor['nombre'], $template);

    //     // Textos del detalle de la compra
    //     $template = str_replace("{{detalles}}", $tr, $template);
    //     $template = str_replace("{{total}}", number_format($total), $template);

    //     // Textos del cliente 
    //     $template = str_replace("{{cliente}}", $cliente['nombres'], $template);
    //     $template = str_replace("{{telefono}}", $cliente['telefono'], $template);

    //     // Texto de la direccion
    //     $template = str_replace("{{barrio}}", $direccion['barrio'], $template);
    //     $template = str_replace("{{direccion}}", $direccion['direccion'], $template);
    //     $template = str_replace("{{observaciones}}", $direccion['observaciones'], $template);

    //     // Retorna el texto
    //     return $template;
    // }
}
