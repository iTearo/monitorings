/**
 * JS includes
 */
window.$ = window.jQuery = require('jquery');
require('bootstrap');
require('admin-lte');
require('moment');
import "@fortawesome/fontawesome-free/js/all.js";

/**
 * CSS include
 */
import "@fortawesome/fontawesome-free/css/all.css";
import "bootstrap/dist/css/bootstrap.min.css";
import "admin-lte/dist/css/adminlte.min.css";
import "ionicons/dist/scss/ionicons.scss";
import '../css/app.scss';

/**
 * Custom application code
 */
if ('true' === getCookie('SIDEBAR_COLLAPSED')) {
    $('.sidebar-mini').addClass('sidebar-collapse');
}

function getCookie(name) {
    let matches = document.cookie.match(new RegExp(
        "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
    ));
    return matches ? decodeURIComponent(matches[1]) : undefined;
}

$('#sidebar-toggle').on('collapsed.lte.pushmenu', function () {
    document.cookie = "SIDEBAR_COLLAPSED=true;path=/";
});

$('#sidebar-toggle').on('shown.lte.pushmenu', function () {
    document.cookie = "SIDEBAR_COLLAPSED=false;path=/";
});

$('.wrapper > .content-wrapper').css({"min-height": $(window).height() - 57});
