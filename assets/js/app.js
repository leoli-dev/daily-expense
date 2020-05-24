import '../css/app.scss';
import '../css/global.scss';
import Cookies from 'js-cookie';

const $ = require('jquery');
require('bootstrap');

// or you can include specific pieces
// require('bootstrap/js/dist/tooltip');
// require('bootstrap/js/dist/popover');

const SESSION_KEY_SIDEBAR_TOGGLED = 'SIDEBAR_TOGGLED';

$(document).ready(function() {
    // $('[data-toggle="popover"]').popover();

    // Side bar toggle
    const $sidebar = $('#accordionSidebar');
    const $sidebarToggle = $('#sidebarToggle');
    $sidebarToggle.click(() => {
        Cookies.set(SESSION_KEY_SIDEBAR_TOGGLED, $sidebar.hasClass('toggled') ? 1 : 0);
    });
});
