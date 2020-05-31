<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Table;

use Yajra\Datatables\Datatables;

class TableController extends Controller
{
    public function index(){
        $currentUser= Auth::guard('admin')->user();
    	// dd($currentUser);
        $sumNotice="0";
        $sumPost="0";
        return view('tables.index',['currentUser'=>$currentUser,'sumNotice'=>$sumNotice,'sumPost'=>$sumPost]);
    }

    public function anyData(){
        $tables = Table::select('tables.*');
        return Datatables::of($tables)
        ->addColumn('action', function ($category) {
            return'
            <button type="button" class="btn btn-xs btn-danger" onclick="alDelete('.$category['id'].')"><i class="fa fa-trash" aria-hidden="true"></i></button>
            ';
            
        })
        ->setRowId('category-{{$id}}')
        ->make(true);
    }



    public function destroy($id){
		// Product::find($id);

      $data=Table::find($id)->delete();
      return response()->json($data);
  }



  public function store(Request $request) {
      $data=$request->all();
      $res=Table::create($data);
      return $res;
  }




}
