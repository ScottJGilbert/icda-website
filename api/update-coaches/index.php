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

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  Response::error('Only POST is allowed.', 405);
  exit;
}

$session = new Session();
$accessLevel = $session->getAccessLevel();
if (!($accessLevel === 'Administrator' || $accessLevel === 'Editor' || $accessLevel === 'Poster')) {
  Response::error('You do not have permission to perform this action.', 403);
  exit;
}

$input = json_decode(file_get_contents('php://input'), true);

if ($input === null) {
  Response::error('Invalid media type', 415);
  exit;
}

if (!is_array($input['list']) || empty($input['list'])) {
  Response::error('Invalid JSON input', 415);
  exit;
}

$schoolModel = new School();
$numSchools = $schoolModel->fetchNumberOfSchools();

if (!isset($item['list'])) {
  Response::error('List is required.', 400);
  exit;
}

if (!is_array($input['list']) || empty($input['list'])) {
  Response::error('List must be a non-empty array.', 400);
}

foreach ($input['list'] as $item) {
  foreach ($item as $key => $value) {
    if (is_string($value)) {
      $value = trim($value);
      $value = stripslashes($value);
      $value = htmlspecialchars($value);
    }

    $input[$key] = $value;
  }

  if (!isset($item['name']) || trim($item['name']) === '') {
    Response::error('Name is required.', 400);
    exit;
  }

  if (isset($item['email']) && filter_var($item['email'], FILTER_VALIDATE_EMAIL) === false) {
    Response::error('Email must be a valid email.', 400);
    exit;
  }

  if (!isset($item['schoolId'])) {
    Response::error('School ID is required.', 400);
    exit;
  }

  if (!is_numeric($item['schoolId']) || $item['schoolId'] < 1 || $item['schoolId'] > $numSchools) {
    Response::error('Invalid School ID.', 400);
    exit;
  }
}

$model = new Coach();
$model->updateCoaches(
  $input['list']
);

Response::success('Coaches updated successfully', 200);