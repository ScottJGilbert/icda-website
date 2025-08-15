<?php

session_start();

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

$slug = strtolower(trim(preg_replace('/[\s\/_]+/', '-', $input['title'])));
$model = new Post();
if (in_array($slug, $model->fetchSlugs()) || strtolower($slug) === 'new') {
  Response::error('A post with this slug already exists.', 400);
  exit;
}

$file = new File();
if ($input['containsImage'] === 'true') {
  if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $input['imageUrl'] = $file->uploadImage();
  } else {
    if ($_FILES['image']['error'] === UPLOAD_ERR_INI_SIZE) {
      Response::error('Image exceeds 8MB limit.', 400);
      exit;
    } else {
      Response::error('Error uploading image.', 400);
      exit;
    }
  }
} else {
  $input['imageUrl'] = '';
}

mkdir(ROOT_PATH . "/news/$slug");
copy(ROOT_PATH . "/news/new-website/index.html", ROOT_PATH . "/news/$slug/index.html");
mkdir(ROOT_PATH . "/admin/news/$slug");
copy(ROOT_PATH . "/admin/news/new-website/index.php", ROOT_PATH . "/admin/news/$slug/index.php");

$model->updatePost($slug, $input['title'], $input['imageUrl'], $input['markdown']);

Response::success('Post created successfully', 200);