<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use Yajra\Datatables\Datatables;
use App\Product;
use App\Category;
use App\User;
use Auth;
use App\Order;
use Gloudemans\Shoppingcart\Facades\Cart;
class OrderController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
         $currentUser= Auth::guard('admin')->user();
        // dd($currentUser);
        $sumNotice="0";
        $sumPost="0";
        return view('orders.index',['currentUser'=>$currentUser,'sumNotice'=>$sumNotice,'sumPost'=>$sumPost]);
    }
    public function anyData(){
        $orders = Order::where('status',2)->select('orders.*');
        return Datatables::of($orders)
        ->addColumn('action', function ($order) {
            return'
            <button type="button" class="btn btn-xs btn-info" data-toggle="modal" href="#wareHousing" onclick="paymentEnd('.$order['id'].')" ><i class="fa fa-eye" aria-hidden="true"></i></button>
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

   
}


