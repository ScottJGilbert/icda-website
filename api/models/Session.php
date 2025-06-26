<?php

class Session
{
  private $pdo;

  public function __construct()
  {
    // Load database config (you can move this later to a config file)
    $this->pdo = Database::getConnection();
  }

  public function createSession($uuid): void
  {
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
      $_SESSION['uuid'] = $uuid;
      $sessionId = session_id();
      $ipAddress = $_SERVER['REMOTE_ADDR'];
      $userAgent = $_SERVER['HTTP_USER_AGENT'];

      $sql = "INSERT INTO sessions (session_id, user_uuid, ip_address, user_agent) VALUES(:sessionId, :uuid, :ipAddress, :userAgent)";
      $stmt = $this->pdo->prepare($sql);
      $stmt->bindParam(':sessionId', $sessionId, PDO::PARAM_STR);
      $stmt->bindParam(':uuid', $uuid, PDO::PARAM_STR);
      $stmt->bindParam(':ipAddress', $ipAddress, PDO::PARAM_STR);
      $stmt->bindParam(':userAgent', $userAgent, PDO::PARAM_STR);

      $stmt->execute();
    }

  }
}