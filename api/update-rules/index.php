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
  Response::error('Invalid media type', 415);
  exit;
}

if (!is_array($input['list']) || empty($input['list'])) {
  Response::error('Invalid JSON input', 415);
  exit;
}

foreach ($input['list'] as $item) {
  foreach ($item as $key => $value) {
    if (is_string($value)) {
      $value = trim($value);
      $value = stripslashes($value);
      $value = htmlspecialchars($value);
    }

    $coach[$key] = $value;
  }

  if (!isset($item['name']) || trim($item['name']) === '') {
    Response::error('Name is required.', 400);
    exit;
  }

  if (!isset($item['number'])) {
    Response::error('Rule number is required.', 400);
    exit;
  }

  if (!is_numeric($item['number']) || $item['number'] <= 0) {
    Response::error('Invalid rule number.', 400);
    exit;
  }

  if (!isset($item['summary']) || trim($item['summary']) === '') {
    Response::error('Summary is required.', 400);
    exit;
  }
}

$model = new Rule();
$model->updateRules(
  $input['list']
);

Response::success('Rules updated successfully', 200);