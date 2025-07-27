<?php

require_once realpath(__DIR__ . '/backend/config/bootstrap.php');
require_once realpath(__DIR__ . '/models/Tournament.php');
require_once realpath(__DIR__ . '/models/Session.php');
require_once realpath(__DIR__ . '/models/Archive.php');

// Strong token stored securely
$expectedToken = $_ENV['CRON_KEY'];

// Check that it's a POST request and the token matches
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || $_POST['key'] !== $expectedToken) {
  http_response_code(403);
  die('Forbidden: Invalid request');
}

function performBackgroundTask()
{
  //Delete when verified working
  file_put_contents('/cron_log.txt', "Task ran at " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);
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

  $tournamentModel = new Tournament();
  $tournamentData = $tournamentModel->archiveTournaments();

  if ($tournamentData) {
    $newDirectory = __DIR__ . "/archive/" . ((((int) date("Y")) - 1) . "-" . date("Y")) . "/";
    mkdir($newDirectory, 0, true);

    copy(__DIR__ . "/archive/2019-2020/index.html", $newDirectory . "index.html");

    for ($i = 1; $i < 6; $i++) {
      rename(
        __DIR__ . "/tournaments/icda-" . $i . "/legislation.pdf",
        __DIR__ . $newDirectory . "icda-" . $i . "-legislation.pdf"
      );
      rename(
        __DIR__ . "/tournaments/icda-" . $i . "/results.pdf",
        __DIR__ . $newDirectory . "icda-" . $i . "-results.pdf"
      );
    }
    rename(
      __DIR__ . "/tournaments/icda-state/legislation.pdf",
      __DIR__ . $newDirectory . "/icda-state-legislation.pdf"
    );
    rename(
      __DIR__ . "/tournaments/icda-state/results.pdf",
      __DIR__ . $newDirectory . "/icda-state-results.pdf"
    );

    $archiveModel->newArchive();

    file_put_contents('/cron_log.txt', "Archived tournaments at " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);
  } else {
    file_put_contents('/cron_log.txt', "No tournaments to archive at " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);
  }
}

performBackgroundTask();