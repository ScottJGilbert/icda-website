<?php

class SessionController
{

	public function terminateSession($sessionId)
	{
		$errors = Validators::validateSessionTermination($sessionId);

		if (!empty($errors)) {
			Response::error($errors[0], 422);
			exit;
		}

		$sessionModel = new Session();
		$sessionModel->terminateSession($sessionId);
	}

	public function logout()
	{
		if (session_status() === PHP_SESSION_ACTIVE) {
			$sessionId = session_id();

			$sessionModel = new Session();
			$sessionModel->terminateSession($sessionId);

			session_unset();
			session_destroy();
		}
	}
}