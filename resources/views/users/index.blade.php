@extends('layouts.adminApp')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">Admin</h3>
                <ul class="breadcrumbs mb-3">
                    <li class="nav-home">
                        <a href="#">
                            <i class="icon-home"></i>
                        </a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">Pengguna</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Users Management</h4>
                            @if (session('success'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('success') }}
                                </div>
                            @endif
                            <a class="btn btn-primary ms-auto" href="{{ route('users.create') }}"><i class="fa fa-plus"></i>
                                Create New User</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="multi-filter-select" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Profile Image</th>
                                        <th>Gender</th>
                                        <th>Roles</th>
                                        <th width="280px">Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Profile Image</th>
                                        <th>Gender</th>
                                        <th>Roles</th>
                                        <th width="280px">Action</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @foreach ($data as $key => $user)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                @if ($user->profile_image)
                                                    <img src="{{ asset('storage/public/profile_images/' . $user->profile_image) }}"
                                                        alt="{{ $user->name }}"
                                                        style="width: 50px; height: 50px; object-fit: cover;"
                                                        class="rounded-circle">
                                                @else
                                                    <img src="{{ asset('assets/img/default-profile.jpg') }}"
                                                        alt="Default Image"
                                                        style="width: 50px; height: 50px; object-fit: cover;"
                                                        class="rounded-circle">
                                                @endif
                                            </td>
                                            <td>{{ $user->gender }}</td>
                                            <td>
                                                @if (!empty($user->getRoleNames()))
                                                    @foreach ($user->getRoleNames() as $v)
                                                        <label class="badge bg-success">{{ $v }}</label>
                                                    @endforeach
                                                @endif
                                            </td>
                                            <td>
                                                <a class="btn btn-info btn-sm" href="{{ route('users.show', $user->id) }}">
                                                    <i class="far fa-eye"></i> Show
                                                </a>
                                                <a class="btn btn-primary btn-sm"
                                                    href="{{ route('users.edit', $user->id) }}">
                                                    <i class="far fa-edit"></i> Edit
                                                </a>
                                                <form method="POST" action="{{ route('users.destroy', $user->id) }}"
                                                    style="display:inline">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="fas fa-trash-alt"></i> Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
