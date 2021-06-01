<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use GuzzleHttp\Client;


class MainController extends Controller
{
    public function showBtcGraph()
	{
		$xAxisData = array_keys($this->getBtcData());
		$yAxisData = array_values($this->getBtcData());
		
		$regression_data = $this->getSimpleLinearRegressionArray($yAxisData);
		
		$chart = (new LarapexChart)->lineChart()
		->setTitle('BTC price')
		->setSubtitle('Simple linear regression')
		->addData('BTC', $yAxisData)
		->addData('Regression', $regression_data)
		->setXAxis($xAxisData);

		$prediction_for_tomorrow = end($regression_data);
		
		return view('chart', compact('chart', 'prediction_for_tomorrow'));
	}

	public function getBtcData()
	{
		$url = "https://api.coindesk.com/v1/bpi/historical/close.json";
		$client = new Client();
        $response = $client->get($url);
        $response = json_decode($response->getBody(), true);
		$btc_data = $response['bpi'];

		return $btc_data;
	}

	public function getSimpleLinearRegressionArray($data)
	{
		$data_length = count($data);

		// the point where SLR intercepts on Y axis
		$intercept = trader_linearreg_intercept($data, $data_length);
		$slope = trader_linearreg_slope($data, $data_length);

		$rez = [];
		// calculate an array depending of intercept and slope
		// Simple Linear Regression
		for ($i=0; $i < $data_length + 1; $i++) { 
			$rez[$i] = $intercept[$data_length - 1] + $slope[$data_length - 1] *$i;
		}

		return $rez;
	}

}
