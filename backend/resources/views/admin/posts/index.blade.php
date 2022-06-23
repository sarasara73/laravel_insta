@extends('layouts.app')

@section('title', 'Admin: Posts')

@section('content')
@if ($all_posts->isNotEmpty())
<table class="table table-hover align-middle bg-white border text-secondary">
  <thead class="small table-primary text-secondary">
    <tr>
      <th></th>
      <th></th>
      <th>CATEGORY</th>
      <th>OWNER</th>
      <th>CREATED AT</th>
      <th>STATUS</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    @foreach ( $all_posts as $post)
    <tr>
      <td class="text-end">{{ $post->id }}</td>
      <!-- image -->
      <td>
        <a href="{{ route('post.show', $post->id) }}">
          <img src="{{ asset('storage/images/' . $post->image) }}" alt="{{ $post->image }}" class="d-block mx-auto admin-posts-img">
        </a>
      </td>
      <!-- category -->
      <td>
        <!-- <div class="col text-end">  -->
          @foreach ($post->categoryPost as $category_post)
          <span class="badge bg-secondary bg-opacity-50">
            {{ $category_post->category->name }}
          </span>
          @endforeach
        <!-- </div> -->
      </td>
      <!-- owner -->
      <td>
        <a href="{{ route('profile.show', $post->user->id) }}" class="text-dark text-decoration-none">{{ $post->user->name }}</a>
      </td>
      <!-- created at -->
      <td>{{ $post->created_at }}</td>
      <!-- status -->
      <td>
        @if ($post->trashed())
        <i class="fas fa-minus-circle text-secondary"></i>&nbsp; Hidden
        @else
        <i class="fas fa-circle text-primary"></i>&nbsp; Visible
        @endif
      </td>
      <td>
        <div class="dropdown">
          <button class="btn btn-sm" data-bs-toggle="dropdown">
            <i class="fas fa-ellipsis-h"></i>
          </button>

          @if ($post->trashed())
          <div class="dropdown-menu">
            <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#unhide-post-{{ $post->id }}">
              <i class="fas fa-eye"></i> Unhide Post {{ $post->id }}
            </button>
          </div>
          @else
          <div class="dropdown-menu">
            <button class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#hide-post-{{ $post->id }}">
              <i class="fas fa-eye-slash"></i> Hide Post {{ $post->id }}
            </button>
          </div>
          @endif
        </div>
        <!-- include modal here -->
        @include('admin.posts.modal.status')
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
{{ $all_posts->links() }}
@endif
@endsection
