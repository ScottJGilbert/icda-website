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

    $this->pdo->prepare("INSERT INTO archiveData (icda_1_school, icda_1_date, icda_2_school, icda_2_date, icda_3_school, icda_3_date, icda_4_school, icda_4_date, icda_5_school, icda_5_date, icda_state_date) VALUES (:icda1School, :icda1Date, :icda2School, :icda2Date, :icda3School, :icda3Date, :icda4School, :icda4Date, :icda5School, :icda5Date, :icdaStateDate)")
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

  public function fetchArchiveData()
  {
    $sql = "SELECT * FROM archiveData";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function fetchSeasonData($id)
  {
    $sql = "SELECT * FROM archiveData WHERE id = :id LIMIT 1";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function updateArchive($names, $dates, $id)
  {
    $this->pdo->prepare('UPDATE archiveData SET icda_1_school = :icda1School, icda_1_date = :icda1Date, icda_2_school = :icda2School, icda_2_date = :icda2Date, icda_3_school = icda3School, icda_3_date = :icda3Date, icda_4_school = :icda4School, icda_4_date = :icda4Date, icda_5_school = :icda5School, icda_5_date = :icda5Date, icda_state_date = :icdaStateDate WHERE id = :id')
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
        ':icdaStateDate' => $dates[5],
        ':id' => $id
      ]);
  }
}