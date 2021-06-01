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
		$chart = (new LarapexChart)->lineChart()
		->setTitle('BTC price')
		->setSubtitle('Simple linear regression')
		->addData('BTC', $yAxisData)
		//->addData('Digital sales', [70, 29, 77, 28, 55, 45])
		->setXAxis($xAxisData);
		
		return view('chart', compact('chart'));
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
}
