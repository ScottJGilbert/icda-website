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
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function updateTournament($id, $data)
  {
    $stmt = $this->pdo->prepare('UPDATE tournament_pages SET tournament_date = :tournamentDate, school_id = :schoolId, tabroom = :tabroom, contacts = :contacts WHERE id = :id');
    $stmt->bindParam(':tournamentDate', $data['tournamentDate'], PDO::PARAM_STR);
    $stmt->bindParam(':schoolId', $data['schoolId'], PDO::PARAM_INT);
    $stmt->bindParam(':tabroom', $data['tabroom'], PDO::PARAM_STR);
    $stmt->bindParam(':contacts', $data['contacts'], PDO::PARAM_STR);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
  }

  public function archiveTournaments()
  {
    $stmt = $this->pdo->prepare('SELECT tournament_date, school_id FROM tournanamant_pages');
    $stmt->execute();
    $tournaments = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = $this->pdo->prepare('DELETE FROM tournament_pages');
    $stmt->execute();

    return $tournaments;
  }
}
