@extends('backend.index')
@section('title', 'Edit Project')

@section('stylesheet')
  <link href="{{asset('css/parsley.css')}}" rel="stylesheet" type="text/css">

@endsection

@section('main-content')

  <div class="row">
    <div class="col-md-8 ">
      <div class="card col-md-12">
        <div class="card-header card-header-primary">
          <h4 class="card-title text-white"><b>Edit Project</b></h4>
        </div>
          <div class="card-body">
        <form action="{{route('project.update', $project->id)}}" enctype="multipart/form-data"  method="POST" data-parsley-validate>
          {{ csrf_field() }}
          @method('put')
          <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" enctype="multipart/form-data"  data-parsley-maxlength="200" id="title" placeholder="Project Title" name="title" required value="{{$project->title}}" >
          </div>
          <div class="form-row">
            <div class="form-group col-md-7">
              <label for="client">Client/Company Name</label>
              <input type="text" class="form-control" id="client" placeholder="Client name" name="client"  required value="{{$project->client}}" >
            </div>
            <div class="form-group col-md-5">
              <label for="exampleFormControlInput1">Project Date</label>
              <input type="date" class="form-control" id="date" placeholder="Project Date" name="date" data-parsley-type="number"	 required value="{{$project->date}}" required>
            </div>
          </div>
          <div class="form-group">
            <label for="description">Project Description</label>
            <textarea class="form-control" id="description" placeholder="Project Description" name="description" required> {{$project->description}} </textarea>
          </div>
          <div class="form-row">
            <div class="form-group col-md-7">
              <label for="link1">Project Link</label>
              <input type="text" class="form-control" id="link1" placeholder="link" name="link1"  required value="{{$project->link1}}" >
            </div>
            <div class="form-group col-md-5">
              <label for="link1">Any other Link</label>
              <input type="text" class="form-control" id="link2" placeholder="link" name="link2"   value="{{$project->link2}}" >
            </div>
          </div>
          <div class="form-row">

            <div class="form-group col-md-4">
              <label for="category">Category</label>
              <select id="category" class="form-control" name="contribution" id="contribution" required >
                <option value="{{$project->contribution}}" selected class="text-dark">{{$project->contribution}}</option>

                <option value="Designing" class="text-dark">Design</option>
                <option value="Development" class="text-dark">Development</option>
                <option value="Design & Development" class="text-dark">Design & Development</option>
                <option value="other" class="text-dark">Others</option>

              </select>
            </div>
            <div class="form-group col-md-8">
              <label for="keyword">Keyword</label>
              <input type="text" class="form-control" id="keyword" name="keyword" placeholder="Keywords Related to Project" value="{{$project->keyword}}">
            </div>
          </div>
          <div class="form-row">



        </div>
          <div class="form-group col-md-4">
            <label for="status">Display</label>
            <select id="status" class="form-control " name="status" required >
              <option value="{{$project->status}}" selected class="text-dark">{{($project->status==1 ? "Show" : "Hide")}}</option>

              <option value="1" class="text-dark" >Show </option>
              <option value="0" class="text-dark">Hide</option>


            </select>
          </div>
        </div>
      </div>

    </div>
    <div class="col-md-4 ">
      <div class="row mt-4 ">
        <div class="col-md-12 bg-transparent " style="background:rgba(0,0,0,1) !important;padding:10px;border-radius:5px;">
          <img src="{{asset('uploads/projects/'.$project->image)}}" class="img-fluid" alt="Project Cover Image">
          <div class="col-md-12" >
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
        </div>
      </div>
      <div class="row">
      <div class="card text-white">
        {{-- <div class="card-header card-header-primary">
          <h4 class="card-title ">Details</h4>
        </div> --}}
        <div class="row justify-content-center mt-3">
          <dl class="row">
            <dt>Created At: </dt>
            <dd class="ml-3">{{ date('j M Y h:H a'),strtotime( $project->created_at)}}</dd>
          </dl>
          <dl class="row">
            <dt>Last Updated: </dt>
            <dd class="ml-3">{{ date('j M Y h:H a'),strtotime( $project->updated_at)}}</dd>

          </dl>
          <dl class="row">
            <dt>Display:</dt>
            <dd class="ml-3">
              <div class="togglebutton">
              <label>
                @if($project->status=='1')
                  <input type="checkbox" checked="" >
                @else
                  <input type="checkbox" >
                @endif

                  <span class="toggle"></span>
                  Toggle is on
              </label>
            </div>
          </dd>

          </dl>
        </div>
        <div class="row">
          <div class="col-md-6">
            <a href="{{route('project.index')}}"><button class="btn btn-danger btn-md btn-block">Cancel</button></a>
          </div>
          <div class="col-md-6">
            <input type="submit" value="Save Changes" class="btn btn-success btn-md btn-block">
          </div>
        </div>
      </form>
      </div>
    </div>
  </div>
  </div>

<div class="row">
  <div class="card bg-stransparent col-md-12">
    <div class="card-header card-header-primary">
      <h4 class="card-title text-white"><b>Project Images/Gallery</b></h4>
    </div>
    <div class="row mt-3">
    @foreach($photo as $photo)
      <div class="col-md-3 mt-3">
        <input type="checkbox" style="position:absolute;right:20px;">
        <a href="{{asset('uploads/projectimages/'.$photo->image)}}" data-lightbox="gallery" style="display:inline-block;" >
      <img src="{{asset('uploads/projectimages/'.$photo->image)}}" class="col-md-12" style="height:130px;display:inline-block;"></a>
    </div>

    @endforeach
</div>
  </div>
</div>

  <div class="row">
    <div class=" card bg-stransparent col-md-12" >
      <div class="card-header card-header-primary">
        <h4 class="card-title text-white"><b>Add New Project Images/Gallery</b></h4>
      </div>
      <div class="col-lg-12 col-sm-12 col-11 main-section">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <input type="hidden" name="projectid" value="{{$project->id}}" id="projectid">
            <div class="form-group">
                <input type="file" id="file-1" name="file" multiple class="file" data-overwright-initial="false" data-min-file-count="1">

            </div>
        </div>
    </div>
  </div>

@endsection
@section('scripts')

  <script>
      CKEDITOR.replace( 'description' );
  </script>
  <script type="text/javascript" src="{{asset('js/lightbox-plus-jquery.min.js')}}">
  <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/js/fileinput.js" type="text/javascript"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/themes/fa/theme.js" type="text/javascript"></script>
  <script type="text/javascript">
      $("#file-1").fileinput({

          theme:'fa',
          uploadUrl:"/admin/image-submit",
          uploadExtraData:function()
          {
              return{
                  _token:$("input[name='_token']").val(),
                  projectid:$('#projectid').val()
              };

          },
          allowedFileExtensions:['jpg','png','gif'],
          overwriteInitial:false,
          maxFileSize:8000,
          maxFilename:20,
          slugcallback:function(filename)
          {
              return filename.replace('(','_').replace(']','_');

          },
          success:function(data){


              console.log(data);

          }
      });

  </script>



@endsection
