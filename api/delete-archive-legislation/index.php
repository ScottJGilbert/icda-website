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

$session = new Session();
$accessLevel = $session->getAccessLevel();
if (!($accessLevel === 'Administrator' || $accessLevel === 'Poster' || $accessLevel === 'Editor')) {
  Response::error('You do not have permission to perform this action.', 403);
  exit;
}

if (!isset($_GET['archiveId'])) {
  Response::error('Archive ID is required.', 400);
  exit;
}

if (!is_numeric($_GET['archiveId']) || $_GET['archiveId'] < 1) {
  Response::error('Invalid archive ID.', 400);
  exit;
}

if (!isset($_GET['tournamentId'])) {
  Response::error('Tournament ID is required.', 400);
  exit;
}

if (!is_numeric($_GET['tournamentId']) || $_GET['tournamentId'] < 1 || $_GET['tournamentId'] > 6) {
  Response::error('Invalid tournament ID.', 400);
  exit;
}

$file = new File();
$file->deleteArchiveLegislation($_GET['archiveId'], $_GET['tournamentId']);

Response::success("Legislation deleted successfully!");