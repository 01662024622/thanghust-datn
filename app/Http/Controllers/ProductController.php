<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductUpdateRequest;
use Yajra\Datatables\Datatables;
use App\Product;
use App\User;
use App\Category;
use App\Gallary_image;
use Auth;
class ProductController extends Controller
{
    public function index(){
    	$currentUser= Auth::guard('admin')->user();
        $products= Product::get();
        $categories= Category::get();
        $sumPost="0";
        $sumNotice="0";
    	return view('products.index',['currentUser'=>$currentUser,'sumNotice'=>$sumNotice,'sumPost'=>$sumPost],['products'=>$products,'categories'=>$categories]);
    }
    public function anyData(){
            // return Datatables::of(User::query())->make(true);
    // $products = Product::select('products.*', 'categories.name as category_name', 'brands.name as brand_name')->join('categories', 'products.category_id', '=', 'categories.id')
    //                         ->join('brands', 'products.brand_id', '=', 'brands.id')
    //                         ->orderBy('products.id', 'desc');
    // $products = Product::select('products.*','product-details.quantity as quantity')
    // ->join('product-details', 'products.id', '=', 'product-details.product_id');
    // ->join('colors', 'product-details.color_id', '=', 'colors.id')
    // ->join('sizes', 'product-details.size_id', '=', 'sizes.id');
        $products = Product::select('products.*');
        return Datatables::of($products)
        ->addColumn('action', function ($product) {
            return'
            <button type="button" class="btn btn-xs btn-success fa fa-plus" data-toggle="modal" href="#wareHousing" onclick="wareHousing('.$product['id'].')" ></button>
            <button type="button" class="btn btn-xs btn-info" data-toggle="modal" href="#showProduct"><i class="fa fa-eye" aria-hidden="true"></i></button>
            <button type="button" class="btn btn-xs btn-warning"data-toggle="modal" onclick="getProduct('.$product['id'].')" href="#editProduct"><i class="fa fa-pencil" aria-hidden="true"></i></button>
            <button type="button" class="btn btn-xs btn-danger" onclick="alDelete('.$product['id'].')"><i class="fa fa-trash" aria-hidden="true"></i></button>
            ';
            
        })
        // ->setRowClass(function ($image) {
        //     return $image->id % 2 == 0 ? 'pink' : 'green';
        // })
        //->editColumn('image', '<img src=""/>')
        //->editColumn('brand_id', 'tung{{$category_id}}')
        //->editColumn('category_id', Category::where('id', '=',$category_id)->first()->name)
        ->setRowId('product-{{$id}}')
        ->editColumn('cost', '{{ number_format($cost)}} VND')
        // ->rawColumns(['action'])
        ->make(true);
}
	public function status($id){
        $product=Product::find($id);
        if ($product->status==0) {
            $product->status=1;
            $product->save();
        }else {
             $product->status=0;
            $product->save();
        }

        return response()->json($product);
    }
    public function getProduct($id){
        $product=Product::find($id);
        // $categories=Category::orderBy('id','DESC')->get();
        $product['images']=Gallary_image::where('product_id',$id)->get();
        return response()->json($product);
    }
    public function destroy($id){
        // Product::find($id);

        $data=Product::find($id)->delete();
        return response()->json($data);
    }
    
    public function store(Request $request) {
        $data=$request->only(['name','description','content','cost','category_id']);
        $data['slug']=str_slug($data['name'].time());
        $product=Product::create($data);
        foreach ($request['images'] as $key => $image) {
            $imageName= 'http://'.request()->getHttpHost().'/images/product/'.time().$key.'.'.$image->getClientOriginalExtension();

        $image->move(public_path('images/product'), $imageName);
        $gallary['link']=$imageName;
        $gallary['product_id']=$product['id'];
        $data=Gallary_image::create($gallary);
        }
        return $product;
    
    }
    public function updateProduct(Request $request) {
        $id=$request->only(['id']);
        $data=$request->only(['name','description','content','cost','category_id']);
        $data['slug']=str_slug($data['name']).time();
        $boolean=Product::where('id',$id)->update($data);
        if ($boolean) {
        return Product::find($id)->first();
        }else{
            return response()->json(['error'=>'500']);
        }
        if (!isempty($request['images'])) {
            # code...
            foreach ($request['images'] as $key => $image) {
                $imageName= request()->getHttpHost().'/images/product/'.time().$key.'.'.$image->getClientOriginalExtension();

            $image->move(public_path('images/product'), $imageName);
            $gallary['link']=$imageName;
            $gallary['product_id']=$product['id'];
            $data=Gallary_image::create($gallary);
            }
        }
        $boolean=Post::find($id)->first()->update($data);
        if ($boolean) {
        return Post::find($id)->first();
        }else{
            return response()->json(['error'=>'500']);
        }
    }
    public function getReason($id){
        $post=Post::where('id',$id)->first();
        return $post;
    }
    public function manageUser($slug){

        $products= Product::where('slug',$slug)->first();
        
    }
}
