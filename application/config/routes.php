<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

// Feria virtual SENA 2020
$route['feria-virtual']['get']          = 'inicio/feria';

// Manejo de sesiones
$route['login']['get']                  = 'zona/login';
$route['iniciar-sesion']['post']        = 'zona/iniciar_sesion';
$route['crear-tienda-online']['get']    = 'zona/nuevo_emprendedor';
$route['registrarse']['post']           = 'zona/registrar_emprendedor';
$route['cerrar-sesion']['post']         = 'zona/cerrar';

// Pagina inicial de la tienda
$route['pais/redireccionar']['post'] = 'pais/redireccionar';
// Cambiar de ciudad
$route['ciudad']['post'] = 'pais/cambiar_ciudad';

// ZONA DE ADMINISTRACIÓN
$route['admin']['get']                           = 'admin/index';
$route['admin/consultar-pais']['post']           = 'zona/consultar_pais_sesion';
$route['admin/ciudades']['get']                  = 'admin/ciudades';
$route['admin/ciudades/agregar']['post']         = 'admin/agregar_ciudad';
$route['admin/ciudades/eliminar']['post']        = 'admin/eliminar_ciudad';
$route['admin/tienda/nueva']['get']              = 'perfiles/nuevo';
$route['admin/tienda/crear']['post']             = 'perfiles/crear';
$route['admin/validar_nombre']['post']           = 'perfiles/validar_nombre_ajax';
$route['admin/cargar_logo']['post']              = 'zona/cargar_logo';
$route['admin/whatsapp']['get']                  = 'perfiles/whatsapp';
$route['admin/whatsapp/verificar']['post']       = 'perfiles/verificar_envio';
$route['admin/whatsapp/confirmar']['post']       = 'perfiles/confirmar_envio';
$route['admin/whatsapp/confirmar/(:num)']['get'] = 'perfiles/confirmar_mensaje/$1';
$route['admin/productos']['get']                 = 'zona/leer_productos';
$route['admin/producto/nuevo']['get']            = 'zona/nuevo_producto';
$route['admin/producto/crear']['post']           = 'zona/crear_producto';
$route['admin/producto/actualizar']['post']      = 'zona/actualizar_producto';
$route['admin/producto/eliminar']['post']        = 'zona/eliminar_producto';
$route['admin/pedidos']['get']                   = 'admin/pedidos';
$route['admin/pedido/(:any)']                    = 'admin/detalles_pedido/$1';
$route['admin/feria-virtual']['get']             = 'admin/feria_virtual';
$route['admin/feria-virtual/registrar']['post']  = 'admin/registro_feria';
$route['admin/feria-virtual/registrado']['get']  = 'admin/confirmacion_feria';
// $route['admin/escuela'] = 'admin/escuela';

$route['assets/(:any)'] = 'assets/$1';
$route['assets/tienda/(:any)'] = 'media/resize/$1';

// ENRUTAMIENTO TIENDA

// Cambiar de pais
$route['^(CO|SV)/pais']['get']                  = 'pais/cambiar_pais';

// Pagina principal de la tienda
$route['^(CO|SV)/(:any)']['get']                = 'tienda/nuevo_index/';
// Buscador
// $route['^(CO|SV)/buscar']['get']                = 'tienda/buscar/';

// Rutas del carrito
$route['^(CO|SV)/carrito']['get']               = 'carrito/index';
$route['^(CO|SV)/carrito/confirmar']['post']    = 'carrito/confirmar';
$route['^(CO|SV)/carrito/enviar']['post']       = 'carrito/enviar';
$route['^(CO|SV)/carrito/mas']['post']          = 'carrito/mas';
$route['^(CO|SV)/carrito/menos']['post']        = 'carrito/menos';
$route['^(CO|SV)/carrito/borrar']['post']       = 'carrito/borrar';
$route['^(CO|SV)/carrito/agregar']['post']      = 'carrito/agregar';
// Explorar tiendas
$route['^(CO|SV)/explorar']['get']              = '/tienda/explorar';
$route['^(CO|SV)/explorar/(:num)']['get']       = '/tienda/explorar/$2';
// Categorias
// $route['^(CO|SV)/(:any)']['get']                = '/tienda/categoria/$2';
// $route['^(CO|SV)/(:any)/(:num)']['get']         = '/tienda/categoria/$2/$3';

// Errores
$route['404'] = 'inicio/no_encontrado';
$route['404_override'] = 'inicio/no_encontrado';
// Tienda del emprendedor
$route['p/(:any)']['get'] = 'perfiles/reindex/$1';
$route['(:any)']['get'] = 'perfiles/index/$1';

// Configuración
$route['default_controller'] = 'inicio/cargando';
// $route['default_controller'] = 'inicio/mantenimiento';

