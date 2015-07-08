<?php
namespace Sari\Provider;


class SessionProvider
{

	public function __construct()
	{
		
		if (session_status() !== PHP_SESSION_ACTIVE) {
			include('src/Config/prod-config.php');
			// session_set_cookie_params(
			// 	$sessionConfig['lifetime'],
			// 	$sessionConfig['path'],
			// 	$sessionConfig['domain'],
			// 	$sessionConfig['secure'],
			// 	$sessionConfig['httponly']
			// );
			session_name($sessionConfig['name']);			
		}

		session_start();
	}

	public function get($name, $index = null)
	{
		if ($index === null) {
			return $_SESSION[$name];
		}else{
			return $_SESSION[$name][$index];
		}
	}

	public function set($name, $index = null, $data = array())
	{	
		if ($index === null) {
			$_SESSION[$name][] = $data;
		}else{
			$_SESSION[$name][$index] = $data;
		}
	}

	public function delete($name, $index = null)
	{
		if ($index === null) {
			unset($_SESSION[$name]);
		}else{
			unset($_SESSION[$name][$index]);
		}
	}

	public function destroy($name)
	{
		unset($_SESSION[$name]);
	}
}

