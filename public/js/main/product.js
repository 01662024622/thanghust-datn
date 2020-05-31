  CKEDITOR.replace( 'description' );
  // CKEDITOR.replace( 'econtent' );
  CKEDITOR.editorConfig = function( config ) {
        // Define changes to default configuration here. For example:
        // config.language = 'fr';
        // config.uiColor = '#AADC6E';
        config.width = '400px';
      };
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
  url: "/api/v1/product/table",
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
    // location.reload();
  }},
  columns: [
  { data: 'id', name: 'id' },
  { data: 'name', name: 'name' },
  { data: 'image', name: 'image' },
  { data: 'category_id', name: 'category_id' },
  { data: 'providor', name: 'providor' },
  // { data: 'created_at', name: 'created_at' },
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
    },
    description:{
      required:true,
      minlength:10,
    },
  },
  messages: {
    name: {
      required: "Enter your name",
      minlength: "Leaste 5 word"
    },
    image: {
      required: "Enter your image",
      minlength: "Leaste 5 word"
    },
    description: {
      required: "Write descripton, plz",
      minlength: "Write descripton, plz",
    },
    
  },
  submitHandler: function(form) {
    var formData = new FormData(form);
    var description = CKEDITOR.instances.description.getData();

    formData.set('description',description);
    if ($('#image').val()=='') {
      formData.delete('image');
    }
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
          url: "/products/"+id,
          success: function(response)
          {
            CKEDITOR.instances.description.setData(response.description);
            $('#name').val(response.name);
            $('#category_id').val(response.category_id);
            $('#quantity').val(response.quantity);
            $('#eid').val(response.id);    
            $('#imgImage').attr('src',response.image);
            $('#imgImage').show();
          },
          error: function (xhr, ajaxOptions, thrownError) {
            toastr.error(thrownError);
          }
        });
      }
function changeStatusManager(id) {

  $.ajax({
          type: "POST",
          url: "api/status/staffProduct",
          data:{
            product_id:$("#staff-product").val(),
            staff_id:id,
          },
          success: function(response)
          {
          // location.reload();
          manager.ajax.reload();
          
         dataTable.ajax.reload();
           toastr.success('has been updated');
          },
          error: function (xhr, ajaxOptions, thrownError) {
            toastr.error(thrownError);
          }
        });
  // body...
}
var manager;
  // get data for form update
  function staff(id) {
    $("#manager-table").dataTable().fnDestroy()
    console.log(id);
$('#staff-product').val(id);
manager = $('#manager-table').DataTable({
  processing: true,
  serverSide: true,
  ajax:{ type: "GET",
  url: "/api/v1/staff/manager/table/"+id,
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
    // location.reload();
  }},
  columns: [
  { data: 'id', name: 'id' },
  { data: 'name', name: 'name' },
  { data: 'image', name: 'image' },
  { data: 'phone', name: 'phone' },
  { data: 'email', name: 'email' },
  { data: 'status', name: 'status' },
  { data: 'action', name: 'action' },
  ]
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
            url: "products/"+id,
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
      function changeStatus(id) {
        console.log(id);
        // $('#editPost').modal('show');
        $.ajax({
          type: "GET",
          url: "api/status/products/"+id,
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

      function clearForm(){
        console.log('clear');
        $('#add-form')[0].reset(); 
        $('#eid').val(''); 
        CKEDITOR.instances.description.setData('');

        $('#imgImage').hide();
      }