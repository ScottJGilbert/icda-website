<?php

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

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
  Response::error('Only GET is allowed.', 405);
  exit;
}

$id = (isset($_GET['id']) && is_numeric($_GET['id'])) ? (int) $_GET['id'] : 1;
if ($id < 1 || $id > 6) {
  $id = 1; // Default to ICDA 1 if invalid
}

$model = new Tournament();
$output = $model->fetchTournament($id);

$schoolModel = new School();
$school = $schoolModel->fetchSchool($output['school_id']);
$output['school_name'] = $school['name'];
$output['school_image'] = $school['imageUrl'] ?? '';

Response::success($output);