@include('layouts.header')
            <div class="col-md-9 col-lg-9">
                <a class = "btn btn-primary m-2 mb-3" href="{{route('users.create')}}">Add</a>
                <form style="width:fit-content;display:inline-block" method="get" action="{{route('users.search')}}">
                    @csrf
                    <div class="form-group">
                        <input type="search" name = "search" placeholder="&#xF002; Search" style="font-family: Arial, 'Font Awesome 5 Free'" />
                    </div>

                </form>

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
                            $auth = Auth::user()->id
                        @endphp
                        @foreach ($users as $user)
                            @php
                                $index ++;
                                $urlEdit = route('users.edit',['user'=>$user->id,'page'=>$page]);
                                $urlDel = route('users.destroy',$user->id);
                                $urlChangePass = route('users.changePass',$user->id);
                                $disabled = "disabled";
                                $disabledBtn = "disabled";
                            @endphp

                        <tr>
                            <td scope="row">{{$index}}</td>
                            <td>{{$user->display_name}}</td>
                            <td>{{$user->email}}</td>
                            <td>
                                @if ($user->role->id != 1 || $auth == $user->id)
                                @php


                                    $disabled="";
                                    $disabledBtn = "";
                                @endphp
                            @endif
                                <a class="btn btn-primary mr-2 mb-1 {{$disabled}} " href="{{$urlEdit}}" disabled tabindex="-1">Edit</a>
                                <a class="btn btn-primary mr-2 {{$disabled}}" href="{{$urlChangePass}}">Change password</a>
                                <form method = "post" action = {{$urlDel}} style="display: inline">
                                    @method('DELETE')
                                    @csrf
                                    <button class = "btn btn-danger" {{$disabledBtn}} onclick="alert('Are you sure to delete user!')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="paginate">
                    {{$users->links()}}
                </div>
            </div>
        </div>
    </div>
</body>
</html>
