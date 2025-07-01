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

	public static function html($data, $statusCode = 200)
	{
		http_response_code($statusCode);
		header('Content-Type: text/html; charset=utf-8');
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
}
