<?php

class Response
{
	public static function json($data, $statusCode = 200)
	{
		http_response_code($statusCode);
		header('Content-Type: application/json');
		echo json_encode($data);
		exit;
	}

	public static function success($payload = [], $statusCode = 200)
	{
		self::json([
			'success' => true,
			'data' => $payload
		], $statusCode);
	}

	public static function error($message = 'Something went wrong', $statusCode = 400)
	{
		self::json([
			'success' => false,
			'error' => $message
		], $statusCode);
	}

	public static function redirect($url)
	{
		// If headers haven't been sent yet, use a server-side redirect
		if (!headers_sent()) {
			header('Location: ' . $url);
			exit;
		}

		// If headers already sent, use JavaScript redirect
		echo "<script>window.location.href = " . json_encode($url) . ";</script>";
		echo '<noscript><meta http-equiv="refresh" content="0;url=' . htmlspecialchars($url) . '"></noscript>';
		exit;
	}
}
