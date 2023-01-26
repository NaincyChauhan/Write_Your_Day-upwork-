$(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
});

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
                    ajaxMessage(1, data.message);
                    loadAjaxTable();
                    e.html('Delete <i class="typcn typcn-delete-outline btn-icon-append"></i>');
                },
                error: function(data) {
                    ajaxMessage(0, "Something went wrong.!");
                    e.html('Delete <i class="typcn typcn-delete-outline btn-icon-append"></i>');
                }
            });
        }
    });
}

function loadAjaxTable() {
    $.ajax({
        type: "GET",
        url: "ajax/load-message-table",
        data: {},
        success: function(data) {
            $('#ajax_data_table').html(data);
            loadDataTable();
        },
        error: function(data) {
            ajaxMessage(0, "Something went wrong.!");
        }
    });
}

$('#allCheck').on('click', function(e) {
    if ($(this).is(':checked', true)) {
        $(".checkbox").prop('checked', true);
    } else {
        $(".checkbox").prop('checked', false);
    }
});

function deleteAll($check) {
    if ($check == 'DELETE') {
        var allVals = [];
        $(".checkbox:checked").each(function() {
            allVals.push($(this).attr('data-id'));
        });

        if (allVals.length <= 0) {
            ajaxMessage(0, "Please select atleast one row.");
        } else {
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
                    var join_selected_values = allVals.join(",");

                    $.ajax({
                        type: "get",
                        url: 'ajax/delete-messages',
                        data: {
                            "ids": join_selected_values
                        },
                        success: function(data) {
                            if (parseInt(data.status) == 1) {
                                ajaxMessage(1, data.message);
                                loadAjaxTable();
                            } else {
                                ajaxMessage(0, data.message);
                            }
                        },
                        error: function(data) {
                            var msg = data.responseJSON.message,
                                error = "<ul>";

                            $.each(data.responseJSON.errors, function(key, value) {
                                error += "<li>" + value + "</li>";
                            });
                            error += "</ul>";
                            errorsHTMLMessage(msg + "<br>" + error);
                        }
                    });
                }
            });
        }
    }
}