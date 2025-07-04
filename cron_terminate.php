<?php

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

// Strong token stored securely
$expectedToken = $_ENV['CRON_KEY'];

// Check that it's a POST request and the token matches
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || $_POST['key'] !== $expectedToken) {
  http_response_code(403);
  die('Forbidden: Invalid request');
}

// Run your task

function performBackgroundTask()
{
  file_put_contents('cron_log.txt', "Task ran at " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);
  $sessionModel = new Session();
  $sessionModel->terminateExpiredSessions();
}

performBackgroundTask();
