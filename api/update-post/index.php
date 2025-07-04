<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  Response::error('Method not allowed', 405);
  exit;
}

$session = new Session();
$accessLevel = $session->getAccessLevel();
if (!($accessLevel === 'Poster' || $accessLevel === 'Administrator')) {
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
  if ($key !== 'imageUrl') {
    $value = stripslashes($value);
  }
  $value = htmlspecialchars($value);

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

$model = new Post();

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

$model->updatePost($input['slug'], $input['title'], $input['imageUrl'], $input['markdown']);

Response::success('Post created successfully', 200);