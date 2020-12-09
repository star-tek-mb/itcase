$(function () {
    $('.link-effect').click(function () {
        var date = new Date(Date.now() + 86400e3);
        date = date.toUTCString();
        if(getCookie('adminSidebarColor') == 'black')
        {
            document.cookie = 'adminSidebarColor=white; path=/; expires=' + date;
        }else if(getCookie('adminSidebarColor') == 'white')
        {
            document.cookie = 'adminSidebarColor=black; path=/; expires=' + date;
        }else{
            document.cookie = 'adminSidebarColor=black; path=/; expires=' + date;
        }
    });
    $('button[data-action=sidebar_toggle]').click(function () {
        var date = new Date(Date.now() + 86400e3);
        date = date.toUTCString();
        if(getCookie('adminSidebarToggle') == 'true')
        {
            document.cookie = 'adminSidebarToggle=false; path=/; expires=' + date;
        }else if(getCookie('adminSidebarToggle') == 'false')
        {
            document.cookie = 'adminSidebarToggle=true; path=/; expires=' + date;
        }else{
            document.cookie = 'adminSidebarToggle=true; path=/; expires=' + date;
        }
    });
});



function getCookie(name) {
    let matches = document.cookie.match(new RegExp(
        "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
    ));
    return matches ? decodeURIComponent(matches[1]) : undefined;
}