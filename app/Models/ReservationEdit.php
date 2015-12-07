<?php

namespace App\Models;
use DB;

class ReservationEdit extends Basemodel
{
	public static $rules = array
	(
		'date_from' => 'required|date|after:today',
		'date_to' => 'required|date|after:date_from',
		'persons_number' => 'required|integer|min:1',
		'room' => 'required'
	);
}