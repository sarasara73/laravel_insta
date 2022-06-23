<div class="row">
  <div class="col-4">
    @if($user->avatar)
    <img src="{{ asset('storage/avatars/'. $user->avatar) }}" alt="{{ $user->avatar }}" class="img-thumbnail rounded-circle d-block mx-auto profile-avatar">
    @else
    <i class="far fa-user-circle text-secondary d-block text-center profile-icon"></i>
    @endif
  </div>
  <div class="col-8">
    <div class="row mb-3">
      <div class="col-auto">
        <h2 class="display-6 inline">{{ $user->name }}</h2>
      </div>
      <div class="col-auto p-2">
        @if(Auth::user()->id === $user->id)
        <a href="{{ route('profile.edit') }}" class="btn btn-outline-secondary btn-sm fw-bold">Edit Profile</a>
        @else
          @if($user->isFollowed())
          <!-- show unfollow if account is already followed. -->
          <form action="{{ route('follow.destroy', $user->id) }}" method="post" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-outline-secondary btn-sm fw-bold">Following</button>
          </form>
          @else
          <form action="{{ route('follow.store', $user->id) }}" method="post" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-primary btn-sm fw-bold">Follow</button>
          </form>
          @endif
        @endif
      </div>
    </div>
    <div class="row mb-3">
      <div class="col-auto">
        <a href="{{ route('profile.show', $user->id) }}" class="text-decoration-none text-dark"><strong>{{ $user->posts->count() }}</strong> {{ $user->posts->count() == 1 ? 'post' : 'posts' }}</a>
      </div>

      <div class="col-auto">
        <a href="{{ route('profile.followers', $user->id) }}" class="text-decoration-none text-dark"><strong>{{ $user->followers->count() }}</strong> {{ $user->followers->count() == 1 ? 'follower' : 'followers' }}</a>
      </div>

      <div class="col-auto">
        <strong>{{ $user->following->count() }}</strong> following
      </div>
      <div class="row">
        <p class="fw-bold">{{ $user->introduction }}</p>
      </div>
    </div>
  </div>
</div>
