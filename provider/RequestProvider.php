<?php
namespace Sari\Provider;


class RequestProvider
{

	public $query;
	public $post;
	public $server;
	public $files;
	public $cookie;

	public function __construct()
	{
	}

	public function get($var = '')
	{
		if ($var <> '') {
			$query = $_GET[$var];
			return $query;
		}

		foreach($_GET as $k=>$v)
		{
			$query[$k] = $v;
		}
		
		return $query;
	}

	public function post($var = '')
	{
		if ($var <> '') {
			$post = $_POST[$var];
			return $post;
		}

		foreach($_POST as $k=>$v)
		{
			$post[$k] = $v;
		}
		
		return $post;
	}

	public function server($var = '')
	{
		if ($var <> '') {
			$server = $_SERVER[$var];
			return $server;
		}

		foreach($_SERVER as $k=>$v)
		{
			$server[$k] = $v;
		}
		
		return $server;
	}

	public function files($var = '')
	{
		if ($var <> '') {
			$files = $_FILES[$var];
			return $files;
		}

		foreach($_FILES as $k=>$v)
		{
			$files[$k] = $v;
		}
		
		return $files;
	}

	public function cookie($var = '')
	{
		if ($var <> '') {
			$cookie = $_COOKIE[$var];
			return $cookie;
		}

		foreach($_COOKIE as $k=>$v)
		{
			$cookie[$k] = $v;
		}
		
		return $cookie;
	}
}

