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

if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
  Response::error('Only DELETE is allowed.', 405);
  exit;
}

$sessionModel = new Session();
$accessLevel = $sessionModel->getAccessLevel();
if (!($accessLevel === 'Administrator')) {
  Response::error('You do not have permission to perform this action.', 403);
}

if (!isset($_GET['slug']) || trim($_GET['slug']) === '') {
  Response::error('Slug is required.', 400);
  exit;
}

if (!preg_match('/^[a-zA-Z0-9-_]+$/', $_GET['slug'])) {
  Response::error('Invalid slug format. Only alphanumeric characters, dashes, and underscores are allowed.', 400);
  exit;
}

if ($_GET['slug'] === 'new') {
  Response::error('Cannot delete the "new" slug.', 400);
  exit;
}

if ($_GET['slug'] === 'new-website') {
  Response::error('Cannot delete the "new-website" post.', 400);
  exit;
}

$model = new Post();
$model->deletePost($_GET['slug']);

$it = new RecursiveDirectoryIterator(ROOT_PATH . "/news/{$_GET['slug']}", RecursiveDirectoryIterator::SKIP_DOTS);
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
rmdir(ROOT_PATH . "/news/{$_GET['slug']}");

$it = new RecursiveDirectoryIterator(ROOT_PATH . "/admin/news/{$_GET['slug']}", RecursiveDirectoryIterator::SKIP_DOTS);
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
rmdir(ROOT_PATH . "/admin/news/{$_GET['slug']}");

Response::success('Post deleted successfully', 200);