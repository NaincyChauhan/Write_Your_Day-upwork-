<table id="shivadatatable" class="table table-bordered">
    <thead>
        <tr>
            <th class="ml-5">#</th>
            <th>Title</th>
            <th>Image</th>
            <th>Btn</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($banners as $banner)
        <tr id="row{{ $banner->id }}">
            <td>{{ $loop->iteration }}</td>
            <td>{{$banner->title}} </td>
            <td>
                @if (isset($banner->image))
                <img class="rounded" src="{{ asset('storage/banners/'.$banner->image) }}" alt="{{ $banner->title }}" style="width: 100px"> @endif
            </td>
            <td><a target="_blanck" href="{{$banner->url}}">{{$banner->btn_name}} </a></td>

            <td>
                <div class="d-flex align-items-center">
                    @can('update-banner')
                        <a class="btn btn-success btn-sm btn-icon-text mr-3 text-white" onclick="event.preventDefault(); callUpdate($(this))" href="{{ route('banner.edit', $banner->id) }}">
                        Edit 
                        <i class="typcn typcn-edit btn-icon-append"></i>
                        </a>
                    @endcan
                    @can('delete-banner')
                        <a class="btn btn-danger btn-sm btn-icon-text" onclick="event.preventDefault(); callDelete($(this))" href="{{ route('banner.destroy', $banner->id) }}">
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
<script>
    // loadDataTable();
</script>