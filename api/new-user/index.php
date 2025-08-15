<?php

session_start();

// Autoload files (we’ll make this work later)
define('ROOT_PATH', dirname(__DIR__, 2)); // Two levels up from this file
spl_autoload_register(function ($class) {
  $paths = ['models', 'core'];
  foreach ($paths as $path) {
    $file = ROOT_PATH . "/backend/$path/$class.php";

    if (file_exists($file)) {
      require_once $file;
      return;
    }
  }
});

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  Response::error('Only POST is allowed.', 405);
  exit;
}

$session = new Session();
$accessLevel = $session->getAccessLevel();
if (!($accessLevel === 'Administrator')) {
  Response::error('You do not have permission to perform this action.', 403);
  exit;
}

$input = json_decode(file_get_contents('php://input'), true);

if ($input === null) {
  Response::error('Invalid JSON input', 415);
  exit;
}

foreach ($input as $key => $value) {
  if (is_string($value)) {
    $value = trim($value);
    $value = stripslashes($value);
    $value = htmlspecialchars($value);
  }

  $input[$key] = $value;
}

if (!isset($input['name']) || trim($input['name']) === '') {
  Response::error('Name is required.', 400);
  exit;
}

if (!isset($input['username']) || trim($input['username']) === '') {
  Response::error('Username is required.', 400);
  exit;
}

if (!isset($input['password']) || trim($input['password']) === '') {
  Response::error('Password is required.', 400);
  exit;
}

if (!isset($input['access_level']) || ($input['access_level'] !== 'Administrator' && $input['access_level'] !== 'Poster' && $input['access_level'] !== 'Editor')) {
  Response::error('Valid permission level is required.', 400);
  exit;
}

$model = new User();
$model->createUser(
  $input['name'],
  $input['username'],
  $input['password'],
  $input['access_level']
);

Response::success('User created successfully', 200);