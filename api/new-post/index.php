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

if (!isset($input['markdown']) || trim($input['markdown']) === '') {
  Response::error('Markdown is required.', statusCode: 400);
  exit;
}

if (!isset($input['containsImage']) || !is_bool($input['containsImage'])) {
  Response::error('Contains image must be a boolean.', 400);
  exit;
}

$fileModel = new File();
if ($input['containsImage']) {
  $input['imageUrl'] = $fileModel->uploadImage();
} else {
  $input['imageUrl'] = '';
}

$model = new Post();
$model->updatePost($input['slug'], $input['title'], $input['imageUrl'], $input['markdown']);

Response::success('Post created successfully', 200);