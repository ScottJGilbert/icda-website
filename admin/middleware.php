<?php

if (session_status() == PHP_SESSION_ACTIVE) {
  $currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
  $sessionModel = new Session();
  $permissionLevel = $sessionModel->validateSession();

  switch ($permissionLevel) {
    case "Editor":
      if ($currentPath == "/management" || $currentPath == "/news") {
        header('Location: /unauthorized');
      }
      break;
    case "Poster":
      if ($currentPath == "/management") {
        header('Location: /unauthorized');
      }
      break;
    case "Administrator":
      break;
    default:
      $sessionController = new SessionController();
      $sessionController->logout();
      header('Location: /login?code=2'); //"Please log in again"
  }
}
header('Location: /login?code=1'); //"Please log in.
