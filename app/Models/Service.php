<?php

namespace App\Models;
use DB;

class Service extends Basemodel
{
	public static $rules = array
	(
		'name' => 'required|max:30',
		'price' => 'required|integer|min:1'
	);

	public static function showServices()
	{
		return DB::select('SELECT * FROM sluzby');
	}

	public static function showService($id)
	{
		return DB::select(DB::raw('SELECT * FROM sluzby WHERE CisSluzby = :some_variable'), array('some_variable' => $id));
	}
}