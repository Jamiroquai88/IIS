<?php

namespace App\Models;
use DB;

class User extends Basemodel
{
	protected $fillable = ['username', 'password', 'password_confirmation'];
	public static $rules = array
	(
		'username' => 'required|unique:users|alpha_dash|min:4',
		'password' => 'required|alpha_num|between:4,12|confirmed',
		'password_confirmation' => 'required|alpha_num|between:4,12',
		'name' => 'required|max:30',
		'birth_date' => 'date|before:today',
		'telephone' => 'digits_between:8,20',
		'mail' => 'email',
		'address' => ''
	);

	public static function showEmployees()
	{
		return DB::select('	SELECT * 
							FROM users');
	}

	public static function showAccount($id)
	{
		return DB::select(DB::raw('SELECT * FROM users WHERE id = :some_variable'), array('some_variable' => $id));
	}
}
