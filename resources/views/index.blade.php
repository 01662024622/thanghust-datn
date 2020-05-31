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

<div class="modal fade" id="bill-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Modal title</h4>
      </div>
      <div class="half-form">
       <div class="form-group">
        <label for="">Name</label>
        <input type="text" class="form-control" id="name" placeholder="Input field">
      </div>
      <div class="form-group">
        <label for="">Cost</label>
        <input type="text" class="form-control" id="cost" placeholder="Input field">
      </div>
      <div class="form-group">
        <label for="">Category</label>
        <select name="category" id="category_id" class="form-control" >
         @foreach ($categories as $category)
         <option value="{{$category['id']}}" selected>{{$category['name']}}</option>
         @endforeach
       </select>
     </div>
     <div id="image_preview"></div>
     <div class="form-group">
      <label for="">Images</label>
      <input type="file" id="file" class="form-control" name="file" />
    </div>

  </div>                       
  <div class="half-form">
    <div class="form-group">
      <label for="">Descripton</label>
      <textarea name="description" id="description" class="form-control"></textarea>
    </div>
    <div class="form-group">
      <label for="">Content</label>
      <textarea name="content"></textarea>
    </div>
  </div>

  <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    <button type="button" id="StoreBtn" class="btn btn-primary">Save changes</button>
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
            $('#pending-bottom').html('');
          },
          error: function (xhr, ajaxOptions, thrownError) {
            toastr.error(thrownError);
          }
        });
      }

  </script>
  @endsection
