@extends('layouts.app')

@section('title', 'Admin: Categories')

@section('content')


<form action="{{ route('admin.categories.store') }}" method="post">
  @csrf

  <div class="row gx-2 mb-4">
    <div class="col-8">
      <input type="text" name="name" placeholder="Add a category..." class="form-control autofocus bg-white">
    </div>
    <div class="col">
      <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i>Add</button>
    </div>
    @error('name')
      <p class="text-danger small">{{ $message }}</p>
    @enderror
  </div>
</form>


  @if ($all_categories->isNotEmpty())
  <table class="table table-hover align-middle bg-white border text-secondary">
    <thead class="small table-warning text-secondary">
      <tr class="text-center">
        <th>#</th>
        <th>NAME</th>
        <th>COUNT</th>
        <th>LAST UPDATED</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      @foreach ( $all_categories as $category)
      <tr class="text-center">
        <td>{{ $category->id }}</td>
        <td>{{ $category->name }}</td>
        <td>{{ $category->categoryPost->count() }}</td>
        <td>{{ $category->updated_at }}</td>
        <td>
          <button class="btn btn-outline-warning me-2" data-bs-toggle="modal" data-bs-target="#edit-category-{{ $category->id }}" title="Edit">
            <i class="fas fa-pen"></i>
          </button>
          <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#delete-category-{{ $category->id }}" title="Delete">
            <i class="fas fa-trash-alt"></i>
          </button>
          @include('admin.categories.modal.status')
        </td>

      </tr>
      @endforeach
      <tr class="text-center">
        <td></td>
        <td class="text-dark">Uncategorized</td>
        <td>{{ $uncategorized_count }}</td>
        <td></td>
        <td></td>
      </tr>
    </tbody>
  </table>
  {{ $all_categories->links() }}
  @endif
@endsection
