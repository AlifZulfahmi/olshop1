@extends('layouts.adminApp')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">Profile</h3>
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
                        <a href="#">My Profile</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="card card-profile">
                    <div class="card-header" style="background-image: url('assets/img/blogpost.jpg')">
                        <div class="profile-picture">
                            <div class="avatar avatar-xl">
                                <img src="assets/img/profile.jpg" alt="..." class="avatar-img rounded-circle" />
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="user-profile text-center">
                            <div class="name">{{ $user->name }}</div>
                            <div class="job">{{ $user->email }}</div>
                            <div class="desc">
                                @if (!empty($user->getRoleNames()))
                                    @foreach ($user->getRoleNames() as $v)
                                        <label class="badge badge-success">{{ $v }}</label>
                                    @endforeach
                                @endif
                            </div>
                            <div class="view-profile">
                                <a href="{{ route('users.index') }}" class="btn btn-secondary w-100">Back</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
