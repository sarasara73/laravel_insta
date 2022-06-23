<!-- deactivate -->
<div class="modal fade" id="deactivate-user-{{ $user->id }}">
  <div class="modal-dialog">
    <div class="modal-content border-danger">
      <div class="modal-header border-danger">
        <h5 class="modal-title text-danger">
          <i class="fas fa-user-slash"></i> Deactivate User
        </h5>
      </div>
      <div class="modal-body">
        Are you sure you want to deactivate {{ $user->name }}?
      </div>
      <div class="modal-footer border-0">
        <form action="{{ route('admin.users.deactivate', $user->id) }}" method="post">
          @csrf
          @method('DELETE')

          <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger btn-sm">Deactivate</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- activate -->
<div class="modal fade" id="activate-user-{{ $user->id }}">
  <div class="modal-dialog">
    <div class="modal-content border-success">
      <div class="modal-header border-success">
        <h5 class="modal-title text-success">
          <i class="fas fa-user-check"></i> Activate User
        </h5>
      </div>
      <div class="modal-body">
        Are you sure you want to activate {{ $user->name }}?
      </div>
      <div class="modal-footer border-0">
        <form action="{{ route('admin.users.activate', $user->id) }}" method="post">
          @csrf
          @method('PATCH')

          <button type="button" class="btn btn-outline-success btn-sm" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-success btn-sm">Activate</button>
        </form>
      </div>
    </div>
  </div>
</div>
