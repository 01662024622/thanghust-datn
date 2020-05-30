<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Table;

class WorkingController extends Controller
{
	public function location($location){

		$locations= Table::select('location')->distinct()->get();
		if ($location!=null) {
			$tables = Table::where('location',$location)->get();
		}
		$tables = Table::where('location',$locations[0]['location'])->get();
		return view('home',['locations'=>$locations,'tables'=>$tables]);
	}
		public function index(){

		$locations= Table::select('location')->distinct()->get();
		$tables = Table::where('location',$locations[0]['location'])->get();
		return view('home',['locations'=>$locations,'tables'=>$tables]);
	}
}
