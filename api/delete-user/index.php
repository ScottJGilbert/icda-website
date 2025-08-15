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

if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
  Response::error('Only DELETE is allowed.', 405);
  exit;
}

$session = new Session();
$accessLevel = $session->getAccessLevel();
if (!($accessLevel === 'Administrator')) {
  Response::error('You do not have permission to perform this action.', 403);
  exit;
}

if (!isset($_GET['uuid']) || trim($_GET['uuid']) === '') {
  Response::error('UUID is required.', 400);
  exit;
}


$model = new User();
$model->deleteUser(
  $_GET['uuid']
);

Response::success('User deleted successfully', 200);