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

if (!isset($input['id']) || !is_numeric($input['id']) || $input['id'] < 1) {
  Response::error('Invalid ID.', 400);
  exit;
}

if (!isset($input['name']) || trim($input['name']) === '') {
  Response::error('Name is required.', 400);
  exit;
}

if (!isset($input['deleteImage']) || !($input['deleteImage'] === 'true' || $input['deleteImage'] === 'false')) {
  Response::error('Delete image flag is required and must be a boolean.', 400);
  exit;
}

$model = new School();

$file = new File();
if ($input['deleteImage'] === 'true') {
  $oldURL = $model->fetchImageUrl($input['id']);
  if ($oldURL)
    $file->deleteImage($oldURL);
  $input['imageUrl'] = '';
} else if (isset($_FILES['image'])) {
  if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
    if ($_FILES['image']['error'] === UPLOAD_ERR_INI_SIZE) {
      Response::error('Image exceeds 8MB limit.', 400);
      exit;
    } else {
      Response::error('Error uploading image.', 400);
      exit;
    }
  }
  $oldURL = $model->fetchImageUrl($input['id']);
  if ($oldURL)
    $file->deleteImage($oldURL);
  $input['imageUrl'] = $file->uploadImage();
} else {
  $input['imageUrl'] = $model->fetchImageUrl($input['id']); // No new image uploaded
}

$model->updateSchool(
  $input['name'],
  $input['imageUrl'],
  $input['id']
);

Response::success('Schools updated successfully', 200);