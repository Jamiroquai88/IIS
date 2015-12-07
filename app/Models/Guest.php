<?php

namespace App\Models;
use DB;

class Guest extends Basemodel
{
	public static $rules = array
	(
		'name' => 'required|max:30',
		'guest_id' => 'required|digits_between:10,10',
		'birth_date' => 'date|before:today',
		'telephone' => 'digits_between:8,20',
		'mail' => 'email',
		'address' => ''
	);

	public static function GetGuestByAccomID($id)
	{
		return DB::select(DB::raw('SELECT * FROM pobyt WHERE CisPobytu = :some_variable'), array('some_variable' => $id));
	}
}