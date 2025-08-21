<?php

session_start();

require_once realpath(__DIR__ . '/../backend/core/Response.php');
require_once realpath(__DIR__ . '/../backend/core/Database.php');
require_once realpath(__DIR__ . '/../backend/models/Session.php');
require_once realpath(__DIR__ . '/../backend/models/User.php');

$currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$sessionModel = new Session();
$permissionLevel = $sessionModel->getAccessLevel();

switch ($permissionLevel) {
  case "Editor":
    if (str_contains($currentPath, "/admin/management") || str_contains($currentPath, "/admin/news")) {
      Response::redirect('/unauthorized');
    }
    break;
  case "Poster":
    if (str_contains($currentPath, "/admin/management")) {
      Response::redirect('/unauthorized');
    }
    break;
  case "Administrator":
    break;
  default:
    $sessionId = session_id();

    $model = new Session();
    $model->terminateSession($sessionId);

    session_unset();
    session_destroy();
    Response::redirect('/login?code=2'); //"Please log in again"
}
