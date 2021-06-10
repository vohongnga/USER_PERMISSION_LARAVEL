@include('layouts.header')
            <div class="col-md-9 col-lg-9">
                <h5>Show Role</h5>
                <form method="" action="">
                <div class="form-group">
                  <label>Name</label>
                  <input type="text"
                    class="form-control" name="name" id="" placeholder="" value={{$role->name}}>
                </div>
                <div class="form-group">
                    <label>Permission</label>
                    <select name = "permission[]" class="selectpicker" multiple data-live-search="true">
                        @foreach ($permissions as $permission)
                            <option value="{{$permission->id}}">{{$permission->name}}</option>
                        @endforeach

                    </select>
                    @php
                        $urlEdit = route('roles.edit',$role->id);
                        $urlDel = route('roles.destroy', $role->id);
                    @endphp
                  </div>
                  <div class="form-group">
                    <a class="btn btn-primary" href = "{{$urlEdit}}">Edit</a>
                    <form method = "post" action = {{$urlDel}} style="display: inline">
                        @method('DELETE')
                        @csrf
                        <button class = "btn btn-danger" onclick="alert('Are you sure to delete role!')">Delete</button>
                    </form>
                  </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
