  @extends('backend.index')

  @section('title','Experience')

  @section('main-content')
  <div class="row">
    <div class="col-md-12">
      <!-- Button trigger modal -->
      <button type="button" class="btn btn-primary rounded" id="addnew">
        Add New
      </button>
      <div class="card" >
        <div class="card-header card-header-primary text-white"  >
          <h4 class="card-title ">Experience</h4>
          <p class="card-category text-white"> List of all experiences</p>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered text-center" id="experiencetable">
              <thead class=" text-primary">
                <th>
                  ID
                </th>
                <th>
                  Organization
                </th>
                <th>
                  Designation
                </th>

                <th>Start Date</th>
                <th>End Date</th>
                <th>Other</th>
                <th>About</th>
                <th>Action</th>
              </thead>

            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal for adding new experience -->


  <div class="modal fade bd-example-modal-lg " id="experiencemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document" >
      <div class="modal-content bg-dark">
        <div class="modal-header bg-official" >
          <h5 class="modal-title text-white font-weight-bold text-uppercase" id="modaltitle">New Experience</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
         <form id="experienceform" action="#" method="POST" >
          {{ csrf_field()}}
          <input type="hidden" id="newid" name="newid">

          <div class="input-group mb-2">
           <div class="input-group-prepend">
             <span class="input-group-text">
              Organization:
            </span>
          </div>
          <input type="text" class="form-control" data-parsley-maxlength="100" id="organization" placeholder="Organization/Company Name" name="organization" onkeyup="clearerror('skillerror')" required>
          <span class="text-danger" id="skillerror"></span>
        </div>
        <div class="input-group mb-2">
         <div class="input-group-prepend">
           <span class="input-group-text">
            Designation:
          </span>
        </div>
        <input type="text" class="form-control" id="designation" placeholder="Designation/Position" name="designation" data-parsley-type="text"  onkeyup="clearerror('percentageerror')" required>
        <span class="text-danger" id="percentageerror"></span>
      </div>

      <div class="input-group mb-2">
        <div class="input-group-prepend">
         <span class="input-group-text">
          Start Date:
        </span>
      </div>
      <input type="text" class="form-control" id="start" placeholder="Start Date" name="start" data-parsley-type="number"  onkeyup="clearerror('percentageerror')" required>
      <span class="text-danger" id="percentageerror"></span>
    </div>
    <div class="input-group mb-2">
      <div class="input-group-prepend">
       <span class="input-group-text">
        End Date:
      </span>
    </div>
    <input type="text" class="form-control" id="end" placeholder="End Date" name="end" data-parsley-type="number"  onkeyup="clearerror('percentageerror')">
    <span class="text-danger" id="percentageerror"></span>
  </div>
  
<div class="input-group mb-2">
  <div class="input-group-prepend">
   <span class="input-group-text">
    About:
  </span>
</div>
<input type="text" class="form-control" id="about" placeholder="About the experience" name="about" data-parsley-type="number"  onkeyup="clearerror('percentageerror')">
<span class="text-danger" id="percentageerror"></span>
</div>
<div class="input-group mb-2">
  <div class="input-group-prepend">
   <span class="input-group-text">
    Others:
  </span>
</div>
<input type="text" class="form-control" id="other" placeholder="Any others mentions" name="other" data-parsley-type="number"  onkeyup="clearerror('percentageerror')">
<span class="text-danger" id="percentageerror"></span>
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

  $(function () {
    $('#experiencetable').DataTable({
      serverSide: true,
      processing: true,
      ajax: '{{route('get.experiences') }}',
      columns: [
      {'data': 'id'},
      {'data': 'organization'},
      {'data': 'designation'},
      {'data': 'start'},
      {'data': 'end'},
      {'data': 'about'},
      {'data': 'other'},
      {'data': 'action'},



      ]
    });
  });

  $(document).on('click','#addnew',function(){
    $('#experiencemodal').modal('show');
    $('#modaltitle').text('Add new experience');
    $('#add').show();
    $('#update').hide();
        $('#newid').val('');

    $("#experienceform").find('input:text, input:password, input:file, select, textarea').val('');
    
    })

    $(document).on('click','.editexperience',function(){
   let organization=$(this).data('organization');
   let designation=$(this).data('designation');
   let start=$(this).data('start');
   let end=$(this).data('end');
   let about=$(this).data('about');
   let other=$(this).data('other');
   let id=$(this).data('id');
   //alert(percentage);
   $('#experiencemodal').modal('show');
   $('#add').hide();
   $('#update').show();
   $('#modaltitle').text('Edit experience');
      $('#organization').val(organization);
      $('#designation').val(designation);
      $('#start').val(start);
      $('#end').val(end);
      $('#about').val(about);
      $('#other').val(other);

   $('#newid').val(id);
 });

  $('#experienceform').submit(function(e){
    e.preventDefault();
    var form=$(this);
    var formData = new FormData($(this)[0]);
    var id=$('#newid').val();
    var url='experience';
    var table='#experiencetable';
    var modal='#experiencemodal';
    addeditfunction(id,url,formData,table,modal)

  })



  function addeditfunction(id,url,formData,table,modal)
  {
   var route;
   var method;
   if(id=="")
   {
    route=url;
    method='POST';
  }
  else{
    route=url+'/'+id;
    method='POST';
    formData.append('_method','PUT');
  }

  $.ajax({
    url:route,
    type:method,
    data: formData,
    dataType: 'json',
    cache: false,
    contentType: false,
    processData: false,
    success:function(data) {

      console.log(data);
      if(data.output=="inserted")
      {

        $(modal).modal('hide');

        $(table).DataTable().ajax.reload();
        toastr.success('New Experience added Congratulations!!', 'Successfully Added!', {timeOut: 5000})
        $("#experienceform").find('input:text, input:password, input:file, select, textarea').val('');

      }
      if(data.output=="updated")
      {
        $(modal).modal('hide');
        $(table).DataTable().ajax.reload();
        toastr.info('Experience has been Updated!!', 'Successfully Updated!', {timeOut: 5000})
        $("#experienceform").find('input:text, input:password, input:file, select, textarea').val('');

      }

    },
  })
}


$(document).on('click','.deleteexperience',function(e){
 e.preventDefault();

 var id=$(this).data('id');
 var route='experience/'+id;
 var table='#experiencetable';
 var token = "{{csrf_token()}}";
  /*   confirm("Are you sure you want to delete??");
  */
     // var method='POST';
     // var formData = new FormData($(this)[0]);

     deleteexperience(id,route,table,token);
    // let method='POST';


  })

function deleteexperience(id,route,table,token)
{
  if (confirm('Are you sure you want to delete this?')) {

      $.ajax({
       url:route,
       method:'DELETE',
       data:{'_token':token},
       dataType:'json',
       success:function(data){

         console.log(data);
         if(data.output=="deleted")
         {
           toastr.success('Experience has been deleted!!', 'Successfully Deleted!', {timeOut: 5000})
           $(table).DataTable().ajax.reload();
         }
       },
       error: function(xhr) {
         console.log(xhr.responseText);
       }
     })
    }
}

  </script>


  @endsection