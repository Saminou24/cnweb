initEffect();
function initEffect() {
    $('#search-box').click(function() {
        $('.hide-items').hide();
        $('#cancel-search').show();
    });
    $('#cancel-search').click(function(){
        $('.hide-items').show();
        $('#cancel-search').hide();
        $('#search-box').val('');
        $('.suggest-container').hide();
    });
}