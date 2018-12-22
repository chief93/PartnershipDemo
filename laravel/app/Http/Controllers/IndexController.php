<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Class IndexController
 *
 * @package App\Http\Controllers
 */
class IndexController extends Controller {
	/**
	 * Create a new controller instance.
	 */
	public function __construct () {
		$this->middleware('guest');
	}
	
	/**
	 * @param Request $request
	 *
	 * @return mixed
	 */
	public function Get (Request $request) {
		return view('Index');
	}
}