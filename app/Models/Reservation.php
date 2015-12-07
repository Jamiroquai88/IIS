<?php

namespace App\Models;
use DB;

class Reservation extends Basemodel
{
	public static $rules = array
	(
		'name' => 'required|max:30',
		'date_from' => 'required|date|after:today',
		'date_to' => 'required|date|after:date_from',
		'persons_number' => 'required|integer|min:1',
		'user_id' => 'required|digits_between:10,10',
		'birth_date' => 'date|before:today',
		'telephone' => 'digits_between:8,20',
		'mail' => 'email',
		'address' => '',
		'room' => 'required'
	);

	public static function showReservations()
	{
		return DB::select('SELECT Meno, Datum, DatumDo, cisrezervace, CisPokoje, Posteli, osob 
							FROM rezervace NATURAL JOIN zakaznik NATURAL JOIN pokoj
							WHERE idzak=rodnecislo AND DatumDo <> "0000-00-00"');
	}

	public static function showPastReservations()
	{
		return DB::select('SELECT *
							FROM rezervace NATURAL JOIN zakaznik
							WHERE idzak = rodnecislo AND DatumDo = "0000-00-00"');
	}

	public static function checkIfExistsZakaznik($value)
	{
		return DB::select(DB::raw('SELECT * FROM zakaznik WHERE rodnecislo = :some_variable'), array('some_variable' => $value));
	}

	public static function checkRoomCapacity($room, $capacity)
	{
		$max = DB::select(DB::raw('SELECT posteli FROM pokoj WHERE cispokoje = :some_variable'), array('some_variable' => $room));
		foreach ($max as $value) 
		{
			return ($value->posteli >= (int)$capacity);
		}
	}

	public static function showReservation($id)
	{
		$raw = 'SELECT * FROM rezervace NATURAL JOIN zakaznik NATURAL JOIN pokoj WHERE CisPokoje = CisPokoje AND IDZak = RodneCislo AND CisRezervace = ' . $id . '';
		return DB::select(DB::raw($raw));
	}

	public static function showRooms()
	{
		foreach ( DB::select(DB::raw('SELECT * FROM pokoj')) as $ar) 
		{
			$rooms_cap[(int)$ar->CisPokoje] = $ar->CisPokoje.'('.$ar->Posteli.')';
		}
		return $rooms_cap;
	}

	public static function isRoomAvailable($from, $to, $room)
	{
		$all_res11 = DB::select(DB::raw('	SELECT Datum, DatumDo 
										FROM rezervace 
										WHERE (Datum >= :some_variable)'), 
										array('some_variable' => $from));
		$all_res12 = DB::select(DB::raw('	SELECT Datum, DatumDo 
										FROM rezervace 
										WHERE (Datum >= :some_variable)'), 
										array('some_variable' => $to));
		foreach($all_res11 as $val)
		{
			$arr11[] = $val; 
		}
		foreach($all_res12 as $val)
		{
			$arr12[] = $val; 
		}

		/** This selects all reservations which are in the conflict **/
		$raw = 'SELECT * FROM rezervace /*NATURAL JOIN rezervovana*/ NATURAL JOIN pokoj WHERE CisPokoje = CisPokoje AND CisPokoje = ' . $room . ' AND NOT((Datum >= ' . "'" . $from . "'" . ' AND Datum >= ' . "'". $to . "'" . ') OR (DatumDo <= ' . "'" . $from . "'" . ' AND DatumDo <= ' . "'". $to . "'" . '))';
		
		$all_res11 = DB::select(DB::raw('	SELECT Datum, DatumDo 
										FROM pobyt 
										WHERE (Datum >= :some_variable)'), 
										array('some_variable' => $from));
		$all_res12 = DB::select(DB::raw('	SELECT Datum, DatumDo 
										FROM pobyt 
										WHERE (Datum >= :some_variable)'), 
										array('some_variable' => $to));
		foreach($all_res11 as $val)
		{
			$arr11[] = $val; 
		}
		foreach($all_res12 as $val)
		{
			$arr12[] = $val; 
		}
		$raw2 = 'SELECT * FROM pobyt NATURAL JOIN pokoj WHERE CisPokoje = Pokoj AND CisPokoje = ' . $room . ' AND NOT((Datum >= ' . "'" . $from . "'" . ' AND Datum >= ' . "'". $to . "'" . ') OR (DatumDo <= ' . "'" . $from . "'" . ' AND DatumDo <= ' . "'". $to . "'" . '))';

		return count(DB::select(DB::raw($raw)))+count(DB::select(DB::raw($raw2)));
	}
}