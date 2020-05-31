
$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});
//____________________________________________________________________________________________________
var dataTable = $('#users-table').DataTable({
  processing: true,
  serverSide: true,
  ajax:{ type: "GET",
  url: "/api/v1/users/table",
  error: function (xhr, ajaxOptions, thrownError) {
   if (xhr!=null) {
    if (xhr.responseJSON!=null) {
      if (xhr.responseJSON.errors!=null) {
        if (xhr.responseJSON.errors.permission!=null) {
          location.reload();
        }
      }
    }
  }
}},
columns: [
{ data: 'id', name: 'id' },
{ data: 'name', name: 'name' },
{ data: 'email', name: 'email' },
{ data: 'phone', name: 'phone' },
{ data: 'address', name: 'address' },
{ data: 'role', name: 'role' },
{ data: 'action', name: 'action' },
]
});
//____________________________________________________________________________________________________

//____________________________________________________________________________________________________
$("#add-form").submit(function(e){
  e.preventDefault();
}).validate({
  rules: {
    name: {
      required: true,
      minlength: 5
    },
    phone:{
      required:true,
      minlength:10,
      maxlength:10,
    },
    email:{
      required:true,
      minlength:10,
    },
    room:{
      required:true,
    },
  },
  messages: {
    name: {
      required: "Enter your name",
      minlength: "Leaste 5 word"
    },
    name: {
      required: "Enter your name",
      minlength: "Leaste 5 word"
    },
    phone:{
      required:"Enter your phone",
      minlength:"Leaste has 10 number",
      maxlength:"Leaste has 10 number",
    },
    email:{
      required:"Enter your email",
      minlength:"This not email",
    },
    room:{
      required:"Enter your room",
    },
    password:{
      required:"Enter your password",
      minlength:"Leaste 8 word",
    },
    email:{
      required:"Enter your email",
      minlength:"Leaste 8 word",
    },
    
  },
  submitHandler: function(form) {
    var formData = new FormData(form);
    if ($('#eid').val()=='') {
      formData.delete('id');
    }

    $.ajax({
      url: form.action,
      type: form.method,
      data: formData,
      dataType:'json',
      async:false,
      processData: false,
      contentType: false,
      success: function(response) {
       setTimeout(function () {
         toastr.success('has been added');
       },1000);
       $("#add-modal").modal('toggle');
       dataTable.ajax.reload();
     }, error: function (xhr, ajaxOptions, thrownError) {
      toastr.error(thrownError);
    },       
  });
  }
});


  // get data for form update
  function getInfo(id) {
    console.log(id);
        // $('#editPost').modal('show');
        $.ajax({
          type: "GET",
          url: "/users/"+id,
          success: function(response)
          {
           $('#name').val(response.name);
           $('#email').val(response.email);
           $('#phone').val(response.phone);
           $('#room').val(response.room);
           $('#apartment_id').val(response.apartment_id);
           $('#eid').val(response.id);
           $('.tag_pass').remove();
         },
         error: function (xhr, ajaxOptions, thrownError) {
          toastr.error(thrownError);
        }
      });
      }



//____________________________________________________________________________________________________

//____________________________________________________________________________________________________
    // Update function
      // Delete function
      function alDelete(id){
        swal({
          title: "Are you sure to remove?",
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
            type: "delete",
            url: "users/"+id,
            success: function(res)
            {
              if(!res.error) {
                toastr.success('Success!');
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
          toastr.error("Cancel!");
        }
      });
      };

      $(function(){
        var viewModel = {};
        viewModel.fileData = ko.observable({
          dataURL: ko.observable(),
    // base64String: ko.observable(),
  });
        viewModel.multiFileData = ko.observable({
          dataURLArray: ko.observableArray(),
        });
        viewModel.onClear = function(fileData){
          if(confirm('Are you sure?')){
            fileData.clear && fileData.clear();
          }                            
        };
        viewModel.debug = function(){
          window.viewModel = viewModel;
          console.log(ko.toJSON(viewModel));
          debugger; 
        };
        ko.applyBindings(viewModel);
      });


      function clearForm(){
        $('#add-form')[0].reset(); 

        $('.tag_pass').remove();
        $('#eid').val(''); 
        $('.modal-body').append(`<div class="form-group tag_pass">
          <label for="name">Password</label>
          <input type="password" class="form-control" id="password" name="password"  placeholder="Enter password">
          </div>
          <div class="form-group tag_pass">
          <label for="name">Re-Password</label>
          <input type="password" class="form-control" id="repassword" name="repassword"  placeholder="Enter password">
          </div>
          <input type="hidden" name="id" id="eid">`);
      }



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
            url: "/api/status/users/"+id,
            data: {
              role:$('#apartment_id_'+id).val()
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
