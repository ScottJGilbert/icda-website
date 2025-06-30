<?php

function checkPost()
{
	if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
		http_response_code(405); // Method Not Allowed
		echo json_encode(['success' => false, 'error' => 'Only POST is allowed']);
		exit;
	}
}

// Enable error reporting (good for development)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Autoload files (we’ll make this work later)
spl_autoload_register(function ($class) {
	$paths = ['controllers', 'models', 'core'];
	foreach ($paths as $path) {
		$file = __DIR__ . "/$path/$class.php";
		if (file_exists($file)) {
			require_once $file;
			return;
		}
	}
});

// Get the request URI path (e.g. /api/login)
$request = $_SERVER['REQUEST_URI'];
$script = $_SERVER['SCRIPT_NAME'];

// Strip off the script path and query string to get clean route
$path = str_replace(dirname($script), '', parse_url($request, PHP_URL_PATH));
$path = trim($path, '/');

// Get raw POST data and decode JSON
$input = json_decode(file_get_contents('php://input'), true);

foreach ($input as $key => $value) {
	$value = trim($value);
	$value = stripslashes($value);
	$value = htmlspecialchars($value);

	$input[$key] = $value;
}

// Simple routing: map /login to UserController::login
switch ($path) {
	case 'api/login':
		checkPost();
		$controller = new UserController();
		$controller->login($input);
		break;
	case 'api/logout':
		$controller = new SessionController();
		$controller->logout();
		header("Refresh:0");
		break;
	case 'api/new-user':
		checkPost();
		$controller = new UserController();
		$controller->newUser($input);
		break;
	case 'api/delete-user':
		checkPost();
		$controller = new UserController();
		$controller->deleteUser($input);
		break;
	case 'api/terminate-session':
		checkPost();
		$controller = new SessionController();
		$controller->terminateSession($input);
		break;
	default:
		http_response_code(404); // Not Found
		echo json_encode(['success' => false, 'error' => 'Endpoint not found']);
}