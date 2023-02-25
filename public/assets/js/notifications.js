function SetNotificationAsRead(id_,thisObj){
    thisObj.attr("disabled", true);
    $.ajax({
        type: "GET",
        processData: false,
        contentType: false,
        url: thisObj.data('url'),
        data:  [],// serializes the form's elements.
        success: function (data) {
            if (data.status==1) {                
                $(`#user_notification_${id_}`).removeClass('notification-list--unread');
                thisObj.css('display','none');
            }
        },
        error: function (data) {
            $.each(data.responseJSON.errors, function (key, value) {
                // console.error("error", value);
            });
            btn.attr("disabled", false);
        }
    });
}

function SetNotificationToRead(thisObj){
    $.ajax({
        type: "GET",
        processData: false,
        contentType: false,
        url: thisObj.data('url'),
        data:  [],// serializes the form's elements.
        success: function (data) {
            if (data.status==1) {        
            }
        },
        error: function (data) {
            $.each(data.responseJSON.errors, function (key, value) {
                // console.error("error", value);
            });
        }
    });
}

function GetMoreReadNotification(thisObj){
    $.ajax({
        type: "GET",
        processData: false,
        contentType: false,
        url: thisObj.data('url'),
        data:  {
            offset : thisObj.data('offset'),
            limit : thisObj.data('limit'),
        },// serializes the form's elements.
        success: function (data) {
            if (data.status==1) {        
                if (data.data.length > 0) {
                    AppendNotifications(data.data)
                }
            }
        },
        error: function (data) {
            $.each(data.responseJSON.errors, function (key, value) {
                // console.error("error", value);
            });
        }
    });
}

var currentPage = 1;
$(window).scroll(function() {
    if($(window).scrollTop() + $(window).height() == $(document).height()) {
        $.get('/notifications?page=' + (currentPage + 1), function(data) {
            if(data.length > 0) {
                $('#notification-main-container').append(data);
                currentPage++;
            } else {
                $('.load-more').text('No more notifications to load');
            }
        });
    }
});
