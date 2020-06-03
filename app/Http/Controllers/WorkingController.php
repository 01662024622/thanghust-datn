<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Table;
use App\Category;
use App\Product;
use App\Order;
use App\OrderProduct;
use App\Wait;
use Cart;
use DB;
use Auth;
use Yajra\Datatables\Datatables;
class WorkingController extends Controller
{
	public function location($location){

		$locations= Table::select('location')->distinct()->get();
		if ($location!=null) {
			$tables = Table::where('tables.location',$location)->leftJoin('orders', function ($join) {
				$join->on('tables.id', '=', 'orders.table_id');
				$join->on('orders.status', DB::raw(0));
			})->select('tables.*','orders.name','orders.phone','orders.note')->get();


		}else{
			$tables = Table::where('tables.location',$locations[0]['location'])->leftJoin('orders', function ($join) {
				$join->on('tables.id', '=', 'orders.table_id');
				$join->on('orders.status', DB::raw(0));
			})->select('tables.*','orders.name','orders.phone','orders.note')->get();
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
		$order = Order::where('table_id',$table->id)->where('status',0)->first();
		if ($order==null) {
			$orderReq['table_id']=$table->id;
			$orderReq['user_id']=Auth::id();
			Order::create($orderReq);
		}
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
		
		$waits = Wait::where('product_id',$product->id)->where('table_id',$table->id)->first();
		if ($waits != null) {
			$waits->quantity=$waits->quantity+1;
			$waits->save();
		}else {
			$data['product_id']=$product->id;
			$data['table_id']=$table->id;
			Wait::create($data);
		}

		return 'true';

	}
	public function tableStatus(Request $request,$id)
	{
		
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
	public function dataWait($id){
		$waits = Wait::where('table_id',$id)->select('waits.*');
        return Datatables::of($waits)
        ->addColumn('image', function ($data) {
        	$product=Product::find($data['product_id']);
            return '<image src="'.$product['image'].'" style="width:100px;hieght:auto" />';
            
        })
        ->addColumn('action', function ($data) {
            return '<input type="number" disabled value="'.$data['quantity'].'" style="width:40px; float:left;margin:0 5px">
            <button type="button" class="btn btn-xs btn-success fa fa-check" onclick="alDeleteWait('.$data['id'].')" style="float:left;margin:0 5px;height:25px;width:25px"></button>
            ';
            
        })
        ->addColumn('cost',  function ($data) {
        	$product=Product::find($data['product_id']);
            return number_format($product->cost) .' VND';
            
        })

        ->addColumn('name',  function ($data) {
        	$product=Product::find($data['product_id']);
            return $product->name;
            
        })
        ->setRowId('product-{{$id}}')
        ->rawColumns(['action','image'],)
        ->make(true);
}

	public function dataBill($id){
		$order = Order::where('table_id',$id)->where('status',0)->first();
		$datas =OrderProduct::where('oder_id',$order->id)->select('order_product.*');
        return Datatables::of($datas)
        ->addColumn('image', function ($data) {
        	$product=Product::find($data['product_id']);
            return '<image src="'.$product['image'].'" style="width:100px;hieght:auto" />';
            
        })
        ->addColumn('action', function ($data) {
            return '<input type="number" disabled value="'.$data['quantity'].'" style="width:40px; float:left;margin:0 5px">
            <button type="button" class="btn btn-xs btn-success fa fa-check" onclick="alDeleteWait('.$data['id'].')" style="float:left;margin:0 5px;height:25px;width:25px"></button>
            ';
            
        })
        ->addColumn('cost',  function ($data) {
        	$product=Product::find($data['product_id']);
            return number_format($product->cost) .' VND';
            
        })

        ->addColumn('name',  function ($data) {
        	$product=Product::find($data['product_id']);
            return $product->name;
            
        })
        ->setRowId('product-{{$id}}')
        ->rawColumns(['action','image'],)
        ->make(true);
}
}
