@include('layouts.header')
            <div class="col-md-9 col-lg-9">
                <a class = "btn btn-primary m-2 mb-3" href="{{route('permissions.create')}}">Add</a>
                {{-- @if(Session::has('msg'))
 {{Session::get('msg')}}
 @endif --}}
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $index = ($page-1)*10;
                        @endphp
                        @foreach ($permissions as $permission)
                            @php
                                $index ++;
                                $urlEdit = route('permissions.edit',$permission->id);
                                $urlDel = route('permissions.destroy',$permission->id);
                            @endphp

                        <tr>
                            <td scope="row">{{$index}}</td>
                            <td>{{$permission->name}}</td>
                            <td>{{$permission->slug}}</td>
                            <td>
                                <a class="btn btn-primary mr-2 mb-1" href="{{$urlEdit}}" >Edit</a>
                                <form method = "post" action = {{$urlDel}} style="display: inline">
                                    @method('DELETE')
                                    @csrf
                                    <button class = "btn btn-danger" onclick="alert('Are you sure to delete permission!')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="paginate">
                    {{$permissions->links("pagination::bootstrap-4")}}
                </div>
            </div>
        </div>
    </div>
</body>
</html>
