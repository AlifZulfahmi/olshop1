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
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="card card-profile text-center">
                    <div class="card-header"
                        style="background-image: url('{{ asset('assets/img/blogpost.jpg') }}'); background-size: cover;">
                        <div class="profile-picture">
                            <div class="avatar avatar-xl">
                                @if ($user->profile_image)
                                    <img src="{{ asset('storage/profile_images/' . $user->profile_image) }}"
                                        alt="Profile Picture" class="avatar-img rounded-circle" />
                                @else
                                    <img src="{{ asset('assets/img/profile.jpg') }}" alt="Profile Picture"
                                        class="avatar-img rounded-circle" />
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="user-profile">
                            <div class="name">{{ $user->name }}</div>
                            <div class="job">{{ $user->email }}</div>
                            <div class="desc mt-2">
                                @if (!empty($user->getRoleNames()))
                                    @foreach ($user->getRoleNames() as $v)
                                        <span class="badge badge-success">{{ $v }}</span>
                                    @endforeach
                                @endif
                            </div>
                            <!-- Tambahkan bagian untuk Gender dan Address -->
                            <div class="details mt-3">
                                <strong>Gender:</strong> {{ $user->gender ?? 'N/A' }}<br>
                                <strong>Address:</strong> {{ $user->address ?? 'N/A' }}
                            </div>
                            <!-- Akhir bagian tambahan -->
                            <div class="view-profile mt-3">
                                <a href="{{ route('users.index') }}" class="btn btn-secondary w-100">Back</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
