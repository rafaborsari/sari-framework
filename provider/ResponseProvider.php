<?php
namespace Sari\Provider;

use Sari\Provider\RouterProvider;

class ResponseProvider
{

	public function __construct()
	{
		$this->router = new RouterProvider;
	}

	public function redirect($url, $statusCode = 302, $headers = array())
	{
		foreach ($headers as $key => $value) {
			header($key . ":" . $value, true);
		}
		$redirectUrl = $this->router->url . $url;
		if (headers_sent()) {
			echo "<script>location.replace('".$redirectUrl."'); </script>";
		}
		echo "<script>location.replace('".$redirectUrl."'); </script>";
	}

	public function abort($statusCode = '404', $message = '', $headers = array())
	{
		foreach ($headers as $key => $value) {
			header($key . ":" . $value, true);
		}
		$redirectUrl = $this->router->url . "errors/code/" . $statusCode;
		echo "<script>location.replace('".$redirectUrl."'); </script>";

	}

}

