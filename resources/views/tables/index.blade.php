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
  <h2>Categories</h2>
  <br />

  <a href="#"  class="btn btn-info" data-toggle="modal" data-target="#create">+ Thêm mới </a>
  <br><br>
  <table id="users-table" class="table table-striped">
    <thead class="flg">
      <tr>
        <th>ID</th>
        <th>Location</th>
        <th>Code</th>
        <th>Member</th>
        <th>Action</th>
      </tr>
    </thead>
  </table>
</div>

<!-- Modal add -->
<div class="modal fade" id="create" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="edituser">Thêm Table</h5>
      </div>
      <div class="modal-body">
        <form action="" method="post" id="addUser" style=" width:100%" enctype="multipart/form-data">
          {{ csrf_field() }}
          <div class="form-group">
            <label class="control-label" for="phone">Code:</label>        
            <input type="text" name="code"  class="form-control" id="code" value="" placeholder="">
          </div>
          <div class="form-group">
            <label for="sel1">Location:</label>
            <select class="form-control" id="location">
              <option value="A">A</option>
              <option value="B">B</option>
              <option value="C">C</option>
              <option value="D">D</option>
            </select>
          </div>
            <div class="form-group">
              <label class="control-label" for="phone">Member:</label>        
              <input type="text" name="member"  class="form-control" id="member" value="" placeholder="">
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

  {{-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script> --}}
  <script type="text/javascript" charset="utf-8">

    $(function () {

      $.ajaxSetup({

        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      var dataTable=$('#users-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('tables.data') !!}',
        columns: [
        { data: 'id', name: 'id' },
        { data: 'location', name: 'location' },
        { data: 'code', name: 'code' },
        { data: 'member', name: 'member' },
        { data: 'action', name: 'action' },
        ]
      });
      $('#StoreBtn').on('click',function(e){
        e.preventDefault();
        console.log($('#name').val());
        $.ajax({
          type:'post',
          url:"{{asset('admin/tables/store')}}",
          data:{
            code:$('#code').val(),
            location:$('#location').val(),
            member:$('#member').val(),
          },
          success:function(response){
           console.log(response);
           setTimeout(function () {
             toastr.success('has been added');

                  // 
                },1000);

           $('#create').modal('hide');
           dataTable.ajax.reload();
         }, error: function (xhr, ajaxOptions, thrownError) {
          toastr.error(xhr.responseJSON.message);

        },

      })
      });


    })



  // get data for form update

      // Delete function
      function alDelete(id){
        console.log(id);
        var path = "/admin/tables/" + id;
        swal({
          title: "Bạn có chắc muốn xóa?",
        // text: "Bạn sẽ không thể khôi phục lại bản ghi này!!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        cancelButtonText: "Không",
        confirmButtonText: "Có",
        // closeOnConfirm: false,
      },
      function(isConfirm) {
        if (isConfirm) {
          $.ajax({
            type: "delete",
            url: path,
            success: function(res)
            {

              if(!res.error) {
                toastr.success('Xóa thành công!');
                $('#category-'+id).remove();
                  //setTimeout(function () {
                    //location.reload();
                  //}, 1000)
                }
              },
              error: function (xhr, ajaxOptions, thrownError) {
                toastr.error(thrownError);
              }
            });
        } else {
          toastr.error("Thao tác xóa đã bị huỷ bỏ!");
        }
      });
      };
      function checkNull(value){
        return (value == null || value === '');
      }
    </script>
    @endsection
