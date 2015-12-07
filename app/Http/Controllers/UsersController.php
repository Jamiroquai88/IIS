<?php

namespace App\Http\Controllers;
use App\Models;
use Input;
use Redirect;
use Hash;
use View;
use Auth;
use DB;
use Request;

class UsersController extends Controller
{
	public $restful = true;

	public function getHome()
	{
		return \View::make('layouts.default')
			->with('title', 'Home');
	}

	public function getDeleteDialog()
	{
		if(Auth::check())
		{
			return \View::make('layouts.default')
				->with('title', 'Delete?')
				->with('employees', \App\Models\User::showEmployees());
		}
		else
		{		
			return Redirect::route('home')
				->with('message', 'You are not logged in!');
		}
	}

	public function getAdministration()
	{
		if(Auth::check())
		{
			return \View::make('layouts.default')
				->with('title', 'Administration')
				->with('employees', \App\Models\User::showEmployees());
		}
		else
		{
			return Redirect::route('home')
				->with('message', 'You are not logged in!');
		}
	}

	public function getRegister()
	{
		if(Auth::check())
		{
			return \View::make('users.new')
				->with('title', 'Register new user');
		}
		else
		{
			return Redirect::route('home')
				->with('message', 'You are not logged in!');
		}
	}

	public function postRegister()
	{
		if(Auth::check())
		{
			$validation = \App\Models\User::Validate(Input::all());
			if($validation->passes())
			{
				/*\App\Models\User::create(array(
						'username' => Input::get('username'),
						'password' => Hash::make(Input::get('password')),
						'name' => Input::get('name'),
						'birth_date' => Input::get('birth_date'),
						'telephone' => Input::get('telephone'),
						'mail' => Input::get('mail'),
						'address' => Input::get('address')
					)
				);*/

				DB::insert('INSERT INTO users (username, password, name, birth_date, telephone, mail, address) VALUES (?, ?, ?, ?, ?, ?, ?)',
					[	Input::get('username'), 
						Hash::make(Input::get('password')), 
						Input::get('name'), 
						Input::get('birth_date'),
						Input::get('telephone'), 
						Input::get('mail'), 
						Input::get('address')]);

				return Redirect::route('home')
					->with('message', 'Thanks for registering!');
			}
			else
			{
				return Redirect::route('register')
					->withErrors($validation)->withInput();
			}
		}
		else
		{
			return Redirect::route('home')
				->with('message', 'You are not logged in!');
		}
	}

	public function getLogin()
	{
		
		return View::make('users.login')
			->with('title', 'Login');

	}

	public function postLogin()
	{
		$user = array
		(
			'username' => Input::get('username'),
			'password' => Input::get('password')
		);
		if(Auth::attempt($user))
		{
			return Redirect::route('home')
				->with('message', 'You are logged in!');
		}
		else
		{
			return Redirect::route('login')
				->with('message', 'Incorrect login/password!')
				->withInput();
		}
	}

	public function getLogout()
	{
		if(Auth::check())
		{
			Auth::logout();
			return Redirect::route('home')
				->with('message', 'You are successfully logged out!');
		}
		else
		{
			return Redirect::route('home')
				->with('message', 'You are not logged in!');
		}
	}

	public function getEditAccount()
	{
		if(Auth::check())
		{
			if(count(Request::all()) > 0)
			{
				foreach (Request::all() as $value) 
				{
					$my_account = $value;
					$is_old = false;
				}
			}
			else
			{
				$my_account = \Session::get('user')->id;
				$is_old = true;	
			}
			
			foreach(\App\Models\User::showAccount($my_account) as $value)
			{
				$my_user = $value;
			}
			
			return \View::make('users.edit')
				->with('title', 'Edit account')
				->with('previous', $my_user)
				->with('old', $is_old);
		}
		else
		{
			return Redirect::route('home')
				->with('message', 'You are not logged in!');
		}
	}

	public function postEditAccount()
	{
		if(Auth::check())
		{
			$validation = \App\Models\UserEdit::Validate(Input::all());
			if($validation->passes())
			{
				/** Here you have to edit table **/
				$raw = 'UPDATE users SET telephone = "' . Input::get('telephone') . '", address = "' . Input::get('address') . '", mail = "' . Input::get('mail') . '" WHERE id = ' . Input::get('id');
				DB::select(DB::raw($raw));

				return Redirect::route('home')
					->with('message', 'Editing of account was successfull!');
			}
			else
			{
				foreach(\App\Models\User::showAccount(Input::get('id')) as $value)
				{
					$my_user = $value;
				}

				return Redirect::route('editaccount')
					->withErrors($validation)
					->withInput()
					->with('user', $my_user);
			}
		}
		else
		{
			return Redirect::route('home')
				->with('message', 'You are not logged in!');
		}
	}

	public function getDeleteAccount()
	{
		if(Auth::check())
		{
			foreach (Request::all() as $value) 
			{	
				$my_account = (int)$value;
			}
			if($my_account == 1)
			{
				return Redirect::route('home')
					->with('message', 'You can not delete admin account!');
			}
			else
			{
				/** Here, you should use some dialog window - Are you sure? Yes/No **/
				DB::select(DB::raw('DELETE FROM users WHERE id = :some_variable'), array('some_variable' => $my_account));
				return Redirect::route('home')
					->with('message', 'Account succesfully deleted!');
			}
		}
		else
		{
			return Redirect::route('home')
				->with('message', 'You are not logged in!');
		}
	}

	/** Kind of - I have no idea what to do with this **** */
	public function getRememberToken()
	{
    	return $this->remember_token;
	}

	public function setRememberToken($value)
	{
   	 	$this->remember_token = $value;
	}

	public function getRememberTokenName()
	{
    	return 'remember_token';
	}
	/** end of **** */
}