@extends('layouts.app')

@section('title','Show Post')

@section('content')
<style>
  .col-4 {
    overflow-y: scroll;
  }

  .card-body {
    position: absolute;
    top:65px;
  }

</style>


<div class="row border shadow">
  <div class="col p-0">
    <img src="{{ asset('/storage/images/'.$post->image) }}" alt="{{ $post->image }}" class="card-img rounded-0">
  </div>
  <div class="col-4 px-0 bg-white ">
    <div class="card border-0">
      <!-- title -->
      <div class="card-header bg-white py-3">
        <div class="row align-items-center">
          <div class="col-auto">
            <a href="{{ route('profile.show', $post->user->id) }}" class="text-secondary">
              @if($post->user->avatar)
              <img src="{{ asset('storage/avatars/'. $post->user->avatar) }}" alt="{{ $post->user->avatar }}" class="rounded-circle title-avatar">
              @else
              <i class="far fa-user-circle title-icon"></i>
              @endif
            </a>
          </div>

          <div class="col ps-0">
            <a href="{{ route('profile.show', $post->user->id) }}" class="text-decoration-none text-dark">{{ $post->user->name }}</a>
          </div>

          <div class="col-auto text-end">
            <!-- if you are the owner of the post, you can edit or delete this post -->
            @if (Auth::user()->id === $post->user->id)
            <div class="dropdown">
              <button class="btn btn-sm shadow-none" data-bs-toggle="dropdown">
                <i class="fas fa-ellipsis-h"></i>
              </button>
              <div class="dropdown-menu">
                <a href="{{ route('post.edit', $post->id) }}" class="dropdown-item text-primary">
                  <i class="far fa-edit"></i> Edit
                </a>
                <!-- to open a modal -->
                <button class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#delete-post-modal{{ $post->id }}">
                  <i class="fas fa-trash-alt"></i> Delete
                </button>
              </div>
            </div>
            @else
              <!-- if you are not the owner of the post, show an unfollow button -->
              @if($post->user->isFollowed())
              <div class="dropdown">
                <button class="btn btn-sm shadow-none" data-bs-toggle="dropdown">
                  <i class="fas fa-ellipsis-h"></i>
                </button>
                <div class="dropdown-menu">
                  <form action="{{ route('follow.destroy', $post->user->id) }}" method="post">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="dropdown-item text-danger">Unfollow</button>
                </div>
              </div>
              @else
              <form action="{{ route('follow.store', $post->user->id) }}" method="post" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-primary btn-sm">Follow</button>
              </form>
              @endif
            @endif
          </div>
        </div>
      </div>
      <!-- body -->
      <div class="card-body w-100">
        <div class="row align-items-center">
          <div class="col-auto">
            @if($post->isLiked())
            <form action="{{ route('like.destroy', $post->id) }}" method="post">
              @csrf
              @method('DELETE')
              <button type="submit" class="shadow-none btn btn-sm ps-0"><i class="fas fa-heart text-danger"></i></button>

              <!-- No. of likes -->
              <span>{{ $post->likes->count() }}</span>
            </form>
            @else
            <form action="{{ route('like.store', $post->id) }}" method="post">
              @csrf
              <button type="submit" class="shadow-none btn btn-sm ps-0"><i class="far fa-heart"></i></button>

              <!-- No. of likes -->
              <span>{{ $post->likes->count() }}</span>
            </form>
            @endif
          </div>
          <div class="col text-end">
            @if ($post->categoryPost->count() == 0)
            <div class="badge bg-dark text-wrap">
              Uncategorized
            </div>
            @endif
            @foreach ($post->categoryPost as $category_post)
            <div class="badge bg-secondary bg-opacity-50 text-wrap">
              {{ $category_post->category->name }}
            </div>
            @endforeach
          </div>
        </div>
        <div class="row">
          <div class="col">
            <a href="{{ route('profile.show', $post->user->id) }}" class="fw-bold text-dark text-decoration-none">{{ $post->user->name }}</a>
            &nbsp;
            <p class="d-inline fw-light">{{ $post->description }}</p>
          </div>
        </div>

        <!--comments-->
        <div class="mt-4">
          <form action="{{ route('comment.store', $post->id) }}" method="post">
            @csrf

            <div class="input-group">
              <textarea name="comment_body{{ $post->id }}" rows="1" class="form-control form-control-sm"  placeholder="Add a comment...">{{ old('comment_body'.$post->id) }}</textarea>
              <button type="submit" class="btn btn-outline-secondary btn-sm">Post</button>
            </div>
            <!-- error -->
            @error('comment_body'. $post->id)
              <p class="text-danger small">{{ $message }}</p>
            @enderror
          </form>

          @if($post->comments->isNotEmpty())
          <ul class="list-group mt-2">
            @foreach($post->comments as $comment)
            <li class="list-group-item border-0 p-0 mb-2">
               <a href="{{ route('profile.show', $comment->user->id) }}" class="fw-bold text-dark text-decoration-none">{{$comment->user->name}}</a>
              &nbsp;
              <p class="d-inline fw-light">{{ $comment->body }}</p>

              <form action="{{ route('comment.destroy', $comment->id) }}" method="post" class="mb-0">
                @csrf
                @method('DELETE')

                <span class="small text-muted">{{ date("D, M d Y", strtotime($comment->created_at)) }}</span>

                @if($comment->user->id === Auth::user()->id)
                  &middot;
                  <button type="submit" class="border-0 bg-transparent text-danger p-0 small">Delete</button>
                @endif
              </form>
            </li>
            @endforeach
          </ul>
          @endif

        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="delete-post-modal{{ $post->id }}">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-danger">
        <h5 class="modal-title text-white">
          <i class="fas fa-exclamation-triangle"></i> Delete Post
        </h5>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to delete this post?</p>
      </div>
      <div class="modal-footer border-0">
        <form action="{{ route('post.destroy', $post->id)}}" method="post">
          @csrf
          @method('DELETE')

          <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger btn-sm">Delete</button>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection
