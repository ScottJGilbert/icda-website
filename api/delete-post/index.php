<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

// Autoload files (we’ll make this work later)
define('ROOT_PATH', dirname(__DIR__, 2)); // Two levels up from this file
spl_autoload_register(function ($class) {
  $paths = ['models', 'core'];
  foreach ($paths as $path) {
    // [root]/api/fetch-post/index.php
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
$accessLevel = $session->getAccessLevel();
if (!($accessLevel === 'Administrator')) {
  Response::error('You do not have permission to perform this action.', 403);
}

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

if (!preg_match('/^[a-zA-Z0-9-_]+$/', $input['slug'])) {
  Response::error('Invalid slug format. Only alphanumeric characters, dashes, and underscores are allowed.', 400);
  exit;
}

if ($input['slug'] === 'new') {
  Response::error('Cannot delete the "new" slug.', 400);
  exit;
}

if ($input['slug'] === 'new-website') {
  Response::error('Cannot delete the "new-website" post.', 400);
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