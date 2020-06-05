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
        <th>Image</th>
        <th>Cost</th>
        <th>Descroption</th>
        <th>Action</th>
      </tr>
    </thead>
  </table>
</div>

{{-- ############## modal cart table#####################--}}

<div class="modal fade" id="bill-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Cart</h4>
      </div>
      <div class="modal-body">
       <table class="table table-bordered" id="bill-table">
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
      Payment Proposal</button>
    </div>
  </div>
</div>
</div>


{{-- ############## modal cart table#####################--}}

<div class="modal fade" id="wait-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Waits</h4>
      </div>
      <div class="modal-body">
       <table class="table table-bordered" id="wait-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Image</th>
            <th>Cost</th>
            <th>Action</th>
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
{{-- ############## modal pending table#####################--}}

<div class="modal fade" id="pending-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Pending</h4>
      </div>
      <div class="modal-body">
       <div class="form-group">
        <label for="">Name</label>
        <input type="text" class="form-control" id="name" placeholder="Input Name">
      </div>
      <div class="form-group">
        <label for="">Phone</label>
        <input type="text" class="form-control" id="phone" placeholder="Input Phone">
      </div>
      <div class="form-group">
        <label for="">Note</label>
        <textarea name="note" id="note" class="form-control"></textarea>
      </div>

    </div>                       
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      <button type="button" id="set-status" class="btn btn-primary">Save changes</button>
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
    ajax: '/anyDataUser/{{$categoryinfor->id}}/{{$tableinfor->code}}',
    columns: [
    { data: 'id', name: 'id' },
    { data: 'name', name: 'name' },
    { data: 'image', name: 'image' },
    { data: 'cost', name: 'cost' },
    { data: 'description', name: 'description' },
    { data: 'action', name: 'action' },
    ],
    "columnDefs": [
    { "width": "65px", "targets": 5 }
    ]
  });
        // width: 65px;

        function wareHousing(id){
          console.log(id);
        // $('#editPost').modal('show');

        $.ajax({
          type: "GET",
          url: "/add/{{$tableinfor->code}}/"+id,

          success: function(response)
          {
            tableData.ajax.reload();
            $('#cover-pending').hide();
            $('#pending-bottom').html('');
          },
          error: function (xhr, ajaxOptions, thrownError) {
            toastr.error(thrownError);
          }
        });
      }
      $('#set-status').on('click', function(event) {
        event.preventDefault();
        $.ajax({
          type: "POST",
          url: "/status/stable/user/{{$tableinfor->id}}",
          data:{
            name:$('#name').val(),
            phone:$('#phone').val(),
            note:$('#note').val(),
          },
          dataType:'json',
          success: function(response)
          {
            location.reload();
          },
          error: function (xhr, ajaxOptions, thrownError) {
            toastr.error(thrownError);
          }
        });
      });
      function setStatus(id) {
       $.ajax({
        type: "POST",
        url: "/status/stable/user/{{$tableinfor->id}}",
        data:{
        },
        dataType:'json',
        success: function(response)
        {
          location.reload();
        },
        error: function (xhr, ajaxOptions, thrownError) {
          toastr.error(thrownError);
        }
      });
     }

     var waits;
     var bills;
     function getDataWait() {
      if(waits!=null){
        waits.ajax.reload();
      }else{
       waits = $('#wait-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/anyData/waits/table/{{$tableinfor->id}}',
        columns: [
        { data: 'id', name: 'id' },
        { data: 'name', name: 'name' },
        { data: 'image', name: 'image' },
        { data: 'cost', name: 'cost' },
    // { data: 'quantity', name: 'quantity' },
    { data: 'action', name: 'action' },
    ],
    "columnDefs": [
    { "width": "65px", "targets": 4 }
    ]
  });
     }

   }
   function getDataBill() {


    if(bills!=null){
      bills.ajax.reload();
    }else{
      bills = $('#bill-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '/anyData/bill/table/{{$tableinfor->id}}',
        columns: [
        { data: 'id', name: 'id' },
        { data: 'name', name: 'name' },
        { data: 'image', name: 'image' },
        { data: 'cost', name: 'cost' },
        { data: 'quantity', name: 'quantity' },
    // { data: 'action', name: 'action' },
    ],
    "columnDefs": [
    { "width": "65px", "targets": 4 }
    ]
  });
    }
  }
  function alDeleteWait(id){
    $.ajax({
      type: "GET",
      url: "/pay/product/"+id,
      success: function(response)
      {
        waits.ajax.reload();
      },
      error: function (xhr, ajaxOptions, thrownError) {
        toastr.error(thrownError);
      }
    });
  }
 $('#payment-proposal').on('click', function(event) {
  event.preventDefault();
  $.ajax({
    type: "GET",
    url: "/payment/proposal/{{$tableinfor->id}}",
    success: function(response)
    {
      location.reload();
    },
    error: function (xhr, ajaxOptions, thrownError) {
      toastr.error(thrownError);
    }
  });
});

</script>
@endsection
