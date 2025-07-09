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

if (!isset($input['markdown']) || trim($input['markdown']) === '') {
  Response::error('Markdown is required.', statusCode: 400);
  exit;
}

if (!isset($input['containsImage']) || !($input['containsImage'] === 'true' || $input['containsImage'] === 'false')) {
  Response::error('Contains image must be a boolean.', 400);
  exit;
}

$input['slug'] = strtolower(trim(preg_replace('/[^a-z0-9]+/', '-', $input['title'])));
$model = new Post();
if (in_array($input['slug'], $model->fetchSlugs()) || $input['slug'] === 'new') {
  Response::error('A post with this slug already exists.', 400);
  exit;
}

$fileModel = new File();
if ($input['containsImage'] === 'true') {
  $input['imageUrl'] = $fileModel->uploadImage();
} else {
  $input['imageUrl'] = '';
}

$model->updatePost($input['slug'], $input['title'], $input['imageUrl'], $input['markdown']);

mkdir(__DIR__ . "../../news/{$input['slug']}");
copy(__DIR__ . "../../news/new-website/index.php", __DIR__ . "../../news/{$input['slug']}/index.php");
mkdir(__DIR__ . "../../admin/news/{$input['slug']}");
copy(__DIR__ . "../../admin/news/new-website/index.php", __DIR__ . "../../admin/news/{$input['slug']}/index.php");

Response::success('Post created successfully', 200);