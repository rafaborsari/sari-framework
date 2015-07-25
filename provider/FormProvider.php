<?php
namespace Sari\Provider;

use Sari\Provider\RouterProvider;
use Sari\Provider\RequestProvider;

class FormProvider
{

	private $csrf;
	public $data;
	public $view;

	public function __construct()
	{
		$this->csrf = md5(__DIR__);
		$_SESSION['crft'] = $this->csrf;		
		$this->router = new RouterProvider;
	}

	public function startForm($options = array(), $data = '', $action = '', $method = 'POST')
	{
		$this->data = $data;

		if ($action <> '') {
			$action = $this->router->url . $action;
		}else{
			$action = $_SERVER['REDIRECT_URL'];
		}

		foreach ($options as $attr => $value) {
			$atributes .= $attr . "= '".$value."'" ;
		}
		$this->view['startForm'] = "<form method='".$method."' action = '".$action."' enctype='multipart/form-data' ".$atributes." >";
		
	}

	public function select($name, $list = array(), $idList, $listShow, $options = array(), $prefixs = array())
	{

		foreach ($options as $attr => $content) {
			$option[$attr]['base'] = "".$attr."='".$content."' ";
			$option[$attr]["value"] = $content;
		}

		foreach ($prefixs as $attr => $content) {
			$prefix[$attr]['base'] = "".$attr."='".$content."' ";
			$prefix[$attr]['value'] = $content;
		}

		$selects .= 
		"<option value='%' selected >".$option['placeholder']['value']."</option>";
		foreach ($list as $key => $value) {
			$selected = ($this->data[$name] == $value[$idList] ? 'selected' : '');
			$selects .= 
			"<option value='".$value[$idList]."' ".$selected." >".$value[$listShow]."</option>";
		}

		$this->view[$name] = include('templates/forms/select-list.php');
	}

	public function add($name, $type = 'text', $options = array(), $prefixs = array())
	{
		if (isset($this->data[$name])) {
			$value = trim(strip_tags($this->data[$name]));
		}

		foreach ($options as $attr => $content) {
			$option[$attr]['base'] = "".$attr."='".$content."' ";
			$option[$attr]["value"] = $content;
		}
		foreach ($prefixs as $attr => $content) {
			$prefix[$attr]['base'] = "".$attr."='".$content."' ";
			$prefix[$attr]['value'] = $content;
		}

		switch ($type) {
			case 'number':
				$this->view[$name] = include('templates/forms/input-number.php');
				break;
			default:
				$this->view[$name] = include('templates/forms/input-text.php');
				break;
		}
	}

	public function textarea($name,	$options = array(), $prefixs = array())
	{
		if (isset($this->data[$name])) {
			$value = trim(strip_tags($this->data[$name]));
		}

		foreach ($options as $attr => $content) {
			$option[$attr]['base'] = "".$attr."='".$content."' ";
			$option[$attr]["value"] = $content;
		}
		foreach ($prefixs as $attr => $content) {
			$prefix[$attr]['base'] = "".$attr."='".$content."' ";
			$prefix[$attr]['value'] = $content;
		}

		$this->view[$name] = include('templates/forms/input-textarea.php');
	}

	public function submit($name, $value = '', $options = array(), $prefixs = array())
	{
		foreach ($options as $attr => $content) {
			$option[$attr]['base'] = "".$attr."='".$content."' ";
			$option[$attr]["value"] = $content;
		}
		foreach ($prefixs as $attr => $content) {
			$prefix[$attr]['base'] = "".$attr."='".$content."' ";
			$prefix[$attr]['value'] = $content;
		}

		$this->view[$name] = include('templates/forms/input-submit.php');
	}

	public function hidden($name, $value)
	{
		$this->view[$name] = include('templates/forms/input-hidden.php');
	}

	public function isValid()
	{
		$request = new RequestProvider;

		if (is_null($this->data) OR is_null($request->post('op'))) {
			return false;
		}

		return true;
	}

	public function endForm()
	{
		$this->view['csrf'] = "<input type='hidden' name='csrf' value='".sha1($this->csrf)."' />";
		$this->view['endForm'] = "</form>";
	}

	public function getView()
	{

		return implode("", $this->view);
	}

	public function createView()
	{
		echo implode("", $this->view);
	}

}

