<?php

namespace App\Models;
use DB;

class BillingCharge extends Basemodel
{
	public static $rules = array
	(
		'service' => 'required',
		'amount' =>  'required|integer|min:1'
	);

	public static function showCost($id)
	{
		return DB::select(DB::raw('SELECT Cena from pobyt WHERE CisPobytu = :some_variable'), array('some_variable' => $id));
	}

	public static function showProductPrices()
	{
		return DB::select(DB::raw('SELECT * FROM sluzby'));
	}
}