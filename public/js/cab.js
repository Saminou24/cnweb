
$('#search-box').bind("keydown", function() {
    
    keyword = $('#search-box').val();
    
    $.ajax({
        url: "/suggest/index?q=" + keyword,
        success: function(data) {
           // alert(data);
            $('#content').html(data);
        }});
});