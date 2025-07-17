<?php

class Tournament
{

  private $pdo;

  public function __construct()
  {
    $this->pdo = Database::getConnection();
  }

  public function fetchTournament($id)
  {
    $stmt = $this->pdo->prepare('SELECT * FROM tournaments WHERE id = :id LIMIT 1');
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $tournament = $stmt->fetch(PDO::FETCH_ASSOC);

    $contactModel = new Contact();
    $contacts = $contactModel->fetchContacts($id);
    $tournament['contacts'] = $contacts;
    return $tournament;
  }

  public function updateTournament($id, $date, $schoolId, $tabroom, $contacts)
  {
    $stmt = $this->pdo->prepare('UPDATE tournaments SET date = :date, school_id = :schoolId, tabroom = :tabroom WHERE id = :id');
    $stmt->bindParam(':date', $date, PDO::PARAM_STR);
    $stmt->bindParam(':schoolId', $schoolId, PDO::PARAM_INT);
    $stmt->bindParam(':tabroom', $tabroom, PDO::PARAM_STR);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    $contactModel = new Contact();
    $contactModel->updateContacts($id, $contacts);
  }

  public function archiveTournaments()
  {
    $stmt = $this->pdo->prepare('SELECT date, school_id FROM tournanamants');
    $stmt->execute();
    $tournaments = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = $this->pdo->prepare('DELETE FROM tournaments');
    $stmt->execute();

    return $tournaments;
  }
}
