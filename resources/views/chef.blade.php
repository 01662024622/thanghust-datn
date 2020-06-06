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
        <th>Quantity</th>
        <th>Table</th>
        <th>Time</th>
        <th>Status</th>
      </tr>
    </thead>
  </table>
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
    ajax: '/chef/anyData/',
    columns: [
    { data: 'id', name: 'id' },
    { data: 'name', name: 'name' },
    { data: 'image', name: 'image' },
    { data: 'quantity', name: 'quantity' },
    { data: 'table', name: 'table' },
    { data: 'created_at', name: 'created_at' },
    { data: 'status', name: 'status' },
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
</script>
@endsection
