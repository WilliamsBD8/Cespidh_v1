<?php namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('AuthController');
$routes->setDefaultMethod('login');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'AuthController::login');
$routes->get('/register', 'AuthController::register');
$routes->post('/create', 'AuthController::create');
$routes->get('/reset_password', 'AuthController::resetPassword');
$routes->post('/forgot_password', 'AuthController::forgotPassword');
$routes->post('/validation', 'AuthController::validation');
$routes->get('/logout', 'AuthController::logout');
$routes->get('/home', 'HomeController::index');
$routes->get('/about', 'HomeController::about');
$routes->get('/perfile', 'UserController::perfile');
$routes->post('/update_photo', 'UserController::updatePhoto');
$routes->post('/update_user', 'UserController::updateUser');
$routes->post('/config/(:segment)', 'ConfigController::index/$1');
$routes->get('/config/(:segment)', 'ConfigController::index/$1');
$routes->post('/table/(:segment)', 'TableController::index/$1');
$routes->get('/table/(:segment)', 'TableController::index/$1');
$routes->post('/table/(:segment)/(:segment)', 'TableController::subindex/$1/$2');
$routes->get('/table/(:segment)/(:segment)', 'TableController::subindex/$1/$2');

$routes->group('cespidh', function ($routes){
	$routes->get('ciudadanos', 'CiudadanoController::index');

	// Create
	$routes->post('create/document', 'DocumentController::create');
	// $routes->get('create/document', 'CiudadanoController::create');
	$routes->get('view/document/(:segment)/(:segment)', 'DocumentController::view_document/$1/$2');

	// Edit	
	$routes->get('edit/document/(:segment)', 'DocumentController::view_edit/$1');
	$routes->post('edit/document', 'DocumentController::edit_document');
	$routes->post('edit/new_document', 'DocumentController::new_document');

	// Historial
	$routes->get('historial/document/(:segment)', 'HistorialController::index/$1');
	$routes->post('historial/work', 'HistorialController::create');
	$routes->get('activity', 'HistorialController::index_activity');
	$routes->get('docs/(:segment)/(:segment)', 'HistorialController::download/$1/$2');

	$routes->get('entidad', 'EntidadController::index');
	$routes->post('entidad/search', 'EntidadController::search');
	$routes->get('entidad/search', 'EntidadController::search');

	//Update user
	$routes->post('update/user', 'UserController::update_perfil_doc');
	$routes->post('create/user', 'UserController::create_perfil_doc');
});

/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need to it be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
