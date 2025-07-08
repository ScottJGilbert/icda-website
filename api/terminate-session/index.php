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

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  Response::error('Only POST is allowed.', 405);
  exit;
}

$session = new Session();
$accessLevel = $session->getAccessLevel();
if (!($accessLevel === 'Administrator')) {
  Response::error('You do not have permission to perform this action.', 403);
  exit;
}

$input = json_decode(file_get_contents('php://input'), true);

if ($input === null) {
  Response::error('Invalid JSON input', 415);
  exit;
}

foreach ($input as $key => $value) {
  $value = trim($value);
  $value = stripslashes($value);
  $value = htmlspecialchars($value);

  $input[$key] = $value;
}

if (!isset($input['sessionId']) || empty($input['sessionId']) || !is_numeric($input['sessionId']) || $input['sessionId'] <= 0) {
  Response::error('Valid session ID is required.', 400);
  exit;
}


$sessionModel = new Session();
$sessionModel->terminateSession($input['sessionId']);

Response::success('Session terminated successfully', 200);