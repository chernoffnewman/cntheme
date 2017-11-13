jQuery(function ($) {

    $('#deletePad').on('click', function (e) {
        e.stopPropagation();

        var $last = $('div.number-placeholder.number-filled').last();
        $last.removeClass('number-filled');
        $last.attr('data-number', '');
        return false;
    });

    $('#clearPad').on('click', function (e) {
        e.stopPropagation();
        $('div.number-placeholder').attr('data-number', '');
        $('div.number-placeholder').removeClass('number-filled');
        return false;
    });

    $('table.keypad a').on('click', function (e) {
        e.stopPropagation();

        var number = $(this).text();

        var $first = $('div.number-placeholder:not(".number-filled")').first();
        $first.attr('data-number', number);
        $first.addClass('number-filled');

        if ($('div.number-filled').length === 4) {
            var code = '';
            $.each($('div.number-filled'), function () {
                code += $(this).attr('data-number');
            });

            $.post('/api/auth', {code: code}, function (rsp) {
                $('#clearPad').trigger('click');

                var status = rsp.status;

                if (status === '200') {
                    $('div.number-placeholder').removeClass('number-filled');
                    $('div.number-placeholder').addClass('number-filled-right');

                    setTimeout(function () {
                        window.location = "/";
                    }, 200);

                }
                else {
                    alert('Wrong PIN');
                }
            });
        }

        return false;
    });
});