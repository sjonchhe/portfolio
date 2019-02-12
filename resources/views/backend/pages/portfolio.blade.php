@extends('backend.index')
@section('title','Portfolio')
@section('main-content')


</script>
  <div class="row" id="portfoliodiv">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header card-header-primary" id="portfoliodiv">
          <h4 class="card-title">Edit Portfolio @role('user') <span class="text-danger">*You donot have permission to edit this</span> @endrole</h4>
          <p class="card-category">Complete the portfolio</p>
        </div>
        @foreach($portfolio as $data)
          <div class="card-body" >
 <form id="portfolioform"  method="POST" enctype="multipart/form-data" data-parsley-validate>
   {{ csrf_field() }}
   {{-- @method('put') --}}
    <input type="hidden" id="hid_id" name="hid_id" value="{{$data->id}}">
               <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="bmd-label-floating">Fist Name</label>
                    <input type="text" class="form-control" name="firstname" id="firstname" value="{{$data->firstname}}" data-parsley-minlength="5" required>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="bmd-label-floating">Middle Name</label>
                    <input type="text" class="form-control" name="middlename" id="middlename" value="{{$data->middlename}}" >
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="bmd-label-floating">Last Name</label>
                    <input type="text" class="form-control" name="lastname" id="lastname" value="{{$data->lastname}}">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-7">
                  <div class="form-group">
                    <label class="bmd-label-floating">Email address</label>
                    <input type="email" class="form-control" value="{{$data->email}}" name="email" id="email">
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="form-group">
                    <label class="bmd-label-floating">Contact</label>
                    <input type="text" class="form-control" name="contact" id="contact" value="{{$data->contact}}">
                  </div>
                </div>


              </div>

              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="bmd-label-floating">Dob</label>
                    <input type="date" class="form-control" value="{{$data->dob}}" name="dob" id="dob">
                  </div>
                </div>
                <div class="col-md-9">
                  <div class="form-group">
                    <label class="bmd-label-floating">Address</label>
                    <input type="text" class="form-control" name="address" id="address" placeholder="Address" value="{{$data->address}}">
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label>About Me</label>
                    <div class="form-group">
                      {{-- <label class="bmd-label-floating"> Lamborghini Mercy, Your chick she so thirsty, I'm in that two seat Lambo.</label> --}}
                      <textarea class="form-control" rows="3" name="about" id="about">{{$data->about}}</textarea>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 ">
                  <div class="form-group">
                    <label>Picture</label>
                    <div class="form-group" >
                      <div class="custom-file" style="border:1px solid #8C7D65; padding-bottom:0px;">

                        <input type="file" class="custom-file-input " id="validatedCustomFile" id="image" name="image" >
                        <label class="custom-file-label" for="validatedCustomFile">Choose file...</label>
                        {{-- <div class="invalid-feedback">Example invalid custom file feedback</div> --}}
                      </div>
                      <label>{{$data->image}}</label>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">

                <div class="col-md-12 text-white" >
                    <label>CV:</label>
                    <input type="file" class="" name="cv" id="cv" style="background:white;padding:10px;">

                      <label>{{$data->cv}}</label>

                </div>
              </div>
              <input type="submit" class="btn btn-primary pull-right" id="update" value="Update Profile">
              <div class="clearfix"></div>
            </form>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card card-profile">
          <div class="card-avatar">
            <a href="#pablo">
              <img class="img" src="{{asset('uploads/profile/'.$data->image)}}" />
            </a>
          </div>
          <div class="card-body">
            {{-- <h6 class="card-category">CEO / Co-Founder</h6> --}}
            <h4 class="card-title">{{$data->firstname}} {{$data->middlename}} {{$data->lastname}}</h4>
            <p class="card-description">
              {!!$data->about!!}
            </p>
            <a href="#pablo" class="btn btn-primary btn-round">Follow</a>
          </div>
        </div>
      @endforeach
    </div>
  </div>
  @endsection
  @section('scripts')
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>

        {{-- <script type="text/javascript" src="{{asset('js/parsley.min.js')}}"></script> --}}
        <script type="text/javascript">
            CKEDITOR.replace( 'about' );
            </script>
      <script type="text/javascript">

 // $(document).on('submit','#portfolioform',function(e){

 // $(document).on('click','#update',function(e){
 $('#portfolioform').submit(function(e){
  // alert ('hello');

 e.preventDefault();
  var form=$(this);
  var formData=new FormData($(this)[0]);
  var id= $('#hid_id').val();
  var route='portfolio';
  var div='#portfoliodiv';
  var token = "{{csrf_token()}}";
  Portfoliofunctionforall(id,route,formData,div)

})
function Portfoliofunctionforall(id,route,formData,div)
{
  var method='POST';
  formData.append('_method','PUT');
  // alert (div);

  $.ajax({
    url:route+'/'+id,
    type:method,
    data:formData,
    dataType:'json',
    cache:false,
    contentType:false,
    processData:false,
    success:function(data){
      console.log(data);
      if(data.output=='updated')
      {
        alert('success');
            $('#portfoliodiv').load(location.href+'#portfoliodiv');
            //location.reload();

      //toastr.success('Portfolio Updated!!','Successfully Updated',{timeOut:5000});
      }
    }
  })
}

  </script>




      @endsection
