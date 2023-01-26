$(function() {
    // Ajax CSRF Token
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
});

function selectAllToggle(e) {
    var selectboxes = $('.check-box-items');
    selectboxes.prop("checked", e.is(":checked"));
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
            e.html('<i class="mdi mdi-cloud-circle"></i> Deleting');
            $.ajax({
                type: "DELETE",
                url: url,
                data: {

                },
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

$('#select-data-action').change(function() {
    if ($(this).val() == 'delete') {
        var allVals = [];
        $(".all_select_rows:checked").each(function() {
            allVals.push($(this).attr('data-id'));
        });
        if (allVals.length <= 0) {
            errorsHTMLMessage("Please Select Any Row" + "<br>");
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
                        url: $(this).data('url'),
                        // processData: false,
                        // contentType: false,
                        type: 'DELETE',
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        data: 'ids=' + join_selected_values,
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
                } else if (result.isDenied) {
                    return false;
                }
            });
        }
    }
});

function loadAjaxTable() {
    $.ajax({
        type: "GET",
        url: "ajax/load-blogtag-table",
        data: {

        },
        success: function(data) {
            $('#ajax_data_table').html(data);
            loadDataTable();
        },
        error: function(data) {
            ajaxMessage(0, "Something went wrong.!");
        }
    });
}