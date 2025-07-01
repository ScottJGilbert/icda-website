<?php

class SessionValidators
{

  public static function validateFetchSessions(): array
  {
    $errors = [];

    $session = new Session();
    $accessLevel = $session->validateSession();
    if (!($accessLevel === 'Administrator')) {
      $errors[] = 'You do not have permission to perform this action.';
    }

    return $errors;
  }

  public static function validateSessionTermination($sessionId): array
  {
    $errors = [];

    if (!isset($sessionId) || trim($sessionId) === '') {
      $errors[] = 'Name is required.';
    }

    $session = new Session();
    $accessLevel = $session->validateSession();
    if (!($accessLevel === 'Administrator')) {
      $errors[] = 'You do not have permission to perform this action.';
    }

    return $errors;
  }
}