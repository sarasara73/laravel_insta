@extends('layouts.app')

@section('title','Home')

@section('content')
<div class="row">
    <div class="col-8">
        @if( Auth::user()->following->count()>0 || Auth::user()->posts->count()>0 )
            @if($all_posts->isNotEmpty())
                @foreach($all_posts as $post)
                    @if($post->user->isFollowed() || $post->user->id === Auth::user()->id)
                <div class="card mb-4">
                    @include('users.posts.contents.title')
                    @include('users.posts.contents.body')
                </div>
                    @endif
                @endforeach
                <!-- <div class="d-flex justify-content-center">
                    {{ $all_posts->links() }}
                </div> -->
            @else
            <!-- if the site doesn't have any posts yet -->
            <div class="text-center">
                <h2>Share Photos</h2>
                <p class="text-muted">When you share photos, they'll appear on your profile.</p>
                <a href="{{ route('post.create') }}" class="text-decoration-none">Share your first photo</a>
            </div>
            @endif
        @else
        <!-- the user is not following anyone or doesn't have any post -->
         <div class="text-center">
            <h2>Share Photos</h2>
            <p class="text-muted">When you share photos, they'll appear on your profile.</p>
            <a href="{{ route('post.create') }}" class="text-decoration-none">Share your first photo</a>
        </div>
        @endif
    </div>
    <div class="col-4">
        <div class="row align-items-center bg-white mb-5 shadow-sm rounded-3">
            <div class="col-auto py-3">
                <a href="{{ route('profile.show', Auth::user()->id) }}">
                    @if(Auth::user()->avatar)
                    <img src="{{ asset('storage/avatars/'. Auth::user()->avatar) }}" alt="{{ Auth::user()->avatar }}" class="rounded-circle overview-avatar">
                    @else
                    <i class="far fa-user-circle text-secondary text-center overview-icon"></i>
                    @endif
                </a>
            </div>
            <div class="col ps-0">
                <a href="{{ route('profile.show', Auth::user()->id) }}" class="text-decoration-none">
                    <div class="text-dark fw-bold">{{ Auth::user()->name }}</div>
                    <div class="text-muted">{{ Auth::user()->email }}</div>
                </a>
            </div>
        </div>

        <!-- suggestion -->
        @include('users.posts.contents.suggestions')
    </div>
</div>
@endsection
