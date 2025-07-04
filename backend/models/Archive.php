<?php

class Archive
{
  private $pdo;

  public function __construct()
  {
    $this->pdo = Database::getConnection();
  }

  public function newArchive()
  {
    $tournamentModel = new Tournament();

    $oldTournamentData = $tournamentModel->archiveTournaments();
    $ids = array_map(function ($tournament) {
      return $tournament['id'];
    }, $oldTournamentData);
    $dates = array_map(function ($tournament) {
      return $tournament['date'];
    }, $oldTournamentData);

    $schoolModel = new School();
    $names = $schoolModel->fetchSchoolNames($ids);

    $this->pdo->prepare("INSERT INTO archives (icda_1_school, icda_1_date, icda_2_school, icda_2_date, icda_3_school, icda_3_date, icda_4_school, icda_4_date, icda_5_school, icda_5_date, icda_state_date) VALUES (:icda1School, :icda1Date, :icda2School, :icda2Date, :icda3School, :icda3Date, :icda4School, :icda4Date, :icda5School, :icda5Date, :icdaStateDate)")
      ->execute([
        ':icda1School' => $names[0],
        ':icda1Date' => $dates[0],
        ':icda2School' => $names[1],
        ':icda2Date' => $dates[1],
        ':icda3School' => $names[2],
        ':icda3Date' => $dates[2],
        ':icda4School' => $names[3],
        ':icda4Date' => $dates[3],
        ':icda5School' => $names[4],
        ':icda5Date' => $dates[4],
        ':icdaStateDate' => $dates[5]
      ]);
  }
}