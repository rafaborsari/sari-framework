<?php
namespace Sari\Provider;

use Sari\Provider\DataBaseProvider;
use Sari\Provider\RouterProvider;

use KoolChart;
use BarSeries;
use AreaSeries;
use ColumnSeries;

class GraphProvider
{

	public function __construct($text, $width = 680, $height = 480)
	{
		$this->dbh = new DataBaseProvider;
		$this->router = new RouterProvider;
		$this->chart = new KoolChart("chart" . rand(0, 999999999));

		$this->chart->Title->Text = $text;
		$this->chart->Width = $width;
		$this->chart->Height = $height;
		$this->chart->DecimalNumber = 2;
		$this->chart->DecimalSeparator = ",";
		$this->chart->ThousandSeparator = ".";
	}

	public function createBarChart($position, 
		$xAxis = array(
			'set'	=> array(),
			'title'	=> "",
		), 
		$yAxis = array(
			'title'			=> "",
			'dataFormat'	=> "{0}",
		)
	)
	{
		$this->chart->Legend->Appearance->Position = $position;

		$this->chart->PlotArea->XAxis->Title = $xAxis['title'];
		$this->chart->PlotArea->XAxis->Set($xAxis['set']);

		$this->chart->PlotArea->YAxis->Title = $yAxis['title'];
		$this->chart->PlotArea->YAxis->LabelsAppearance->DataFormatString = $yAxis['dataFormat'];
	}

	public function addBarSeries($name, $dataFormat = '{0}', $data = array(), $colorBar = 'auto')
	{
		$series = new BarSeries();
		$series->Name = $name;
		$series->TooltipsAppearance->DataFormatString = $dataFormat;
		$series->Appearance->BackgroundColor = $colorBar;
		$series->ArrayData($data);
		$this->chart->PlotArea->AddSeries($series);
	}

	public function addAreaSeries($name, $dataFormat = '{0}', $data = array(), $colorBar = 'auto')
	{
		$series = new AreaSeries();
		$series->Name = $name;
		$series->LabelsAppearance->DataFormatString = $dataFormat;
		$series->TooltipsAppearance->DataFormatString = $dataFormat;
		$series->Appearance->BackgroundColor = $colorBar;
		$series->ArrayData($data);
		$this->chart->PlotArea->AddSeries($series);
	}

	public function addColumnSeries($name, $dataFormat = '{0}', $data = array(), $colorBar = 'auto')
	{
		$series = new ColumnSeries();
		$series->Name = $name;
		$series->TooltipsAppearance->DataFormatString = $dataFormat;
		$series->Appearance->BackgroundColor = $colorBar;
		$series->ArrayData($data);
		$this->chart->PlotArea->AddSeries($series);
	}

	public function renderChart()
	{
		return $this->chart->Render();
	}



}


