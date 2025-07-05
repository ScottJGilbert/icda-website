<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405); // Method Not Allowed
  echo json_encode(['success' => false, 'error' => 'Only GET is allowed']);
  exit;
}

$sessionModel = new Session();
$accessLevel = $session->getAccessLevel();
if (!($accessLevel === 'Administrator')) {
  Response::error('You do not have permission to perform this action.', 403);
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

foreach ($input as $key => $value) {
  $value = trim($value);
  $value = stripslashes($value);
  $value = htmlspecialchars($value);

  $input[$key] = $value;
}

if (!isset($input['slug']) || trim($input['slug']) === '') {
  Response::error('Slug is required.', 400);
  exit;
}

$model = new Post();
$model->deletePost($input['slug']);

$it = new RecursiveDirectoryIterator(__DIR__ . "../../news/{$input['slug']}", RecursiveDirectoryIterator::SKIP_DOTS);
$files = new RecursiveIteratorIterator(
  $it,
  RecursiveIteratorIterator::CHILD_FIRST
);
foreach ($files as $file) {
  if ($file->isDir()) {
    rmdir($file->getPathname());
  } else {
    unlink($file->getPathname());
  }
}
rmdir(__DIR__ . "../../news/{$input['slug']}");

$it = new RecursiveDirectoryIterator(__DIR__ . "../../admin/news/{$input['slug']}", RecursiveDirectoryIterator::SKIP_DOTS);
$files = new RecursiveIteratorIterator(
  $it,
  RecursiveIteratorIterator::CHILD_FIRST
);
foreach ($files as $file) {
  if ($file->isDir()) {
    rmdir($file->getPathname());
  } else {
    unlink($file->getPathname());
  }
}
rmdir(__DIR__ . "../../admin/news/{$input['slug']}");

Response::success('Post deleted successfully', 200);