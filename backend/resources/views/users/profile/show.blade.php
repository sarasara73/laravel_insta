@extends('layouts.app')

@section('title', 'Profile')

@section('content')
@include('users.profile.header')

<!-- show posts -->
@if ($user->posts->isNotEmpty())
<div class="row" style="margin-top: 100px;">
  @foreach ($user->posts as $post)
  <div class="col-4 mb-4">
    <a href="{{ route('post.show', $post->id) }}">
      <img src="{{ asset('/storage/images/'.$post->image) }}" alt="{{ $post->image }}" class="grid-img">
    </a>
  </div>
  @endforeach
</div>
@endif
@endsection
