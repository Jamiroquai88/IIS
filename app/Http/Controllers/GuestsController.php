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

class GuestsController extends Controller
{
	public static function postSearch()
	{
		$raw = 'SELECT * FROM zakaznik WHERE LOWER (Meno) LIKE LOWER ("%' . Input::get('keyword') . '%")';
		return \View::make('guests.results')
			->with('title', 'Search Results')
			->with('searchresults', DB::select(DB::raw($raw)));
	}

	public function getGuests()
	{
		if(Auth::check())
		{
			return \View::make('layouts.default')
				->with('title', 'Guests')
				->with('guests', DB::select(DB::raw('SELECT * FROM zakaznik')));
		}
		else
		{		
			return Redirect::route('home')
				->with('message', 'You are not logged in!');
		}
	}

}