<?php

require_once realpath(__DIR__ . '/../core/Response.php');
require_once realpath(__DIR__ . '/../models/Session.php');

if (session_status() == PHP_SESSION_ACTIVE) {
  $currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
  $sessionModel = new Session();
  $permissionLevel = $sessionModel->getAccessLevel();

  switch ($permissionLevel) {
    case "Editor":
      if ($currentPath == "/management" || $currentPath == "/news") {
        Response::redirect('/unauthorized', 403); // Forbidden
      }
      break;
    case "Poster":
      if ($currentPath == "/management") {
        Response::redirect('/unauthorized', 403); // Forbidden
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
      Response::redirect('/login?code=2', 403); //"Please log in again"
  }
} else {
  Response::redirect('/login?code=1', 403); //"Please log in"
}
