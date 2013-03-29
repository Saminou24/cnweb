/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function() {

    setUpEffect();
    function setUpEffect() {

        $(document).click(function(event) {
            var target = event.target || event.srcElement || event.originalTarget;
            if (target == $('#search-box')[0])
                $('#search-box').css({
                    "border-color": "#4883da",
                    "width": "400px",
                    "border": "2px solid #fff",
                    "box-shadow": "0 0  3px #fff"
                });
            else if ($('#search-box').css('width') > "200px")
                $('#search-box').css('width', "200px");
        })
    }
});
