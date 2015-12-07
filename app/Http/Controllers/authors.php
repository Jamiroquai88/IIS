<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

class AuthorsController extends BaseController
{
	public $restful = true;
	public function getIindex()
	{
		return View::make('authors.index');
	}
}