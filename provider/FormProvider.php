<?php
namespace Sari\Provider;

use Sari\Provider\RouterProvider;
use Sari\Provider\RequestProvider;

class FormProvider
{

	private $csrf;
	public $data;

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
		$this->view = "<form method='".$method."' action = '".$action."' enctype='multipart/form-data' ".$atributes." >";
		
	}

	public function select($name, $list = array(), $idList, $listShow, 
		$options = array(
			'placeholder' 	=> '',
			'class'			=> '',
			'required'		=> '',
			'label'			=> '',
			'selected'		=> '',
		), 
		$prefix = array(
			'class'			=> '',
		)
	)
	{
		foreach ($list as $key => $value) {
			$selected = ($this->data[$name] == $value[$idList] ? 'disabled selected' : '');
			$select .= 
			"<option value='".$value[$idList]."' ".$selected." >".$value[$listShow]."</option>";
		}

		$this->view .= include('templates/forms/select-list.php');
	}

	public function add($name, $type = 'text', 
		$options = array(
			'placeholder' 	=> '',
			'class'			=> '',
			'required'		=> '',
			'label'			=> '',
			'autofocus'		=> '',
			'step'			=> '',
			'min'			=> '',
			'max'			=> '',
			'accept'		=> '',
		), 
		$prefix = array(
			'class'			=> '',
		)
	)
	{

		if (isset($this->data[$name])) {
			$value = trim(strip_tags($this->data[$name]));
		}

		$required = (is_null($options['required']) ? "" : "required='required'");
		$autofocus = (is_null($options['autofocus']) ? "" : "autofocus='autofocus'");


		switch ($type) {
			case 'number':
				$this->view .= include('templates/forms/input-number.php');
				break;
			default:
				$this->view .= include('templates/forms/input-text.php');
				break;
		}
	}

	public function textarea($name,
		$options = array(
			'placeholder' 	=> '',
			'class'			=> '',
			'required'		=> '',
			'label'			=> '',
			'autofocus'		=> '',
		), 
		$prefix = array(
			'class'			=> '',
		)
	)
	{
		if (isset($this->data[$name])) {
			$value = trim(strip_tags($this->data[$name]));
		}

		$required = (is_null($options['required']) ? "" : "required='required'");
		$autofocus = (is_null($options['autofocus']) ? "" : "autofocus='autofocus'");

		$this->view .= include('templates/forms/input-textarea.php');
	}

	public function submit($name, $value = '', 
		$options = array(
			'class'			=> '',
			'label'			=> '',
		), 
		$prefix = array(
			'class'			=> '',
		)
	)
	{
		$this->view .= include('templates/forms/input-submit.php');
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
		$this->view .= "<input type='hidden' name='csrf' value='".sha1($this->csrf)."' />";
		$this->view .= "</form>";
	}

	public function getView()
	{
		return $this->view;
	}

	public function createView()
	{
		echo $this->view;
	}

}

