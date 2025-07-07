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

	public static function image($image, $statusCode = 200)
	{
		http_response_code($statusCode);
		$fileExtension = pathinfo($image, PATHINFO_EXTENSION);
		header('Content-Type: image/' . $fileExtension);
		echo base64_encode($image);
		exit;
	}

	public static function error($message = 'Something went wrong', $statusCode = 400)
	{
		self::json([
			'success' => false,
			'error' => $message
		], $statusCode);
	}

	public static function redirect($url, $statusCode)
	{
		http_response_code($statusCode);
		header("Location: $url");
		exit;
	}
}
