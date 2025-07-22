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

if (!isset($_GET['id']) || !is_numeric($_GET['id']) || $_GET['id'] < 1) {
  Response::error('Invalid ID.', 400);
  exit;
}

$model = new School();
$model->deleteSchool($_GET['id']);

Response::success('School deleted successfully', 200);