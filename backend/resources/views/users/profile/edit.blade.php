@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<form action="{{ route('profile.update') }}" method="post" enctype="multipart/form-data">
  @csrf
  @method('PATCH')

  <div class="row mb-3">
    <div class="col-4">
      <label for="avatar" class="form-label fw-bold">Profile Picture</label>
      @if($user->avatar)
      <img src="{{ asset('storage/avatars/'. $user->avatar) }}" alt="{{ $user->avatar }}" class="img-thumbnail card-img rounded-circle d-block profile-avatar">
      @else
      <i class="far fa-user-circle profile-icon d-block text-center text-secondary profile-icon"></i>
      @endif
      <input type="file" name="avatar" id="avatar" class="form-control mt-1">
      @error('avatar')
      <p class="text-danger small">{{ $message }}</p>
      @enderror
    </div>
  </div>
  <div class="mb-3">
    <label for="name" class="form-label fw-bold">Name</label>
    <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" autofocus>
    @error('name')
    <p class="text-danger small">{{ $message }}</p>
    @enderror
  </div>
  <div class="mb-3">
    <label for="email" class="form-label fw-bold">Email Adress</label>
    <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}">
  </div>
  <div class="mb-3">
    <label for="intro" class="form-label fw-bold">Introduction</label>
    <textarea name="intro" id="intro" rows="5" class="form-control" placeholder="Describe yourself" >{{old('intro', $user->introduction)}}</textarea>
    @error('intro')
    <p class="text-danger small">{{ $message }}</p>
    @enderror
  </div>

  <button type="submit" class="btn btn-primary px-5">Save</button>
</form>
@endsection
