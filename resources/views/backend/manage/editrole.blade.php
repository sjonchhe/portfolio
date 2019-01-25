@extends('backend.index')
@section('title','Edit Role')

@section('main-content')

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header card-header-primary text-white"  >
          <h4 class="card-title ">Edit Role</h4>
          {{-- <p class="card-category text-white"> List of all Roles</p> --}}
        </div>
        <div class="card-body">
          <form action="{{route('role.update',$role->id)}}" method="POST">
            {{csrf_field()}}
            @method('PUT')
              <div class="form-row">
                <div class="form-group col-md-5">
                  <label for="inputEmail4">Name </label><br>
                  <input type="text" class="form-control" id="name" placeholder="Name of the Role" value="{{$role->name}}" name="name">
                </div>
                <div class="form-group col-md-7">
                  <label for="inputPassword4">Display Name</label><br>
                  <input type="text" class="form-control" id="display_name" name="display_name" placeholder="Display Name" value="{{$role->display_name}}">
                </div>
              </div>
              <div class="form-group">
                <label for="inputAddress">Description</label><br>
              <textarea class="form-control" name="description" placeholder="Desription about the role" id="description" >{{$role->description}}</textarea>
              </div>
              <div class="form-group">
                <label>Permissions</label><br>
              @foreach($permission as $permission)
              <div class="form-check form-check-inline mr-3">
                  <label class="form-check-label">
                      <input class="form-check-input" type="checkbox" value="{{$permission->id}}" name="permission[]" {{in_array( $permission->id,$roleperm ) ? "checked" : " "}} > {{$permission->name}}
                      <span class="form-check-sign">
                          <span class="check"></span>
                      </span>
                  </label>
              </div>
            @endforeach
        </div>

              <button type="submit" class="btn btn-primary">Update</button>
            </form>

        </div>
      </div>

    </div>
  </div>
@endsection
