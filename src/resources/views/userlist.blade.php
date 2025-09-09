@extends('adminlayout')
@section('user')
    active-nav-link
@endsection
@section('title')
    User List
@endsection
@section('content')

@if (count($users)<=0)
    <h1 class="text-center mt-5">No User Found</h1>
@else
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-elegant animate-fade-in">
            <div class="card-header bg-white text-center py-4">
                <h3 class="card-title mb-1">User List</h3>
                <p class="text-muted mb-0">View and manage your user</p>
            </div>
            <div class="card-body p-4">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Role</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <th scope="row">{{$user->id}}</th>
                                <td>{{$user->username}}</td>
                                <td>{{$user->email}}</td>
                                <td>
                                    @if ($user->username == 'admin')
                                         <section class="d-flex align-items-center">
                                            <p class="mb-0 me-2">Admin</p>
                                         </section>
                                    @else
                                        <form action="{{ route('users.updateRole', $user->id) }}" method="POST">
                                            @csrf
                                            <select class="form-select" name="role" onchange="this.form.submit()">
                                                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                                <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                                            </select>
                                        </form>
                                        @if(session('success'))
                                            <div class="alert alert-success mt-2" id="success-alert">
                                            {{ session('success') }}
                                        </div>

                                        <script>
                                            setTimeout(function() {
                                                let alertBox = document.getElementById('success-alert');
                                                if (alertBox) {
                                                alertBox.style.transition = "opacity 0.5s ease";
                                                alertBox.style.opacity = "0";
                                                setTimeout(() => alertBox.remove(), 2000);
                                                }}, 2000);
                                         </script>
                                        @endif

                                    @endif
                                   
                                </td>
                                <td>
                                    @if($user->username == 'admin')
                                        <a href="#" class="btn btn-danger disabled">Delete</a>
                                    @else
                                        <form action="{{ route('userdelete', $user->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger deleteButton">
                                            Delete
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endif

@endsection