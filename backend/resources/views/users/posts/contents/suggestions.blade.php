@if($suggested_users)
<p class="fw-bold text-secondary">Suggestions For You</p>

@foreach(array_slice($suggested_users, 0, 10) as $user)
<div class="row align-items-center mb-3">
  <div class="col-auto">
    <a href="{{ route('profile.show', $user->id) }}">
      @if($user->avatar)
      <img src="{{ asset('/storage/avatars/' . $user->avatar) }}" alt="{{ $user->avatar }}" class="rounded-circle title-avatar">
      @else
      <i class="far fa-user-circle text-secondary title-icon"></i>
      @endif
    </a>
  </div>
  <div class="col ps-0">
    <a href="{{ route('profile.show', $user->id) }}" class="text-decoration-none text-dark fw-bold small">{{ $user->name }}</a>
  </div>
  <div class="col-auto text-end">
    <form action="{{ route('follow.store', $user->id) }}" method="post" class="d-inline">
      @csrf
      <button type="submit" class="btn btn-outline-primary btn-sm border-0">Follow</button>
    </form>
  </div>
</div>
@endforeach

@endif
