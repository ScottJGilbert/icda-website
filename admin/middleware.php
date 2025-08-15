<?php

require_once realpath(__DIR__ . '/../backend/core/Response.php');
require_once realpath(__DIR__ . '/../backend/models/Session.php');

if (session_status() == PHP_SESSION_ACTIVE) {
  $currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
  $sessionModel = new Session();
  $permissionLevel = $sessionModel->getAccessLevel();

  switch ($permissionLevel) {
    case "Editor":
      if ($currentPath == "/management" || $currentPath == "/news") {
        Response::redirect('/unauthorized');
      }
      break;
    case "Poster":
      if ($currentPath == "/management") {
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
} else {
  Response::redirect('/login?code=1'); //"Please log in"
}
