<?php

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
  http_response_code(405); // Method Not Allowed
  echo json_encode(['success' => false, 'error' => 'Only GET is allowed']);
  exit;
}

$sessionModel = new Session();
$accessLevel = $session->getAccessLevel();
if (!($accessLevel === 'Administrator')) {
  Response::error('You do not have permission to perform this action.', 403);
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

$sessions = $sessionModel->fetchSessions();

Response::success($sessions);