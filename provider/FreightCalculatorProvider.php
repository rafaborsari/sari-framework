<?php
namespace Sari\Provider;

use Sari\Provider\RouterProvider;
use Sari\Provider\DataBaseProvider;
use Sari\Provider\SessionProvider;
use Sari\Provider\FormProvider;

use cURL;

class FreightCalculatorProvider
{
	
	public function __construct()
	{
		$this->urlWebservice = 'http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx';
		$this->data = array(
			'nCdEmpresa' 			=> 	'',
			'sDsSenha'				=>	'',
			'sCepOrigem'			=>	'',
			'sCepDestino'			=>	'',
			'nVlPeso'				=>	'1',
			'nCdFormato'			=>	'1',
			'nVlComprimento'		=>	'16',
			'nVlAltura'				=>	'5',
			'nVlLargura'			=>	'15',
			'nVlDiametro'			=>	'0',
			'sCdMaoPropria'			=>	'n',
			'nVlValorDeclarado'		=>	'0',
			'sCdAvisoRecebimento'	=>	'n',
			'StrRetorno'			=>	'xml',
			'nCdServico'			=>	'41106,40010,40045,40215,40290',
		);

		$this->correioService = array(
			'41106' => 'PAC',
			'40010' => 'SEDEX',
			'40045' => 'SEDEX a Cobrar',
			'40215' => 'SEDEX 10',
			'40290' => 'SEDEX Hoje',
		);
	}

	public function getParam($name, $value)
	{
		$this->data[$name] = (string) $value;
	}

	public function setParam($name)
	{
		return $this->data[name];
	}

	public function calculate()
	{
		$parameters = http_build_query($this->data);
		
		$curl = curl_init($this->urlWebservice.'?'.$parameters);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

		$result = curl_exec($curl);

		return simplexml_load_string($result);

	}

}

