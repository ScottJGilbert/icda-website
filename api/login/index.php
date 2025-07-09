<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

// Autoload files (we’ll make this work later)
define('ROOT_PATH', dirname(__DIR__, 2)); // Two levels up from this file
spl_autoload_register(function ($class) {
  $paths = ['models', 'core'];
  foreach ($paths as $path) {
    // [root]/api/fetch-post/index.php
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

$input = json_decode(file_get_contents('php://input'), true);

foreach ($input as $key => $value) {
  $value = trim($value);
  $value = stripslashes($value);
  $value = htmlspecialchars($value);

  $input[$key] = $value;
}

$username = isset($input['username']) ? trim($input['username']) : '';
$password = isset($input['password']) ? trim($input['password']) : '';

if ($username === '') {
  Response::error('Username is required.', 400);
  exit;
}

if ($password === '') {
  Response::error('Password is required.', 400);
  exit;
}

$model = new User();
$success = $model->login($username, $password);

if ($success) {
  Response::redirect('/admin', 200);
  exit;
} else {
  Response::error('Invalid username or password', 401);
  exit;
}
