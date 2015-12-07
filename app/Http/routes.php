<?php

//use App\Http\Controllers\questions;
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// todo - delete inactive guests

/** Home Page **/
Route::get('/', ['uses' => 'UsersController@getHome', 'as' => 'home']);

/** Administration **/
Route::get('administration', ['uses' => 'UsersController@getAdministration', 'as' => 'administration']);
Route::get('register', ['uses' => 'UsersController@getRegister', 'as' => 'register']);
Route::get('editaccount', ['uses' => 'UsersController@getEditAccount', 'as' => 'editaccount']);
Route::get('deleteaccount', ['uses' => 'UsersController@getDeleteAccount', 'as' => 'deleteaccount']);

/** Login/logout **/
Route::get('login', ['uses' => 'UsersController@getLogin', 'as' => 'login']);
Route::get('logout', ['uses' => 'UsersController@getLogout', 'as' => 'logout']);

/** Reservations **/
Route::get('reservation', ['uses' => 'ReservationsController@getReservations', 'as' => 'reservation']);
Route::get('createreservation', ['uses' => 'ReservationsController@getCreateReservation', 'as' => 'createreservation']);
Route::get('confirmreservation', ['uses' => 'ReservationsController@getConfirmReservation', 'as' => 'confirmreservation']);
Route::get('deletereservation', ['uses' => 'ReservationsController@getDeleteReservation', 'as' => 'deletereservation']);
Route::get('editreservation', ['uses' => 'ReservationsController@getEditReservation', 'as' => 'editreservation']);
Route::get('pastreservations', ['uses' => 'ReservationsController@getPastReservations', 'as' => 'pastreservations']);

/** Billing **/
Route::get('billing', ['uses' => 'BillingController@getBilling', 'as' => 'billing']);
Route::get('accomguest', ['uses' => 'BillingController@getAccomGuest', 'as' => 'accomguest']);
Route::get('charge', ['uses' => 'BillingController@getCharge', 'as' => 'charge']);
Route::get('checkout', ['uses' => 'BillingController@getCheckOut', 'as' => 'checkout']);
Route::get('addguest', ['uses' => 'BillingController@getAddGuest', 'as' => 'addguest']);
Route::get('pastaccom', ['uses' => 'BillingController@getPastAccom', 'as' => 'pastaccom']);

/** Services **/
Route::get('services', ['uses' => 'ServicesController@getServices', 'as' => 'services']);
Route::get('newservice', ['uses' => 'ServicesController@getNewService', 'as' => 'newservice']);
Route::get('deleteservice', ['uses' => 'ServicesController@getDeleteService', 'as' => 'deleteservice']);
Route::get('editservice', ['uses' => 'ServicesController@getEditService', 'as' => 'editservice']);



Route::get('deletedialog', ['uses' => 'ReservationsController@getDeleteDialog', 'as' => 'deletedialog']);
Route::get('confirmdialog', ['uses' => 'ReservationsController@getConfirmDialog', 'as' => 'confirmdialog']);

Route::get('deleteaccdialog', ['uses' => 'UsersController@getDeleteDialog', 'as' => 'deleteaccdialog']);

Route::get('payments', ['uses' => 'BillingController@getPayments', 'as' => 'payments']);



/** Guests **/
Route::get('guests', ['uses' => 'GuestsController@getGuests', 'as' => 'guests']);

/** Post register **/
Route::post('register', ['before' => 'csrf', 'uses' => 'UsersController@postRegister']);

/** Post login **/
Route::post('login', ['before' => 'csrf', 'uses' => 'UsersController@postLogin']);

/** Post reservation **/
Route::post('createreservation', ['before' => 'csrf', 'uses' => 'ReservationsController@postCreateReservation']);

/** Post edit reservation **/
Route::post('editreservation', ['before' => 'csrf', 'uses' => 'ReservationsController@postEditReservation']);

/** Post account edit **/
Route::post('editaccount', ['before' => 'csrf', 'uses' => 'UsersController@postEditAccount']);

/** Post new accomodation **/
Route::post('accomguest', ['before' => 'csrf', 'uses' => 'BillingController@postAccomGuest']);

/** Post charge **/
Route::post('charge', ['before' => 'csrf', 'uses' => 'BillingController@postCharge']);

/** Post checkout **/
Route::post('checkout', ['before' => 'csrf', 'uses' => 'BillingController@postCheckOut']);

/** Post new service **/
Route::post('newservice', ['before' => 'csrf', 'uses' => 'ServicesController@postNewService']);

/** Post edit service **/
Route::post('editservice', ['before' => 'csrf', 'uses' => 'ServicesController@postEditService']);

/** Post add guest to accomodation **/
Route::post('addguest', ['before' => 'csrf', 'uses' => 'BillingController@postAddGuest']);

/** Search by name **/
Route::post('search', ['before' => 'csrf', 'uses' => 'GuestsController@postSearch']);

Route::post('searchbill', ['before' => 'csrf', 'uses' => 'BillingController@postSearch']);

