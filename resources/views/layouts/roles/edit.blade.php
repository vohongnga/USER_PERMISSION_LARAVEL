@include('layouts.header')

            <div class="col-md-9 col-lg-9">
                <h5>Edit Role</h5>
                @php
                    $action=route('roles.update',$role->id);
                @endphp
                <form method="post" action="{{$action}}">
                    @method('PUT')
                    {{csrf_field()}}
                <div class="form-group">
                  <label>Name</label>
                  <input type="text"
                    class="form-control" name="name" id="" placeholder="" value={{$role->name}}>
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
                    <button type="reset" class="btn btn-warning" value="Reset">Reset</button>
                  </div>
                </form>
            </div>
        </div>
    </div>
    @php
        $php_array = [];
        foreach($permissionsRole as $per)
        {
            $php_array[] = $per->id;
        }
    @endphp
    <script>
        var js_array = [<?php echo '"'.implode('","', $php_array).'"' ?>];
        $('.selectpicker').selectpicker('val', js_array);
    </script>
</body>
</html>
