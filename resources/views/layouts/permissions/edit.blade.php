@include('layouts.header')
            <div class="col-md-9 col-lg-9">
                <h5>Edit Permission</h5>
                @php
                    $action=route('permissions.update',$permission->id);
                @endphp
                <form method="post" action="{{$action}}">
                    @method('put')
                    {{csrf_field()}}
                <div class="form-group">
                  <label>Name</label>
                  <input type="text"
                    class="form-control" name="name" id="" placeholder="" value="{{$permission->name}}">
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
                    <button type="reset" class="btn btn-warning" value="Reset">Reset</button>
                  </div>
                  </select>
                </form>
            </div>
        </div>
    </div>
    @php
        $php_array = [];
        foreach($rolesOfPermission as $per)
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
