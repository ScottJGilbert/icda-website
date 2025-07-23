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
if (!($accessLevel === 'Editor' || $accessLevel === 'Poster' || $accessLevel === 'Administrator')) {
  Response::error('You do not have permission to perform this action.', 403);
  exit;
}

if (strpos($_SERVER['CONTENT_TYPE'], 'multipart/form-data') !== 0) {
  Response::error('Invalid media type', 415);
  exit;
}

$targetDir = __DIR__ . '../../tournaments/icda-';

$input = [];

foreach ($_POST as $key => $value) {
  if (is_string($value)) {
    $value = trim($value);
    if ($key !== 'imageUrl') {
      $value = stripslashes($value);
    }
    $value = htmlspecialchars($value);
  }

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
  Response::error('Tabroom link is required.', 400);
  exit;
}

if (!isset($input['contacts']) === '') {
  Response::error('Contacts are required.', 400);
  exit;
}

$contactList = json_decode($input['contacts'], true);
if (!is_array($contactList) || empty($contactList)) {
  Response::error('Contacts must be a non-empty array.', 400);
  exit;
}

for ($i = 0; $i < count($contactList); $i++) {
  if (!isset($contactList[$i]['name']) || trim($contactList[$i]['name']) === '') {
    Response::error('Contact name is required.', 400);
    exit;
  }
  if (!isset($contactList[$i]['email']) || !filter_var($contactList[$i]['email'], FILTER_VALIDATE_EMAIL)) {
    Response::error('Valid contact email is required.', 400);
    exit;
  }
}

if (!isset($input['deleteLegislation']) || !($input['deleteLegislation'] === 'true' || $input['deleteLegislation'] === 'false')) {
  Response::error('Delete legislation status is required and must be a boolean.', 400);
  exit;
}

if (!isset($input['deleteResults']) || !($input['deleteResults'] === 'true' || $input['deleteResults'] === 'false')) {
  Response::error('Delete results status is required and must be a boolean.', 400);
  exit;
}

$file = new File();

if ($input['deleteLegislation'] === 'true') {
  $file->deleteLegislation($input['id']);
} else if (isset($_FILES['legislation']) && $_FILES['legislation']['error'] === UPLOAD_ERR_OK) {
  $file->uploadLegislation($input['id']);
}

if ($input['deleteResults'] === 'true') {
  $file->deleteResults($input['id']);
} else if (isset($_FILES['results']) && $_FILES['results']['error'] === UPLOAD_ERR_OK) {
  $file->uploadResults($input['id']);
}

$model = new Tournament();
$model->updateTournament($input['id'], $input['date'], $input['schoolId'], $input['tabroom'], $contactList);

Response::success('Tournament updated successfully', 200);