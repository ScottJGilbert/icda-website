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

function performBackgroundTask()
{
  $tournamentModel = new Tournament();
  $tournamentData = $tournamentModel->archiveTournaments();

  if ($tournamentData) {
    $newDirectory = __DIR__ . "/archive/" . ((((int) date("Y")) - 1) . "-" . date("Y")) . "/";
    mkdir($newDirectory, 0, true);

    for ($i = 1; $i < 6; $i++) {
      rename(
        __DIR__ . "/../../tournaments/icda-" . $i . "/legislation.pdf",
        __DIR__ . $newDirectory . "icda-" . $i . "-legislation.pdf"
      );
      rename(
        __DIR__ . "/../../tournaments/icda-" . $i . "/results.pdf",
        __DIR__ . $newDirectory . "icda-" . $i . "-results.pdf"
      );
    }
    rename(
      __DIR__ . "/../../tournaments/icda-state/legislation.pdf",
      __DIR__ . $newDirectory . "/icda-state-legislation.pdf"
    );
    rename(
      __DIR__ . "/../../tournaments/icda-state/results.pdf",
      __DIR__ . $newDirectory . "/icda-state-results.pdf"
    );

    $archiveModel = new Archive();
    $archiveModel->newArchive();

    file_put_contents('cron_log.txt', "Archived tournaments at " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);
  } else {
    file_put_contents('cron_log.txt', "No tournaments to archive at " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);
  }
}

performBackgroundTask();