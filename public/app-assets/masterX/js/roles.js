$(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
});

function ajaxDataTable() {
    $.ajax({
        type: "GET",
        url: "ajax/load-role-table",
        data: {},
        success: function(data) {
            $('#ajax_data_table').html(data);
        },
        error: function(data) {
            ajaxMessage(0, 'Something went wrong. Kindly refresh the page.');
        }
    });
}

function callUpdate(e) {
    var url = e.attr('href');
    e.html('Requesting <i class="mdi mdi-cloud-circle"></i>');
    $.ajax({
        type: "GET",
        url: url,
        data: {},
        success: function(data) {
            $('#editData').html(data);
            $('#editImagegallery').modal('show');
            e.html('<i class="mdi mdi-table-edit"></i> Edit');
        },
        error: function(data) {
            ajaxMessage(0, "Something went wrong.!");
            e.html('<i class="mdi mdi-table-edit"></i> Edit');
        }
    });
}

function callDelete(e) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Proceed!'
    }).then((result) => {
        if (result.isConfirmed) {
            var url = e.attr('href');
            e.html('Deleting <i class="mdi mdi-cloud-circle"></i>');
            $.ajax({
                type: "DELETE",
                url: url,
                data: {},
                success: function(data) {
                    ajaxDataTable();
                    ajaxMessage(1, data.message);
                    e.html('<i class="mdi mdi-delete-variant"></i> Delete');
                },
                error: function(data) {
                    ajaxMessage(0, "Something went wrong.!");
                    e.html('<i class="mdi mdi-delete-variant"></i> Delete');
                }
            });
        }
    });
}