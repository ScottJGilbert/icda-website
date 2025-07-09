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
if (!($accessLevel === 'Poster' || $accessLevel === 'Administrator')) {
  Response::error('You do not have permission to perform this action.', 403);
  exit;
}

$input = [];

foreach ($_POST as $key => $value) {
  if (is_string($value) && $key !== 'markdown') {
    $value = trim($value);
    if ($key !== 'imageUrl') {
      $value = stripslashes($value);
    }
    $value = htmlspecialchars($value);
  }

  $input[$key] = $value;
}

if (!isset($input['title']) || trim($input['title']) === '') {
  Response::error('Title is required.', 400);
  exit;
}

if (!isset($input['slug']) || trim($input['slug']) === '') {
  Response::error('Slug is required.', statusCode: 400);
  exit;
}

if (!isset($input['markdown']) || trim($input['markdown']) === '') {
  Response::error('Markdown is required.', statusCode: 400);
  exit;
}

if (!isset($input['deleteImage']) || !($input['deleteImage'] === 'true' || $input['deleteImage'] === 'false')) {
  Response::error('Delete image flag is required and must be a boolean.', 400);
  exit;
}

$model = new Post();

$file = new File();
if ($input['deleteImage'] === 'true') {
  $oldURL = $model->fetchImageUrl($input['slug']);
  if ($oldURL)
    $file->deleteImage($oldURL);
  $input['imageUrl'] = '';
} else if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
  $oldURL = $model->fetchImageUrl($input['slug']);
  if ($oldURL)
    $file->deleteImage($oldURL);
  $input['imageUrl'] = $fileModel->uploadImage();
} else {
  $input['imageUrl'] = $model->fetchImageUrl($input['slug']); // No new image uploaded
}

$model->updatePost($input['slug'], $input['title'], $input['imageUrl'], $input['markdown']);

Response::success('Post created successfully', 200);
