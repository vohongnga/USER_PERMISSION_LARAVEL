@include('layouts.header')
@if (!isset($name))
@php
    $name = '';
@endphp

@endif
            <div class="col-md-9 col-lg-9">
                <div class = "header-search">
                    <a class = "btn btn-primary m-2 mb-3" href="{{route('users.create')}}">Add</a>
                    <form style="width:fit-content;display:inline-block" method="get" action={{route('users.search')}}>
                        @csrf
                        <div class="form-group">
                            <input type="text" name="search" id="" class="form-control" placeholder="&#xF002; Search" style="font-family: Arial, 'Font Awesome 5 Free'"  aria-describedby="helpId" value="{{$name}}">
                        </div>

                    </form>
                </div>

                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $index = ($page-1)*10;
                            $auth = Auth::user()->id;
                            $arrUser = $members;
                        @endphp
                        @if ($role)
                            @php
                                $arrUser = $users;
                            @endphp
                        @endif
                        @foreach ($arrUser as $user)
                            @php
                                $index ++;
                                $urlEdit = route('users.edit',['user'=>$user->id,'page'=>$page]);
                                $urlDel = route('users.destroy',$user->id);
                                $urlChangePass = route('users.changePass',$user->id);
                            @endphp

                        <tr>
                            <td scope="row">{{$index}}</td>
                            <td>{{$user->display_name}}</td>
                            <td>{{$user->email}}</td>
                            <td>
                                @if ($user->role->id != 1 || $auth == $user->id)
                                <a class="btn btn-primary mr-2  " href="{{$urlEdit}}" disabled tabindex="-1">Edit</a>
                                <a class="btn btn-primary mr-2 " href="{{$urlChangePass}}">Change password</a>
                                <form method = "post" action = {{$urlDel}} style="display: inline">
                                    @method('DELETE')
                                    @csrf
                                    <button class = "btn btn-danger" onclick="alert('Are you sure to delete user!')">Delete</button>
                                </form>
                            @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="paginate">
                    {{$arrUser->links("pagination::bootstrap-4")}}
                </div>
            </div>
        </div>
    </div>
    <script>
        $('.flex justify-between flex-1 sm:hidden').empty();

    </script>
</body>
</html>
