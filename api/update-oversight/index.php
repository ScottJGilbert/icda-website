<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  Response::error('Method not allowed', 405);
  exit;
}

$session = new Session();
$accessLevel = $session->getAccessLevel();
if (!($accessLevel === 'Administrator' || $accessLevel === 'Poster' || $accessLevel === 'Editor')) {
  Response::error('You do not have permission to perform this action.', 403);
  exit;
}

ini_set('display_errors', 1);
error_reporting(E_ALL);

// Autoload files (we’ll make this work later)
spl_autoload_register(function ($class) {
  $paths = ['controllers', 'models', 'core'];
  foreach ($paths as $path) {
    $file = __DIR__ . "../backend/$path/$class.php";
    if (file_exists($file)) {
      require_once $file;
      return;
    }
  }
});

$input = json_decode(file_get_contents('php://input'), true);

if ($input === null) {
  Response::error('Invalid JSON input', 415);
  exit;
}

foreach ($input as $key => $value) {
  $value = trim($value);
  $value = stripslashes($value);
  $value = htmlspecialchars($value);

  $input[$key] = $value;
}

if (!isset($input['id'])) {
  Response::error('ID is required.', 400);
  exit;
}

if (!is_numeric($input['id']) || $input['id'] < 1 || $input['id'] > 7) {
  Response::error('Invalid ID.', 400);
  exit;
}

if (!isset($input['name']) || trim($input['name']) === '') {
  Response::error('Name is required.', 400);
  exit;
}

if (!isset($input['email']) || trim($input['email']) === '') {
  Response::error('Email is required.', 400);
  exit;
}

if ($input['email'] !== '' && !filter_var($input['email'], FILTER_VALIDATE_EMAIL)) {
  Response::error('Invalid email format.', 400);
  exit;
}

$model = new Oversight();
$model->updateOversight($input['id'], $input['name'], $input['email']);

Response::success('Oversight member updated successfully', 200);