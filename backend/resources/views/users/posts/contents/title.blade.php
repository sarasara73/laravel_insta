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
      <div class="dropdown">
        <button class="btn btn-sm shadow-none" data-bs-toggle="dropdown">
          <i class="fas fa-ellipsis-h"></i>
        </button>

        <!-- if you are the owner of the post, you can edit or delete this post -->
        @if (Auth::user()->id === $post->user->id)
        <div class="dropdown-menu">
          <a href="{{ route('post.edit', $post->id) }}" class="dropdown-item text-primary">
            <i class="far fa-edit"></i> Edit
          </a>
          <!-- to open a modal -->
          <button class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#delete-post-modal{{ $post->id }}">
            <i class="fas fa-trash-alt"></i> Delete
          </button>
        </div>
        @else
        <!-- if you are not the owner of the post, show an unfollow/follow button -->
        <div class="dropdown-menu">
          <form action="{{ route('follow.destroy', $post->user->id) }}" method="post">
              @csrf
              @method('DELETE')

              <button type="submit" class="dropdown-item text-danger">Unfollow</button>
          </form>
        </div>
        @endif
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
        <form action="{{ route('post.destroy', $post->id) }}" method="post">
          @csrf
          @method('DELETE')

          <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger btn-sm">Delete</button>
        </form>
      </div>
    </div>
  </div>
</div>
