@extends('layouts.adminheader')
@section('css')
<style type="text/css" media="screen">
  .paginate_button{
    color: #fff;
    background-color: #e68f35;
    border-color: #d43f3a;
    padding: 6px;
    border-radius: 5px;
    margin: 2px;
  }
</style>

<script src="https://cdn.ckeditor.com/4.8.0/standard/ckeditor.js"></script>
@endsection
@section('content')

<div class="container" style="width:100%">
  <h2>Coupons</h2>
  <br />

  <a href="#"  class="btn btn-info" data-toggle="modal" data-target="#create">+ Add </a>
  <br><br>
  <table id="users-table" class="table table-striped">
    <thead class="flg">
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Amount</th>
        <th>Expiration Date</th>
        <th>Action</th>
      </tr>
    </thead>
  </table>
</div>
<div class="modal fade" id="editProduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="">Update Coupon</h5>
      </div>
      <div class="modal-body">
        <form action="" method="user" role="form" id="editUser" style=" width:100%" enctype="multipart/form-data">
          {{ csrf_field() }}
          <div class="form-group">
            <label class="control-label col-sm-2" for="name">Name:</label>
            <input type="text" class="form-control" id="ename" placeholder="Enter name" name="name">
          </div>
          <div class="form-group ">
            <label class="control-label col-sm-2 requiredField" for="date">
             Date
             <span class="asteriskField">
              *
            </span>
          </label>
          <input class="form-control" id="edate" name="date" placeholder="MM/DD/YYYY" type="text"/>
        </div>
        <div class="form-group">
          <label class="control-label" for="name">Percent:</label>
          <div class="row">
            <div class="col-xs-11">

              <input type="number" class="form-control" id="eamount" placeholder="Enter percent" name="amount">
            </div>
            <span class="col-xs-1">%</span>
          </div>
        </div>

        <input type="hidden" name="eid" id="eid">
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" id="UpdateBtn" class="btn btn-primary">Save changes</button>
        </div> 
      </form>
    </div>

  </div>
</div>
</div>
<!-- Modal add -->
<div class="modal fade" id="create" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="edituser">Add Coupons</h5>
      </div>
      <div class="modal-body">
        <form action="" method="post" id="addUser" style=" width:100%" enctype="multipart/form-data">
          {{ csrf_field() }}
          <div class="form-group">
            <label class="control-label col-sm-2" for="name">Name:</label>
            <input type="text" class="form-control" id="name" placeholder="Enter name" name="name">
          </div>
          <div class="form-group ">
            <label class="control-label col-sm-2 requiredField" for="date">
             Date
             <span class="asteriskField">
              *
            </span>
          </label>
          <input class="form-control" id="date" name="date" placeholder="MM/DD/YYYY" type="text"/>
        </div>
        <div class="form-group">
          <label class="control-label" for="name">Percent:</label>
          <div class="row">
            <div class="col-xs-11">

              <input type="number" class="form-control" id="amount" placeholder="Enter percent" name="amount">
            </div>
            <span class="col-xs-1">%</span>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" id="StoreBtn" class="btn btn-primary">Save changes</button>
        </div> 
      </form>
    </div>
  </div>
</div>
</div>
@endsection
@section('js')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>

<script>
  $(document).ready(function(){
    var date_input=$('input[name="date"]'); //our date input has the name "date"
    var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
    date_input.datepicker({
      format: 'mm/dd/yyyy ',
      container: container,
      todayHighlight: true,
      autoclose: true,
      startDate : new Date()
    })
  })
</script>

{{-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script> --}}
<script type="text/javascript" charset="utf-8">
  $(function () {
    $.ajaxSetup({

      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    var dataTable = $('#users-table').DataTable({
      processing: true,
      serverSide: true,
      ajax: '{!! route('coupons.data') !!}',
      columns: [
      { data: 'id', name: 'id' },
      { data: 'name', name: 'name' },
      { data: 'amount', name: 'amount' },
      { data: 'expiration_date', name: 'expiration_date' },
      { data: 'action', name: 'action' },
      ]
    });

    $('#StoreBtn').on('click',function(e){
      e.preventDefault();
      console.log($('#name').val());
      $.ajax({
        type:'post',
        url:"{{asset('admin/coupons/store')}}",
        data:{
          name:$('#name').val(),
          expiration_date:$('#date').val(),
          amount:$('#amount').val(),
        },
        success:function(response){
         console.log(response);
         setTimeout(function () {
           toastr.success('has been added');},1000);
         dataTable.ajax.reload();
         $('#create').modal('hide');

       }, error: function (xhr, ajaxOptions, thrownError) {
        if (!checkNull(xhr.responseJSON.errors)) {
          console.log(xhr.responseJSON.errors);
          $('p#sperrors').remove();
          if(!checkNull(xhr.responseJSON.errors.name))
          {
            for (var i = 0; i < xhr.responseJSON.errors.name.length; i++) {
              var html='<p id="sperrors" style="color:red">'+xhr.responseJSON.errors.name[i]+'</p>';

              $(html).insertAfter('#name');
            }
          };
          if(!checkNull(xhr.responseJSON.errors.sort_order))
          {
            for (var i = 0; i < xhr.responseJSON.errors.sort_order.length; i++) {
              var html='<p id="sperrors" style="color:red">'+xhr.responseJSON.errors.sort_order[i]+'</p>';
              console.log(html);
              $(html).insertAfter('#sort_order');
            }
          };
        }
        toastr.error(xhr.responseJSON.message);

      },

    })
    });





  // get data for form update

      // Update function
      $('#UpdateBtn').on('click',function(e){
        e.preventDefault();
        var id=$('#eid').val();
        console.log(id);
        $.ajax({
          type:'post',
          url: "{{ asset('admin/coupons/update') }}",
          data:{
            name:$('#ename').val(),
          expiration_date:$('#edate').val(),
          amount:$('#eamount').val(),
            id:$('#eid').val(),
          },
          success: function(response){
            console.log(response);
            setTimeout(function () {
              toastr.success(response.name+'has been updated');

            },1000);

            $('#editProduct').modal('hide');
            dataTable.ajax.reload();

          }, error: function (xhr, ajaxOptions, thrownError) {
            if (!checkNull(xhr.responseJSON.errors)) {
              console.log(xhr.responseJSON.errors);
              $('p#sperrors').remove();
              if(!checkNull(xhr.responseJSON.errors.name))
              {
                for (var i = 0; i < xhr.responseJSON.errors.name.length; i++) {
                  var html='<p id="sperrors" style="color:red">'+xhr.responseJSON.errors.name[i]+'</p>';

                  $(html).insertAfter('#name');
                }
              };
              if(!checkNull(xhr.responseJSON.errors.sort_order))
              {
                for (var i = 0; i < xhr.responseJSON.errors.sort_order.length; i++) {
                  var html='<p id="sperrors" style="color:red">'+xhr.responseJSON.errors.sort_order[i]+'</p>';
                  console.log(html);
                  $(html).insertAfter('#sort_order');
                }
              };
            }
            toastr.error(xhr.responseJSON.message);

          },

        })
      });
        })
      function getProduct(id) {
        console.log(id);
        // $('#editPost').modal('show');

        $.ajax({
          type: "GET",
          url: "/admin/coupons/edit/" + id,

          success: function(response)
          { console.log(response); 
            $('#ename').val(response.name);
            $('#edate').datepicker("setDate",response.expiration_date);
            $('#eamount').val(response.amount);
            $('#eid').val(response.id);

          },
          error: function (xhr, ajaxOptions, thrownError) {
            toastr.error(thrownError);
          }
        });

      }

     
    </script>
    @endsection
