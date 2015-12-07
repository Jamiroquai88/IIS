<?php

namespace App\Models;
use DB;

class UserEdit extends Basemodel
{
	public static $rules = array
	(
		'telephone' => 'digits_between:8,20',
		'mail' => 'email',
		'address' => ''
	);
}