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
if (!($accessLevel === 'Administrator' || $accessLevel === 'Poster' || $accessLevel === 'Editor')) {
  Response::error('You do not have permission to perform this action.', 403);
  exit;
}

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

if ($input === null) {
  Response::error('Invalid media type.', 415);
  exit;
}

if (!isset($_FILES['legislation']) && $_FILES['legislation']['error'] !== UPLOAD_ERR_OK) {
  Response::error('Invalid file upload', 400);
  exit;
}

if (!isset($input['archiveId'])) {
  Response::error('Archive ID is required.', 400);
  exit;
}

if (!is_numeric($input['archiveId']) || $input['archiveId'] < 1) {
  Response::error('Invalid archive ID.', 400);
  exit;
}

if (!isset($input['tournamentId'])) {
  Response::error('Tournament ID is required.', 400);
  exit;
}

if (!is_numeric($input['tournamentId']) || $input['tournamentId'] < 1 || $input['tournamentId'] > 6) {
  Response::error('Invalid tournament ID.', 400);
  exit;
}

$file = new File();
$file->uploadArchiveLegislation($input['archiveId'], $input['tournamentId']);

Response::success("Legislation uploaded successfully!");