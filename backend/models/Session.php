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
			session_regenerate_id(true);
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

	public function getAccessLevel(): string
	{
		$sessionId = session_id();

		$sql = "SELECT * FROM sessions WHERE (session_id = :sessionId AND DATE_ADD(last_seen, INTERVAL 30 MINUTE) > NOW()) LIMIT 1";
		$stmt = $this->pdo->prepare($sql);
		$stmt->bindParam(":sessionId", $sessionId, PDO::PARAM_STR);
		$stmt->execute();
		$validSession = $stmt->fetch(PDO::FETCH_ASSOC); // Returns false if not found

		if ($validSession !== false) {
			$userModel = new User();
			return $userModel->findAccessByUUID($validSession['user_uuid']);
		} else {
			return 'None';
		}
	}

	public function terminateSession($sessionId): void
	{
		//Handle actual session destruction in controller
		$sql = "DELETE FROM sessions WHERE session_id = :sessionId";
		$stmt = $this->pdo->prepare($sql);
		$stmt->bindParam(":sessionId", $sessionId, PDO::PARAM_STR);
		$stmt->execute();
	}

	public function terminateDeletedUserSessions($uuid): void
	{
		$sql = "DELETE FROM sessions WHERE user_uuid = :uuid";
		$stmt = $this->pdo->prepare($sql);
		$stmt->bindParam(":uuid", $uuid, PDO::PARAM_STR);
		$stmt->execute();
	}

	public function terminateExpiredSessions(): void
	{
		$sql = "DELETE FROM sessions WHERE DATE_ADD(last_seen, INTERVAL 30 MINUTE) > NOW()";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute();
	}

	public function fetchSessions(): array
	{
		$sql = "SELECT * FROM sessions";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
}
