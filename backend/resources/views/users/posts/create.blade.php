@extends('layouts.app')

@section('title','Create Post')

@section('content')
<form action="{{ route('post.store') }}" method="post" enctype="multipart/form-data">
  @csrf
  <div class="mb-3">
    <label for="category" class="form-label d-block fw-bold">
      Category <span class="txt-muted fw-normal">(up to 3)</span>
    </label>
    @foreach ($all_categories as $category)
      <div class="form-check form-check-inline">
        <input type="checkbox" name="category[]" id="{{ $category->name }}" class="form-check-input" value="{{ $category->id }}" >
        <label for="{{ $category->name }}" class="form-check-label">{{ $category->name }}</label>
      </div>
    @endforeach
    <!-- error -->
    @error('category')
    <p class="text-danger small">{{ $message }}</p>
    @enderror
  </div>

    <div class="mb-3">
      <label for="description" class="form-label fw-bold">Description</label>
      <textarea name="description" id="description" rows="3" rows="10" class="form-control" placeholder="What's on your mind">{{ old('description') }}</textarea>
      <!-- error -->
      @error('description')
      <p class="text-danger small">{{ $message }}</p>
      @enderror
    </div>

    <div class="mb-3">
      <input type="file" name="image" class="form-control">
      <!-- error -->
      @error('image')
      <p class="text-danger small">{{ $message }}</p>
      @enderror
    </div>

    <button type="submit" class="btn btn-primary px-5">Post</button>
</form>
@endsection
