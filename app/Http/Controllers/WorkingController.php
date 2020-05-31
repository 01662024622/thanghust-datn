<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Table;
use App\Category;
use App\Product;
use Cart;

class WorkingController extends Controller
{
	public function location($location){

		$locations= Table::select('location')->distinct()->get();
		if ($location!=null) {
			$tables = Table::where('location',$location)->get();
		}else{

			$tables = Table::where('location',$locations[0]['location'])->get();
		}
		$page="location";
		return view('home',['locations'=>$locations,'categories'=>[],'tables'=>$tables,'page'=>$page,'tableinfor'=>null]);

	}
	public function index(){

		$locations= Table::select('location')->distinct()->get();
		$tables = Table::where('location',$locations[0]['location'])->get();
		$page="location";
		return view('home',['locations'=>$locations,'categories'=>[],'tables'=>$tables,'page'=>$page,'tableinfor'=>null]);
	}
	public function table(Request $request,$table){
		$categories= Category::all();
		if ($request->has('category')) {
			
		$categoryinfor = Category::where('id',$request->category)->first();
		}else {
			$categoryinfor= $categories->first();
		}
		$table = Table::where('code',$table)->first();
		// return $table;
		$cart = Cart::content()->where('options.table',$table->code);
		$page="table";
		return view('index',['locations'=>[],'categories'=>$categories,'categoryinfor'=>$categoryinfor,'tableinfor'=>$table,'page'=>$page,'cart'=>$cart]);
	}

	public function cart($table,$id)
	{
		// Cart::destroy();
		$table = Table::where('code',$table)->first();
		if ($table->status!=2) {
			$table->status=2;
			$table->save();
		}
		
		$product = Product::find($id);
		$cartInfo = [
			'id' => $id,
			'name' => $product->name,
			'price' => $product->cost,
			'qty' => '1',
			"options"=>['table'=>$table->code]
			
		];
		Cart::add($cartInfo);

		// $cart = Cart::content()->where('id',3)->where('options.table','A52');

		return 'true';

	}
	public function tableStatus($id)
	{
		$table = Table::where('id',$id)->first();
		if ($table->status==0) {
			$table->status=1;
		}else {
			$table->status=0;
		}
		$table->save();
		return $table;
	}
}
