@extends('layouts.adminheader')
@section('css')
<style type="text/css" media="screen">
  .half-form{
    width: 50%;
    padding: 10px;
    float: left;

  }
  .modal-dialog{
    width: 100%;
  }

</style>
@endsection
@section('content')

<div class="container">



  <br><br>
  <a class="btn btn-primary" data-toggle="modal" href='#addProduct'>+Add Product</a>

  <br><br>
  <table class="table table-bordered" id="users-table">
    <thead>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Image</th>
        <th>Cost</th>
        <th>Created Date</th>
        <th>Action</th>
      </tr>
    </thead>
  </table>
</div>
<!-- modal add product -->
<div class="modal fade" id="addProduct">
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
{{-- edit product modal  --}}

<!-- modal add quantity product -->
<div class="modal fade" id="wareHousing">
  <div class="modal-dialog" style="max-width: 700px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">This product are available: <span id="quantity"></span> </h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="quantity">Add Number Quantity</label>
          <input class="form-control" type="number" id="quantity-number-add" name="number" value="0" style="float: left; width: 80%" placeholder="Add Number Quantity ...">
          <button type="button" class="btn btn-xs btn-success fa fa-plus" style="float: right;width: 35px;height: 35px;" id="addQuantity"></button>
        </div>
        <input type="hidden" name="wid" id="wid">
        <br>
        <br>
        <br>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>
{{-- edit product modal  --}}


<div class="modal fade" id="editProduct">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Modal title</h4>
      </div>
      <div class="half-form">
       <div class="form-group">
        <label for="">Name</label>
        <input type="text" class="form-control" id="ename" placeholder="Input field">
      </div>
      <div class="form-group">
        <label for="">Cost</label>
        <input type="text" class="form-control" id="ecost" placeholder="Input field">
      </div>
      <div class="form-group">
        <label for="">Category</label>
        <select name="category" id="ecategory_id" class="form-control" >
          @foreach ($categories as $category)
          <option value="{{$category['id']}}" selected>{{$category['name']}}</option>
          @endforeach
        </select>
      </div>
      <div id="eimage_preview">

      </div>
      <div class="form-group">
        <label for="">Images</label>
        <input type="file" id="efile" class="form-control" name="efiles" />
      </div>

    </div>                       
    <div class="half-form">
      <div class="form-group">
        <label for="">Descripton</label>
        <textarea name="description" id="edescription"class="form-control"></textarea>
      </div>
      <div class="form-group">
        <label for="">Content</label>
        <textarea name="econtent"></textarea>
      </div>
    </div>
    <input type="hidden" id="eid" name="eid">
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      <button type="button" id="UpdateBtn" class="btn btn-primary">Save changes</button>
    </div>
  </div>
</div>
</div>


@endsection

@section('js')
<script src="https://cdn.ckeditor.com/4.9.2/standard/ckeditor.js"></script>

<script>
  CKEDITOR.replace( 'content' );
  CKEDITOR.replace( 'econtent' );
  CKEDITOR.editorConfig = function( config ) {
        // Define changes to default configuration here. For example:
        // config.language = 'fr';
        // config.uiColor = '#AADC6E';
        config.width = '400px';

      };
    </script>
    {{-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script> --}}
    
    <script type="text/javascript" charset="utf-8">
      $(function () {
        $.ajaxSetup({

          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
        var tableData=$('#users-table').DataTable({
          processing: true,
          serverSide: true,
          ajax: '{!! route('datatables.data') !!}',
          columns: [
          { data: 'id', name: 'id' },
          { data: 'name', name: 'name' },
          { data: 'image', name: 'image' },
          { data: 'cost', name: 'cost' },
          { data: 'updated_at', name: 'updated_at' },
          { data: 'action', name: 'action' },
          ]
        });
        $("#files").change(function(){
         $('#image_preview').html("");
         var total_file=document.getElementById("files").files.length;
         console.log(document.getElementById("files").files);
         for(var i=0;i<total_file;i++)
         {
          $('#image_preview').append("<img class'img-responsive img' style='width:50px' src='"+URL.createObjectURL(event.target.files[i])+"'>");
        }

      });

        $('#StoreBtn').on('click',function(e){
          e.preventDefault();
          var content = CKEDITOR.instances.content.getData();
          var file = document.getElementById('file').files[0];
          
          var newPost = new FormData();
          newPost.append('name',$('#name').val());
          newPost.append('description',$('#description').val());
          newPost.append('content',content);
          newPost.append('category_id',$('#category_id').val());
          newPost.append('cost',$('#cost').val());
          newPost.append('image',file);
          
          $.ajax({
            type:'post',
            url:"product/store",
            data:newPost,
            dataType:'json',
            async:false,
            processData: false,
            contentType: false,
            success:function(response){
             console.log(response);
             setTimeout(function () {
               toastr.success('has been added');
                  // window.location.href="";
                  // 
                },1000);
                // var data = JSON.parse(response).data;
                $('#addProduct').modal('hide');
                tableData.ajax.reload();
              }, error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr);
                if (!checkNull(xhr.responseJSON)) {
                  $('p#sperrors').hide();
                  if(!checkNull(xhr.responseJSON.errors.name))
                  {
                    for (var i = 0; i < xhr.responseJSON.errors.name.length; i++) {
                      var html='<p id="sperrors" style="color:red">'+xhr.responseJSON.errors.name[i]+'</p>';
                      console.log(html);
                      $(html).insertAfter('#name');

                    }
                  };
                  if(!checkNull(xhr.responseJSON.errors.content))
                  {
                    for (var i = 0; i < xhr.responseJSON.errors.content.length; i++) {
                      var html='<p id="sperrors" style="color:red">'+xhr.responseJSON.errors.content[i]+'</p>';
                      console.log(html);
                      $(html).insertAfter('#contentdiv');

                    }
                  };
                  if(!checkNull(xhr.responseJSON.errors.description))
                   {console.log('test ok');
                 for (var i = 0; i < xhr.responseJSON.errors.description.length; i++) {
                  var html='<p id="sperrors" style="color:red">'+xhr.responseJSON.errors.description[i]+'</p>';
                  console.log(html);
                  $(html).insertAfter('#description');

                }
              };
              if(!checkNull(xhr.responseJSON.errors.sale_cost))
              {
                for (var i = 0; i < xhr.responseJSON.errors.sale_cost.length; i++) {
                  var html='<p id="sperrors" style="color:red">'+xhr.responseJSON.errors.sale_cost[i]+'</p>';
                  console.log(html);
                  $(html).insertAfter('#tag');

                }
              }
              if (!checkNull(xhr.responseJSON.message)) {

                toastr.error(xhr.responseJSON.message);
              }
            };

          },

        })
        });

        $('#UpdateBtn').on('click',function(e){
          e.preventDefault();
          var econtent = CKEDITOR.instances.econtent.getData();
          var efile = document.getElementById('efile').files[0];
          var updatePost = new FormData();
          updatePost.append('id',$('#eid').val());
          updatePost.append('name',$('#ename').val());
          updatePost.append('description',$('#edescription').val());
          updatePost.append('content',econtent);
          updatePost.append('category_id',$('#ecategory_id').val());
          updatePost.append('ecost',$('#ecost').val());
          console.log(updatePost);
          for (var i = 0; i < efiles.length; i++) {

            updatePost.append('image',efile);
          }  $.ajax({
            type:'post',
            url: "product/update",

            data:updatePost,
            dataType:'json',
            async:false,
            processData: false,
            contentType: false,
            success: function(response){
              console.log(response);
        // var result = JSON.parse(response);
        setTimeout(function () {
          toastr.success(response.name+'has been added');
          // window.location.href="";
        },1000);
        
        $('#editProduct').modal('hide');
        
        tableData.ajax.reload();
      },  error: function (xhr, ajaxOptions, thrownError) {
        $("p.sperrors").replaceWith("");
        if (!checkNull(xhr.responseJSON)) {


          if(!checkNull(xhr.responseJSON.errors.name))
          { 
            for (var i = 0; i < xhr.responseJSON.errors.name.length; i++) {
              var html='<p class="sperrors" style="color:red">'+xhr.responseJSON.errors.name[i]+'</p>';
              $(html).insertAfter('#ename');

            }
          };
          if(!checkNull(xhr.responseJSON.errors.content))
          {
            for (var i = 0; i < xhr.responseJSON.errors.content.length; i++) {
              var html='<p class="sperrors" style="color:red">'+xhr.responseJSON.errors.content[i]+'</p>';
              $(html).insertAfter('#econtentdiv');

            }
          };
          if(!checkNull(xhr.responseJSON.errors.description))
          {
            for (var i = 0; i < xhr.responseJSON.errors.description.length; i++) {
              var html='<p  class="sperrors" style="color:red">'+xhr.responseJSON.errors.description[i]+'</p>';
              $(html).insertAfter('#edescription');

            }
          };
          if(!checkNull(xhr.responseJSON.errors.sale_cost))
          {
            for (var i = 0; i < xhr.responseJSON.errors.sale_cost.length; i++) {
              var html='<p class="sperrors" style="color:red">'+xhr.responseJSON.errors.sale_cost[i]+'</p>';
              $(html).insertAfter('#etag');

            }
          };
        };

      },

    })
        });
      })


  // get data for form update
  function getProduct(id) {
    console.log(id);
        // $('#editPost').modal('show');

        $.ajax({
          type: "GET",
          url: "{{ asset('admin/getProduct') }}/"+id,

          success: function(response)
          {
            $('#eimage_preview').html("");
            CKEDITOR.instances.econtent.setData(response.content);
            $('#ename').val(response.name);
            $('#edescription').val(response.description);
            $("#ecost").val(response.cost);
            $('#ecategory_id').val(response.category_id);
            $('#eid').val(response.id);
            for (var i = 0; i < response.images.length; i++) {
             html="<img src='"+response.images[i].link+"' class='img-responsive img' style='display:inline-block;width:50px'>";
             $('#eimage_preview').append(html);
           }         
         },
         error: function (xhr, ajaxOptions, thrownError) {
          toastr.error(thrownError);
        }
      });

      }

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
            url: "product/"+id,
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
      function checkNull(value){
        return (value == null || value === '');
      }
      $('#sale_cost').on('keypress', function(e){
  return e.metaKey || // cmd/ctrl
    e.which <= 0 || // arrow keys
    e.which == 8 || // delete key
    /[0-9]/.test(String.fromCharCode(e.which)); // numbers
  })
      $('#esale_cost').on('keypress', function(e){
  return e.metaKey || // cmd/ctrl
    e.which <= 0 || // arrow keys
    e.which == 8 || // delete key
    /[0-9]/.test(String.fromCharCode(e.which)); // numbers
  })
      $('#cost').on('keypress', function(e){
  return e.metaKey || // cmd/ctrl
    e.which <= 0 || // arrow keys
    e.which == 8 || // delete key
    /[0-9]/.test(String.fromCharCode(e.which)); // numbers
  })
      $('#ecost').on('keypress', function(e){
  return e.metaKey || // cmd/ctrl
    e.which <= 0 || // arrow keys
    e.which == 8 || // delete key
    /[0-9]/.test(String.fromCharCode(e.which)); // numbers
  })

      function wareHousing(id){
        console.log(id);
        // $('#editPost').modal('show');

        $.ajax({
          type: "GET",
          url: "{{ asset('admin/getProduct') }}/"+id,

          success: function(response)
          {
            $('#quantity').text(response.quantity);     
            $('#wid').val(response.id);     
          },
          error: function (xhr, ajaxOptions, thrownError) {
            toastr.error(thrownError);
          }
        });
      }
      $('#addQuantity').on('click',function(e){
        var id = $('#wid').val();
        $.ajax({
          type:'post',
          url: "/admin/product/add/quantity/"+id,

          data:{
            addNumber:$('#quantity-number-add').val()
          },
          dataType:'json',
          success: function(response){
            wareHousing(id);
            $('#quantity-number-add').val(0);
          toastr.success(response.name+' has been add quantity');
      },  error: function (xhr, ajaxOptions, thrownError) {
        toastr.error(thrownError);
      }
    })
      })
    </script>

    @endsection