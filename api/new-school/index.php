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

$session = new Session();
$accessLevel = $session->getAccessLevel();
if (!($accessLevel === 'Administrator' || $accessLevel === 'Poster' || $accessLevel === 'Editor')) {
  Response::error('You do not have permission to perform this action.', 403);
  exit;
}

if (strpos($_SERVER['CONTENT_TYPE'], 'multipart/form-data') === 0) {
  // For multipart/form-data, JSON is usually sent as a field, e.g., 'json'
  if (isset($_POST['json'])) {
    $input = json_decode($_POST['json'], true);
  } else {
    $input = null;
  }
} else {
  Response::error('Invalid media type', 415);
  exit;
}

if ($input === null) {
  Response::error('Invalid JSON input', 415);
  exit;
}

foreach ($input['list'] as $key => $value) {
  $value = trim($value);
  $value = stripslashes($value);
  $value = htmlspecialchars($value);

  $input[$key] = $value;

}

if (!isset($input['id']) || !is_numeric($input['id']) || $input['id'] < 1) {
  Response::error('Invalid ID.', 400);
  exit;
}

if (!isset($item['name']) || trim($item['name']) === '') {
  Response::error('Name is required.', 400);
  exit;
}

if (!isset($input['containsImage']) || !is_bool($input['containsImage'])) {
  Response::error('Contains image flag is required and must be a boolean.', 400);
  exit;
}

$fileModel = new File();
if ($input['containsImage']) {
  $input['imageUrl'] = $fileModel->uploadImage();
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