
@section('title','Skill')
@extends('backend.index')
@section('main-content')



          <div class="row">
            <div class="col-md-12">
              <!-- Button trigger modal -->
          <button type="button" class="btn btn-primary rounded" id="addnew">
            Add New
          </button>
              <div class="card" >
                <div class="card-header card-header-primary text-white"  >
                  <h4 class="card-title ">Skill</h4>
                  <p class="card-category text-white"> List of all the skills</p>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-stripped " id="skilltable">
                      <thead class=" text-primary">
                        <th>
                          ID
                        </th>
                        <th>
                          Skill
                        </th>
                        <th>
                          Percentage
                        </th>
                        <th>
                          Created At
                        </th>
                        <th>
                            Updated At
                        </th>
                        <th>Edit</th>
                        <th>Delete</th>
                      </thead>

                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>


 <!-- Modal for adding new skill -->


    <div class="modal fade bd-example-modal-lg " id="skillmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document" >
        <div class="modal-content bg-dark">
          <div class="modal-header bg-official" >
            <h5 class="modal-title text-white font-weight-bold text-uppercase" id="modaltitle">New Skill</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
       <form id="skillform" action="#" method="POST" >
              {{ csrf_field() }}
              <input type="hidden" id="newid" name="newid">
              <div class="form-group">
                <input type="text" class="form-control" data-parsley-maxlength="100" id="skillname" placeholder="Skill/Language Name" name="skill" onkeyup="clearerror('skillerror')">
                <span class="text-danger" id="skillerror"></span>
              </div>
              <div class="form-group">
                <input type="text" class="form-control" id="percentage" placeholder="Percentage" name="percentage" data-parsley-type="number"  onkeyup="clearerror('percentageerror')">
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
        $('#skilltable').DataTable({
            serverSide: true,
            processing: true,
          ajax: '{{route('get.skills') }}',
          columns: [
                 {'data': 'id'},
                {'data': 'skill'},
                {'data': 'percentage'},
                {'data': 'created_at'},
                {'data': 'updated_at'},
                {'data': 'edit'},
                {'data': 'delete'}



          ]
    });
  });

    $(document).on('click','#addnew',function(){
    $('#skillmodal').modal('show');
    $('#modaltitle').text('Add new Skill');
    $('#add').show();
    $('#update').hide();
    $('#skillname').val('');
    $('#percentage').val('');
    // $('#skillform')[0].reset();
    $('#newid').val('');
        //$("#skillform").find('input:text, input:password, input:file, select, textarea').val('');

  })
  $(document).on('click','.editskill',function(){
  let skill=$(this).data('skill');
   let percentage=$(this).data('percentage');
   let id=$(this).data('id');
   // alert(percentage);
   $('#skillmodal').modal('show');
   $('#add').hide();
   $('#update').show();
   $('#modaltitle').text('Edit Skill');
   $('#skillname').val(skill);
   $('#percentage').val(percentage);
   $('#newid').val(id);
   //$('#skillform')[0].reset();
 });


 $(document).on('click','.deleteskill',function(e){
   e.preventDefault();

   var id=$(this).data('id');
   var route='skill/'+id;
   var table='#skilltable';
   var token = "{{csrf_token()}}";

   // var method='POST';
   // var formData = new FormData($(this)[0]);

   deletefunction(id,route,table,token);
  // let method='POST';


 })

 function deletefunction(id,route,table,token)
 {
    //alert('here');
    //alert(id);
    //alert(route);
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
         toastr.success('Skill has been deleted!!', 'Successfully Deleted!', {timeOut: 5000})
         $(table).DataTable().ajax.reload();
       }
     },
     error: function(xhr) {
   console.log(xhr.responseText);
 }
   })
 }
}

  $('#skillform').submit(function(e){
    e.preventDefault();
    var form=$(this);
       var formData = new FormData($(this)[0]);
       var id=$('#newid').val();
       var url='skill';
       var errorfunction='skillerror';
       var table='#skilltable';
       var modal='#skillmodal';
       CUfunctionforall(id,url,formData,errorfunction,table,modal)

  })

  function CUfunctionforall(id,url,formData,errorfunction,table,modal)
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
     //successmessage("success","The data has been inserted","#fec107","success")
     toastr.success('New Skill added Congratulations!!', 'Successfully Added!', {timeOut: 5000})

    }
    if(data.output=="updated")
    {
      $(modal).modal('hide');
      $(table).DataTable().ajax.reload();
     toastr.info('Skill has been Updated!!', 'Successfully Updated!', {timeOut: 5000})
    }

    },error:function(error)
    {


    if (error.status === 413){
    swal("ERROR!", "Some error occurred!!Please try again later.", "error");
    console.log('unknown error');
    } else if (error.status === 422){


      toastr.error('We do have the Kapua suite available.', 'Turtle Bay Resort', {timeOut: 5000})
    var invalid = JSON.parse(error.responseText);


    console.log(invalid);

    if (invalid.errors.skill!== undefined){
$('#skillerror').fadeIn();
   $('#skillerror').text(invalid.errors.skill);
   }
   if (invalid.errors.percentage!== undefined){
  $('#percentageerror').fadeIn();
  $('#percentageerror').text(invalid.errors.percentage);
  }

    }


    }  //show validation error message on modal if exist
    })


    }
 function clearerror(id)
 {
   $('#'+id).fadeOut();
 }


  </script>
  {{-- $('#grouptable').load(location.href + ' #grouptable'); --}}

      @endsection
