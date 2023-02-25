$(document).ready(function () {
    // LoadMorePost();
});

// Get Only 100 posts
function LoadMorePost() {
    var load_more_btn = $('#load-more-post');
    var offset = load_more_btn.data('offset');
    var limit = load_more_btn.data('limit');
    if (offset < 100) {        
        // send an AJAX request to retrieve the comments and replies
        $.ajax({
            url: `${window.location.origin}/load/posts/`,
            type: 'GET',
            data: {
                offset: offset,
                limit: limit
            },
            success: function (data) {
                    console.log("this is offset data1111",offset, "and this is limit",limit);
                    load_more_btn.data('offset',offset + limit);
                    console.log("this is offset data2222",$('#load-more-post').data('offset'));
                    $('#main-post-container').append(data);

                    if ($('#load-post-length').data('limit') < limit) {
                        // console.log("data is very very low");
                    }else{
                        LoadMorePost();
                    }
            }, error: function (error) {
                // console.log("this is error is here",error);
            }
        });
    }
}

// Infinity Scroll Posts
$(document).ready(function() {
    $(window).scroll(function() {
        if($(window).scrollTop() + $(window).height() == $(document).height()) {
            var page = $('#main-post-container').data('page');
            loadMoreData(page);
            $('#main-post-container').data('page', page + 1);
        }
    });
    function loadMoreData(page){
        $.ajax({
            url: `${window.location.origin}/load/posts/`,
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
