@extends('backend.index')
@section('title','Permission List')
@section('main-content')

  <div class="row">
    <div class="col-md-12">
      <!-- Button trigger modal -->
  <button type="button" class="btn btn-primary rounded" id="addpermission">
    Add New
  </button>
      <div class="card" >
        <div class="card-header card-header-primary text-white"  >
          <h4 class="card-title ">Roles and Permission</h4>
          <p class="card-category text-white"> List of all the Roles & Permissions</p>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-stripped table-official " id="permissiontable" style="background:rgba(0,0,0,0);
            color:white !important;">
              <thead class=" text-primary">
                <th>
                  ID
                </th>
                <th>
                  Name
                </th>
                <th>
                  Display Name
                </th>
                <th>Description</th>
                <th>
                  Created At
                </th>
                <th>
                    Updated At
                </th>
                <th>
                  Action
                </th>
              </tr>
              @foreach($permission as $permission)
                <tr>
                  <td>{{$permission->id}}</td>
                  <td>{{$permission->name}}</td>
                  <td>{{$permission->display_name}}</td>
                  <td>{{$permission->description}}</td>
                  <td>{{$permission->created_at}}</td>
                  <td>{{$permission->updated_at}}</td>
                  <td>
                    <button class="btn btn-sm btn-info " id="editpermission" data-id="{{$permission->id}}" data-name="{{$permission->name}}" data-display="{{$permission->display_name}}" data-description="{{$permission->description}}">Edit</button>
                      <button class="btn btn-sm btn-danger deletepermission" data-id="{{$permission->id}}"  >Delete</button>
                  </td>
                </tr>
              @endforeach
              </thead>

            </table>
          </div>
        </div>
      </div>
    </div>
  </div>


   <!-- Modal for adding new admin -->


      <div class="modal fade bd-example-modal-lg " id="permissionmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document" >
          <div class="modal-content bg-dark">
            <div class="modal-header bg-official" >
              <h5 class="modal-title text-white font-weight-bold text-uppercase" id="modaltitle">New Permission</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
         <form id="permissionform" action="#" method="POST" >
                {{ csrf_field() }}
                <input type="hidden" id="newid" name="newid">
                <div class="form-group">
                  <label>Permission name</label><br>
                  <input type="text" class="form-control" data-parsley-maxlength="100" id="name" placeholder="Permission Name" name="name">
                  <span class="text-danger" id="namerror"></span>

                </div><br>
                <div class="form-group">
                  <label>Display Name</label><br>

                  <input type="text" class="form-control" id="display_name" placeholder="Display Name" name="display_name" >
                  <span class="text-danger" id="display_nameerror"></span>
                </div><br>
                <div class="form-group">
                  <label>Description</label><br>

                <textarea class="form-control" name="description" id="description" placeholder="Description"></textarea>
                <span class="text-danger" id="descriptionerror"></span>

                </div>


              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-warning" data-dismiss="modal" style="display:none;" id="delete">Delete</button>
                <button type="button" id="close" class="btn btn-danger" data-dismiss="modal">Close</button>
                <input type="reset" id="reset" class="btn btn-warning btn-md">
                <button  id="add" value="Add" class="btn btn-primary btn-md" style="display:none;">Add</button>
                <button id="update" value="Update" class="btn btn-primary btn-md" style="display:none;">Update</button>
              </div>
                        </form>
          </div>
        </div>
      </div>


  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script type="text/javascript">

  CKEDITOR.replace( 'description' );

  </script>
</script>
<script type="text/javascript">
$(document).on('click','#addpermission',function(){
  $('#permissionmodal').modal('show');
  $('#add').show();
  $('#update').hide();
  $('#modaltitle').text('Add Permission');
  $('#name').val('');
  $('#display_name').val('');
  $('#description').val('');
});
$(document).on('click','#editpermission',function(){
  // alert('edit');
  $('#permissionmodal').modal('show');
  $('#add').hide();
  $('#update').show();
  $('#modaltitle').text('Edit Permission');
  let name=$(this).data('name');
  let display=$(this).data('display');
  let description=$(this).data('description');
  let id=$(this).data('id');
  $('#name').val(name);
  $('#display_name').val(display);
  $('#description').val(description);
  $('#newid').val(id);
})

$('#permissionform').submit(function(e){
  e.preventDefault();

  var form=$(this);
  var formData= new FormData($(this)[0]);
  var name=$('#name').val();
  var display_name=$('#display_name').val();
  var description=$('#description').val();
  var table='#permissiontable';
  var modal='#permissionmodal';
  var url='permission';
  var id=$('#newid').val();
  functionforall(id,table,modal,url,formData)
});

function functionforall(id,table,modal,url,formData)
{

  var route;
  var method;
  if(id=="")
  {
    route=url;
    method='POST';
  }
  else {
    route= url+'/'+id;
    method='POST';
    formData.append('_method','PUT');
  }

$.ajax({
  url:route,
  type:method,
  data:formData,
  dataType:'json',
  cache:false,
  contentType:false,
  processData:false,
  success:function(data){
    console.log(data);
    if(data.output=="inserted")
    {

    $(modal).modal('hide');
    // $(table).DataTable().ajax.reload();
    $('#permissiontable').load(location.href + ' #permissiontable');

     //successmessage("success","The data has been inserted","#fec107","success")
     toastr.success('New Permission has been added!!', 'Successfully Added', {timeOut: 5000});
  }
  if(data.output=="updated")
  {
    $(modal).modal('hide');
    $('#permissiontable').addClass('table-official');
    $('#permissiontable').load(location.href + ' #permissiontable');

     toastr.success('Permission has been updated!!', 'Successfully Updated', {timeOut: 5000});
  }


},

    error:function(error) {
       toastr.danger('New admin has been added!!', 'Successfully Added', {timeOut: 5000})
  //console.log(xhr.responseText);
}
});
}


$(document).on('click','.deletepermission',function(e){
e.preventDefault();
var id=$(this).data('id');
var route='permission/'+id;
var table='#permissiontable';
var token="{{csrf_token()}}";
// alert(id);

deletefunction(id,route,table,token);
});

function deletefunction(id,route,table,token)
{
  // alert('down under');
  $.ajax({
    url:route,
    method:'Delete',
    data:{'_token':token},
    dataType:'json',
    success:function(data){
      console.log(data);
      if(data.output=='deleted')
      {
        // alert('deleted');
        toastr.success('Permission has been deleted!!','Successfully deleted',{timeOut:5000});
        $('#permissiontable').load(location.href + ' #permissiontable');
        $('#permissiontable').addClass('table-official');
      }
    }
  });
}



</script>
  @endsection
  {{-- @section('scripts')
@endsection --}}
