<table id="shivadatatable" class="table table-bordered">
    <thead>
        <tr>
            <th class="ml-5">#</th>
            <th class="ml-5"></th>
            <th>Date</th>
            <th>Name</th>
            <th>Email</th>
            <th>Mobile</th>
            <th>message</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($messages as $message)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>
                <input type="checkbox" class="checkbox" data-id="{{ $message->id }}">
            </td>
            <td>{{ date("d M Y", strtotime($message->created_at)) }}</td>
            <td>{{$message->name}} </td>
            <td>{{$message->email}} </td>
            <td>{{$message->phone}} </td>
            <td>{{$message->message}} </td>
            <td>
                <div class="d-flex align-items-center">
                    @can('delete-Enquiry')                                        
                        <a class="btn btn-danger btn-sm btn-icon-text"
                            onclick="event.preventDefault(); callDelete($(this))"
                            href="{{ route('helpcenter.destroy', $message->id) }}">
                            Delete
                            <i class="typcn typcn-delete-outline btn-icon-append"></i>
                        </a>
                    @endcan
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>