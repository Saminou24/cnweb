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
    cab.addEventListener();
}

cab.addEventListener = function() {

    $('#send-message,#like,#facebook-share').click(function(e) {
        var post = cab.post;
        switch (e.target.getAttribute('id')) {
            case 'send-message':
                $('.active').removeClass("active")
                $('#send-message').addClass("active");
                $('#content-message').show();
                $('#content-facebook').hide();
                $('#plugin-content').show();
                var newSrc = '/comment/index/pid/' + post.currentPostId;
                var iframe = $($('#content-message').children('iframe')[0]);
                if (newSrc != iframe.attr('src'))
                    iframe.attr("src", newSrc);
                break;
            case "like":
//                $('.active').removeClass("active")
//                $('#like').addClass("active");
                $.ajax({
                    url: "/comment/like"
                });
                break;
            case 'facebook-share':
                $('.active').removeClass("active");
                $('#facebook-share').addClass("active");
                $('#plugin-content').show();
                $('#content-facebook').show();
                $('#content-message').hide();

        }
        //  $('#plugin-content').show();
    });
}
cab.postMessage = function() {

}