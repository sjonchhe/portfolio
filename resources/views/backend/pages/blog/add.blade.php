\@extends('backend.index')
@section('title','Add Blog')

@section('main-content')

<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header card-header-primary"><h4 class="card-title">New blog</h4></div>
			<div class="card-body">
			<form action="{{route('blog.store')}}" method="POST" enctype="multipart/form-data" data-parsley-validate>
				{{csrf_field()}}
				<div class="row">
					<div class="col-md-12">
						<label for="title" class="text-white">Title</label>
					<div class="form-group">
						<input class="form-control" type="text" placeholder="Blog title here" name="title">
					</div>
					</div>			
				</div>
				<div class="row">
					<div class="col-md-12">
						<label for="cover" class="text-white">Cover Image</label>
						<input type="file" class="form-control" name="image">
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<label for="" class="text-white">Blog</label>
							<div class="form-group">
								<textarea class="form-control" id="blogdesc" placeholder="Blog description here" name="description">
									
								</textarea>
							</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<label for="" class="text-white">URL Links</label>
							<div class="form-group">
									<input type="text" class="form-control" name="url" placeholder="Any URL links">
							</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-4">
						<label for="status" class="text-white">Status</label>
						<select name="status" id="" class="form-control ">
							<option value="1" class="text-black">Display</option>
							<option value="0" class="text-black">Hide</option>
						</select>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<button class="btn btn-primary">Upload</button>
					</div>
				</div>
				
				<br>

			</form>
			</div>

		</div>
	</div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
	            CKEDITOR.replace( 'blogdesc' );
</script>
@endsection