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

class BillingController extends Controller
{
	//post search for searchbox
	public static function postSearch()
	{
		$raw = 'SELECT * FROM pobyt NATURAL JOIN zakaznik WHERE idzak=rodnecislo AND DatumDo = "0000-00-00" AND LOWER (Meno) LIKE LOWER ("%' . Input::get('keyword') . '%")';
		#return \View::make('billing.billingresults')
		return \View::make('layouts.default')
			->with('title', 'Search Results')
			->with('searchresults', DB::select(DB::raw($raw)));
	}
	//
	public static function getPayments()
	{
		if(Auth::check())
		{
			return \View::make('layouts.default')
				->with('title', 'Payments')
				->with('payments', \App\Models\Billing::showPayments());
		}
		else
		{
			return Redirect::route('home')
				->with('message', 'You are not logged in!');
		}
	}

	public static function getBilling()
	{
		if(Auth::check())
		{
			return \View::make('layouts.default')
				->with('title', 'Billing')
				->with('guests', \App\Models\Billing::showGuests());
		}
		else
		{
			return Redirect::route('home')
				->with('message', 'You are not logged in!');
		}
	}

	public static function getAccomGuest()
	{
		if(Auth::check())
		{
			return \View::make('billing.newaccom')
				->with('title', 'Accomodate guest')
				->with('allrooms', \App\Models\Reservation::showRooms());
		}
		else
		{
			return Redirect::route('home')
				->with('message', 'You are not logged in!');
		}
	}

	public static function postAccomGuest()
	{
		if(Auth::check())
		{
			$validation = \App\Models\Billing::validate(Input::all());
			//dd($validation);
			if($validation->passes())
			{
				if(\App\Models\Reservation::isRoomAvailable(\Carbon\Carbon::now(), Input::get('date_to'), Input::get('room')) > 0)
				{
					return Redirect::route('accomguest')
						->withErrors(array('message' => 'Room is occupied in this period!'))
						->withInput();
				}
				
				if(!\App\Models\Reservation::checkRoomCapacity(Input::get('room'), Input::get('persons_number')))
					return Redirect::route('createreservation')
						->withErrors(array('message' => 'Room does not have enough capacity!'))
						->withInput();

				if(count(\App\Models\Reservation::checkIfExistsZakaznik(Input::get('guest_id'))) == 0)
				{
					/** Here, you have to check if user_id is valid ID number **/
					DB::insert('INSERT INTO zakaznik (meno, rodnecislo, adresa, datnar, telcis, mail) VALUES (?, ?, ?, ?, ?, ?)',
						[Input::get('name'), Input::get('guest_id'), Input::get('address'), Input::get('birth_date'), Input::get('telephone'), Input::get('mail')]);
				}

				$pobyt_number_query = DB::select('SELECT MAX(cispobytu) AS maxx FROM pobyt');
				$pobyt_number = $pobyt_number_query[0]->maxx +1;

				DB::insert('INSERT INTO pobyt (cispobytu, datum, datumdo, idzak, osob, pokoj) VALUES (?, ?, ?, ?, ?, ?)', 
					[$pobyt_number, \Carbon\Carbon::now(), Input::get('date_to'), Input::get('guest_id'), Input::get('persons_number'), Input::get('room')]);

				DB::insert('INSERT INTO obyvana (CisPobytu, IDZak) VALUES (?, ?)',
					[$pobyt_number, Input::get('guest_id')]);

				return Redirect::route('home')
					->with('message', 'Your accomodation was succesfull!');
				
			}
			else
			{
				return Redirect::route('accomguest')
					->withErrors($validation)->withInput();
			}
		}
		else
		{
			return Redirect::route('home')
				->with('message', 'You are not logged in!');
		}
	}

	public static function getCharge()
	{
		if(Auth::check())
		{
			$my_res = false;
			foreach (Request::all() as $value) 
			{	
				$my_res = (int)$value;
			}
			
			foreach (\App\Models\Billing::showServices() as $value)
			{
				$arr2[] = $value;
			}
			
			return \View::make('billing.charge')
				->with('title', 'Charge')
				->with('previous', $my_res)
				->with('services', array_keys(\App\Models\Billing::showServices()))
				->with('cost', $arr2);
		}
		else
		{
			return Redirect::route('home')
				->with('message', 'You are not logged in!');
		}
	}

	public static function postCharge()
	{
		if(Auth::check())
		{
			$validation = \App\Models\BillingCharge::validate(Input::all());
			if($validation->passes())
			{
				$price = (\App\Models\BillingCharge::showCost(Input::get('id')));
				$all_products =  \App\Models\BillingCharge::showProductPrices();
				$product_price = (int)$all_products[Input::get('service')]->Cena;
				$product_id = (int)$all_products[Input::get('service')]->CisSluzby;
				$new_price = (int)$price[0]->Cena + $product_price * Input::get('amount');
				$raw = 'UPDATE pobyt SET Cena = ' . $new_price . ' WHERE CisPobytu = ' . Input::get('id');
				DB::select(DB::raw($raw));
				$zau_number_query = DB::select('SELECT MAX(IDZauctovania) AS maxx FROM zauctovane');
				if($zau_number_query[0]->maxx == 'NULL')
				{
					$zau_number = 1;
				}
				else
				{
					$zau_number = (int)$zau_number_query[0]->maxx + 1;
				}

				DB::insert('INSERT INTO zauctovane (IDZauctovania, CisSluzby, Kusov, CisPobytu, ZamID) VALUES (?, ?, ?, ?, ?)',
					[$zau_number, $product_id, Input::get('amount'), Input::get('id'), Auth::user()->username]);
				
				return Redirect::route('home')
					->with('message', 'Charging was succesfull!');
			}
			else
			{
				return Redirect::route('charge')
					->withErrors($validation)
					->withInput();
			}
		}
		else
		{
			return Redirect::route('home')
				->with('message', 'You are not logged in!');
		}
	}

	public static function getCheckOut()
	{
		if(Auth::check())
		{
			foreach (Request::all() as $value) 
			{	
				$my_res = (int)$value;
			}
			foreach(\App\Models\Billing::showGuests() as $guest)
			{	
				if($guest->cispobytu == $my_res)
					break;
			}
			$date_from = strtotime($guest->Datum);
			$date_to = strtotime($guest->DatumDo);
			$datediff = $date_to - $date_from;
	     	$days = (int)floor($datediff/(60*60*24));
			
			foreach(\App\Models\Billing::showRooms() as $room)
			{
				if($guest->Pokoj == $room->CisPokoje)
				{
					$room_price = $room->CenaNoc;
					break;
				}
			}

			$to_check = (object)['name' => $guest->Meno, 'from' => $guest->Datum, 'to' => $guest->DatumDo, 'nights' => $days, 'pay' => (int)$guest->Cena + $days * $room_price, 'room' => $guest->Pokoj];

			return \View::make('billing.checkout')
				->with('title', 'Check Out')
				->with('previous', $my_res)
				->with('info', $to_check);
		}
		else
		{
			return Redirect::route('home')
				->with('message', 'You are not logged in!');
		}
	}

	public static function postCheckOut()
	{
		if(Auth::check())
		{
			$my_res = Input::get('id');
			$payment = Input::get('payment');
			$pay_number_query = DB::select('SELECT MAX(CisPlatby) AS maxx FROM platba');
			if($pay_number_query[0]->maxx == 'NULL')
			{
				$pay_num = 1;
			}
			else
			{
				$pay_num = (int)$pay_number_query[0]->maxx + 1;
			}

			$my_accom = DB::select(DB::raw('SELECT * FROM pobyt WHERE CisPobytu = :some_variable'), ['some_variable' => $my_res]);
	
			DB::insert('INSERT INTO platba (CisPlatby, Datum, Suma, IDZak, IDZam, IDPobytu) VALUES (?, ?, ?, ?, ?, ?)',
				[$pay_num, \Carbon\Carbon::now(), $payment, $my_accom[0]->IDZak, Auth::user()->id, $my_accom[0]->CisPobytu]);

			//DB::select(DB::raw('DELETE FROM zauctovane WHERE CisPobytu = :some_variable'), array('some_variable' => $my_res));
			$raw = 'UPDATE pobyt SET DatumDo = "NULL", Cena = ' . $payment . ' WHERE CisPobytu = ' . $my_res;
			DB::select(DB::raw($raw));
			//DB::select(DB::raw('DELETE FROM pobyt WHERE CisPobytu = :some_variable'), array('some_variable' => $my_res));
			return Redirect::route('home')
				->with('message', 'Guest was succesfully checked out!');
		}
		else
		{
			return Redirect::route('home')
				->with('message', 'You are not logged in!');
		}
	}

	public static function getAddGuest()
	{
		if(Auth::check())
		{
			if(count(Request::all()) > 0)
			{
				foreach (Request::all() as $value) 
				{	
					$my_res = (int)$value;
				}
			}
			else
			{
				$my_res = \Session::get('id');
			}
			
			$raw = 'SELECT * FROM pobyt NATURAL JOIN pokoj WHERE CisPobytu = ' . $my_res . ' AND Pokoj = CisPokoje';
			$obj = (DB::select(DB::raw($raw)));

			if(!($obj[0]->Osob < $obj[0]->Posteli))
			{
				return Redirect::route('home')
					->with('message', 'Can not add any more guests!');
			}
			else
				return \View::make('billing.addguest')
					->with('title', 'Add Guest')
					->with('id', $my_res);
		}
		else
		{
			return Redirect::route('home')
				->with('message', 'You are not logged in!');
		}
	}

	public static function postAddGuest()
	{
		if(Auth::check())
		{
			$validation = \App\Models\Guest::validate(Input::all());
			if($validation->passes())
			{
				if(count(\App\Models\Reservation::checkIfExistsZakaznik(Input::get('guest_id'))) == 0)
				{
					/** Here, you have to check if user_id is valid ID number **/
					DB::insert('INSERT INTO zakaznik (meno, rodnecislo, adresa, datnar, telcis, mail) VALUES (?, ?, ?, ?, ?, ?)',
						[Input::get('name'), Input::get('guest_id'), Input::get('address'), Input::get('birth_date'), Input::get('telephone'), Input::get('mail')]);
				}
				DB::insert('INSERT INTO obyvana (CisPobytu, IDZak) VALUES (?, ?)',
					[Input::get('id'), Input::get('guest_id')]);

				return Redirect::route('home')
				->with('message', 'Guest successfully added!');
			}
			else
			{
				return Redirect::route('addguest')
					->withErrors($validation)
					->withInput()
					->with('id', Input::get('id'));
			}
		}
		else
		{
			return Redirect::route('home')
				->with('message', 'You are not logged in!');
		}
	}

	public static function getPastAccom()
	{
		if(Auth::check())
		{
			return \View::make('layouts.default')
				->with('title', 'Past Accomodations')
				->with('guests', \App\Models\Billing::showPastAccom());
		}
		else
		{
			return Redirect::route('home')
				->with('message', 'You are not logged in!');
		}	
	}
}