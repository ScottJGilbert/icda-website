<?php

class School
{
  private $pdo;

  public function __construct()
  {
    $this->pdo = Database::getConnection();
  }

  public function fetchSchools()
  {
    $stmt = $this->pdo->query("SELECT * FROM schools ORDER BY name ASC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function updateSchools($schools)
  {
    $stmt = $this->pdo->query("DELETE FROM schools");
    $stmt->execute();

    foreach ($schools as $school) {
      $stmt = $this->pdo->prepare("INSERT INTO schools (name, image_url) VALUES (:name, :imageUrl)");
      $stmt->bindParam(':name', $school['name'], PDO::PARAM_STR);
      $stmt->bindParam(':imageUrl', $school['imageUrl'], PDO::PARAM_STR);
      $stmt->execute();
    }
  }

  public function fetchNumberOfSchools()
  {
    $stmt = $this->pdo->query("SELECT COUNT(*) FROM schools");
    return $stmt->fetchColumn();
  }
}