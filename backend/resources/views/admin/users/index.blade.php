@extends('layouts.app')

@section('title', 'Admin: Users')

@section('content')
<table class="table table-hover align-middle bg-white border text-secondary">
  <thead class="small table-success text-secondary">
    <tr>
      <th></th>
      <th>NAME</th>
      <th>EMAIL</th>
      <th>CREATED AT</th>
      <th>STATUS</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    @foreach ( $all_users as $user)
    <tr>
      <td>
        @if ($user->avatar)
        <img src="{{ asset('/storage/avatars/' . $user->avatar) }}" alt="{{ $user->avatar }}" class="rounded-circle d-block mx-auto admin-users-avatar">
        @else
        <i class="far fa-user-circle d-block text-center admin-users-icon"></i>
        @endif
      </td>
      <td>
        <a href="{{ route('profile.show', $user->id) }}" class="text-decoration-none text-dark fw-bold">{{ $user->name }}</a>
      </td>
      <td>{{ $user->email }}</td>
      <td>{{ $user->created_at }}</td>
      <td>
        @if ($user->trashed())
        <i class="far fa-circle text-secondary"></i>&nbsp; Inactive
        @else
        <i class="fas fa-circle text-success"></i>&nbsp; Active
        @endif
      </td>
      <td>
        @if($user->role_id === App\Models\User::USER_ROLE_ID)
        <!-- @if(Auth::user()->id != $user->id) -->
        <div class="dropdown">
          <button class="btn btn-sm" data-bs-toggle="dropdown">
            <i class="fas fa-ellipsis-h"></i>
          </button>

          @if ($user->trashed())
          <div class="dropdown-menu">
            <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#activate-user-{{ $user->id }}">
              <i class="fas fa-user-check"></i> Activate {{ $user->name }}
            </button>
          </div>
          @else
          <div class="dropdown-menu">
            <button class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#deactivate-user-{{ $user->id }}">
              <i class="fas fa-user-slash"></i> Deactivate {{ $user->name }}
            </button>
          </div>
          @endif
        </div>
        <!-- include modal here -->
        @include('admin.users.modal.status')
        @endif
        @endif
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
{{ $all_users->links() }}
@endsection
