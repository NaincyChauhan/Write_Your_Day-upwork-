<table id="shivadatatable" class="table table-striped mb-5">
    <thead>
        <tr>
            <th>#</th>
            <th>Role</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $user->roles()->exists() ? $user->roles()->first()->name : '' }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>                                            
                <td>{{ $user->mobile }}</td>                                            
                <td>
                    @can('update-user')
                        <label class="switch">
                            <input type="checkbox" onchange="changeStatus($(this))" href="{{ route('change-staff-status', $user->id) }}" {{ $user->status == 1 ? 'checked' : '' }}>
                            <span class="slider round"></span>
                        </label>
                    @endcan
                </td>                                            
                <td>
                    <div class="d-flex align-items-center">
                        @can('update-user')
                            <a class="btn btn-success btn-sm btn-icon-text mr-3 text-white" onclick="event.preventDefault(); callUpdate($(this))" href="{{ route('user.edit', $user->id) }}">
                                <i class="mdi mdi-table-edit"></i> Edit
                            </a>
                        @endcan
                        @can('delete-user')
                            <a class="btn btn-danger btn-sm btn-icon-text" onclick="event.preventDefault(); callDelete($(this))" href="{{ route('user.destroy', $user->id) }}">
                                <i class="mdi mdi-delete-variant"></i> Delete
                            </a>
                        @endcan
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th>#</th>
            <th>Role</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </tfoot>
</table>
<script>
    loadDataTable();
</script>