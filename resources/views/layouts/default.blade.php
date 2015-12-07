<!DOCTYPE html>
<html>
	<head>
		<title>{{ $title }}</title>
		{!! Html::style('/css/bootstrap.min.css') !!}
		{!! Html::style('/css/main.css') !!}
		{!! Html::script('/js/bootstrap.min.js') !!}
		{!! Html::script('/js/application.js') !!}
	</head>
	<body>
		<div class="container">

			<nav class="navbar navbar-default"> 
			  	<div class="container-fluid">  
			    	<div class="navbar-header"> 
			      		<button aria-expanded="false" data-target="#bs-example-navbar-collapse-1" data-toggle="collapse" class="navbar-toggle collapsed" type="button"> 
			        		<span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> 
			        		<span class="icon-bar"></span> <span class="icon-bar"></span> 
			      		</button> 
			      		{!! Html::link('/', 'Grand Hotel *****', array('class' => 'navbar-brand')) !!}
			    	</div>  
			    	<div id="bs-example-navbar-collapse-1" class="collapse navbar-collapse"> 
			      		<ul class="nav navbar-nav"> 
					        @if(!Auth::check())
								<li>{!! Html::linkRoute('login', 'Login') !!}</li>
							@else
								@if(Auth::user()->username == 'admin')
									<li>{!! Html::linkRoute('administration', 'Administration') !!}</li>
								@endif
								<!-- Reservations -->
								@if(Route::getCurrentRoute()->getActionName() == 'App\Http\Controllers\ReservationsController@getReservations' ||
								 Route::getCurrentRoute()->getActionName() == 'App\Http\Controllers\ReservationsController@getCreateReservation' ||
								 Route::getCurrentRoute()->getActionName() == 'App\Http\Controllers\ReservationsController@getPastReservations' ||
								 Route::getCurrentRoute()->getActionName() == 'App\Http\Controllers\ReservationsController@getPastReservations')
									<li class="active">{!! Html::linkRoute('reservation', 'Reservations') !!}</li>
								@else
									<li>{!! Html::linkRoute('reservation', 'Reservations') !!}</li>
								@endif

								<!-- Billing -->
								@if(Route::getCurrentRoute()->getActionName() == 'App\Http\Controllers\BillingController@getBilling' ||	
								Route::getCurrentRoute()->getActionName() == 'App\Http\Controllers\BillingController@getAccomGuest' || 
								Route::getCurrentRoute()->getActionName() == 'App\Http\Controllers\BillingController@getCharge' || 
								Route::getCurrentRoute()->getActionName() == 'App\Http\Controllers\BillingController@getAddGuest' || 
								Route::getCurrentRoute()->getActionName() == 'App\Http\Controllers\BillingController@getPastAccom' || 
								Route::getCurrentRoute()->getActionName() == 'App\Http\Controllers\BillingController@postSearch')
									<li class="active">{!! Html::linkRoute('billing', 'Billing') !!}</li>
								@else
									<li>{!! Html::linkRoute('billing', 'Billing') !!}</li>
								@endif
								<!-- Services -->
								@if(Route::getCurrentRoute()->getActionName() == 'App\Http\Controllers\ServicesController@getServices' ||
									Route::getCurrentRoute()->getActionName() == 'App\Http\Controllers\ServicesController@getNewService')
									<li class="active">{!! Html::linkRoute('services', 'Services') !!}</li>
								@else
									<li>{!! Html::linkRoute('services', 'Services') !!}</li>
								@endif

								<!-- Guests -->
								@if(Route::getCurrentRoute()->getActionName() == 'App\Http\Controllers\GuestsController@getGuests')
									<li class="active">{!! Html::linkRoute('guests', 'Guests') !!}</li>
								@else
									<li>{!! Html::linkRoute('guests', 'Guests') !!}</li>	
								@endif

								<li>{!! Html::linkRoute('logout', 'Logout ('.Auth::user()->username.')') !!}</li>					
							@endif		
			      		</ul>   
			    	</div> 
			  	</div> 
			</nav>
			
			<div class="row">
				@if(Route::getCurrentRoute()->getActionName() == 'App\Http\Controllers\UsersController@getHome' &&
					!isset($message))
					<div class="col-md-12">
						<div class="page-header">
						  	<h3>Created by Laravel 5.1</h3>
						  	<h4>Authors: Jan Profant and Tomas Mazurek</h4>
						</div>		
					</div>
				@endif
			</div>
			
			@if(Auth::check())


			<!-- Administration -->			
			<div class="row">


				@if(Route::getCurrentRoute()->getActionName() == 'App\Http\Controllers\UsersController@getAdministration' || 
					Route::getCurrentRoute()->getActionName() == 'App\Http\Controllers\UsersController@getRegister' ||
					Route::getCurrentRoute()->getActionName() == 'App\Http\Controllers\UsersController@getEditAccount' ||
					Route::getCurrentRoute()->getActionName() == 'App\Http\Controllers\UsersController@getDeleteAccount' ||
					Route::getCurrentRoute()->getActionName() == 'App\Http\Controllers\UsersController@getDeleteDialog')
					<div class="col-md-12">		
						<div class="page-header">
						  	<h1>Administration</h1>
						</div>
					</div>
					<div class="col-md-3">
						<ul class="nav nav-pills nav-stacked">	
							@if(Route::getCurrentRoute()->getActionName() == 'App\Http\Controllers\UsersController@getRegister')	
								<li role="presentation" class="active">{!! Html::linkRoute('register', 'Create User') !!}</li>
							@else
								<li role="presentation">{!! Html::linkRoute('register', 'Create User') !!}</li>
							@endif
						</ul>
					</div>
					<div class="col-md-9">	
						@if(Route::getCurrentRoute()->getActionName() == 'App\Http\Controllers\UsersController@getDeleteDialog')
							<div class="modal-dialog">
		    					<div class="modal-content">
	      							<div class="modal-header">
		        						
	        							<h4 class="modal-title">Are you sure?</h4>
	      							</div>
	      							<div class="modal-body">
	       								<p>Delete this account</p>
      									<table table class="table table-striped">
										<tr>
											<th>Login</th>
											<th>Name</th>
											<th>Date of birth</th>
											<th>Telephone</th>
											<th>Email</th>
											<th>Address</th>
										</tr>	
										@foreach($employees as $emp)
		  									<tr>
		  										@if($emp->id == $_GET["id"])
									    			<td>{!! $emp->username !!}</td>
									    			<td>{!! $emp->name !!}</td>
									    			<td>{!! $emp->birth_date !!}</td>
									    			<td>{!! $emp->telephone !!}</td>
									    			<td>{!! $emp->mail !!}</td>
									    			<td>{!! $emp->address !!}</td>
									    		@endif
									  		</tr>
										@endforeach		
       								 </table>
	   							    </div>
	  	    						<div class="modal-footer">
	  	    							<a href="{{ URL::route('administration') }}" class="btn btn-default btn-sm"> No </a>
	        							{!! Html::linkAction('UsersController@getDeleteAccount', 'Yes' , ['id' => $_GET["id"]], array('class' => 'btn btn-primary btn-sm', 'type' => 'button')) !!}
	      							</div>
	    						</div><!-- /.modal-content -->
	  						</div><!-- /.modal-dialog -->
						@endif

						@if(Route::getCurrentRoute()->getActionName() == 'App\Http\Controllers\UsersController@getRegister')
							@yield('content')
						@endif

						@if(Route::getCurrentRoute()->getActionName() == 'App\Http\Controllers\UsersController@getEditAccount')
							@yield('content')
						@endif

						@if(Route::getCurrentRoute()->getActionName() == 'App\Http\Controllers\UsersController@getAdministration')

							@if(!$employees)
								<div class="alert alert-info" role="alert">In system is not created any user.</div>
							@else
								<table class="table table-striped">
									<tr>
										<th>Login</th>
										<th>Name</th>
										<th>Date of birth</th>
										<th>Telephone number</th>
										<th>Email</th>
										<th>Address</th>
								  	  	<th colspan="2">Action</th>
									</tr>
									@foreach($employees as $res)
						  			<tr>
								    	<td>{!! $res->username !!}</td>
								  	  	<td>{!! $res->name !!}</td>
								  	  	<td>{!! $res->birth_date !!}</td>
								  	  	<td>{!! $res->telephone !!}</td>
								  	  	<td>{!! $res->mail !!}</td>
								  	  	<td>{!! $res->address !!}</td>
								  	  	@if($res->username != 'admin')
								  	  	<td>{!! Html::linkAction('UsersController@getEditAccount', 'Edit account', ['id' => $res->id]) !!}</td>
								    	<td>{!! Html::linkRoute('deleteaccdialog', 'Delete account',   ['id' => $res->id]) !!}</td>
								    	@endif
								    	
									</tr>
									@endforeach
								</table>
							@endif
																	
						@endif
					</div>
				@endif
			</div>
			<!-- Administration ends here-->

			<!-- Billing -->		
			<div class="row">
				@if(Route::getCurrentRoute()->getActionName() == 'App\Http\Controllers\BillingController@getBilling' ||
						Route::getCurrentRoute()->getActionName() == 'App\Http\Controllers\BillingController@getAccomGuest' ||
						Route::getCurrentRoute()->getActionName() == 'App\Http\Controllers\BillingController@getCharge' ||
						Route::getCurrentRoute()->getActionName() == 'App\Http\Controllers\BillingController@getAddGuest' || 
						Route::getCurrentRoute()->getActionName() == 'App\Http\Controllers\BillingController@getPastAccom' || 
						Route::getCurrentRoute()->getActionName() == 'App\Http\Controllers\BillingController@postSearch' ||
						Route::getCurrentRoute()->getActionName() == 'App\Http\Controllers\BillingController@getCheckOut' ||
						Route::getCurrentRoute()->getActionName() == 'App\Http\Controllers\BillingController@getPayments' )
					<div class="col-md-12">
						<div class="page-header">
						  	<h1>Billing</h1>
						</div>		
					</div>
					<div class="col-md-3">
						<ul class="nav nav-pills nav-stacked">
							@if(Route::getCurrentRoute()->getActionName() == 'App\Http\Controllers\BillingController@getAccomGuest')
								<li role="presentation" class="active">{!! Html::linkRoute('accomguest', 'Accomodate New Guest') !!}</li>
							@else
								<li role="presentation">{!! Html::linkRoute('accomguest', 'Accomodate New Guest') !!}</li>
							@endif

							

							@if(Route::getCurrentRoute()->getActionName() == 'App\Http\Controllers\BillingController@getPastAccom' || 
							Route::getCurrentRoute()->getActionName() == 'App\Http\Controllers\BillingController@postSearch')
								<li role="presentation" class="active">{!! Html::linkRoute('pastaccom', 'Past Accomodations') !!}</li>
							@else 
								<li role="presentation">{!! Html::linkRoute('pastaccom', 'Past Accomodations') !!}</li>
							@endif


							@if(Route::getCurrentRoute()->getActionName() == 'App\Http\Controllers\BillingController@getPayments')
								<li role="presentation" class="active">{!! Html::linkRoute('payments', 'Payments') !!}</li>
							@else
								<li role="presentation">{!! Html::linkRoute('payments', 'Payments') !!}</li>
							@endif
						</ul>
					</div>
					<div class="col-md-9">

						@if(Route::getCurrentRoute()->getActionName() == 'App\Http\Controllers\BillingController@getPayments')
							<h3>Payments</h3>
							@if(!$payments)
								<div class="alert alert-info" role="alert">No Payments.</div>
							@else
								<table class="table table-striped">
									<tr>
										<th>ID</th>
										<th>Date</th>
										<th>Price</th>
										<th>Guets ID</th>
										<th>Employee ID</th>
										<th>Accommodation ID</th>
									</tr>
									@foreach($payments as $pay)
		  								<tr>
									    	<td>{!! $pay->CisPlatby !!}</td>
									  	  	<td>{!! $pay->Datum !!}</td>	
									  	  	<td>{!! $pay->Suma !!}</td>	
									  	  	<td>{!! $pay->IDZak !!}</td>
									  	  	<td>{!! $pay->IDZam !!}</td>	
									    	<td>{!! $pay->IDPobytu !!}</td>
									  	</tr>
									@endforeach
								</table>
							@endif
						@endif

						@if(Route::getCurrentRoute()->getActionName() == 'App\Http\Controllers\BillingController@getBilling')
							<h3>Current Guests</h3>
							@if(!$guests)
								<div class="alert alert-info" role="alert">No Current Guests.</div>
							@else
								<table class="table table-striped">
									<tr>
										<th>Name</th>
										<th>From</th>
										<th>To</th>
										<th>Room</th>
										<th>Price</th>
										<th>Persons</th>
										<th>Action</th>
										<th></th>
										<th></th>
									</tr>
									@foreach($guests as $res)
		  								<tr>
									    	<td>{!! $res->Meno !!}</td>
									  	  	<td>{!! $res->Datum !!}</td>	
									  	  	<td>{!! $res->DatumDo !!}</td>	
									  	  	<td>{!! $res->Pokoj !!}</td>
									  	  	<td>{!! $res->Cena !!}</td>	
									    	<td>{!! $res->Osob !!}</td>
									    	<td>{!! Html::linkAction('BillingController@getAddGuest', 'Add Guest', ['id' => $res->cispobytu]) !!}</td>
									    	<td>{!! Html::linkAction('BillingController@getCharge', 'Charge', ['id' => $res->cispobytu]) !!}</td>
										    <td>{!! Html::linkAction('BillingController@getCheckOut', 'Check Out',  ['id' => $res->cispobytu]) !!}</td>
									  	</tr>
									@endforeach
								</table>
							@endif
						@endif

						@if(Route::getCurrentRoute()->getActionName() == 'App\Http\Controllers\BillingController@getPastAccom' ||
						Route::getCurrentRoute()->getActionName() == 'App\Http\Controllers\BillingController@postSearch')
							<div id="searchbar">
								{!! Form::open(array('action' => 'BillingController@postSearch', 'method' => 'POST')) !!}
								{!! Form::token() !!}
								{!! Form::text('keyword', 'Search', array('id' => 'keyword')) !!}
								{!! Form::submit('Search') !!}
								{!! Form::close() !!}
							</div>
							<h3>Past Guests</h3>
							@if(Route::getCurrentRoute()->getActionName() == 'App\Http\Controllers\BillingController@postSearch')
								@if(!$searchresults)
									<div class="alert alert-info" role="alert">No Results</div>
								@else			
									<table class="table table-striped">
										<tr>
											<th>Name</th>
											<th>Date</th>
											<th>Persons</th>
											<th>Room</th>
											<th>price</th>
										</tr>
										@foreach($searchresults as $res)
	  										<tr>
												<td>{!! $res->Meno !!}</td>
										  	  	<td>{!! $res->Datum !!}</td>	
										  	  	<td>{!! $res->Osob !!}</td>	
										  	  	<td>{!! $res->Pokoj !!}</td>
										  	  	<td>{!! $res->Cena !!}</td>
											</tr>
										@endforeach
									</table>
								@endif
							
							@else	
								@if(!$guests)
									<div class="alert alert-info" role="alert">No Past Guests.</div>
								@else
									<table class="table table-striped">
										<tr>
											<th>Name</th>
											<th>Date</th>
											<th>Persons</th>
											<th>Room</th>
											<th>Price</th>
										</tr>
										@foreach($guests as $res)
			  								<tr>
										    	<td>{!! $res->Meno !!}</td>
										  	  	<td>{!! $res->Datum !!}</td>	
										  	  	<td>{!! $res->Osob !!}</td>	
										  	  	<td>{!! $res->Pokoj !!}</td>
										  	  	<td>{!! $res->Cena !!}</td>
										  	</tr>
										@endforeach
									</table>
								@endif
							@endif
						@endif
						@yield('content')	
					</div>
						
				@endif
			</div>
			<!-- Billing ends here-->

			<!-- Services -->
			<div class="row">
				@if(Route::getCurrentRoute()->getActionName() == 'App\Http\Controllers\ServicesController@getServices' ||
					Route::getCurrentRoute()->getActionName() == 'App\Http\Controllers\ServicesController@getNewService' ||
					Route::getCurrentRoute()->getActionName() == 'App\Http\Controllers\ServicesController@getEditService')
					<div class="col-md-12">
						<div class="page-header">
						  	<h1>Services</h1>
						</div>		
					</div>

					<div class="col-md-3">
						<ul class="nav nav-pills nav-stacked">
							@if(Route::getCurrentRoute()->getActionName() == 'App\Http\Controllers\ServicesController@getNewService')
								<li role="presentation" class="active">{!! Html::linkRoute('newservice', 'New Service') !!}</li>
							@else
								<li role="presentation">{!! Html::linkRoute('newservice', 'New Service') !!}</li>
							@endif
								
								
						</ul>
					</div>
					<div class="col-md-9">
						@if(Route::getCurrentRoute()->getActionName() == 'App\Http\Controllers\ServicesController@getNewService')
							@yield('content')
						@endif

						@if(Route::getCurrentRoute()->getActionName() == 'App\Http\Controllers\ServicesController@getServices')
							<h3>Current Services</h3>
							@if(!$services)
								<div class="alert alert-info" role="alert">No Current Services</div>
							@else
								<table class="table table-striped">
									<tr>
										<th >Name</th>
										<th>Price</th>
										<th width="10%">Action</th>
										<th width="10%"></th>
									</tr>
										@foreach($services as $res)
	  										<tr>
										    	<td>{!! $res->Nazov !!}</td>
										  	  	<td>{!! $res->Cena !!}</td>
										    	<td>{!! Html::linkAction('ServicesController@getEditService', 'Edit',  ['id' => $res->CisSluzby]) !!}</td>
										    	<td>{!! Html::linkAction('ServicesController@getDeleteService', 'Delete',  ['id' => $res->CisSluzby]) !!}</td>
										  	</tr>
										@endforeach
									</table>
								</ul>
							@endif
						@endif

						@if(Route::getCurrentRoute()->getActionName() == 'App\Http\Controllers\ServicesController@getEditService')
							@yield('content')
						@endif
					</div>
				@endif
			</div>
			<!-- Services ends here-->

			<!-- Guests-->
			<div class="row">
				@if(Route::getCurrentRoute()->getActionName() == 'App\Http\Controllers\GuestsController@getGuests' || 
				Route::getCurrentRoute()->getActionName() == 'App\Http\Controllers\GuestsController@postSearch')
					<div class="col-md-12">
						<div class="page-header">
							<div id="searchbar">
								{!! Form::open(array('action' => 'GuestsController@postSearch', 'method' => 'POST')) !!}
								{!! Form::token() !!}
								{!! Form::text('keyword', 'Search', array('id' => 'keyword')) !!}
								{!! Form::submit('Search') !!}
								{!! Form::close() !!}
							</div>
						  	<h1>Guests</h1>

						</div>	
					@if(Route::getCurrentRoute()->getActionName() == 'App\Http\Controllers\GuestsController@postSearch')	
						@yield('content')
					@endif	
					@if(Route::getCurrentRoute()->getActionName() == 'App\Http\Controllers\GuestsController@getGuests')	
						@if(!$guests)
								<div class="alert alert-info" role="alert">No Guests</div>
						@else
							<table class="table table-striped">
								<tr>
									<th>Name</th>
									<th>Address</th>
									<th>Birth date</th>
									<th>Telephone</th>
								</tr>
									@foreach($guests as $res)
	  									<tr>
									    	<td>{!! $res->Meno !!}</td>
									    	<td>{!! $res->Adresa !!}</td>
									    	<td>{!! $res->DatNar !!}</td>
									    	<td>{!! $res->TelCis !!}</td>
										</tr>
									@endforeach
							</table>
						@endif
					@endif
					</div>
				@endif
			</div>
			<!-- Guests ends here-->

			<!-- Reservations-->
			<div class="row">


				
				@if(Route::getCurrentRoute()->getActionName() == 'App\Http\Controllers\ReservationsController@getReservations' ||
						Route::getCurrentRoute()->getActionName() == 'App\Http\Controllers\ReservationsController@getCreateReservation' ||
						Route::getCurrentRoute()->getActionName() == 'App\Http\Controllers\ReservationsController@getPastReservations' || 
						Route::getCurrentRoute()->getActionName() == 'App\Http\Controllers\ReservationsController@getDeleteDialog' ||
						Route::getCurrentRoute()->getActionName() == 'App\Http\Controllers\ReservationsController@getConfirmDialog' ||
						Route::getCurrentRoute()->getActionName() == 'App\Http\Controllers\ReservationsController@getEditReservation')
					<div class="col-md-12">
						<div class="page-header">
						  	<h1>Reservations</h1>
						</div>	
					</div>

					<div class="col-md-3">
						<ul class="nav nav-pills nav-stacked">
							@if(Route::getCurrentRoute()->getActionName() == 'App\Http\Controllers\ReservationsController@getCreateReservation')
								<li role="presentation" class="active">{!! Html::linkRoute('createreservation', 'Create Reservation') !!}</li>
							@else
								<li role="presentation">{!! Html::linkRoute('createreservation', 'Create Reservation') !!}</li>
							@endif

							@if(Route::getCurrentRoute()->getActionName() == 'App\Http\Controllers\ReservationsController@getPastReservations')
								<li role="presentation" class="active">{!! Html::linkRoute('pastreservations', 'Past Reservations') !!}</li>
							@else
								<li role="presentation">{!! Html::linkRoute('pastreservations', 'Past Reservations') !!}</li>
							@endif
						</ul>
					</div>

					<div class="col-md-9">
						@if(Route::getCurrentRoute()->getActionName() == 'App\Http\Controllers\ReservationsController@getReservations')
							<h3>Current Reservations</h3>
							@if(!$reservations)
								<div class="alert alert-info" role="alert">No current reservations.</div>
							@else
								<table table class="table table-striped">
									<tr>
										<th>Name</th>
										<th>From</th>
										<th>To</th>
										<th>Persons</th>
										<th>Room number</th>
										<th>Action</th>
										<th></th>
										<th></th>
									</tr>
									@foreach($reservations as $res)
	  									<tr>
									    	<td>{!! $res->Meno !!}</td>
									  	  	<td>{!! $res->Datum !!}</td>	
									  	  	<td>{!! $res->DatumDo !!}</td>	
									    	<td>{!! $res->osob !!}</td>
									    	<td>{!! $res->CisPokoje !!}</td>
									    	<td>{!! Html::linkRoute('confirmdialog', 'Confirm', ['id' => $res->cisrezervace]) !!}</td>
									    	<td>{!! Html::linkAction('ReservationsController@getEditReservation', 'Edit',  ['id' => $res->cisrezervace]) !!}</td>
									    	<td>{!! Html::linkRoute('deletedialog', 'Delete',  ['id' => $res->cisrezervace]) !!}</td>
									  	</tr>
									@endforeach										  
								</table>
							@endif
						@endif

						@if(Route::getCurrentRoute()->getActionName() == 'App\Http\Controllers\ReservationsController@getDeleteDialog')
					 	<div class="modal-dialog">
	    					<div class="modal-content">
      							<div class="modal-header">
	        															  
								</table>
        							<h4 class="modal-title">Are you sure?</h4>
      							</div>
      							<div class="modal-body">
      								<p>Delete this reservation</p>
      								<table table class="table table-striped">
										<tr>
											<th>Name</th>
											<th>From</th>
											<th>To</th>
											<th>Persons</th>
											<th>Room</th>
										</tr>	
										@foreach($reservations as $res)
		  									<tr>
		  										@if($res->cisrezervace == $_GET["id"])
									    			<td>{!! $res->Meno !!}</td>
									    			<td>{!! $res->Datum !!}</td>
									    			<td>{!! $res->DatumDo !!}</td>
									    			<td>{!! $res->osob !!}</td>
									    			<td>{!! $res->CisPokoje !!}</td>
									    		@endif
									  		</tr>
										@endforeach		
       								 </table>
   							    </div>
  	    						<div class="modal-footer">
  	    							<a href="{{ URL::route('reservation') }}" class="btn btn-default btn-sm"> No </a>
        							{!! Html::linkAction('ReservationsController@getDeleteReservation', 'Yes' , ['id' => $_GET["id"]], array('class' => 'btn btn-primary btn-sm', 'type' => 'button')) !!}
      							</div>
    						</div><!-- /.modal-content -->
  						</div><!-- /.modal-dialog -->
						@endif

						@if(Route::getCurrentRoute()->getActionName() == 'App\Http\Controllers\ReservationsController@getConfirmDialog')
							<div class="modal-dialog">
	    					<div class="modal-content">
      							<div class="modal-header">
	        						
        							<h4 class="modal-title">Are you sure?</h4>
      							</div>
      							<div class="modal-body">
       								<p>Confirm this reservation</p>
      								<table table class="table table-striped">
										<tr>
											<th>Name</th>
											<th>From</th>
											<th>To</th>
											<th>Persons</th>
											<th>Room</th>
										</tr>	
										@foreach($reservations as $res)
		  									<tr>
		  										@if($res->cisrezervace == $_GET["id"])
									    			<td>{!! $res->Meno !!}</td>
									    			<td>{!! $res->Datum !!}</td>
									    			<td>{!! $res->DatumDo !!}</td>
									    			<td>{!! $res->osob !!}</td>
									    			<td>{!! $res->CisPokoje !!}</td>
									    		@endif
									  		</tr>
										@endforeach		
       								 </table>
   							    </div>
  	    						<div class="modal-footer">
  	    							<a href="{{ URL::route('reservation') }}" class="btn btn-default btn-sm"> No </a>
        							{!! Html::linkAction('ReservationsController@getConfirmReservation', 'Yes' , ['id' => $_GET["id"]], array('class' => 'btn btn-primary btn-sm', 'type' => 'button')) !!}
      							</div>
    						</div><!-- /.modal-content -->
  						</div><!-- /.modal-dialog -->
						@endif
  					
				
				


						@if(Route::getCurrentRoute()->getActionName() == 'App\Http\Controllers\ReservationsController@getPastReservations')
							<h3>Past Reservations</h3>
							@if(!$reservations)
								<div class="alert alert-info" role="alert">No past reservations.</div>
							@else
								<table  class="table table-striped">
									<tr>
										<th>Name</th>
										<th>Date</th>
										<th>Room num.</th>
										<th>Persons</th>
										<th>Reservation ID</th>									
									</tr>
									@foreach($reservations as $res)
	  									<tr>
									    	<td>{!! $res->Meno !!}</td>	
									    	<td>{!! $res->Datum !!}</td>
									    	<td>{!! $res->CisPokoje !!}</td>
									    	<td>{!! $res->osob !!}</td>
									    	<td>{!! $res->CisRezervace !!}</td>												    	
									    </tr>
									@endforeach 
								</table>
							@endif
						@endif
						@yield('content')
					</div>
				@endif
			</div>
			<!-- Reservations ends here-->


			<!-- END -->	
			@endif
			@if(Route::getCurrentRoute()->getActionName() == 'App\Http\Controllers\UsersController@getLogin')
				@yield('content')
			@endif
		</div>	
		
		<div id="content">
			@if(Session::has('message'))
				<div class="alert alert-info" role="alert">{!! Session::get('message') !!}</div>
			@endif
			
			
		</div>
		<div id="footer">
			&copy; Grand Hotel Information System {!! date('Y') !!}
		</div>

	</body>
</html>