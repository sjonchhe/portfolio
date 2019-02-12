@extends('backend.index')

@section('title','Blogs')

@section('main-content')

<div class="row">
            <div class="col-md-12">
              <!-- Button trigger modal -->
          <a href="{{route('blog.create')}}" class="btn btn-primary rounded" id="addnew">
            Add New
          </a>
              <div class="card" >
                <div class="card-header card-header-primary text-white"  >
                  <h4 class="card-title ">Blog</h4>
                  <p class="card-category text-white"> List of all the Blogs</p>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-bordered table-official text-center" id="blogtable">
                      <thead class="text-primary">
                        <tr>
                        <th>
                          ID
                        </th>
                        <th>
                          Blog Title
                        </th>
                       
                        <th>Status</th>
                         <th>
                          Added By
                        </th>
                        <th>Views</th>
                        <th>
                          Created At
                        </th>
                       
                        <th>Delete</th>
                      </tr>
                      </thead>
                      
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>

 <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>

<script type="text/javascript">
  $(function(){
    $('#blogtable').DataTable({
      serverSide:true,
      processing:true,
      ajax:'{{route('get.blogs')}}',
      columns:[
          {'data':'id'},
          {'data':'title'},
          {'data':'status'},
          {'data':'addedby'},
          {'data':'views'},
          {'data':'created_at'},
          {'data':'delete'}
      ]
    })
  });

$(document).on('click','.deleteblog',function(e){
  e.preventDefault();
  var id=$(this).data('id');
  var table='#blogtable';
  var token='{{csrf_token()}}';
  var route='blog/'+id;
  deleteblog(id,table,token,route)
})

function deleteblog(id,table,token,route)
{
 if (confirm('Are you sure you want to delete this?')) {
 
  $.ajax({
    url:route,
    method:'DELETE',
    data:{'_token':token},
    dataType:'json',
    success:function(data){
      console.log(data);
      if(data.output=='deleted')
      {
        toastr.success('Blog has been deleted!','Successfully Deleted',{timeOut:5000})
        $(table).DataTable().ajax.reload();
      }
    }
  })

}
}
</script>
@endsection