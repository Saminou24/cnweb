$(document).ready(function(){
    init();
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
    version: "0.0.1"
};
cab.confirmLink = function(info) {
    var c = confirm(info);
    return c;

}