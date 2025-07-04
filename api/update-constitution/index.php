<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  Response::error('Method not allowed', 405);
  exit;
}

$session = new Session();
$accessLevel = $session->getAccessLevel();
if (!($accessLevel === 'Administrator')) {
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

if (!(strpos($_SERVER['CONTENT_TYPE'], 'multipart/form-data') === 0)) {
  Response::error('Invalid media type', 415);
  exit;
}

$file = new File();
if (isset($_FILES['constitution']) && $_FILES['constitution']['error'] === UPLOAD_ERR_OK) {
  $file->uploadConstitution();
} else {
  Response::error('No file uploaded or file upload error.', 400);
  exit;
}

Response::success('Constitution updated successfully.', 200);