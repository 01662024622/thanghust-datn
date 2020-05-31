
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
//____________________________________________________________________________________________________
var dataTable = $('#users-table').DataTable({
  processing: true,
  serverSide: true,
  ajax: "/api/v1/orders/table",
  columns: [
  { data: 'id', name: 'id' },
  { data: 'user', name: 'user' },
  { data: 'email', name: 'email' },
  { data: 'phone', name: 'phone' },
  { data: 'address', name: 'address' },
  { data: 'product', name: 'product' },
  { data: 'staffs', name: 'staffs' },
  { data: 'created_at', name: 'created_at' },
  { data: 'status', name: 'status' },
  ]
});



      function changeStatus(id) {
        console.log(id);
        // $('#editPost').modal('show');
        $.ajax({
          type: "POST",
          url: "api/status/orders/"+id,
          data:{
            status:$('#status_'+id)
          },
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