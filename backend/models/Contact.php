<?php

class Contact
{

  private $pdo;

  public function __construct()
  {
    $this->pdo = Database::getConnection();
  }

  public function fetchContacts($tournamentId)
  {
    $stmt = $this->pdo->prepare('SELECT * FROM contacts WHERE tournament = :tournamentId');
    $stmt->bindParam(':tournamentId', $tournamentId, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function updateContacts($tournamentId, $contacts)
  {
    // Clear existing contacts for the tournament
    $stmt = $this->pdo->prepare('DELETE FROM contacts WHERE tournament = :tournamentId');
    $stmt->bindParam(':tournamentId', $tournamentId, PDO::PARAM_INT);
    $stmt->execute();

    // Insert new contacts
    foreach ($contacts as $contact) {
      $stmt = $this->pdo->prepare('INSERT INTO contacts (tournament, name, email) VALUES (:tournamentId, :name, :email)');
      $stmt->bindParam(':tournamentId', $tournamentId, PDO::PARAM_INT);
      $stmt->bindParam(':name', $contact['name'], PDO::PARAM_STR);
      $stmt->bindParam(':email', $contact['email'], PDO::PARAM_STR);
      $stmt->execute();
    }
  }
}