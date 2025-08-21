<?php

class Rule
{

  private $pdo;

  public function __construct()
  {
    $this->pdo = Database::getConnection();
  }

  public function fetchRules()
  {
    $stmt = $this->pdo->prepare("SELECT * FROM rules ORDER BY number");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function updateRules($rules)
  {
    $stmt = $this->pdo->query("DELETE FROM rules");
    $stmt->execute();

    foreach ($rules as $rule) {
      $stmt = $this->pdo->prepare("INSERT INTO rules (name, number, summary) VALUES (:name, :number, :summary)");
      $stmt->bindParam(':name', $rule['name'], PDO::PARAM_STR);
      $stmt->bindParam(':number', $rule['number'], PDO::PARAM_INT);
      $stmt->bindParam(':summary', $rule['summary'], PDO::PARAM_STR);
      $stmt->execute();
    }
  }
}