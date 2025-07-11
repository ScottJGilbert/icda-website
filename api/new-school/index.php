<?php

session_start();

ini_set('display_errors', 1);
error_reporting(E_ALL);

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
if (!($accessLevel === 'Administrator' || $accessLevel === 'Poster' || $accessLevel === 'Editor')) {
  Response::error('You do not have permission to perform this action.', 403);
  exit;
}

if (strpos($_SERVER['CONTENT_TYPE'], 'multipart/form-data') !== 0) {
  Response::error('Invalid media type', 415);
  exit;
}

$input = [];

foreach ($_POST as $key => $value) {
  if (is_string($value)) {
    $value = trim($value);
    if ($key !== 'imageUrl') {
      $value = stripslashes($value);
    }
    $value = htmlspecialchars($value);
  }

  $input[$key] = $value;
}

if (!isset($item['name']) || trim($item['name']) === '') {
  Response::error('Name is required.', 400);
  exit;
}

if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
  $file = new File();
  $input['imageUrl'] = $file->uploadImage();
} else {
  $input['imageUrl'] = '';
}

$model = new School();
$model->updateSchool(
  $input['name'],
  $input['imageUrl'],
  -1
);

Response::success('School created successfully', 200);