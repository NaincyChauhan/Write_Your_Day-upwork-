// Infinity Scroll Posts
$(document).ready(function() {
    $(window).scroll(function() {
        if($(window).scrollTop() + $(window).height() == $(document).height()) {
            var page = $('#main-post-container').data('page');
            loadMoreData(page);
            $('#main-post-container').data('page',page + 1);
        }
    });
    function loadMoreData(page){
        $.ajax({
            url: `/ajax/search${window.location.search}`,
            type: 'GET',
            data: {
                page: page,
            },
            success: function (data) {
                    $('#main-post-container').append(data);
            }, error: function (error) {
                // console.log("this is error is here",error);
            }
        });
    }
});