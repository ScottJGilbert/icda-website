<?php

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
  http_response_code(405); // Method Not Allowed
  echo json_encode(['success' => false, 'error' => 'Only GET is allowed']);
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

$id = isset($_GET['id']) ? (int) $_GET['id'] : 1;
if ($id < 1 || $id > 7) {
  $id = 1; // Default to president if invalid
}

$model = new Oversight();
$output = $model->fetchOversight($id);

Response::success($output);