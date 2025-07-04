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

  public function updateSchool($name, $imageUrl, $id)
  {
    if ($id > 0) {
      $stmt = $this->pdo->prepare("UPDATE schools SET name = :name, image_url = :imageUrl WHERE id = :id");
    } else {
      $stmt = $this->pdo->prepare("INSERT INTO schools (name, image_url) VALUES (:name, :imageUrl)");
    }
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':imageUrl', $imageUrl, PDO::PARAM_STR);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    return $stmt->execute();
  }

  public function fetchNumberOfSchools()
  {
    $stmt = $this->pdo->query("SELECT COUNT(*) FROM schools");
    return $stmt->fetchColumn();
  }

  public function fetchImageUrl($id): string
  {
    $stmt = $this->pdo->prepare("SELECT image_url FROM schools WHERE id = :id LIMIT 1");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchColumn();
  }

  public function deleteSchool($id)
  {
    $stmt = $this->pdo->prepare("DELETE FROM schools WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    return $stmt->execute();
  }
}