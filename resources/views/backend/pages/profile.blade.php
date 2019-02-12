@extends('backend.index')
@section('title','Edit Profile')

@section('main-content')

<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header card-header-primary"><h4 class="card-title">Edit Profile</h4></div>
			<div class="card-body">

			<form action="{{route('adminlist.update',$user->id)}}" method="POST" enctype="multipart/form-data" data-parsley-validate>
				{{csrf_field()}}
				@method('put')
				<div class="row">
					<div class="col-md-5">
						<label for="title" class="">Username</label>
						<div class="form-group">
							<input class="form-control" type="text" placeholder="someone" name="username" value="{{$user->name}}">
						</div>
					</div>
					<div class="col-md-7">
						<label for="" class="">Email Address</label>
							<div class="form-group">
								<input type="email" name="email" id="email" class="form-control" placeholder="something@abc.com" value="{{$user->email}}">
							</div>
						</div> 			
				</div>
				<br>
				<div class="row">
					<div class="col-md-6">
						<label for="provider" class="">Provider (Disabled)</label>
						<div class="form-group">
							<input class="form-control text-capitalize" type="text" placeholder="provider name" value="{{$user->provider}}" disabled>
						</div>
					</div>
					<div class="col-md-6">
						<label for="" class="">Provider Id (Disabled)</label>
							<div class="form-group">
								<input type="text" class="form-control" value="{{$user->provider_id}}" placeholder="Provider Id" disabled>
							</div>
						</div> 			
				</div>
				<br>
				<div class="row">
					<div class="col-md-6">
						<label for="" class="">Admin Role</label>
						<select name="" id="" class="form-control">
							<option value=""></option>
							@foreach($role as $role)
								<option value="{1role->id}" class="text-black text-capitalize">{{$role->name}}</option>
							@endforeach
						</select></div>
				</div>
				<br>
				<!-- <div class="row">
					<div class="col-md-12">
						<label for="cover" class="text-white">Cover Image</label>
						<input type="file" class="form-control" name="image">
					</div>
				</div> -->
			
				
				<div class="row">
					<div class="col-md-12">
					<button class="btn btn-primary">Update</button>	
					</div>
				</div>

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