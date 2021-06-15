@include('layouts.header')
            <div class="col-md-9 col-lg-9">
                <a class = "btn btn-primary m-2 mb-3" href="{{route('roles.create')}}">Add</a>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Permissions</th>
                            <th style="width:180px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $index = ($page-1)*10;
                        @endphp
                        @foreach ($roles as $role)
                            @php
                                $index ++;
                                $urlEdit = route('roles.edit',$role->id);
                                $urlDel = route('roles.destroy',$role->id);
                                $urlShow = route('roles.show', $role->id);
                            @endphp

                        <tr>
                            <td scope="row">{{$index}}</td>
                            <td>{{$role->name}}</td>
                            <td>{{$role->slug}}</td>
                            <td>
                                @foreach($role->permissions as $permission)
                                <div class="permission">{{$permission->name}}</div>
                                @endforeach
                            </td>
                            <td>
                                <a class="btn btn-primary mr-2 mb-1" href="{{$urlEdit}}" >Edit</a>
                                {{-- <a class="btn btn-primary mr-2 mb-1" href="{{$urlShow}}" >View</a> --}}
                                <form method = "post" action = {{$urlDel}} style="display: inline">
                                    @method('DELETE')
                                    @csrf
                                    <button class = "btn btn-danger" onclick="alert('Are you sure to delete role!')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="paginate">
                    {{$roles->links("pagination::bootstrap-4")}}
                </div>
            </div>
        </div>
    </div>
</body>
</html>
