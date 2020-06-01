<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Table;
use App\Category;
use App\Product;
use App\Order;
use App\Wait;
use Cart;
use DB;

class WorkingController extends Controller
{
	public function location($location){

		$locations= Table::select('location')->distinct()->get();
		if ($location!=null) {
			$tables = Table::where('tables.location',$location)->leftJoin('orders', function ($join) {
				$join->on('tables.id', '=', 'orders.table_id');
				$join->on('orders.status', DB::raw(0));
			})->select('tables.*','orders.name','orders.phone')->get();


		}else{
			$tables = Table::where('tables.location',$locations[0]['location'])->leftJoin('orders', function ($join) {
				$join->on('tables.id', '=', 'orders.table_id');
				$join->on('orders.status', DB::raw(0));
			})->select('tables.*,orders.name,orders.phone,orders.status as statusorder')->get();
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
		$data['product_id']=$product->id;
		$data['table_id']=$table->id;
		Wait::create($data);
		// $cart = Cart::content()->where('id',3)->where('options.table','A52');

		return 'true';

	}
	public function tableStatus(Request $request,$code)
	{
		$table = Table::where('code',$id)->first();
		if ($table->status==0) {
			$order = $request->only(['name','phone','note']);
			$order['user_id']=Auth::id();
			$order['table_id']=$table->id;
			$order=Order::create($order);
			$table->status=1;
		}else {
			Order::where('table_id',$table->id)->where('status',0)->delete();
			$table->status=0;
		}
		$table->save();
		return $table;
	}
}
