<?php

class Oversight
{

  private $pdo;

  public function __construct()
  {
    $this->pdo = Database::getConnection();
  }

  public function fetchAllOversight()
  {
    $stmt = $this->pdo->prepare("SELECT * FROM oversight");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function fetchOversight($id)
  {
    $stmt = $this->pdo->prepare('SELECT * FROM oversight WHERE id = :id LIMIT 1');
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function fetchImageUrl($id): string
  {
    $stmt = $this->pdo->prepare('SELECT image_url FROM oversight WHERE id = :id LIMIT 1');
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchColumn();
  }

  public function updateOversight($id, $name, $email, $imageUrl)
  {
    $stmt = $this->pdo->prepare('UPDATE oversight SET name = :name, email = :email, image_url = :imageUrl WHERE id = :id');
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':imageUrl', $imageUrl, PDO::PARAM_STR);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
  }
}