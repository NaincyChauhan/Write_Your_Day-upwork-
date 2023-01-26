<table id="shivadatatable" class="table table-bordered table-striped mb-5">
  <thead>
    <th>#</th>
    <th>Name</th>
    <th>Action</th>
  </thead>
  <tbody>
      @foreach($roles as $role)
          <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{$role->name}}</td>
              <td>
                <div class="d-flex align-items-center">
                  @can('update-role')
                    <a class="btn btn-success btn-sm btn-icon-text mr-3 text-white" href="{{ route('role.edit', $role->id) }}">
                      <i class="mdi mdi-table-edit"></i> Edit
                    </a>
                  @endcan
                  @can('delete-role')
                    <a class="btn btn-danger btn-sm btn-icon-text" onclick="event.preventDefault(); callDelete($(this))" href="{{ route('role.destroy', $role->id) }}">
                      <i class="mdi mdi-delete-variant"></i> Delete
                    </a>
                  @endcan
                </div>
              </td>
          </tr>
      @endforeach                                            
  </tbody>
  <tfoot>
      <th>#</th>
      <th>Name</th>
      <th>Role</th>
  </tfoot>
</table>
<script>
  makeDataTable();
</script>