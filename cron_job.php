<?php

require_once realpath(__DIR__ . '/backend/config/bootstrap.php');
require_once realpath(__DIR__ . '/backend/core/Response.php');
require_once realpath(__DIR__ . '/backend/core/Database.php');
require_once realpath(__DIR__ . '/models/Contact.php');
require_once realpath(__DIR__ . '/models/Tournament.php');
require_once realpath(__DIR__ . '/models/Session.php');
require_once realpath(__DIR__ . '/models/Archive.php');
require_once realpath(__DIR__ . '/models/School.php');

// Strong token stored securely
$expectedToken = $_ENV['CRON_KEY'];

// Check that it's a POST request and the token matches
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || $_POST['key'] !== $expectedToken) {
  Response::error('Forbidden: Invalid request', 400);
  exit;
}

function performBackgroundTask()
{
  //Delete when verified working
  file_put_contents(__DIR__ . '/cron_log.txt', "Task ran at " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);
  $sessionModel = new Session();
  $sessionModel->terminateExpiredSessions();

  if (date('m') !== '08' || date('d') !== '01') {
    return;
  }
  $archiveModel = new Archive();

  $previousArchiveTime = $archiveModel->fetchLastArchiveTime();
  if ($previousArchiveTime && strtotime($previousArchiveTime) > strtotime('-1 year')) {
    return;
  }

  $newDirectory = __DIR__ . "/archive/" . ((((int) date("Y")) - 1) . "-" . date("Y")) . "/";
  mkdir($newDirectory, 0777, true);

  copy(__DIR__ . "/archive/2019-2020/index.html", $newDirectory . "index.html");

  for ($i = 1; $i < 6; $i++) {
    if (file_exists(__DIR__ . "/tournaments/icda-" . $i . "/legislation.pdf")) {
      rename(
        __DIR__ . "/tournaments/icda-" . $i . "/legislation.pdf",
        $newDirectory . "icda-" . $i . "-legislation.pdf"
      );
    }
    if (file_exists(__DIR__ . "/tournaments/icda-" . $i . "/results.pdf")) {
      rename(
        __DIR__ . "/tournaments/icda-" . $i . "/results.pdf",
        $newDirectory . "icda-" . $i . "-results.pdf"
      );
    }
  }
  if (file_exists(__DIR__ . "/tournaments/icda-state/legislation.pdf")) {
    rename(
      __DIR__ . "/tournaments/icda-state/legislation.pdf",
      $newDirectory . "icda-state-legislation.pdf"
    );
  }
  if (file_exists(__DIR__ . "/tournaments/icda-state/results.pdf")) {
    rename(
      __DIR__ . "/tournaments/icda-state/results.pdf",
      $newDirectory . "icda-state-results.pdf"
    );
  }

  $archiveModel->newArchive();
}

performBackgroundTask();