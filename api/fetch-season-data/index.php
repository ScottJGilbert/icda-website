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

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
  Response::error('Only GET is allowed.', 405);
  exit;
}

$id = $_GET['id'];
if (!isset($id) || !is_numeric($id)) {
  Response::error('Invalid ID', 404);
}


$model = new Archive();
$output = $model->fetchSeasonData($id);

$season = (2018 + $id) . '-' . (2018 + $id + 1);

$legislationFiles = [];
$resultsFiles = [];
for ($i = 1; $i < 6; $i++) {
  $legislationFiles[] = file_exists(ROOT_PATH . "/archive/$season/icda-$i-legislation.pdf");
  $resultsFiles[] = file_exists(ROOT_PATH . "/archive/$season/icda-$i-results.pdf");
}

$legislationFiles[] = file_exists(ROOT_PATH . "/archive/$season/icda-state-legislation.pdf");
$resultsFiles[] = file_exists(ROOT_PATH . "/archive/$season/icda-state-results.pdf");

$output['legislationFiles'] = $legislationFiles;
$output['resultsFiles'] = $resultsFiles;

Response::success($output);