@extends('backend.index')
@section('title','Admin List')
@section('main-content')

  <div class="row">
    <div class="col-md-12">
      <!-- Button trigger modal -->
  <button type="button" class="btn btn-primary rounded" id="addadmin">
    Add New
  </button>
      <div class="card" >
        <div class="card-header card-header-primary text-white"  >
          <h4 class="card-title ">Admin List</h4>
          <p class="card-category text-white"> List of all the admins/users</p>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-stripped table-official " id="admintable">
              <thead class=" text-primary">
                <th>
                  ID
                </th>
                <th>
                  Name
                </th>
                <th>
                  Email
                </th>
                <th>
                  Created At
                </th>
                <th>
                    Updated At
                </th>
              </tr>
              {{-- @foreach($user as $user)
                <tr>
                  <td>{{$user->id}}</td>
                  <td>{{$user->name}}</td>
                  <td>{{$user->email}}</td>
                  <td>{{$user->created_at}}</td>
                  <td>{{$user->updated_at}}</td>
                </tr>
              @endforeach --}}
              </thead>

            </table>
          </div>
        </div>
      </div>
    </div>
  </div>


   <!-- Modal for adding new admin -->


      <div class="modal fade bd-example-modal-lg " id="adminmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document" >
          <div class="modal-content bg-dark">
            <div class="modal-header bg-official" >
              <h5 class="modal-title text-white font-weight-bold text-uppercase" id="modaltitle">New Admin</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
         <form id="adminform" action="#" method="POST" >
                {{ csrf_field() }}
                <input type="hidden" id="newid" name="newid">
                <div class="form-group">
                  <input type="text" class="form-control" data-parsley-maxlength="100" id="username" placeholder="Username" name="username" onkeyup="clearerror('usernameerror')">
                  <span class="text-danger" id="skillerror"></span>
                </div>
                <div class="form-group">
                  <input type="email" class="form-control" id="email" placeholder="example@abc.com" name="email" data-parsley-type="number"  onkeyup="clearerror('emailerror')">
                  <span class="text-danger" id="emailerror"></span>
                </div>
                <div class="form-group">
                  <input type="password" class="form-control" data-parsley-maxlength="100" id="password" placeholder="Password" name="password" onkeyup="clearerror('passworderror')">
                  <span class="text-danger" id="passworderror"></span>
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
$(document).ready(function () {
  $('#admintable').DataTable({
    serverSide: true,
    processing: true,
    ajax: '{{route('get.admins')}}',
    order: [[ 0, "desc" ]],
    columns:[
      {'data' : 'id'},
      {'data' : 'name'},
      {'data' : 'email'},
      {'data' : 'created_at'},
      {'data' : 'updated_at'}
    ]
  });
});

$(document).on('click','#addadmin',function(){
  $('#adminmodal').modal('show');
  $('#add').show();
});

$('#adminform').submit(function(e){
  e.preventDefault();

  var form=$(this);
  var formData= new FormData($(this)[0]);
  var name=$('#username').val();
  var email=$('#email').val();
  var password=$('#password').val();
  var table='#admintable';
  var modal='#adminmodal';
  var route='adminlist';

  functionforall(table,modal,route,formData)
});

function functionforall(table,modal,route,formData)
{
$.ajax({
  url:route,
  type:'POST',
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
    $(table).DataTable().ajax.reload();
     //successmessage("success","The data has been inserted","#fec107","success")
     toastr.success('New admin has been added!!', 'Successfully Added!', {timeOut: 5000})
  }

},

    error:function(xhr) {
       toastr.danger('New admin has been added!!', 'Successfully Added!', {timeOut: 5000})
  //console.log(xhr.responseText);
}
});
}



</script>
  @endsection
  {{-- @section('scripts')
@endsection --}}
