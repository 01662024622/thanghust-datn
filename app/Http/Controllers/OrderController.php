<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use Yajra\Datatables\Datatables;
use App\Product;
use App\Category;
use App\Product_detail;
use App\User;
use App\Gallary_image;
use App\Size;
use App\Color;
use Auth;
use App\Order;
use App\Order_detail;
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
        $products= Product::get();
        $categories= Category::get();
        $colors= Color::get();
        $sizes= Size::get();
        // dd($currentUser);
        $sumNotice="0";
        $sumPost="0";
        return view('orders.index',['currentUser'=>$currentUser,'sumNotice'=>$sumNotice,'sumPost'=>$sumPost],['products'=>$products,'categories'=>$categories,'vendors'=>$vendors,'sizes'=>$sizes,'colors'=>$colors,]);
    }
    public function anyData(){
        $orders = Order::select('orders.*');
        return Datatables::of($orders)
        ->addColumn('action', function ($order) {
            return'
            <button type="button" class="btn btn-xs btn-info" data-toggle="modal" href="#wareHousing" onclick="wareHousing('.$order['id'].')" ><i class="fa fa-eye" aria-hidden="true"></i></button>
            <button type="button" class="btn btn-xs btn-danger" onclick="alDelete('.$order['id'].')"><i class="fa fa-trash" aria-hidden="true"></i></button>
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

    public function getOrder($id){
        
        $data= Order_detail::where('order_id',$id)->get();
                foreach ($data as $key => $value) {
                    $product=Product::where('code',$value['product_id'])->first();
                    $image=Gallary_image::where('product_id',$product['id'])->first();
                    $product_detail=Product_detail::where('id',$value['product_detail_id'])->first();
                    $color=Color::where('id',$product_detail['color_id'])->first();
                    $size=Size::where('id',$product_detail['size_id'])->first();
                    $value['color_id']=$color['color'];
                    $value['size_id']=$size['size'];
                    $value['name']=$product['name'];
                    $value['link']=$image['link'];
                    $value['price']=number_format($product['sale_cost']);
                }
        return response()->json($data);
    }
    
    public function deleteOrder($id){
        $data=Order_detail::where('order_id',$id)->delete();
        $data=Order::find($id)->delete();
        return response()->json($data);
    }
}


