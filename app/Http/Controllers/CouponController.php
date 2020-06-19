<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;
use App\User;
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
            <button type="button" class="btn btn-xs btn-warning"data-toggle="modal" onclick="getProduct('.$data['id'].')" href="#editProduct"><i class="fa fa-pencil" aria-hidden="true"></i></button>
            ';
            
        })
        ->setRowId('data-{{$id}}')
        ->make(true);
}

	
	public function getData($id){
    	$data=Coupon::find($id);
    	$data->expiration_date=Carbon::createFromFormat('Y-m-d',$data->expiration_date)->format('m/d/Y');
    	return $data;
	}






	public function store(Request $request) {
		$data=$request->all();
		// return $data;
		$data['expiration_date']=Carbon::createFromFormat('m/d/Y',$data['expiration_date'])->format('Y-m-d');
		$coupon=Coupon::create($data);
		return $coupon;
	}



	public function updateData(Request $request) {
		$id=$request->only(['id']);
		$data=$request->all();
		$data['expiration_date']=Carbon::createFromFormat('m/d/Y',$data['expiration_date'])->format('Y-m-d');
		$data=Coupon::find($id)->first()->update($data);
		if ($data) {
			$data=Coupon::where('id',$id)->first();
			
    		return $data;
		};
		 return response()->json(['error'=>'500']);	
	}
}
