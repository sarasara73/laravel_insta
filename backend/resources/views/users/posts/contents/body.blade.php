<!-- clickable post image -->
<div class="container p-0">
  <a href="{{ route('post.show', $post->id) }}">
    <img src="{{ asset('/storage/images/'. $post->image) }} " alt="{{ $post->image }}" class="card-img rounded-0">
  </a>
</div>

<!-- details of the post -->
<div class="card-body">
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
  <!-- include comments here -->
  @include('users.posts.contents.comments')
</div>
