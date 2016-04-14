$(document).ready(function() {
    $(document).ajaxSend(function(event, request, settings) {
        $('div.alert').hide();
        $('#loading-indicator').show();
    });

    $(document).ajaxComplete(function(event, request, settings) {
        $('#loading-indicator').hide();
    });
    $(document).ajaxError(function(event, request, settings) {
        $('#loading-indicator').hide();
    });

    var backToTop = $('<a>', {id: 'backToTop', href: '#top'});
    var icon = $('<i>', {class: 'icon-chevron-up'});
    backToTop.appendTo('body');
    icon.appendTo(backToTop);
    backToTop.hide();
    $(window).scroll(function() {
        if ($(this).scrollTop() > 150) {
            backToTop.fadeIn();
        } else {
            backToTop.fadeOut();
        }
    });
    backToTop.click(function(e) {
        e.preventDefault();
        $('body, html').animate({
            scrollTop: 0
        }, 700);
    });
});


function ozaj(text) {
    if (confirm(text)) {
        return true;
    } else {
        return false;
    }
}

$(document).ready(function() {
    $('[data-toggle="modal"]').click(function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        if (url.indexOf('#') == 0) {
            $(url).modal('open');
        } else {
            $.get(url, function(data) {
                $('<div class="modal hide fade">' + data + '</div>').modal();
            }).success(function() {
                $('input:text:visible:first').focus();
            });
        }
    });

});

function show_ajaxMsq(msg, type) {
    $('div#msgbox').prepend(
            $('<div />').addClass('alert').addClass(type).append(
            '<a class="close" data-dismiss="alert">&times;</a>',
            msg
            )
            );
}




