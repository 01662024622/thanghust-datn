@extends('layouts.adminheader')
@section('content')

<div class="container">
  <br><br>
  <a class="btn btn-primary" data-toggle="modal" href='#addUsser'>+Add User</a>

  <br><br>
  <table class="table table-bordered" id="users-table">
    <thead>
      <tr>
        <th>ID</th>
        <th>Avatar</th>   
        <th>Name</th>
        <th>Email</th>
        <th>phone</th>
        <th>Address</th>
        <th>Role</th>
        <th>Action</th>
      </tr>
    </thead>
  </table>
</div>
<div class="modal fade" id="editUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="edituser">Cập Nhật Thông Tin User</h5>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label class="control-label col-sm-2" for="name">Name:</label>
          <input type="text" class="form-control" id="ename" placeholder="Enter name" name="ename">
        </div>
        <div class="form-group">
          <label class="control-label col-sm-2" for="email">Email:</label>       
          <input type="email" class="form-control" id="eemail" placeholder="Enter email" name="eemail">
        </div>
        <div class="form-group">
          <label class="control-label col-sm-2" for="description">Avata:</label>
          <img id="imgFile" class="img img-responsive" width="30%" alt="">
          <input type="file" name="image" id="editfile" onchange="loadFile(event)">
        </div>
        <div class="form-group">
          <label class="control-label" for="phone">Phone:</label>        
          <input type="tel" name="ephone"  class="form-control" id="ephone" value="" placeholder="">
        </div>
        <div class="form-group">
         <label class="control-label col-sm-2" for="name">Address:</label>
         <input type="text" class="form-control" id="eaddress" placeholder="Enter address" name="eaddress">
       </div>
       <input type="hidden" name="eid" id="eid">
       <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" id="UpdateBtn" class="btn btn-primary">Save changes</button>
      </div>
    </div>

  </div>
</div>
</div>
<!-- Modal add -->
<div class="modal fade" id="addUsser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="edituser">Thêm User</h5>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label class="control-label col-sm-2" for="name">Name:</label>
          <input type="text" class="form-control" id="name" placeholder="Enter name" name="name">
        </div>
        <div class="form-group">
          <label class="control-label col-sm-2" for="email">Email:</label>       
          <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
        </div>
        <br><br>
        <div class="form-group">
          <label class="control-label col-sm-2" for="avata">Avata:</label>
          <img id="imgCreate" class="img img-responsive" width="30%" alt="">
          <input type="file" name="image" id="file" onchange="loadFileC(event)">
        </div>
        <br><br>
        <div class="form-group">
          <label class="control-label col-sm-2" for="phone">Phone:</label>        
          <input type="tel" name="phone"  class="form-control" id="phone" value="" placeholder="">
        </div>
        <div class="form-group">
         <label class="control-label col-sm-2" for="name">Address:</label>
         <input type="text" class="form-control" id="address" placeholder="Enter address" name="address">
       </div>
       <div class="portlet-title">
        <div class="form-group">        
          <label class="control-label col-sm-2" for="description">Password:</label>
          <input type="password"  class="form-control" name="password" id='password' placeholder=""> 
        </div>
      </div> 
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" id="StoreBtn" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
</div>
@endsection

@section('js')


{{-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script> --}}

<script type="text/javascript" charset="utf-8">
 var dataTable;
  $(function () {
    $.ajaxSetup({

      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    dataTable=  $('#users-table').DataTable({
      processing: true,
      serverSide: true,
      ajax: '{!! route('users.data') !!}',
      columns: [
      { data: 'id', name: 'id' },
      { data: 'avata', name: 'avata' },
      { data: 'name', name: 'name' },
      { data: 'email', name: 'email' },
      { data: 'phone', name: 'phone' },
      { data: 'address', name: 'address' },
      { data: 'role', name: 'role' },
      { data: 'action', name: 'action' },
      ]
    });
    $('#phone').on('keypress', function(e){
  return e.metaKey || // cmd/ctrl
    e.which <= 0 || // arrow keys
    e.which == 8 || // delete key
    /[0-9]/.test(String.fromCharCode(e.which)); // numbers
  })
    $('#ephone').on('keypress', function(e){
  return e.metaKey || // cmd/ctrl
    e.which <= 0 || // arrow keys
    e.which == 8 || // delete key
    /[0-9]/.test(String.fromCharCode(e.which)); // numbers
  })
    $('#StoreBtn').click(function(e){
      e.preventDefault();
      var file = $('#file').get(0).files[0];
      var newUser = new FormData();
      newUser.append('name', $('#name').val());
      newUser.append('phone', $('#phone').val());
      newUser.append('email', $('#email').val());
      newUser.append('address', $('#address').val());
      newUser.append('password', $('#password').val());
      newUser.append('image', file);
      $.ajax({

        url:'{{asset('admin/users/store')}}',
        data:newUser,
        dataType:'json',
        async:false,
        type:'post',
        processData: false,
        contentType: false,
        success:function(response){
         setTimeout(function () {
           toastr.success('has been added');

         },1000);
                // var data = JSON.parse(response).data;
                dataTable.ajax.reload();
                $('#addUsser').modal('hide');

              }, error: function (xhr, ajaxOptions, thrownError) {
                if (!checkNull(xhr.responseJSON)) {
                  $('p#sperrors').remove();
                  if(!checkNull(xhr.responseJSON.errors.name))
                  {
                    for (var i = 0; i < xhr.responseJSON.errors.name.length; i++) {
                      var html='<p id="sperrors" style="color:red">'+xhr.responseJSON.errors.name[i]+'</p>';
                      $(html).insertAfter('#name');
                    }
                  };
                  if(!checkNull(xhr.responseJSON.errors.email))
                  {
                    for (var i = 0; i < xhr.responseJSON.errors.email.length; i++) {
                      var html='<p id="sperrors" style="color:red">'+xhr.responseJSON.errors.email[i]+'</p>';
                      $(html).insertAfter('#email');
                    }
                  };
                  if(!checkNull(xhr.responseJSON.errors.phone))
                  {
                    for (var i = 0; i < xhr.responseJSON.errors.phone.length; i++) {
                      var html='<p id="sperrors" style="color:red">'+xhr.responseJSON.errors.phone[i]+'</p>';
                      $(html).insertAfter('#phone');
                    }
                  };
                  if(!checkNull(xhr.responseJSON.errors.address))
                  {
                    for (var i = 0; i < xhr.responseJSON.errors.address.length; i++) {
                      var html='<p id="sperrors" style="color:red">'+xhr.responseJSON.errors.address[i]+'</p>';
                      $(html).insertAfter('#address');
                    }
                  };
                  if(!checkNull(xhr.responseJSON.errors.password))
                  {
                    for (var i = 0; i < xhr.responseJSON.errors.password.length; i++) {
                      var html='<p id="sperrors" style="color:red">'+xhr.responseJSON.errors.password[i]+'</p>';
                      $(html).insertAfter('#password');
                    }
                  };
                  toastr.error(xhr.responseJSON.message);
                }
              },

            })
    });

    function checkNull(value){
      return (value == null || value === '');
    }


    $('#UpdateBtn').on('click',function(e){
     e.preventDefault();
     var file = $('#editfile').get(0).files[0];
     var editUser = new FormData();
     editUser.append('name', $('#ename').val());
     editUser.append('phone', $('#ephone').val());
     editUser.append('email', $('#eemail').val());
     editUser.append('address', $('#eaddress').val());
     editUser.append('id', $('#eid').val());
     editUser.append('image', file);
     $.ajax({

      url:'{{asset('admin/users/update')}}',
      data:editUser,
      dataType:'json',
      async:false,
      type:'post',
      processData: false,
      contentType: false,
      success: function(response){
        setTimeout(function () {
          toastr.success(response.name+'has been added');
        },1000);

        $('#editUser').modal('hide');
        dataTable.ajax.reload();
      }, error: function (xhr, ajaxOptions, thrownError) {
        if (!checkNull(xhr.responseJSON.errors)) {
          $('p#sperrors').remove();
          if(!checkNull(xhr.responseJSON.errors.name))
          {
            for (var i = 0; i < xhr.responseJSON.errors.name.length; i++) {
              var html='<p id="sperrors" style="color:red">'+xhr.responseJSON.errors.name[i]+'</p>';
              $(html).insertAfter('#ename');
            }
          };
          if(!checkNull(xhr.responseJSON.errors.email))
          {
            for (var i = 0; i < xhr.responseJSON.errors.email.length; i++) {
              var html='<p id="sperrors" style="color:red">'+xhr.responseJSON.errors.email[i]+'</p>';
              $(html).insertAfter('#eemail');
            }
          };
          if(!checkNull(xhr.responseJSON.errors.phone))
          {
            for (var i = 0; i < xhr.responseJSON.errors.phone.length; i++) {
              var html='<p id="sperrors" style="color:red">'+xhr.responseJSON.errors.phone[i]+'</p>';
              $(html).insertAfter('#ephone');
            }
          };
          if(!checkNull(xhr.responseJSON.errors.address))
          {
            for (var i = 0; i < xhr.responseJSON.errors.address.length; i++) {
              var html='<p id="sperrors" style="color:red">'+xhr.responseJSON.errors.address[i]+'</p>';
              $(html).insertAfter('#eaddress');
            }
          };
          if(!checkNull(xhr.responseJSON.errors.password))
          {
            for (var i = 0; i < xhr.responseJSON.errors.password.length; i++) {
              var html='<p id="sperrors" style="color:red">'+xhr.responseJSON.errors.password[i]+'</p>';
              $(html).insertAfter('#epassword');
            }
          };
          toastr.error(xhr.responseJSON.message);
        }
      },
    })
   });

  })



  // Delete function
      function setStatus(id){
        swal({
          title: "Bạn có chắc muốn thay đổi trạng thái?",
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
            type: "get",
            url: "/admin/user/status/"+id,
            success: function(res)
            {

              if(!res.error) {
                toastr.success('Thay đổi trạng thái thành công thành công!');
                $('#product-'+id).remove();
                  setTimeout(function () {
                    location.reload();
                  }, 1000)
                }
              },
              error: function (xhr, ajaxOptions, thrownError) {
                toastr.error(thrownError);
              }
            });
        } else {
          toastr.error("Thao tác đã bị huỷ bỏ!");
        }
      });
      };
     

  // Delete function
      function alDelete(id){
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
            url: "/admin/user/"+id,
            success: function(res)
            {

              if(!res.error) {
                toastr.success('Xóa thành công!');
                $('#product-'+id).remove();
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
      function wareHousingDelete(id){
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
            url: "wareHousingDelete/"+id,
            success: function(res)
            {

              if(!res.error) {
                toastr.success('Xóa thành công!');
                $('#wareHousing-'+id).remove();
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



 function changeStatus(id){
        swal({
          title: "Are you sure to change?",
        // text: "Bạn sẽ không thể khôi phục lại bản ghi này!!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",  
        cancelButtonText: "No",
        confirmButtonText: "Yes",
        // closeOnConfirm: false,
      },
      function(isConfirm) {
        if (isConfirm) {
          $.ajax({
            type: "post",
            url: "/admin/api/status/users/"+id,
            data: {
              role:$('#role_'+id).val()
            },
            dataType:'json',
            success: function(res)
            {
              if(!res.error) {
                toastr.success('Success!');

                dataTable.ajax.reload();
              }
            },
            error: function (xhr, ajaxOptions, thrownError) {
              toastr.error(thrownError);
            }
          });
        } else {
          toastr.error("Cancel!");
        }
      });
      };



</script>

@endsection