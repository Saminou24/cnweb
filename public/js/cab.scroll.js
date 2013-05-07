$(document).scroll(function(e) {
    var top = $(document).scrollTop();
    getPostElementAt(top);
    if ($(window).scrollTop() >= $(document).height() - $(window).height()) {

        cab.current_seg_page++;
//        alert(cab.current_seg_page)
        var pageId = $('#page_id').val();
        var p = 1.0 * pageId + 1.0 * cab.current_seg_page;
//        var sort;
        
        if (cab.current_seg_page < cab.SEG_PER_PAGE) {
            $('#loading').show();
           

            if (location.href.match(/^http(s)?:\/\/[^\/]+\/uploader\/.*/)) {
                var uid = location.href.substr(location.href.search("uploader")).split("/")[1].split("?")[0];
                var query = location.search.substr(1).split("&");
                var page = 0;
                for (var i = 0; i < query.length; i++) {
                    var ar = query[i].split("=");
                    if (ar[0] == "page") {
                        page = ar[1];
                        break;
                    }
                }
                cab.sort = "userpost";
                $.ajax(
                        "/ajax/index?act=load_more&sort=userpost&uid=" + uid + "&page=" + p
                        ).done(function(data) {
                    $('#content').html($('#content').html() + data);
                    $('#loading').hide();
                    // alert('test');
                });
            }
            else {
                cab.sort = (location.href.match(/^http(s)?:\/\/[^\/]+\/hot\/.*/)) ? "hot" : "new";
                $.ajax(
                        "/ajax/index?act=load_more&sort=" + cab.sort + "&page=" + p
                        ).done(function(data) {
                    $('#content').html($('#content').html() + data);
                    $('#loading').hide();
                    // alert('test');
                });
            }


//            alert(location.href.match(/^http.*\/uploader\/\.*/))
//            if (location.href.match(/^http.*\/uploader\/\.*/)) {
//                var url = location.strstr("uploader/").split("/")
//                alert(url[1]);
//
//            }
        }
        else if (cab.current_seg_page == cab.SEG_PER_PAGE) {
//            alert(cab.sort)
            if (cab.sort == "userpost")
                $('#content').html($('#content').html() + "<a role='button' href='" + location.href + "?page=" + p + "'>Trang tiếp theo </a>");
            else
                $('#content').html($('#content').html() + "<a role='button' href='/" + cab.sort + "/index/page/" + p + "'>Trang tiếp theo </a>");
        }
    }
});

function getPostElementAt(top) {
    var tags = $('.post-item');
    var isShow = 0;
    for (var i = 0; i < tags.length; i++) {
        if ($(tags[i]).offset().top - 70 <= top && $(tags[i]).offset().top + $(tags[i]).height() - 72 >= top) {
            $(tags[i]).children(".post-info").addClass("post-position-fixed").removeClass("post-position-absolute");
            cab.post.currentPostId = $(tags[i]).find('.id').val();
            cab.post.currentPost = $(tags[i]);
            cab.post.likeStatus = $(tags[i]).find(".id").attr("like-status");

            if (cab.post.likeStatus == 1)
                $('#like').addClass("active");
            else
                $('#like').removeClass("active");
            isShow = true;
//            break;
            //alert(cab.post.currentPostId);

        }
        else
            $(tags[i]).children(".post-info").addClass("post-position-absolute").removeClass("post-position-fixed");
    }
    if (isShow)
        $('#toolbar-wrap').show();
    else
        $('#toolbar-wrap').hide();
}