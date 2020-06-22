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
      <div class="form-group">
        <span style="float: left"><b>Total: </b></span>
        <span style="float: right"><b id="total-number"></b></span>
      </div>
      <br>
      <br>
      @if($tax>0)
      <div class="form-group">
        <span style="float: left"><b>Tax: </b></span>
        <span style="float: right"><b id="total-number">{{$tax}}%</b></span>
      </div>
      @endif
      <br>
      <div class="form-group">
        <label for="">Coupon: </label>
        <select name="coupons" id="coupons" style="width: 100%" class="form-control" onchange="setVoucher()">
          <option value="0"><b> <strong>Not have</strong></b> </option>
          @foreach($coupons as $coupon)
          <option value="{{$coupon['id']}}">{{$coupon['name']}}-{{$coupon['amount']}}%</option>
          @endforeach
        </select>
      </div>
      <br>

      @if($tax>0)
      <div class="form-group">
        <span style="float: left"><b>Payment: </b></span>
        <span style="float: right"><b id="total-number-payment"></span>
        </div>
        @endif
        <br>

        <br>
        <br>
        <br>
      </div>                       
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" id="payment-proposal" class="btn btn-primary">
        Payment</button>
      </div>
    </div>
  </div>
</div>

<input type="hidden" name="oid" id="oid" value="">

@endsection
@section('js')
<script>
  var tax={{$tax}};
  var total_number = 0;
  var coupon=0;
  var total_number_payment=0;
  var coupons =@json($coupons);
  function setVoucher(){
    var id = $('#coupons').val();
    for (var i = coupons.length - 1; i >= 0; i--) {
      if (coupons[i]["id"]==id) {
        coupon=coupons[i]["amount"];
        break;
      }
    }
    total_number_payment=total_number*((100+tax)/100)*((100-coupon)/100)
    $('#total-number-payment').text(parseInt(total_number_payment).toLocaleString()+" VND");
  }

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


    $("#oid").val(id)
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
            total_number=total;
            total_number_payment=total_number*((100+tax)/100)*((100-coupon)/100);
            console.log(total);
            $('#total-number').text(parseInt(total).toLocaleString()+" VND");
            $('#total-number-payment').text(parseInt(total_number_payment).toLocaleString()+" VND");
            coupon=0;
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
    $.ajax({
      type: "GET",
      url: '/cashier/order/'+id,
      success: function(response)
      {
        $('#name').val(response.name);
        $('#phone').val(response.phone);
        $('#note').val(response.note);
      },
      error: function (xhr, ajaxOptions, thrownError) {
        toastr.error(thrownError);
      }
    });

    
  }
  $('#payment-proposal').on('click', function(event) {
    var id= $("#oid").val();
    event.preventDefault();
    $.ajax({
      type: "POST",
      url: "/status/table/cashier/"+id,
      data:{
        name:$('#name').val(),
        phone:$('#phone').val(),
        note:$('#note').val(),
        coupon_id:$('#coupons').val(),
        status:2,
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
</script>
@endsection
