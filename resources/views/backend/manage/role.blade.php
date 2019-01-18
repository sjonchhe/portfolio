@extends('backend.index')
@section('title','Roles')

@section('main-content')

  <div class="row">
    <div class="col-md-12">
      <!-- Button trigger modal -->
  <button type="button" class="btn btn-primary rounded" id="addrole">
    Add New
  </button>
      <div class="card" >
        <div class="card-header card-header-primary text-white"  >
          <h4 class="card-title ">Roles</h4>
          <p class="card-category text-white"> List of all Roles</p>
        </div>
        <div class="card-body">
          <div class="table-responsive">

            <table class="table table-stripped table-official " id="roletable" style="background:rgba(0,0,0,0);color:white !important;">
              <thead class="text-primary">
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
            </thead>
            <tbody>
              @foreach($role as $role)
                <tr>
                  <td>{{$role->id}}</td>
                  <td>{{$role->name}}</td>
                  <td>{{$role->display_name}}</td>
                  <td>{{$role->description}}</td>
                  <td>{{$role->created_at}}</td>
                  <td>{{$role->updated_at}}</td>
                  <td>
                    <button class="btn btn-sm btn-info " id="editpermission"><a href="{{route('role.show')}}">View/Edit</a></button>
                      <button class="btn btn-sm btn-danger deleterole" data-id="{{$role->id}}"  >Delete</button>
                  </td>
                </tr>
              @endforeach
            </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>


   <!-- Modal for adding new role -->


      <div class="modal fade bd-example-modal-lg " id="rolemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document" >
          <div class="modal-content bg-dark">
            <div class="modal-header bg-official" >
              <h5 class="modal-title text-white font-weight-bold text-uppercase" id="modaltitle">New Role</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
         <form id="roleform" action="#" method="POST" >
                {{ csrf_field() }}
                <input type="hidden" id="newid" name="newid">
                <div class="form-group">
                  <label>Role name</label><br>
                  <input type="text" class="form-control" data-parsley-maxlength="100" id="name" placeholder="Role Name" name="name">
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

$(document).on('click','#addrole',function(){
  // $('#addrole').click(function(){
  $('#rolemodal').modal('show');
  $('#add').show();
  $('#update').hide();
});
$('#roleform').submit(function(e){
  e.preventDefault();
  var form=$(this);
  var formData=new FormData($(this)[0]);
  var name=$('#name').val();
  var display_name=$('#display_name').val();
  var description=$('#description').val();
  var table='#roletable';
  var modal='#rolemodal';
  var url='role';
  var method='POST';
  addrole(url,table,modal,formData,method)
});

function addrole(url,table,modal,formData,method)
{
  // alert('adasd');
  $.ajax({
    url:url,
    type:method,
    data:formData,
    dataType:'json',
    cache:false,
    contentType:false,
    processData:false,
    success:function(data){
      console.log(data);

      if(data.output=='inserted')
      {

      $(modal).modal('hide');
      //$('#roletable').addClass('table-official');
      $('#roletable').load(location.href + ' #roletable');

      toastr.success('New role has been added!!','Successfully added',{timeOut:5000});
      }

    }
  });
}

$(document).on('click','.deleterole',function(e){
// $('.deleterole').click(function(e){
  // alert('asda');
  e.preventDefault();
  var id=$(this).data('id');
  var route='role/'+id;
  var table='#roletable';
  var token='{{csrf_token()}}';
  deleterole(id,route,table,token)
});
function deleterole(id,route,table,token)
{
  $.ajax({
    url:route,
    method:'Delete',
    data:{'_token':token},
    dataType:'json',
    success:function(data){
      console.log(data);
      if(data.output=='deleted')
      {
        toastr.success('Role has been deleted!!','Successfully Deleted',{timeOut:5000});
        $('#roletable').load(location.href + ' #roletable');
      }
    }
  })
}
</script>


@endsection
