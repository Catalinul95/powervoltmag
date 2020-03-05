$(document).ready(function () {
    var tabs = $('.tabs').children();

    for (var i = 0; i < tabs.length; i++) {
        if ($(tabs[i]).hasClass('active')) {
            var tab = tabs[i];
            var tabBody = $('#'+tab.className.split(' ')[1]);
            tabBody.css('display', 'block');
        }
    }

    $('.tab').on('click', function (e) {
        for (var i = 0; i < tabs.length; i++) {
            var tab = tabs[i];
            $(tabs[i]).removeClass('active');
            var tabBody = $('#'+tab.className.split(' ')[1]);
            tabBody.css('display', 'none');
        }

        $(this).addClass('active');
        $('#'+$(this).attr('class').split(' ')[1]).css('display', 'block');
    });

    console.log($('.fotorama__arr fotorama__arr--prev'));
});