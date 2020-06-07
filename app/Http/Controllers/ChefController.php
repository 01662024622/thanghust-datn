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
class ChefController extends Controller
{
	public function index(){

		$locations= Table::select('location')->distinct()->get();
		
		return view('chef',['locations'=>$locations,'categories'=>[],'tableinfor'=>null]);

	}
	public function dataChef(){
		$waits = Wait::select('waits.*');
		
		return Datatables::of($waits)
		->addColumn('image', function ($data) {
			$product=Product::find($data['product_id']);
			return '<image src="'.$product['image'].'" style="width:100px;hieght:auto" />';

		})
		->addColumn('cost',  function ($data) {
			$product=Product::find($data['product_id']);
			return number_format($product->cost) .' VND';

		})

		->addColumn('table',  function ($data) {
			$order=Order::find($data['order_id']);
			$table=Table::find($order['table_id']);
			return $table->code;

		})
		->editColumn('created_at',  function ($data) {
			$now = Carbon::now();
			return $data['created_at']->diffForHumans($now);
		})

		->editColumn('status',  function ($data) {
			if($data['status']==0){
				return '<button type="button" class="btn btn-xs btn-warning" onclick="completeWait('.$data['id'].')" style="float:left;margin:0 5px;height:25px">Waits</button>';
			}else {
				return '<button type="button" class="btn btn-xs btn-success" style="float:left;margin:0 5px;height:25px" disabled>Done</button>';
			}
		})

		->addColumn('name',  function ($data) {
			$product=Product::find($data['product_id']);
			return $product->name;

		})
		->setRowId('product-{{$id}}')
		->rawColumns(['action','image','status'],)
		->make(true);
	}
	function changeStatus($id)
	{
		$wait=Wait::find($id);
		$wait->status=1;
		$wait->save();
		return $wait;
	}

	public function cashier(){

		$locations= Table::select('location')->distinct()->get();
		
		return view('cashier',['locations'=>$locations,'categories'=>[],'tableinfor'=>null]);

	}
	
	public function dataCashier(){
		$orders = Order::where('status',1)->select('orders.*');
		return Datatables::of($orders)
		->addColumn('action', function ($order) {
			return'
			<button type="button" class="btn btn-xs btn-success" data-toggle="modal" href="#wareHousing" onclick="paymentEnd('.$order['id'].')" ><i class="fa fa-credit-card-alt" aria-hidden="true"></i></button>
			';

		})
        // ->setRowClass(function ($image) {
        //     return $image->id % 2 == 0 ? 'pink' : 'green';
        // })
        //->editColumn('image', '<img src=""/>')
        //->editColumn('brand_id', 'tung{{$category_id}}')
        //->editColumn('category_id', Category::where('id', '=',$category_id)->first()->name)
		->setRowId('product-{{$id}}')
		->editColumn('total', '{{ number_format($total)}}')
        // ->rawColumns(['action'])
		->make(true);
	}
	public function orderBill($id){
		$order = Order::find($id);
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

		->addColumn('costvnd',  function ($data) {
			$product=Product::find($data['product_id']);
			return number_format($product->cost) .' VND';

		})
		->addColumn('cost',  function ($data) {
			$product=Product::find($data['product_id']);
			return $product->cost;

		})

		->addColumn('name',  function ($data) {
			$product=Product::find($data['product_id']);
			return $product->name;

		})
		->setRowId('product-{{$id}}')
		->rawColumns(['image'],)
		->make(true);
	}
	
}
