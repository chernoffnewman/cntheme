(function ($) {
    $("select[name=_status]").each(function () {
        $(this).append("<option value='featured'>Featured</option>");
        $(this).find('option[value="publish"]').text('Approved');

        $('tr.inline-edit-row').find('fieldset.inline-edit-col-left').hide();
        $('tr.inline-edit-row').find('fieldset.inline-edit-col-right').find('div.inline-edit-col').css('border-style', 'none');
    });
})(jQuery);
