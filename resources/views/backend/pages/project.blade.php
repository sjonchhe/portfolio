
@section('title','Project')
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
          <h4 class="card-title ">Projects</h4>
          <p class="card-category text-white"> List of all the projects</p>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-hover" id="projecttable">
              <thead class=" text-primary">
                <th>Id</th>
                <th>Title</th>
                <th>Client</th>
                <th>Date</th>
                <th>Contribution</th>
                <th>Link</th>
                <th>Views</th>
                <th></th>
                <th></th>

                {{-- <th>Action</th> --}}
              </thead>

            </table>
          </div>
        </div>
      </div>
    </div>
  </div>


  <!-- Modal for adding new project -->


  <div class="modal fade bd-example-modal-lg " id="projectmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document" >
      <div class="modal-content bg-dark">
        <div class="modal-header bg-official" >
          <h5 class="modal-title text-white text-uppercase font-weight-bold" id="modaltitle">New Project</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="projectform" action="#" method="POST" >
            {{ csrf_field() }}

            <div class="form-group">
              {{-- <label for="title">Title</label><br> --}}
              <input type="text" class="form-control" id="title" placeholder="Project Title" name="title" required minlength="4" maxlength="200">
            </div>
            <div class="form-row">
              <div class="form-group col-md-8">
                {{-- <label for="client">Client</label> --}}
                <input type="text" class="form-control" id="client" placeholder="Client/Company Name" name="client" minlength="4" maxlength="200" required>
              </div>
              <div class="form-group col-md-4">
                {{-- <label for="date">Date</label> --}}
                <input type="date" class="form-control" id="date" placeholder="Date" name="date" required>
              </div>
            </div>
            <div class="form-group">
              {{-- <label for="inputAddress">Description</label> --}}
              <textarea class="form-control " id="article-ckeditor" placeholder="Project Description" name="description" minlength="4" required></textarea>
            </div>
            <div class="form-row">
              <div class="form-group col-md-7">
                {{-- <label for="link1">Project Link</label> --}}
                <input type="text" class="form-control" id="link1" placeholder="Link for Launching the project" name="link1" minlength="4" required>
              </div>
              <div class="form-group col-md-5">
                {{-- <label for="link2">Secondary Link</label> --}}
                <input type="text" class="form-control" id="link2" placeholder="Any other external Link" name="link2" minlength="5">
              </div>
            </div>

            <div class="form-row">

              <div class="form-group col-md-4">
                {{-- <label for="category">Category</label> --}}
                <select id="category" class="form-control" name="contribution" required>
                  <option value="Designing" selected>Design</option>
                  <option value="Development">Development</option>
                  <option value="Design & Development">Design & Development</option>
                  <option value="Others">Others</option>

                </select>
              </div>
              <div class="form-group col-md-8">
                {{-- <label for="keyword">Keyword</label> --}}
                <input type="text" class="form-control" id="keyword" name="keyword" placeholder="Keywords Related to Project">
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-6" >
                <div class="form-group">
                  <label>Project Cover Image</label>
                  <div class="form-group">
                    <div class="custom-file" style="border:1px solid #8C7D65; padding-bottom:0px;">

                      <input type="file" class="custom-file-input" id="validatedCustomFile" name="image" id="image" >
                      <label class="custom-file-label" for="validatedCustomFile">Choose file...</label>
                      {{-- <div class="invalid-feedback">Example invalid custom file feedback</div> --}}
                    </div>

                  </div>
                </div>
              </div>
              <div class="form-group col-md-3">
                {{-- <label for="status">Display in Frontend</label> --}}
                <select id="status" class="form-control" name="status" required>
                  <option value="1" selected>Show in Frontend</option>
                  <option value="0">Donot Show in Frontend</option>


                </select>
              </div>


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
    $('#projecttable').DataTable({
      serverSide: true,
      processing: true,
      ajax: '{{route('get.projects') }}',
      columns: [
        {'data': 'id'},
        {'data': 'title'},
        {'data': 'client'},
        {'data': 'date'},
        {'data': 'contribution'},
        {'data': 'link'},
        {'data': 'views'},
        {'data':'view'},
        {'data':'delete'}




      ]
    });
  });

  $(document).on('click','#addnew',function(){
    $('#projectmodal').modal('show');
    $('#modaltitle').text('Add new Project');
    $('#add').show();
    $('#update').hide();
    //$('#skillform')[0].reset();
  })

  $('#projectform').submit(function(e){
    e.preventDefault();
    var form=$(this);
    var formData = new FormData($(this)[0]);
    var route='project';
    var errorfunction='projecterror';
    var table='#projecttable';
    var modal='#projectmodal';
    //var method='POST';
   CUfunctionforall(route,formData,errorfunction,table,modal)
 })

 function CUfunctionforall(route,formData,errorfunction,table,modal)
    {
        var method='POST';

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
              $(table).DataTable().ajax.reload();
              toastr.success('New Project has been added!','Successfully added!',{timeOut:5000})
            }},
            error:function(error)
            {

            }

          })
        };

    $(document).on('click','.deleteproject',function(e){
     e.preventDefault();
     var id=$(this).data(id);
     var route='project/'+id;
     var table='#projecttable';
     var token='{{csrf_token()}}';
     deleteproject(id,route,table,token);
    });

    function deleteproject(id,route,table,token)
    {
      $.ajax({
      url:route,
      method:'Delete',
      data:{'_token':token},
      dataType:'json',
      success:function(data){
        console.log(data);
          if(data.output=="deleted")
       {
         toastr.success('Skill has been deleted!!', 'Successfully Deleted!', {timeOut: 5000})
         $(table).DataTable().ajax.reload();
       }

      }
    });
    }

  </script>

@endsection
