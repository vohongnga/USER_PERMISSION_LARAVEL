@include('layouts.header')
            <div class="col-md-9 col-lg-9">
                <h5>Add User</h5>
                <form method="post" action="{{route('users.store')}}">
                    {{csrf_field()}}
                <div class="form-group">
                  <label>Name</label>
                  <input type="text"
                    class="form-control" name="display_name" id="" placeholder="">
                    @error('display_name')
                    <p class="txtred">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="text"
                      class="form-control" name="email" id="" placeholder="">
                      @error('email')
                        <p class="txtred">{{ $message }}</p>
                        @enderror
                  </div>
                  <div class="form-group">
                    <label>Password</label>
                    <input type="password"
                      class="form-control" name="password" id="" placeholder="">
                      @error('password')
                    <p class="txtred">{{ $message }}</p>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label>Confirm password</label>
                    <input type="password"
                      class="form-control" name="password_confirmation" id="" placeholder="">
                      @error('password_confirmation')
                    <p class="txtred">{{ $message }}</p>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label>Role</label>
                    <select name = "role_id">
                        <option value="0">Select Role</option>
                        @foreach ($roles as $role)
                            <option value="{{$role->id}}" >{{$role->name}}</option>
                        @endforeach

                    </select>
                    @error('role_id')
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
