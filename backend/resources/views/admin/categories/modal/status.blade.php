<!-- update -->
<div class="modal fade" id="edit-category-{{ $category->id }}">
  <div class="modal-dialog">
    <form action="{{ route('admin.categories.update', $category->id) }}" method="post">
    @csrf
    @method('PATCH')

      <div class="modal-content border-warning">
        <div class="modal-header border-warning">
          <h5 class="modal-title text-dark">
            <i class="fas fa-edit"></i> Edit Category
          </h5>
        </div>
        <div class="modal-body">
          <input type="text" value="{{ $category->name }}" placeholder="Category name" name="name" class="form-control">
        </div>
        <div class="modal-footer border-0">
            <button type="button" class="btn btn-outline-warning btn-sm" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-warning btn-sm">Update</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- delete -->
<div class="modal fade" id="delete-category-{{ $category->id }}">
  <div class="modal-dialog">

    <div class="modal-content border-danger">
      <div class="modal-header border-danger">
        <h5 class="modal-title text-dark">
          <i class="fas fa-trash"></i> Delete Category
        </h5>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to delete <span class="fw-bold">{{ $category->name }} </span>category?</p>
        <p class="fw-light">This action will affect all the posts under this category. Posts without a category will fall under Uncategorized.</p>
      </div>

      <div class="modal-footer border-0">
        <form action="{{ route('admin.destroy.update', $category->id) }}" method="post">
          @csrf
          @method('DELETE')

          <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger btn-sm">Delete</button>
        </form>
      </div>
    </div>
  </div>
</div>
