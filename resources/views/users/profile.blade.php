@extends('layouts.back')
@section('title', 'Profile')
@php
use Illuminate\Support\Str;
@endphp
@push('styles')
    <link rel="stylesheet" href="{{ asset('backend/assets/modules/select2/dist/css/select2.min.css') }}">
    <style>
        .profile-widget-picture {
            width: 100px;
            height: 100px;
            object-fit: cover;
            object-position: center;
            border: 3px solid #fff;
            box-shadow: 0 2px 6px rgba(0,0,0,0.15);
        }
    </style>
@endpush
@section('content')
@php
$user = Auth::user();
@endphp
<section class="section">
    <div class="section-header">
        <h1>Profile</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item">Profile</div>
        </div>
    </div>
    <div class="section-body">
        <h2 class="section-title">Hi, {{ Auth::user()->name }}</h2>
        <p class="section-lead">
            Change information about yourself on this page.
        </p>

        <div class="row mt-sm-4">
            <div class="col-12 col-md-12 col-lg-5">
                <div class="card profile-widget">
                    <div class="profile-widget-header">
                        <img alt="image" src="{{ $user->image ? asset('storage/' . $user->image) : asset('backend/assets/img/avatar/xyz.png') }}" class="rounded-circle profile-widget-picture">
                    </div>
                    <div class="profile-widget-description">
                        <div class="mb-3 row">
                            <label for="name" class="col-md-4 col-form-label text-md-end text-start"><strong>Name:</strong></label>
                            <div class="col-md-6" style="line-height: 35px;">
                                {{ $user->name }}
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="email" class="col-md-4 col-form-label text-md-end text-start"><strong>Email Address:</strong></label>
                            <div class="col-md-6" style="line-height: 35px;">
                                {{ $user->email }}
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="phone" class="col-md-4 col-form-label text-md-end text-start"><strong>Phone:</strong></label>
                            <div class="col-md-6" style="line-height: 35px;">
                                {{ $user->phone ?? 'Not provided' }}
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="location" class="col-md-4 col-form-label text-md-end text-start"><strong>Location:</strong></label>
                            <div class="col-md-6" style="line-height: 35px;">
                                {{ $user->location ?? 'Not provided' }}
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="bio" class="col-md-4 col-form-label text-md-end text-start"><strong>Bio:</strong></label>
                            <div class="col-md-6" style="line-height: 35px;">
                                {{ Str::limit($user->bio ?? 'No bio provided', 100) }}
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="reading_interests" class="col-md-4 col-form-label text-md-end text-start"><strong>Reading Interests:</strong></label>
                            <div class="col-md-6" style="line-height: 35px;">
                                @if($user->reading_interests && is_array($user->reading_interests))
                                    @foreach($user->reading_interests as $interest)
                                        <span class="badge bg-secondary me-1">{{ $interest }}</span>
                                    @endforeach
                                @else
                                    Not specified
                                @endif
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="roles" class="col-md-4 col-form-label text-md-end text-start"><strong>Roles:</strong></label>
                            <div class="col-md-6" style="line-height: 35px;">
                                @forelse ($user->getRoleNames() as $role)
                                    <span class="badge bg-primary">{{ $role }}</span>
                                @empty
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-12 col-lg-7">
                <div class="card">
                    <form method="post" action="{{ route('users.update', $user->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method("PUT")
                        <div class="card-header">
                            <h4>Edit Profile</h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-3 row">
                                <label for="name" class="col-md-4 col-form-label text-md-end text-start">Name</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ $user->name }}">
                                    @if ($errors->has('name'))
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="email" class="col-md-4 col-form-label text-md-end text-start">Email Address</label>
                                <div class="col-md-6">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ $user->email }}">
                                    @if ($errors->has('email'))
                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="password" class="col-md-4 col-form-label text-md-end text-start">Password</label>
                                <div class="col-md-6">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                                    @if ($errors->has('password'))
                                        <span class="text-danger">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="password_confirmation" class="col-md-4 col-form-label text-md-end text-start">Confirm Password</label>
                                <div class="col-md-6">
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="phone" class="col-md-4 col-form-label text-md-end text-start">Phone</label>
                                <div class="col-md-6">
                                    <input type="tel" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                                    @if ($errors->has('phone'))
                                        <span class="text-danger">{{ $errors->first('phone') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="location" class="col-md-4 col-form-label text-md-end text-start">Location</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control @error('location') is-invalid @enderror" id="location" name="location" value="{{ old('location', $user->location) }}" placeholder="City, Country">
                                    @if ($errors->has('location'))
                                        <span class="text-danger">{{ $errors->first('location') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="bio" class="col-md-4 col-form-label text-md-end text-start">Bio</label>
                                <div class="col-md-6">
                                    <textarea class="form-control @error('bio') is-invalid @enderror" id="bio" name="bio" rows="3" placeholder="Tell us about yourself...">{{ old('bio', $user->bio) }}</textarea>
                                    @if ($errors->has('bio'))
                                        <span class="text-danger">{{ $errors->first('bio') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="reading_interests" class="col-md-4 col-form-label text-md-end text-start">Reading Interests</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control @error('reading_interests') is-invalid @enderror" id="reading_interests" name="reading_interests" value="{{ old('reading_interests', is_array($user->reading_interests) ? implode(', ', $user->reading_interests) : '') }}" placeholder="Fiction, Science, History, etc. (comma separated)">
                                    <small class="form-text text-muted">Enter your reading interests separated by commas</small>
                                    @if ($errors->has('reading_interests'))
                                        <span class="text-danger">{{ $errors->first('reading_interests') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="image" class="col-md-4 col-form-label text-md-end text-start">Profile Image</label>
                                <div class="col-md-6">
                                    <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image">
                                    @if ($errors->has('image'))
                                        <span class="text-danger">{{ $errors->first('image') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="roles" class="col-md-4 col-form-label text-md-end text-start">Roles</label>
                                <div class="col-md-6">
                                    <select class="form-control @error('roles') is-invalid @enderror select2" multiple aria-label="Roles" id="roles" name="roles[]">
                                        @forelse ($user->getRoleNames() as $role)
                                            <option value="{{ $role }}" selected>
                                                {{ $role }}
                                            </option>
                                        @empty
                                        @endforelse
                                    </select>
                                    @if ($errors->has('roles'))
                                        <span class="text-danger">{{ $errors->first('roles') }}</span>
                                    @endif
                                </div>
                            </div>

                            <input type="hidden" name="from" value="profile">
                        </div>
                        <div class="card-footer text-end">
                            <button type="submit" class="btn btn-primary">Update Profile</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection




@push('scripts')
    <script src="{{ asset('backend/assets/modules/select2/dist/js/select2.full.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
@endpush

