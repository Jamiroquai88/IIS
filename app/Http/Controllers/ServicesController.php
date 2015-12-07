<?php

namespace App\Http\Controllers;
use App\Http\Controllers;
use App\Models;
use Input;
use Redirect;
use DB;
use Route;
use Request;
use Carbon\Carbon;
use Auth;

class ServicesController extends Controller
{
	public static function getServices()
	{
		if(Auth::check())
		{
			return \View::make('layouts.default')
				->with('title', 'Services')
				->with('services', \App\Models\Service::showServices());
		}
		else
		{
			return Redirect::route('home')
				->with('message', 'You are not logged in!');
		}
	}

	public static function getNewService()
	{
		if(Auth::check())
		{
			return \View::make('services.new')
				->with('title', 'New Service');
		}
		else
		{
			return Redirect::route('home')
				->with('message', 'You are not logged in!');
		}
	}

	public static function postNewService()
	{
		if(Auth::check())
		{
			$validation = \App\Models\Service::validate(Input::all());
			if($validation->passes())
			{
				$res_number_query = DB::select('SELECT MAX(CisSluzby) AS maxx FROM sluzby');
				$this_service_number = (int)$res_number_query[0]->maxx + 1;
				DB::insert('INSERT INTO sluzby (CisSluzby, Nazov, Cena) VALUES (?, ?, ?)',
					[$this_service_number, Input::get('name'), Input::get('price')]);
				return Redirect::route('home')
					->with('message', 'Creating of new service was successfull!');		 
			}
			else
			{
				return Redirect::route('newservice')
					->withErrors($validation)->withInput();
			}
		}
		else
		{
			return Redirect::route('home')
				->with('message', 'You are not logged in!');
		}
	}

	public static function getDeleteService()
	{
		if(Auth::check())
		{
			foreach (Request::all() as $value) 
			{
				$my_id = (int)$value;
			}
			DB::select(DB::raw('DELETE FROM sluzby WHERE CisSluzby = :some_variable'), array('some_variable' => $my_id));
			return Redirect::route('home')
				->with('message', 'Service was successfully deleted!');
		}
		else
		{
			return Redirect::route('home')
				->with('message', 'You are not logged in!');
		}
	}

	public static function getEditService()
	{
		if(Auth::check())
		{
			if(count(Request::all()) > 0)
			{
				foreach (Request::all() as $value) 
				{
					$my_id = (int)$value;
					$is_old = false;
				}
			}
			else
			{
				$my_id = \Session::get('service')->CisSluzby;
				$is_old = true;	
			}
	
			foreach (\App\Models\Service::showService($my_id) as $value) 
			{
				$my_service = $value;
			}
			
			return \View::make('services.edit')
				->with('title', 'Edit Service')
				->with('service', $my_service)
				->with('old', $is_old);
		}
		else
		{
			return Redirect::route('home')
				->with('message', 'You are not logged in!');
		}
	}

	public static function postEditService()
	{
		if(Auth::check())
		{
			$validation = \App\Models\Service::validate(Input::all());
			if($validation->passes())
			{
				$raw = 'UPDATE sluzby SET Cena = ' . Input::get('price') . ', Nazov = "' . Input::get('name') . '" WHERE CisSluzby = ' . Input::get('id');
				DB::select(DB::raw($raw));
				
				return Redirect::route('home')
					->with('message', 'Editing of service was successfull!');	
			}
			else
			{
				foreach (\App\Models\Service::showService(Input::get('id')) as $value) 
				{
					$my_service = $value;
				}
		
				return Redirect::route('editservice')
					->withErrors($validation)
					->withInput()
					->with('service', $my_service);
			}
		}
		else
		{
			return Redirect::route('home')
				->with('message', 'You are not logged in!');
		}
	}
}