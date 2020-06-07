@extends('layouts.adminheader')
@section('css')
<style type="text/css" media="screen">
  .half-form{
    width: 50%;
    padding: 10px;
    float: left;

  }
  .modal-dialog{
    width: 100%;
  }

</style>
@endsection
@section('content')

<div class="container">



  <br><br>

  <br><br>
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

<div class="modal fade" id="wareHousing">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Order</h4>
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
    </div>
</div>
</div>
</div>
@endsection

@section('js')
<script>
    $(function () {
  $.ajaxSetup({

    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $('#users-table').DataTable({
    processing: true,
    serverSide: true,
    ajax: '{!! route('adminOder.data') !!}',
    columns: [
    { data: 'id', name: 'id' },
    { data: 'name', name: 'name' },
    { data: 'phone', name: 'phone' },
    { data: 'total', name: 'total' },
    { data: 'updated_at', name: 'updated_at' },
    { data: 'action', name: 'action' },
    ]
  });
  
  })
 function paymentEnd(id) {
     $('#bill-table').DataTable({
        "processing": true,
        "serverSide": true,
        ajax:{
          url: '/admin/anyData/order/bill/'+id,
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
</script>
@endsection