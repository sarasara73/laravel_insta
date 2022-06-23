@extends('layouts.app')

@section('title', 'Followers')

@section('content')
@include('users.profile.header')

<div style="margin-top: 100px">

  <!-- show all followers here -->
  @if ($user->followers->count() != 0)
  <div class="container col-4">
    <h3 class="text-muted text-center">Followers</h3>

    @foreach($user->followers as $follower)
      <div class="row align-items-center mt-3">
        <div class="col-auto">
          <a href="{{ route('profile.show' , $follower->follower->id) }}">
            @if ($follower->follower->avatar)
            <img src="{{ asset('/storage/avatars/' . $follower->follower->avatar) }}" alt="{{ $follower->follower->avatar }}" class="rounded-circle title-avatar">
            @else
            <i class="far fa-user-circle text-secondary title-icon"></i>
            @endif
          </a>
        </div>
        <div class="col ps-0">
          <a href="{{ route('profile.show', $follower->follower->id) }}" class="text-decoration-none fw-bold text-dark small">{{ $follower->follower->name }}</a>
        </div>
        <div class="col-auto text-end">
          @if ($follower->follower->isFollowed())
          <form action="{{ route('follow.destroy', $follower->follower->id) }}" method="post" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-outline-secondary btn-sm border-0">Following</button>
          </form>
          @else
          <form action="{{ route('follow.store', $follower->follower->id) }}" method="post" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-outline-primary btn-sm border-0">Follow</button>
          </form>
          @endif
        </div>
      </div>
    @endforeach
  </div>
  @else
  <h3 class="text-muted text-center">No followers yet.</h3>
  @endif
  <!-- show following if already follwing and follow, if not yet followed. -->
</div>

@endsection
