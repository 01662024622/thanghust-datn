
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
//____________________________________________________________________________________________________
var dataTable = $('#users-table').DataTable({
  processing: true,
  serverSide: true,
  ajax: "/api/v1/category/table",
  columns: [
  { data: 'id', name: 'id' },
  { data: 'name', name: 'name' },
  { data: 'parent_id', name: 'parent_id' },
  { data: 'created_at', name: 'created_at' },
  { data: 'status', name: 'status' },
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
    }
  },
  messages: {
    name: {
      required: "Enter your name",
      minlength: "Leaste 5 word"
    }
    
  },
  submitHandler: function(form) {

    var formData = new FormData(form);
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
  $("#edit-form").submit(function(e){
    e.preventDefault();
  }).validate({
    rules: {
      name: {
        required: true,
        minlength: 5
      }
    },
    messages: {
      name: {
        required: "Enter your name",
        minlength: "Leaste 5 word"
      }

    },
    submitHandler: function(form) {
      var updateData = new FormData(form);
      $.ajax({
        url: form.action+"/"+$('#eid').val(),
        type: form.method,
        data: updateData,
        headers: {"Access-Control-Allow-Methods": "GET, POST, PATCH, PUT, DELETE"},
        dataType:'json',
        async:false,
        processData: false,
        contentType: false,
        success: function(response) {
         setTimeout(function () {
           toastr.success('has been updated');
         },1000);
         $("#edit-modal").modal('hide');
         dataTable.ajax.reload();
       }, error: function (xhr, ajaxOptions, thrownError) {
        toastr.error(thrownError);
      },       
    });
    }
  });

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
            url: "categories/"+id,
            success: function(res)
            {
              if(!res.error) {
                toastr.success('Success!');
                $('#data-'+id).remove();
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




    // })
//_________

function getInfo(id) {
  console.log(id);
        // $('#editPost').modal('show');
        $.ajax({
          type: "GET",
          url: "/categories/"+id,
          success: function(response)
          {
            $('#ename').val(response.name);
            $('#eparent_id').val(response.parent_id);
            $('#eid').val(response.id);    
          },
          error: function (xhr, ajaxOptions, thrownError) {
            toastr.error(thrownError);
          }
        });
      }

      function changeStatus(id) {
        console.log(id);
        // $('#editPost').modal('show');
        $.ajax({
          type: "GET",
          url: "api/status/categories/"+id,
          success: function(response)
          {
          // location.reload();
          
         dataTable.ajax.reload();
           toastr.success('has been updated');
          },
          error: function (xhr, ajaxOptions, thrownError) {
            toastr.error(thrownError);
          }
        });
      }