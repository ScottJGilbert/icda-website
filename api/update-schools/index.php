<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  Response::error('Method not allowed', 405);
  exit;
}

$session = new Session();
$accessLevel = $session->getAccessLevel();
if (!($accessLevel === 'Administrator' || $accessLevel === 'Poster' || $accessLevel === 'Editor')) {
  Response::error('You do not have permission to perform this action.', 403);
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
    $value = trim($value);
    if ($key !== 'imageUrl') {
      $value = stripslashes($value);
    }
    $value = htmlspecialchars($value);

    $coach[$key] = $value;
  }

  if (!isset($item['name']) || trim($item['name']) === '') {
    Response::error('Name is required.', 400);
    exit;
  }

}

$model = new School();
$model->updateSchools(
  $input['list'],
);

Response::success('Schools updated successfully', 200);