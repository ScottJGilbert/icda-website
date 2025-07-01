<?php

class UserValidators
{

  public static function validateLogin($data): array
  {
    $errors = [];

    // Sanitize input to prevent SQL injection
    $username = isset($data['username']) ? trim($data['username']) : '';
    $password = isset($data['password']) ? trim($data['password']) : '';

    // Remove unwanted characters (basic sanitization)
    $sanitizedUsername = filter_var($username, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
    $sanitizedPassword = filter_var($password, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);

    if ($username === '') {
      $errors[] = 'Username is required.';
    }

    if ($password === '') {
      $errors[] = 'Password is required.';
    }

    if ($username !== $sanitizedUsername || $password !== $sanitizedPassword) {
      $errors[] = 'Failed sanitization check.';
    }

    // Optionally, you can return sanitized data as well
    // return ['errors' => $errors, 'sanitized' => ['username' => $username, 'password' => $password]];

    return $errors;
  }

  public static function validateFetchUsers(): array
  {
    $errors = [];

    $session = new Session();
    $accessLevel = $session->validateSession();
    if (!($accessLevel === 'Administrator')) {
      $errors[] = 'You do not have permission to perform this action.';
    }

    return $errors;
  }

  public static function validateNewUser($data): array
  {
    $errors = [];

    if (!isset($data['name']) || trim($data['name']) === '') {
      $errors[] = 'Name is required.';
    }

    if (!isset($data['username']) || trim($data['username']) === '') {
      $errors[] = 'Username is required.';
    }

    if (!isset($data['password']) || trim($data['password']) === '') {
      $errors[] = 'Password is required.';
    }

    if (!isset($data['permission']) || trim($data['permission']) === '') {
      $errors[] = 'Permission is required.';
    }

    $session = new Session();
    $accessLevel = $session->validateSession();
    if (!($accessLevel === 'Administrator')) {
      $errors[] = 'You do not have permission to perform this action.';
    }

    return $errors;
  }

  public static function validateUserDeletion(array $data): array
  {
    $errors = [];

    if (!isset($data['uuid']) || trim($data['uuid']) === '') {
      $errors[] = 'UUID is required.';
    }

    $session = new Session();
    $accessLevel = $session->validateSession();
    if (!($accessLevel === 'Administrator')) {
      $errors[] = 'You do not have permission to perform this action.';
    }

    return $errors;
  }
}