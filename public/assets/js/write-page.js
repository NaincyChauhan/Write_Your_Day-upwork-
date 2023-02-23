//Declare all variables
const editBtn = document.querySelector('#edit_btn');
const previewModal = document.querySelector('.preview-modal');
const previewModalContent = document.querySelector('.content-container');
const previewBtn = document.querySelector('.preview-btn');
const userBlogTitleInput = document.querySelector('#blog-title');
const blogTitle = document.querySelector('.review-detail h4');
const blogContent = document.querySelector('.review-detail-content');
let userBlogContentInput;

//ckeditor initiallization
// ClassicEditor.builtinPlugins = [WordCountPlugin]

ClassicEditor
    .create(document.querySelector('#toolbar-grouping'), {
        toolbar: [
            'heading', '|',
            'fontfamily', 'fontsize', '|',
            'alignment', '|',
            'fontColor', 'fontBackgroundColor', '|',
            'bold', 'italic', 'underline', '|',
            'link', '|',
            'bulletedList', 'numberedList', '|',
            'outdent', 'indent', '|',
            'uploadImage', 'blockQuote', '|',
            'undo', 'redo'
        ],
        heading: {
            options: [
                { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' },
                { model: 'heading5', view: 'h5', title: 'Heading 5', class: 'ck-heading_heading5' },
                { model: 'heading6', view: 'h6', title: 'Heading 6', class: 'ck-heading_heading6' }
            ]
        },
        // plugins: ['WordCount'],
        // extraPlugins: ['MaxLength'],
        // extraPlugins: 'wordcount',
        maxLength: {
            maxCharCount: 200, // set the maximum character count here
            message: 'You have reached the maximum character count.', // message to show when the limit is exceeded
        }
    })
    .then(e => {
        userBlogContentInput = () => e.getData();
        // const wordCountPlugin = e.plugins.get( 'WordCount' );
        // console.log(wordCountPlugin);
        // console.log(e.plugins.get("WordCount"));
        // window.editor = e;
        // console.log("debugging11",window.editor);
        // document.getElementById("demo-word-count").appendChild(e.plugins.get("WordCount").wordCountContainer) 
    })
    .catch(error => {
        console.error(error);
    });


function countChar(val) {
    var len = val.value.length;
    if (len >= 500) {
        val.value = val.value.substring(0, 500);
    } else {
        $('#demo-word-count').text(500 - len);
    }
};

//functions
previewBtn.onclick = () => {
    let content = userBlogContentInput();
    if (userBlogTitleInput.value === '' || userBlogTitleInput.value === null || userBlogTitleInput.value === undefined) {
        blogTitle.innerHTML = blogTitle.dataset.placeholder;
        blogTitle.style.color = '#969c8b';
    } else {
        blogTitle.innerHTML = userBlogTitleInput.value;
        blogTitle.style.color = '#333';
    }

    if (content === '' || content === null || content === undefined) {
        blogContent.innerHTML = blogContent.dataset.placeholder;
        blogContent.style.color = '#969c8b';
    } else {
        blogContent.innerHTML = content;
        blogContent.style.color = '#444';
    }
    previewModal.style.display = 'flex';
    previewModalContent.style.animation = 'scaleout .3s ease';
}
let closeModal = () => {
    previewModalContent.style.animation = 'scalein .3s ease'
    setTimeout(() => previewModal.style.display = 'none', 250);
}
editBtn.onclick = closeModal;

window.onclick = e => {
    if (e.target === previewModal) closeModal();
}

// Don't Remove

$('.post-type-button').click(function () {
    $('#inputType').val($(this).attr('type-value'));
    // ('#LogInForm').submit();
    // $('#type-dropdown-menu').toggleClass('show');
});

// Title Length
$("#blog-title").on("input", function () {
    const post_title = $("#blog-title").val();
    $('#title_max_length').html(`Remaining Character ${55 - Number(post_title.length)}`)
    $('#slug_url').val(post_title);
});

// Seo Title
$("#seo_title").on("input", function () {
    $('#post-title-preview').html($(this).val());
});

// Meta Descripation
$("#meta_desc").on("input", function () {
    $('#post-preview-desc-text').html($(this).val().substring(0, 200)+".");
});

// Create User Post
$(function () {
    $('#create-post-form').validate({
        rules: {
            title: "required",
            slug_url: "required",
        },
        messages: {
            title: "Oops.! The Title field is required.",
            slug_url: "Oops.! The Slug Url field is required.",
        },
        errorElement: 'div',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.write-page-input').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        },
        submitHandler: function (f) {
            clearErrors();
            // console.log("this is function");
            // return;
            var btn = $('#type-dropdown-menu'),
                form = $('#create-post-form');
            btn.attr('disabled', true);
            $.ajax({
                type: "POST",
                processData: false,
                contentType: false,
                url: form.attr('action'),
                data: new FormData(form[0]), // serializes the form's elements.
                success: function (data) {
                    // clearErrors();
                    if (parseInt(data.status) == 1) {
                        MessageShow('alert-success', data.message, 'session_message_area');
                        window.location.pathname = "/";
                    } else {
                        MessageShow('alert-danger', data.message, 'session_message_area');
                    }
                    btn.attr("disabled", false);
                },
                error: function (data) {
                    // clearErrors();
                    if (data.responseJSON.errors) {                        
                        $.each(data.responseJSON.errors, function (key, value) {
                            $(`#${key}` + "_error").html(value);
                        });
                    }else{
                        if ((data.responseJSON.messages)) {                            
                            MessageShow('alert-danger', data.responseJSON.messages, 'session_message_area');
                        }
                    }
                    btn.attr("disabled", false);
                }
            });
            return false;
        }
    });
});

// Clear All Input Errors
function clearErrors() {
    const Error_Messages = ['title', 'desc', 'seo_title', 'meta_desc', 'slug_url'];
    $.each(Error_Messages, function (key, value) {
        $(`#${value}` + "_error").html("");
    });
}

// Show Response Message
function MessageShow(addclass, msg, container) {
    $(`#${container}`).html(`<div class="alert ${addclass} alert-dismissible fade show" role="alert">
                                 <span id="success-message">${msg}</span>
                                 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>`);
    window.scrollTo(0, 0);
}

$(document).ready(function () {
    getDateTime();    
});

setInterval(function() {
    getDateTime(); 
}, 60000);

function getDateTime() {
    var currentDate = new Date();
    var timeString = currentDate.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    var dateString = currentDate.toLocaleDateString([], { month: 'short', day: '2-digit', year: 'numeric' });
    const currentTime =  timeString + ' - ' + dateString;
    $('.date-time-text').each(function (index, element) {
        $(element).html(`<i class="far fa-clock"></i>`+currentTime);
    });
}

function sendCreatAjaxRequest(form_) {
    var form = new FormData(form_[0])
    form.append('descripation',userBlogContentInput());
    $.ajax({
        type: "POST",
        processData: false,
        contentType: false,
        url: `${window.location.origin}/auto/draft/store-post`,
        data: form, // serializes the form's elements.
        success: function (data) {
            if (parseInt(data.status) == 1) {
                showAutoDraftMessage(data.message);
            } else {
                showAutoDraftMessage(data.message);
            }
        },
        error: function (data) {
            if (data.responseJSON.errors) {                        
                $.each(data.responseJSON.errors, function (key, value) {
                    $(`#${key}` + "_error").html(value);
                });
            }else{
                if ((data.responseJSON.messages)) {    
                    showAutoDraftMessage(data.responseJSON.messages);
                }
            }
        }
    });
}

function showAutoDraftMessage(message_) {
    $('#like-popup').html(`<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
                    <div id="liveToast" style="width: 160px;" class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="toast-body" style="font-size: 14px; font-weight: 500;">
                            ${message_}
                        </div>
                    </div>
                </div>`);

    setTimeout(function () {
        $('#like-popup').html("");
    }, 2000);
}

$(document).ready(function(){
    $('#blog-title').keypress(function(event){
        if(event.keyCode == 13){
            event.preventDefault();
        }
    });
});

function SaveSeoData(thisObj){
    thisObj.html('Saved');
    $('#seo_title').attr('readonly',true);
    $('#slug_url').attr('readonly',true);
    $('#meta_desc').attr('readonly',true);
}