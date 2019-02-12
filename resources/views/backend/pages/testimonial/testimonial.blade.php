
@section('title','Testimonial')
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
                  <h4 class="card-title ">Testimonial</h4>
                  <p class="card-category text-white"> List of all the testimonials</p>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-bordered text-center " id="testimonialtable">
                      <thead class=" text-primary">
                        <th>
                          ID
                        </th>
                        <th>
                          Person/Company Name
                        </th>
                        <th>
                          About
                        </th>
                        <th>Testimonial</th>
                        <th>Status</th>
                        <th>
                          Created At
                        </th>
                       
                        <th>Action</th>
                      </thead>

                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>


 <!-- Modal for adding new testimonial -->


    <div class="modal fade bd-example-modal-lg " id="testimonialmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document" >
        <div class="modal-content bg-dark">
          <div class="modal-header bg-official" >
            <h5 class="modal-title text-white font-weight-bold text-uppercase" id="modaltitle">New Testimonial</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
       <form id="testimonialform" action="#" method="POST" >
              {{ csrf_field() }}
              <input type="hidden" id="newid" name="newid">
              <div class="input-group mb-2">
                <div class="input-group-prepend">
                   <span class="input-group-text">
                     Name:
                    </span>
                  </div>
                <input type="text" class="form-control" data-parsley-maxlength="100" id="name" placeholder="Person/Company name" name="name" onkeyup="clearerror('testimonialerror')">
                <span class="text-danger" id="skillerror"></span>
              </div>
             
               <div class="input-group mb-2">
                <div class="input-group-prepend">
                   <span class="input-group-text">
                     About the person:
                    </span>
                  </div>
                <input type="text" class="form-control" data-parsley-maxlength="100" id="about" placeholder="About the person" name="about" onkeyup="clearerror('testimonialerror')">
                <span class="text-danger" id="testimonialerror"></span>
              </div>
               <div class="input-group mb-2">
                <div class="input-group-prepend">
                   <span class="input-group-text">
                     Testimonial:
                    </span>
                  </div>
                <textarea class="form-control" id="description" placeholder="Full testimonial" name="description" data-parsley-type="number"  onkeyup="clearerror('percentageerror')"></textarea>
                <span class="text-danger" id="percentageerror"></span>
              </div>
              <div class="input-group mb-2" id="statusdis">
                <div class="input-group-prepend">
                   <span class="input-group-text">
                     Status:
                    </span>
                  </div>
               <select name="status" id="status" class="form-control col-md-4 text-black">
                
                 <option value="1" class="text-black">Show</option>
                 <option value="0" class="text-black">Hide</option>
               </select>
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
        $('#testimonialtable').DataTable({
            serverSide: true,
            processing: true,
          ajax: '{{route('get.testimonials') }}',
          columns: [
                 {'data': 'id'},
                {'data': 'name'},
                {'data': 'about'},
                {'data': 'description'},
                {'data': 'status'},
                {'data': 'created_at'},
                {'data': 'action'}



          ]
    });
  });

    $(document).on('click','#addnew',function(){
    $('#testimonialmodal').modal('show');
    $('#modaltitle').text('Add new Testimonial');
    $('#add').show();
    $('#update').hide();
    $('#status').val('1');
    $('#statusdis').hide(); 
      $("#testimonialform").find('input:text, input:password, input:file, select, textarea').val('');

  })
  $(document).on('click','.edittestimonial',function(){
   let name=$(this).data('name');
   let about=$(this).data('about');
   let description=$(this).data('description');
   let status=$(this).data('status');
   let id=$(this).data('id');
   // alert(percentage);
   $('#testimonialmodal').modal('show');
   $('#statusdis').show(); 
   $('#add').hide();
   $('#update').show();
   $('#modaltitle').text('Edit Testimonial');
   $('#name').val(name);
   $('#about').val(about);
   $('#status').val(status);
   $('#description').val(description);
   $('#newid').val(id);
 });


 $(document).on('click','.deletetestimonial',function(e){
   e.preventDefault();

   var id=$(this).data('id');
   var route='testimonial/'+id;
   var table='#testimonialtable';
   var token = "{{csrf_token()}}";

   deleteTestimonial(id,route,table,token);


 })

 function deleteTestimonial(id,route,table,token)
 {
    //alert('here');
    //alert(id);
    //alert(route);
   $.ajax({
     url:route,
     method:'DELETE',
     data:{'_token':token},
     dataType:'json',
     success:function(data){

       console.log(data);
       if(data.output=="deleted")
       {
         toastr.success('Testimonial has been deleted!!', 'Successfully Deleted!', {timeOut: 5000})
         $(table).DataTable().ajax.reload();
       }
     },
     error: function(xhr) {
   console.log(xhr.responseText);
 }
   })
 }

  $('#testimonialform').submit(function(e){
    e.preventDefault();
    var form=$(this);
       var formData = new FormData($(this)[0]);
       var id=$('#newid').val();
       var url='testimonial';
       var errorfunction='testimonialerror';
       var table='#testimonialtable';
       var modal='#testimonialmodal';
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
     toastr.success('New Testimonial added Congratulations!!', 'Successfully Added!', {timeOut: 5000})

    }
    if(data.output=="updated")
    {
      $(modal).modal('hide');
      $(table).DataTable().ajax.reload();
     toastr.info('Testimonial has been Updated!!', 'Successfully Updated!', {timeOut: 5000})
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

    if (invalid.errors.testimonial!== undefined){
$('#testimonialerror').fadeIn();
   $('#testimonialerror').text(invalid.errors.testimonial);
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
