$('#search-box').focus(function() {
    $('#search-box').css("width", "400px");
}).blur(function() {
    $('#search-box').css("width", "250px");
});

$('.table tr').not(':first').hover(
        function() {
            $(this).css("background", "#66cba3");
        },
        function() {
            $(this).css("background", "");
        }
);
$('.close').click(function() {
    $(this).parent().hide("slow");
})