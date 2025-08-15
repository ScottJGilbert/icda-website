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

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  Response::error('Only POST is allowed.', 405);
  exit;
}

$session = new Session();
$accessLevel = $session->getAccessLevel();
if (!($accessLevel === 'Administrator' || $accessLevel === 'Poster' || $accessLevel === 'Editor')) {
  Response::error('You do not have permission to perform this action.', 403);
  exit;
}

$input = json_decode(file_get_contents('php://input'), true);

if ($input === null) {
  Response::error('Invalid JSON input', 415);
  exit;
}

if (!isset($input['id'])) {
  Response::error('Archive ID is required.', 400);
  exit;
}

if (!is_numeric($input['id']) || $input['id'] < 1) {
  Response::error('Invalid archive ID.', 400);
  exit;
}

if (!isset($input['names'])) {
  Response::error('Names are required.', 400);
  exit;
}

if (!is_array($input['names']) || empty($input['names'])) {
  Response::error('Names must be a non-empty array.', 400);
}

$sanitizedNames = [];

foreach ($input['names'] as $value) {
  if (is_string($value)) {
    $value = trim($value);
    $value = stripslashes($value);
    $value = htmlspecialchars($value);
  }

  $sanitizedNames[] = $value;
}

if (!isset($input['dates'])) {
  Response::error('Dates are required.', 400);
  exit;
}

if (!is_array($input['dates']) || empty($input['dates'])) {
  Response::error('Dates must be a non-empty array.', 400);
}

$sanitizedDates = [];

foreach ($input['dates'] as $value) {
  if (is_string($value)) {
    $value = trim($value);
    $value = stripslashes($value);
    $value = htmlspecialchars($value);
  }

  $sanitizedDates[] = $value;
}


$model = new Archive();
$model->updateArchive($sanitizedNames, $sanitizedDates, $input['id']);

Response::success("Archive data updated successfully!");