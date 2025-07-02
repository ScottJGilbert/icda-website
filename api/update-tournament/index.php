<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  Response::error('Method not allowed', 405);
  exit;
}

$session = new Session();
$accessLevel = $session->getAccessLevel();
if (!($accessLevel === 'Editor' || $accessLevel === 'Poster' || $accessLevel === 'Administrator')) {
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
  Response::error('Invalid JSON input', 415);
  exit;
}

foreach ($input as $key => $value) {
  $value = trim($value);
  if ($key !== 'tabroom') {
    $value = stripslashes($value);
  }
  $value = htmlspecialchars($value);

  $input[$key] = $value;
}

$numSchools = (new School())->fetchNumberOfSchools();

if (!isset($input['id'])) {
  Response::error('ID is required.', 400);
  exit;
}

if (!is_numeric($input['id']) || $input['id'] < 1 || $input['id'] > 6) {
  Response::error('Invalid ID.', 400);
  exit;
}

if (!isset($input['date']) || trim($input['date']) === '') {
  Response::error('Date is required.', 400);
  exit;
}

if ($input['date'] !== '' && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $input['date'])) {
  Response::error('Invalid date format. Use YYYY-MM-DD.', 400);
  exit;
}

if (!isset($input['schoolId']) || !is_numeric($input['schoolId']) || $input['schoolId'] < 1 || $input['schoolId'] > $numSchools) {
  Response::error('School ID is required and must be a positive integer.', 400);
  exit;
}

if (!isset($input['tabroom']) || trim($input['tabrom']) === '') {
  Response::error('Email is required.', 400);
  exit;
}

if (!isset($input['contacts']) || trim($input['contacts']) === '') {
  Response::error('Contacts are required.', 400);
  exit;
}

$model = new Tournament();
$model->updateTournament($input['id'], $input['date'], $input['schoolId'], $input['tabroom'], $input['contacts']);

Response::success('Tournament updated successfully', 200);