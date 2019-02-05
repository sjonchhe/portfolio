@if(Session::has('success'))
<!-- <script type="text/javascript">
  
toastr.success('<?php echo "success";?>','Success Alert',{timeOut:5000});

</script> -->
<div class="alert alert-success col-md-12" role="alert" style="position:relative;top:30px;">
          <div class="container">

              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true" style="color:red;">x</span>
              </button>

              <b>{{ Session::get('success') }}</b>  </div>
      </div>
@endif
@if(Session::has('failure'))

  <div class="alert alert-danger " role="alert" style="position:relative;top:60px;">
    <strong>Failure: </strong>{{ Session::get('failure') }}
  </div>

@endif

@if( count($errors) >0 )

  <div class="alert alert-danger" role="alert" style="position:relative;top:60px;">
    <strong>Errors: </strong>
    <ul>
    @foreach($errors->all() as $error)
      <li>{{ $error }}</li>
    @endforeach
  </ul>
  </div>

@endif
