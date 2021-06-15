@include('layouts.header')
            <div class="col-md-9 col-lg-9">
                <h5>Add Permission</h5>
                <form method="post" action="{{route('permissions.store')}}">
                    {{csrf_field()}}
                <div class="form-group">
                  <label>Name</label>
                  <input type="text"
                    class="form-control" name="name" id="" placeholder="">
                    <small id="helpId" class="text-muted">Format: "Action Object" Action(create, edit, delete, show) Object(user, role, permission) Ex: create user
                    </small>
                    @error('name')
                    <p class="txtred">{{ $message }}</p>
                    @enderror
                </div>
                {{-- <div class="form-group">
                    <label>Role</label>
                    <select name = "role_id[]" class="selectpicker" multiple data-live-search="true">
                        @foreach ($roles as $role)
                            <option value="{{$role->id}}">{{$role->name}}</option>
                        @endforeach

                    </select>
                    @error('role_id')
                    <p class="txtred">{{ $message }}</p>
                    @enderror
                  </div> --}}
                  <div class="form-group">
                    <button type = "submit" class="btn btn-primary">Submit</button>
                    <button type="reset" class="btn btn-warning">Reset</button>
                  </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
