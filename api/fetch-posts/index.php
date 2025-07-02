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

$page = (isset($_GET['page']) && is_numeric($_GET['page'])) ? (int) $_GET['page'] : 1;
if ($page < 1) {
  $page = 1; // Default to page 1 if invalid
}

$model = new Post();
$output = $model->fetchPosts($page);

Response::success($output);