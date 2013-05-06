$(document).ready(function() {
    // alert('init')
    init();
    cab.init();
});

function init() {
    //container
    var timeId = {
        'suggest': 'undefined',
        'time': new Date().getTime()
    };
    var MIN_UPDATE_TIME = 150;
    $('#search-box').bind("keyup", function() {
        // alert('keyfire');
        var keyword = $('#search-box').val();
        var t = new Date().getTime();
        if (timeId['suggest'] && t - timeId['time'] < MIN_UPDATE_TIME)
            clearTimeout(timeId['suggest']);
        if (keyword.length > 0) {

            timeId['suggest'] = setTimeout(function() {
                timeId['time'] = new Date().getTime();
                $.ajax({
                    url: "/suggest/index?q=" + keyword,
                    success: function(data) {
                        $('#suggest-container').html(data).show();
                    }});
            }, 50);
        } else
            $('#suggest-container').hide();

    });
}

cab = {
    version: "0.0.1",
    post: {
        currentPostId: 0
    }
};
cab.confirmLink = function(info) {
    var c = confirm(info);
    return c;

}

cab.init = function() {
    cab.current_seg_page = 0;
    cab.SEG_PER_PAGE = 3;
    cab.addEventListener();
    cab.user = {status: -1}; //not init
    cab.browser = {width: $(window).width()};
    cab.updateStatus();

    var src = $('#cab-script').attr("src").split('?');
    var mode = src[1];
    if (mode)
        cab.mode = mode;
    else
        cab.mode = "normal";
}

cab.addEventListener = function() {
    $('.close').click(function() {
        $(this).parent().hide("slow");
    })
    $('#plugin-message').enscroll({
        showOnHover: true,
        verticalTrackClass: 'track3',
        verticalHandleClass: 'handle3'
    });
    $('#send-message,#like,#facebook-share').click(function(e) {
        var post = cab.post;
        var target = e.target;
        var curentId = cab.post.currentPostId;
        var curentPost = cab.post.currentPost;
        if ($(target).hasClass("active") && target.getAttribute('id') != 'like') {
            $('#plugin-content').hide();
            $(target).removeClass("active");
        } else
            switch (target.getAttribute('id')) {
                case 'send-message':
                    $('.active').removeClass("active")
                    $('#send-message').addClass("active");
                    $('#content-message').show();
                    $('#content-facebook').hide();
                    $('#plugin-content').show();
                    $('#loading').show();
                    $.ajax({
                        url: '/c/' + curentId + '?mode=plugin',
                        success: function(data) {
//                            alert('load')
                            $('#loading').hide();
                            $('#plugin-message-content').html(data);
                        }
                    });


                    break;
                case "like":
                    function likeAction() {
                        $(target).toggleClass("active");
                        if (curentId) {

                            $.ajax(
                                    "/ajax/index?act=like&type=photo&id=" + curentId
                                    ).done(function(st) {
                                var t = st.split("|");

                                if (t[0] == 1)
                                    $(target).addClass('active');
                                else
                                    $(target).removeClass('active');
                                curentPost.find(".post-like").html(t[1]);
                            }).fail(function() {
                                alert("Đã có lỗi xảy ra! Vui lòng kiểm tra lại mạng");
                                $(e.target).toggleClass("active");
                            });
                        }
                    }
//                $('.active').removeClass("active")
                    if (cab.user.status == -1)
                        cab.updateStatus(function() {
                            if (cab.user.status == 0)
                                alert("Bạn phải đăng nhập để thực hiện chức năng này :)");
                            else {
                                likeAction();
                            }

                        });
                    else {
                        if (cab.user.status == 0)
                            alert("Bạn phải đăng nhập để thực hiện chức năng này :)");
                        else
                            likeAction();
                    }

                    break;
                case 'facebook-share':
                    $('.active').removeClass("active");
                    $('#facebook-share').addClass("active");

                    $('#plugin-content').show();
                    $('#plugin-facebook').html("<div class='fb-comments' data-href='http://cnweb.local/" + curentId + "' data-width='" + $(window).width() + "' data-num-posts='3'></div>").show();
                    $('#plugin-message').hide();
                    FB.XFBML.parse();

            }

        //  $('#plugin-content').show();
    });
    $('#menu-btn').click(function() {
        $('#subMenu').toggle();
    });
    $('.link').click(function(e) {
        var location = e.target.getAttribute("href");
        document.location = location;
    })
}
cab.sendMessage = function() {
    $.ajax({
        url: "/c/" + cab.post.currentPostId + "?mode=plugin",
        type: "POST",
        data: {
            "comment": $('#plugin-msg').val()
        },
        success: function(data) {
//            alert('update')
            $('#plugin-message-content').html(data);
        }
    });
    $('#plugin-msg').val("");
}
cab.updateStatus = function() {
    $.ajax(
            "/ajax/index?act=check_status"
            ).done(function(data) {
        cab.user.status = parseInt(data);
    });
}