init();

function init() {
    //container
    var timeId = {};

    $('#search-box').bind("keyup", function() {
        // alert('keyfire');
        var keyword = $('#search-box').val();
        if (timeId['suggest'])
            clearTimeout(timeId['suggest']);
        if (keyword.length > 0)
            timeId['suggest'] = setTimeout(function() {
                // alert('eventCall');
                $.ajax({
                    url: "/suggest/index?q=" + keyword,
                    success: function(data) {
                       //alert(data);
//                        //highlight
//                        // alert(data.match(/<li>[a-z]*<\/li>/gi));
//                        var keyArr = keyword.split(" ");
//                        keyArr.forEach(function(e) {
//                            // alert('replace: ' + e);
//                            if (e.length > 0) {
//                                var re = new RegExp(e, "gi");
//
//                                data = data.replace(re, "<strong>$&</strong>");
//                            }
//                        });
                        $('#suggest-container').html(data).show();
                        
                    }});
            }, 150);
         else
             $('#suggest-container').hide();    

    });
}

cab = {
    version: "0.0.1"
};
cab.confirmLink = function(info){
    var c = confirm(info);
    return c;
}