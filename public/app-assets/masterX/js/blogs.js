$(function() {
    // Ajax CSRF Token
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // TagInput
    $('#tags').tagsInput({ width: 'auto' });
});

var directionality = "ltr";
tinymce.init({
    selector: '.tinyMCE',
    min_height: 500,
    valid_elements: '*[*]',
    relative_urls: false,
    remove_script_host: false,
    directionality: directionality,
    language: 'en',
    menubar: 'file edit view insert format tools table help',
    plugins: [
        "advlist autolink lists link image charmap print preview anchor",
        "searchreplace visualblocks code codesample fullscreen",
        "insertdatetime media table paste imagetools"
    ],
    toolbar: 'code preview | undo redo | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | image media link | fullscreen',
    content_css: ['/app-assets/plugins/tinymce/editor_content.css'],
});
tinymce.DOM.loadCSS('/app-assets/plugins/tinymce/editor_ui.css');

// Save Blog Validation
function addValidation() {
    $('#addBlogForm').validate({
        rules: {
            title: "required",
            category_id: "required",
            image: "required",
            keywords: "required",
            desc: "required",
            content: "required",
        },
        messages: {
            title: "Oops.! The Title field is required.",
            category_id: "Oops.! The Category field is required.",
            image: "Oops.! The Image field is required.",
            desc: "Oops.! The Descripation field is required.",
            keywords: "Oops.! The Keywords field is required.",
            content: "Oops.! The Content field is required.",
        },
        errorElement: 'span',
        errorPlacement: function(error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function(element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        },
        submitHandler: function(f) {
            var btn = $('#addBlogBTN'),
                form = $('#addBlogForm');

            tinymce.triggerSave();
            btn.attr('disabled', true);
            btn.html('<i class="mdi mdi-cloud-circle"></i> Saving');
            $.ajax({
                type: "POST",
                processData: false,
                contentType: false,
                url: form.attr('action'),
                data: new FormData(form[0]), // serializes the form's elements.
                success: function(data) {
                    if (parseInt(data.status) == 1) {
                        ajaxMessage(1, data.message);
                    } else {
                        ajaxMessage(0, data.message);
                    }
                    btn.attr("disabled", false);
                    form[0].reset();
                    btn.html('<i class="mdi mdi-cloud-upload"></i> Save');
                },
                error: function(data) {
                    var msg = data.responseJSON.message,
                        error = "<ul>";

                    $.each(data.responseJSON.errors, function(key, value) {
                        error += "<li>" + value + "</li>";
                    });
                    error += "</ul>";
                    errorsHTMLMessage(msg + "<br>" + error);
                    btn.attr("disabled", false);
                    btn.html('<i class="mdi mdi-cloud-upload"></i> Save');
                }
            });

            return false;
        }
    });
}

//Update Blog Validation
function updateValidation() {
    $('#updateBlogForm').validate({
        rules: {
            title: "required",
            category_id: "required",
            keywords: "required",
            desc: "required",
            content: "required",
        },
        messages: {
            title: "Oops.! The Title field is required.",
            category_id: "Oops.! The Category field is required.",
            desc: "Oops.! The Descripation field is required.",
            keywords: "Oops.! The Keywords field is required.",
            content: "Oops.! The Content field is required.",
        },
        errorElement: 'span',
        errorPlacement: function(error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function(element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        },
        submitHandler: function(f) {
            var btn = $('#updateBlogBTN'),
                form = $('#updateBlogForm');

            tinymce.triggerSave();
            btn.attr('disabled', true);
            btn.html('<i class="mdi mdi-cloud-circle"></i> Saving');
            $.ajax({
                type: "POST",
                processData: false,
                contentType: false,
                url: form.attr('action'),
                data: new FormData(form[0]), // serializes the form's elements.
                success: function(data) {
                    if (parseInt(data.status) == 1) {
                        ajaxMessage(1, data.message);
                        $('#image').html(data.img);
                    } else {
                        ajaxMessage(0, data.message);
                    }
                    btn.attr("disabled", false);
                    btn.html('<i class="mdi mdi-cloud-upload"></i> Save');
                },
                error: function(data) {
                    var msg = data.responseJSON.message,
                        error = "<ul>";

                    $.each(data.responseJSON.errors, function(key, value) {
                        error += "<li>" + value + "</li>";
                    });
                    error += "</ul>";
                    errorsHTMLMessage(msg + "<br>" + error);
                    btn.attr("disabled", false);
                    btn.html('<i class="mdi mdi-cloud-upload"></i> Save');
                }
            });
            return false;
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

function loadAjaxTable() {
    $.ajax({
        type: "GET",
        url: "ajax/load-blog-table",
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