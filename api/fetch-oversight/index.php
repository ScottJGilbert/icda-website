<?php

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

$id = isset($_GET['id']) ? (int) $_GET['id'] : 1;
if ($id < 1 || $id > 7) {
  $id = 1; // Default to president if invalid
}

$model = new Oversight();
$output = $model->fetchOversight($id);

Response::success($output);