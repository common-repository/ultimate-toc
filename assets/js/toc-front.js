
function expand(param) {
    param.style.display = (param.style.display == "none") ? "block" : "none";
}
function read_toggle(id, more, less) {
    el = document.getElementById("readlink" + id);
    el.innerHTML = (el.innerHTML == more) ? less : more;
    expand(document.getElementById("read" + id));
}
if (jQuery(".toc-fixed-style-wrapper")[0]){
    var fixmeTop = jQuery('.fixme').offset().top;
    jQuery(window).scroll(function() {
        var currentScroll = jQuery(window).scrollTop();
        if (currentScroll >= fixmeTop) {
            jQuery('.fixme').addClass('fixed-me');
        } else {
            jQuery('.fixme').removeClass('fixed-me');
        }
    });
}