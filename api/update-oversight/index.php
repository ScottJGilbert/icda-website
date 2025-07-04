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

if (!isset($input['deleteImage']) || !is_bool($input['deleteImage'])) {
  Response::error('Delete image flag is required and must be a boolean.', 400);
  exit;
}

$model = new Oversight();

$file = new File();
if ($input['deleteImage']) {
  $oldURL = $model->fetchImageUrl($input['id']);
  if ($oldURL)
    $file->deleteImage($oldURL);
  $input['imageUrl'] = '';
} else if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
  $oldURL = $model->fetchImageUrl($input['id']);
  if ($oldURL)
    $file->deleteImage($oldURL);
  $input['imageUrl'] = $fileModel->uploadImage();
} else {
  $input['imageUrl'] = $model->fetchImageUrl($input['id']); // No new image uploaded
}

$model->updateOversight($input['id'], $input['name'], $input['email'], $input['imageUrl']);

Response::success('Oversight member updated successfully', 200);