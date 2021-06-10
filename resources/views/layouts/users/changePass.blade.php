@include('layouts.header')
            <div class="col-md-9 col-lg-9">
                <h5>Change password</h5>
                @php
                    $action=route('users.changePass',$user->id);
                @endphp
                <form method="post" action="{{$action}}">
                    @method('PUT')
                    {{csrf_field()}}
                <div class="form-group">
                  <label>Password</label>
                  <input type="password"
                    class="form-control" name="password" id="" placeholder="">
                    @error('password')
                    <p class="txtred">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Password confirmed</label>
                    <input type="password"
                      class="form-control" name="password_confirmation" id="" placeholder="">
                      @error('password_confirmation')
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
