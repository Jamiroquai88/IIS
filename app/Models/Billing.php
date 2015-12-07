<?php

namespace App\Models;
use DB;

class Billing extends Basemodel
{
	public static $rules = array
	(
		'name' => 'required|max:30',
		'date_to' => 'required|date|after:yesterday',
		'persons_number' => 'required|integer|min:1',
		'guest_id' => 'required|digits:10',
		'birth_date' => 'date|before:today',
		'telephone' => 'digits_between:8,20',
		'mail' => 'email',
		'address' => '',
		'room' => 'required'	
	);

	public static function showGuests()
	{
		return DB::select('SELECT Meno, Datum, DatumDo, cispobytu, Cena, Pokoj, Osob 
							FROM pobyt NATURAL JOIN zakaznik
							WHERE idzak=rodnecislo AND DatumDo <> "0000-00-00"');
	}

	public static function showPayments()
	{
		return DB::select('SELECT * FROM platba');
	}

	public static function showServices()
	{
		foreach (DB::select(DB::raw('SELECT * FROM sluzby')) as $ar) 
		{
			$services[$ar->Nazov] = $ar->Cena;
		}
		return $services;
	}

	public static function showRooms()
	{
		return DB::select('SELECT * FROM pokoj');
	}

	public static function showPastAccom()
	{
		return DB::select('SELECT *
							FROM pobyt NATURAL JOIN zakaznik  
							WHERE idzak=rodnecislo AND DatumDo = "0000-00-00"');
	}

}