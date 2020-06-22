(function ($) {

    if ($('.repeater').size() > 0) {
        $('.repeater').repeater({
            repeaters: [{
                selector: '.inner-repeater'
            }],
            isFirstItemUndeletable: true
        });
    }

    if ($('.repeater-template').size() > 0) {
        $('.repeater-template').each(function (_, repeater) {
            var template = $('template', repeater).html();
            var list     = $('[data-repeater-list]', repeater);
            var creater  = $('[date-repeater-create]', repeater);
            var index    = list.data('repeaterIndex');
            creater.on('click', function () {
                if ($(this).hasClass('disabled')) {
                    return ;
                }
                var _template   = template.replace(/__index__/g, index);
                var $template   = $(_template);
                list.append($template);
                index++;
            });
        });
        $(document).on('click', '[date-repeater-delete]', function () {
            $(this).parents('date-repeater-item').remove();
        });
    }

})(jQuery);
