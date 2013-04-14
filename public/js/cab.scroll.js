$(document).scroll(function(e){
   var top = $(document).scrollTop();
   getPostElementAt(top);
});

function getPostElementAt(top){
    var tags = $('.post-item');
    for (var i=0; i<tags.length; i++){
        if ($(tags[i]).offset().top < top && $(tags[i]).offset().top + $(tags[i]).height() >= top) {
            $(tags[i]).children(".post-info").show();
        }
        else
            $(tags[i]).children(".post-info").hide();
    }
}