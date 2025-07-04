<?php

class Coach
{

  private $pdo;

  public function __construct()
  {
    $this->pdo = Database::getConnection();
  }

  public function fetchCoaches()
  {
    $sql = "SELECT * FROM sessions";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function updateCoaches($coaches)
  {
    $stmt = $this->pdo->query("DELETE FROM coaches");
    $stmt->execute();

    foreach ($coaches as $coach) {
      $stmt = $this->pdo->prepare("INSERT INTO coaches (name, email, school_id) VALUES (:name, :email, :schoolId)");
      $stmt->bindParam(':name', $coach['name'], PDO::PARAM_STR);
      $stmt->bindParam(':email', $coach['email'], PDO::PARAM_STR);
      $stmt->bindParam(':schoolId', $coach['schoolId'], PDO::PARAM_INT);
      $stmt->execute();
    }
  }

  public function fetchCoach($id)
  {
    $stmt = $this->pdo->prepare('SELECT * FROM coaches WHERE id = :id LIMIT 1');
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }
}