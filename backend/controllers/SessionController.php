<?php

class SessionController
{

	public function fetchSessions()
	{
		$errors = SessionValidators::validateFetchSessions();

		if (!empty($errors)) {
			Response::error($errors[0], 422);
			exit;
		}

		$sessionModel = new Session();
		$sessions = $sessionModel->fetchSessions();

		Response::success($sessions);
	}

	public function terminateSession($sessionId)
	{
		$errors = SessionValidators::validateSessionTermination($sessionId);

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