<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;
use App\Coupon;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;
use App\User;
use Carbon\Carbon;
class CouponController extends Controller
{
     public function index(){
        $currentUser= Auth::guard('admin')->user();
    	$categories= Coupon::get();
    	// dd($currentUser);
    	$sumNotice="0";
    	$sumPost="0";
    	return view('coupon.index',['currentUser'=>$currentUser,'sumNotice'=>$sumNotice,'sumPost'=>$sumPost],['categories'=>$categories]);
	}

	public function anyData(){
        $coupons = Coupon::select('coupons.*');
        return Datatables::of($coupons)
        ->addColumn('action', function ($data) {
            return'
            <button type="button" class="btn btn-xs btn-info" data-toggle="modal" href="#showProduct"><i class="fa fa-eye" aria-hidden="true"></i></button>
            <button type="button" class="btn btn-xs btn-warning"data-toggle="modal" onclick="getProduct('.$data['id'].')" href="#editProduct"><i class="fa fa-pencil" aria-hidden="true"></i></button>
            <button type="button" class="btn btn-xs btn-danger" onclick="alDelete('.$data['id'].')"><i class="fa fa-trash" aria-hidden="true"></i></button>
            ';
            
        })
        ->setRowId('data-{{$id}}')
        ->make(true);
}

	
	public function getData($id){
    	$categories=Coupon::find($id);
    	return $categories;
	}



	public function destroy($id){
		// Product::find($id);

		$data=Coupon::find($id)->delete();
		return response()->json($data);
	}



	public function store(Request $request) {
		$data=$request->all();
		// return $data;
		$data['expiration_date']=Carbon::createFromFormat('m/d/Y',$data['expiration_date'])->toDateTimeString();
		$coupon=Coupon::create($data);
		return $coupon;
	}



	public function updateData(Request $request) {
		$id=$request->only(['id']);
		$data=$request->all();
		$data=Coupon::find($id)->first()->update($data);
		if ($data) {
			$data=Coupon::where('id',$id)->first();
			
    		return $data;
		};
		 return response()->json(['error'=>'500']);	
	}
}
