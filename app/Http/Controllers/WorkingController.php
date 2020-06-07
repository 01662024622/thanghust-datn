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
use Carbon\Carbon;
class WorkingController extends Controller
{
	public function location($location){
		if (Auth::user()->status==2) {
			return redirect('/chef');
		}

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
		$order= Order::where('table_id',$table->id)->where('status',0)->first();
		if ($order==null) {
			$orderReq['table_id']=$table->id;
			$orderReq['user_id']=Auth::id();
			$order=Order::create($orderReq);
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
		
		$waits = Wait::where('product_id',$product->id)->where('order_id',$order->id)->first();
		if ($waits != null) {
			$waits->quantity=$waits->quantity+1;
			$waits->save();
		}else {
			$data['product_id']=$product->id;
			$data['order_id']=$order->id;
			Wait::create($data);
		}

		return 'true';

	}

	public function cartminus($table,$id)
	{
			// Cart::destroy();
		$table = Table::where('code',$table)->first();

		$order= Order::where('table_id',$table->id)->where('status',0)->first();
		$wait= Wait::find($id);

		$product = Product::find($wait->product_id);
		$cart = Cart::content()->where('id',$product->id)->where('options.table',$table->code)->first();
		Cart::update($cart->rowId, ['qty' =>($cart->qty-1) ]);

		$waits = Wait::where('product_id',$product->id)->where('order_id',$order->id)->first();
		if ($waits->quantity>1) {
			$waits->quantity=$waits->quantity-1;
			$waits->save();
		}else {

			$waits->delete();
		}

		return 'true';

	}

	public function tableStatus(Request $request,$id)
	{
		$table= Table::find($id);
		
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
		$order = Order::where('table_id',$id)->where('status',0)->first();
		if ($order!=null) {
			$waits = Wait::where('order_id',$order->id)->select('waits.*');
		}else {
			$waits = Wait::where('order_id',0)->select('waits.*');
		}
		
		return Datatables::of($waits)
		->addColumn('image', function ($data) {
			$product=Product::find($data['product_id']);
			return '<image src="'.$product['image'].'" style="width:100px;hieght:auto" />';

		})
		->addColumn('action', function ($data) {
			return '<button type="button" class="btn btn-xs btn-danger fa fa-minus" onclick="minusWait('.$data['id'].')" style="float:left;margin:0 5px;height:25px;width:25px"></button>
			<input type="number" disabled value="'.$data['quantity'].'" style="width:40px; float:left;margin:0 5px">
			<button type="button" class="btn btn-xs btn-success fa fa-check" onclick="alDeleteWait('.$data['id'].')" style="float:left;margin:0 5px;height:25px;width:25px"></button>
			';
			
			

		})
		->addColumn('cost',  function ($data) {
			$product=Product::find($data['product_id']);
			return number_format($product->cost) .' VND';

		})
		->editColumn('created_at',  function ($data) {
			$now = Carbon::now();
			return $data['created_at']->diffForHumans($now);
		})


		->addColumn('name',  function ($data) {
			$product=Product::find($data['product_id']);
			return $product->name;

		})	
		->editColumn('status',  function ($data) {
			if($data['status']==0){
				return '<button type="button" class="btn btn-xs btn-warning" style="float:left;margin:0 5px;height:25px">Waits</button>';
			}else {
				return '<button type="button" class="btn btn-xs btn-success" style="float:left;margin:0 5px;height:25px">Done</button>';
			}
		})
		->setRowId('product-{{$id}}')
		->rawColumns(['action','image','status'],)
		->make(true);
	}

	public function dataBill($id){
		$order = Order::where('table_id',$id)->where('status',0)->first();
		if ($order!=null) {
			$datas =OrderProduct::where('order_id',$order->id)->select('order_product.*');
		}else {
			$datas =OrderProduct::where('order_id',0)->select('order_product.*');
		}
		return Datatables::of($datas)
		->addColumn('image', function ($data) {
			$product=Product::find($data['product_id']);
			return '<image src="'.$product['image'].'" style="width:100px;hieght:auto" />';

		})		
		->editColumn('created_at',  function ($data) {
			$now = Carbon::now();
			return $data['created_at']->diffForHumans($now);
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
		->rawColumns(['image'],)
		->make(true);
	}

	public function payProduct($id)
	{
		$waits = Wait::find($id);
		$orderProduct =OrderProduct::where('order_id',$waits->order_id)->where('product_id',$waits->product_id)->first();
		if ($orderProduct!=null) {
			$orderProduct->quantity=$orderProduct->quantity+$waits->quantity;
			$orderProduct->save();
		}else{
			$data['order_id']=$waits->order_id;
			$data['product_id']=$waits->product_id;
			$data['quantity']=$waits->quantity;
			OrderProduct::create($data);
		}
		$waits->delete();
		return $waits;
	}
	public function paymentProposal($id)
	{
		$order =Order::where('table_id',$id)->where('status',0)->first();
		
		$table=Table::find($id);
		$carts= Cart::content()->where('options.table',$table->code);
		$total =0;
		foreach ($carts as $cart) {
			$total=$total+($cart->price*$cart->qty);
			Cart::remove($cart->rowId);
		}
		$order->total=$total;
		$order->status=1;
		$order->save();
		$table->status=0;
		$table->save();
		return $order;
	}

	public function orderStatus(Request $request,$id)
	{
		
		$order=Order::find($id);
		$order->update($request->all());
		$table=Table::find($order->table_id);
		$table->status=0;
		$table->save();
		return $order;
	}
	
}
