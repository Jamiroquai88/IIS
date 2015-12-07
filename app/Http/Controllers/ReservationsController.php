<?php

namespace App\Http\Controllers;
use App\Models;
use Input;
use Redirect;
use DB;
use Route;
use Request;
use Auth;

class ReservationsController extends Controller
{
	/*public function __construct()
	{
		//$this->filter('before', 'auth');
	}*/



	public function getReservations()
	{
		if(Auth::check())
		{
			return \View::make('layouts.default')
				->with('title', 'Reservations')
				->with('reservations', \App\Models\Reservation::showReservations());
		}
		else
		{		
			return Redirect::route('home')
				->with('message', 'You are not logged in!');
		}
	}

	public function getDeleteDialog()
	{
		if(Auth::check())
		{
			return \View::make('layouts.default')
				->with('title', 'Delete?')
				->with('reservations', \App\Models\Reservation::showReservations());
		}
		else
		{		
			return Redirect::route('home')
				->with('message', 'You are not logged in!');
		}
	}

	public function getConfirmDialog()
	{
		if(Auth::check())
		{
			return \View::make('layouts.default')
				->with('title', 'Confirm?')
				->with('reservations', \App\Models\Reservation::showReservations());
		}
		else
		{		
			return Redirect::route('home')
				->with('message', 'You are not logged in!');
		}
	}

	public function getCreateReservation()
	{
		if(Auth::check())
		{
			return \View::make('reservations.index')
				->with('title', 'Create Reservation')
				->with('allrooms', \App\Models\Reservation::showRooms());
		}
		else
		{		
			return Redirect::route('home')
				->with('message', 'You are not logged in!');
		}
	}

	public function postCreateReservation()
	{
		if(Auth::check())
		{
			$validation = \App\Models\Reservation::validate(Input::all());
			if($validation->passes())
			{
				if(\App\Models\Reservation::isRoomAvailable(Input::get('date_from'), Input::get('date_to'), Input::get('room')) > 0)
				{
					return Redirect::route('createreservation')
						->withErrors(array('message' => 'Room is occupied in this period!'))
						->withInput();
				}
				/** Get primary key of table rezervace and set value of new row (+1) **/
				$res_number_query = DB::select('SELECT MAX(cisrezervace) AS maxx FROM rezervace');
				if($res_number_query[0]->maxx == 'NULL')
				{
					$reservation_number = 1;
				}
				else
				{
					$reservation_number = (int)$res_number_query[0]->maxx + 1;
				}
				//dd(Input::get('room'), Input::get('persons_number'));
				if(!\App\Models\Reservation::checkRoomCapacity(Input::get('room'), Input::get('persons_number')))
					return Redirect::route('createreservation')
						->withErrors(array('message' => 'Room does not have enough capacity. Please divide this reservation.'))
						->withInput();

				if(count(\App\Models\Reservation::checkIfExistsZakaznik(Input::get('user_id'))) == 0)
				{
					/** Here, you have to check if user_id is valid ID number **/


					DB::insert('INSERT INTO zakaznik (meno, rodnecislo, adresa, datnar, telcis, mail) VALUES (?, ?, ?, ?, ?, ?)',
						[Input::get('name'), Input::get('user_id'), Input::get('address'), Input::get('birth_date'), Input::get('telephone'), Input::get('mail')]);
				}


				DB::insert('INSERT INTO rezervace (cisrezervace, datum, datumdo, idzak, osob, cispokoje) VALUES (?, ?, ?, ?, ?, ?)', 
					[$reservation_number, Input::get('date_from'), Input::get('date_to'), Input::get('user_id'), Input::get('persons_number'), Input::get('room')]);
				
				return Redirect::route('home')
					->with('message', 'Your reservation was succesfull!');
			}
			else
			{
				
				return Redirect::route('createreservation')
					->withErrors($validation)->withInput();
			}
		}
		else
		{
			return Redirect::route('home')
				->with('message', 'You are not logged in!');
		}
	} 

	public function getConfirmReservation()
	{
		if(Auth::check())
		{
			$my_id_rez = Request::all();
			foreach (Request::all() as $value) 
			{
				$my_id_rez = $value;
			}

			$stay_number_query = DB::select('SELECT MAX(cispobytu) AS maxx FROM pobyt');
			$stay_number = $stay_number_query[0]->maxx +1;

			$tmp_date =  DB::select(DB::raw('SELECT datum FROM rezervace WHERE cisrezervace = :some_variable'), array('some_variable' => $my_id_rez));
			$tmp_date_to = DB::select(DB::raw('SELECT datumdo FROM rezervace WHERE cisrezervace = :some_variable'), array('some_variable' => $my_id_rez));
			$tmp_customer_id = DB::select(DB::raw('SELECT idzak FROM rezervace WHERE cisrezervace = :some_variable'), array('some_variable' => $my_id_rez));
			$room_number =  DB::select(DB::raw('SELECT cispokoje FROM rezervace WHERE cisrezervace = :some_variable'), array('some_variable' => $my_id_rez));
			$persons =  DB::select(DB::raw('SELECT osob FROM rezervace WHERE cisrezervace = :some_variable'), array('some_variable' => $my_id_rez));
			
			DB::insert('INSERT INTO pobyt (cispobytu, datum, cena, idzak, datumdo, pokoj, osob) VALUES (?, ?, ?, ?, ?, ?, ?)',
				[$stay_number, $tmp_date[0]->datum, 0.0, $tmp_customer_id[0]->idzak, $tmp_date_to[0]->datumdo, $room_number[0]->cispokoje, $persons[0]->osob]);

			DB::insert('INSERT INTO obyvana (CisPobytu, IDZak) VALUES (?, ?)',
				[$stay_number, $tmp_customer_id[0]->idzak]);

			$raw = 'UPDATE rezervace SET DatumDo = "NULL"';
			DB::select(DB::raw($raw));

			return Redirect::route('home')
				->with('message', 'Your reservation was succesfully confirmed!');
		}
		else
		{
			return Redirect::route('home')
				->with('message', 'You are not logged in!');
		}
	}

	public function getDeleteReservation()
	{
		if(Auth::check())
		{

			$my_id_rez = Request::input();
			foreach (Request::all() as $value) 
			{
				$my_id_rez = $value;
			}

			DB::select(DB::raw('DELETE FROM rezervace WHERE cisrezervace = :some_variable'), array('some_variable' => $my_id_rez));

			return Redirect::route('home')
				->with('message', 'Your reservation was succesfully deleted!');
		}
		else
		{
			return Redirect::route('home')
				->with('message', 'You are not logged in!');
		}
	}

	public function getEditReservation()
	{
		if(Auth::check())
		{
			if(count(Request::all()) > 0)
			{
				foreach (Request::all() as $value) 
				{	
					$my_res = (int)$value;
					$is_old = false;
				}
			}
			else
			{
				$my_res = \Session::get('previous')->CisRezervace;
				$is_old = true;	
			}
			
			foreach(\App\Models\Reservation::showReservation($my_res) as $value)
			{
				$this_res = $value;
			}
	
			return \View::make('reservations.edit')
				->with('title', 'Edit Reservation')
				->with('previous', $this_res)
				->with('old', $is_old)
				->with('allrooms', \App\Models\Reservation::showRooms());
		}
		else
		{
			return Redirect::route('home')
				->with('message', 'You are not logged in!');
		}
	}

	public function postEditReservation()
	{
		if(Auth::check())
		{
			$validation = \App\Models\ReservationEdit::validate(Input::all());
			if($validation->passes())
			{
				$save_res = \App\Models\Reservation::showReservation(Input::get('id'));
		
				DB::select(DB::raw('DELETE FROM rezervace WHERE cisrezervace = :some_variable'), array('some_variable' => Input::get('id')));

				/** Check if function does not return the same reservation **/

				foreach ($save_res as $value) 
				{
					$res = $value;
				}

				if(!\App\Models\Reservation::checkRoomCapacity((string)Input::get('room'), (string)Input::get('persons_number')))
				{
					DB::insert('INSERT INTO rezervace (cisrezervace, datum, datumdo, idzak, osob,cispokoje) VALUES (?, ?, ?, ?, ?, ?)', 
						[$res->CisRezervace, $res->Datum, $res->DatumDo, $res->IDZak, $res->osob, $res->CisPokoje]);

					return Redirect::route('editreservation')
						->withErrors(array('message' => 'Room does not have enough capacity. Please divide this reservation.'))
						->withInput()
						->with('previous', $res);
				}
			
				if(\App\Models\Reservation::isRoomAvailable(Input::get('date_from'), Input::get('date_to'), Input::get('room')) > 0)
				{
					DB::insert('INSERT INTO rezervace (cisrezervace, datum, datumdo, idzak, osob,cispokoje) VALUES (?, ?, ?, ?, ?, ?)', 
						[$res->CisRezervace, $res->Datum, $res->DatumDo, $res->IDZak, $res->osob, $res->CisPokoje]);

					return Redirect::route('editreservation')
						->withErrors(array('message' => 'Room is occupied in this period!'))
						->withInput()
						->with('previous', $res);
				}
				else
				{
					/** Here you have to edit database with input data, or in this case, insert new data **/
					DB::insert('INSERT INTO rezervace (cisrezervace, datum, datumdo, idzak, osob, cispokoje) VALUES (?, ?, ?, ?, ?, ?)', 
						[Input::get('id'), Input::get('date_from'), Input::get('date_to'), $res->IDZak, Input::get('persons_number'), Input::get('room')]);

					return Redirect::route('home')
						->with('message', 'Your reservation was succesfully updated!');
				}
			}
			else
			{
				foreach (\App\Models\Reservation::showReservation(Input::get('id')) as $value) 
				{
					$my_reservation = $value;
				}

				return Redirect::route('editreservation')
					->withErrors($validation)
					->withInput()
					->with('previous', $my_reservation);
			}
		}
		else
		{
			return Redirect::route('home')
				->with('message', 'You are not logged in!');
		}
	}

	public function getPastReservations()
	{
		if(Auth::check())
		{
			return \View::make('layouts.default')
				->with('title', 'Past Reservations')
				->with('reservations', \App\Models\Reservation::showPastReservations());
		}
		else
		{		
			return Redirect::route('home')
				->with('message', 'You are not logged in!');
		}
	}
}