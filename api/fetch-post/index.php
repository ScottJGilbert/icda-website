<?php

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

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
  Response::error('Only GET is allowed.', 405);
  exit;
}

if (isset($_GET['slug']) && !is_string($_GET['slug'])) {
  Response::error('Slug must be a string.', 400);
  exit;
}

$slug = $_GET['slug'];
$slug = trim($slug);
$slug = stripslashes($slug);
$slug = htmlspecialchars($slug);

$model = new Post();
$output = $model->fetchPostBySlug($slug);

foreach ($output as $key => $value) {
  if (is_string($value)) {
    $output[$key] = htmlspecialchars($value);
  }
}

Response::success($output);
