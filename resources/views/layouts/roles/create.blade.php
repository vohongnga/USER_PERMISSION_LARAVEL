@include('layouts.header')
            <div class="col-md-9 col-lg-9">
                <h5>Add Role</h5>
                <form method="post" action="{{route('roles.store')}}">
                    {{csrf_field()}}
                <div class="form-group">
                  <label>Name</label>
                  <input type="text"
                    class="form-control" name="name" id="" placeholder="">
                    @error('name')
                    <p class="txtred">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Permission</label>
                    <select name = "permission[]" class="selectpicker" multiple data-live-search="true">
                        @foreach ($permissions as $permissionRole)
                            <option value="{{$permissionRole->id}}">{{$permissionRole->name}}</option>
                        @endforeach

                    </select>
                    @error('permission')
                    <p class="txtred">{{ $message }}</p>
                    @enderror
                  </div>
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
