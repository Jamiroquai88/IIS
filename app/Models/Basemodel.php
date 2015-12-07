<?php

namespace App\Models;
use Eloquent;
use Validator;

class Basemodel extends \Eloquent
{
	public static function validate($data)
	{
		return Validator::make($data, static::$rules);
	}
}