@include('layouts.header')
            <div class="col-md-9 col-lg-9">
                <h5>Edit User</h5>
                @php
                    $action=route('users.update',['user'=>$user->id,'page'=>$page]);
                @endphp
                <form method="post" action="{{$action}}">
                    @method('PUT')
                    {{csrf_field()}}
                <div class="form-group">
                  <label>Name</label>
                  <input type="text"
                    class="form-control" name="display_name" id="" placeholder=""value="{{$user->display_name}}" >
                    @error('display_name')
                    <p class="txtred">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="text"
                      class="form-control" name="email" id="" placeholder="" value="{{$user->email}}">
                      @error('email')
                    <p class="txtred">{{ $message }}</p>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label>Role</label>
                    <select name = "role_id">
                        <option value="0">Select Role</option>
                        @foreach ($roles as $role)
                            @if ($role->id == $user->role->id)
                                @php
                                    $selected ="selected=selected";
                                @endphp
                            @else
                                @php
                                    $selected = "";
                                @endphp
                            @endif
                            <option value="{{$role->id}}" {{$selected}}>{{$role->name}}</option>
                        @endforeach

                    </select>
                    @error('role_id')
                    <p class="txtred">{{ $message }}</p>
                    @enderror
                  </div>
                  <div class="form-group">
                    <button type = "submit" class="btn btn-primary">Submit</button>
                    <button type="reset" class="btn btn-warning" value="Reset">Reset</button>
                  </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
