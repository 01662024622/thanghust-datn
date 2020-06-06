@extends('layouts.app')

@section('css')
<style type="text/css" media="screen">
  .table-container{
    background-color: #449d44;
    margin:30px;
    color: white;
    font-size: 30px;
    font-weight: 900;
    text-align: center;
  }
</style>
@endsection
@section('content')
<div class="container">
  <table class="table table-bordered" id="users-table">
    <thead>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Phone</th>
        <th>Total</th>
        <th>Created Date</th>
        <th>Action</th>
      </tr>
    </thead>
  </table>
</div>
{{-- ############## modal cart table#####################--}}

<div class="modal fade" id="wareHousing">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Cart</h4>
      </div>
      <div class="modal-body">
       <table class="table table-bordered" id="bill-table" width="100%">
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Image</th>
            <th>Cost</th>
            <th>Quantity</th>
          </tr>
        </thead>
      </table>

    </div>                       
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      <button type="button" id="payment-proposal" class="btn btn-primary">
      Payment</button>
    </div>
  </div>
</div>
</div>



@endsection
@section('js')
<script>
  $.ajaxSetup({

    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  var tableData=$('#users-table').DataTable({
    processing: true,
    serverSide: true,
    ajax: '/cashier/anyData/',
    columns: [
    { data: 'id', name: 'id' },
    { data: 'name', name: 'name' },
    { data: 'phone', name: 'phone' },
    { data: 'total', name: 'total' },
    { data: 'updated_at', name: 'updated_at' },
    { data: 'action', name: 'action' },
    ],
    "columnDefs": [
    { "width": "65px", "targets": 5 }
    ]
  });
  function completeWait(id) {
    $.ajax({
      type: "GET",
      url: "/chef/order/"+id,
      success: function(response)
      {
        tableData.ajax.reload();
      },
      error: function (xhr, ajaxOptions, thrownError) {
        toastr.error(thrownError);
      }
    });
  }
  setInterval(function() {
    console.log('xxx')
    tableData.ajax.reload();
  }, 30000);

  var bills;

  function paymentEnd(id) {
    if(bills!=undefined){
      bills.ajax.reload();
    }else{
      console.log(id)
      bills = $('#bill-table').DataTable({
        "processing": true,
        "serverSide": true,
        ajax:{
          url: '/anyData/order/bill/'+id,
          type: "GET",
          datatype: "json",
          dataSrc: function (data) {
            var total=0;
            for (var i = data.data.length - 1; i >= 0; i--) {
              total=total+data.data[i]['quantity']*data.data[i]['cost'];
            }
            console.log(total);
            return data.data;
          }
        }, 
        columns: [
        { data: 'id', name: 'id' },
        { data: 'name', name: 'name' },
        { data: 'image', name: 'image' },
        { data: 'costvnd', name: 'costvnd' },
        { data: 'quantity', name: 'quantity' }
        ],
        "columnDefs": [
        { "width": "65px", "targets": 4 }
        ]
      });
    }
  }

</script>
@endsection
