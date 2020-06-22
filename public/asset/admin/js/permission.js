(function ($) {
    var check_permission_toggle = function () {
        var is_all_checked = function (toggle) {
            var filter = toggle.data('filter');
            var wrapper = $(toggle.data('wrapper'));
            var all_checked = true;
            $(filter + ' :checkbox', wrapper).each(function (_, checkbox) {
                if (!checkbox.checked) {
                    all_checked = false;
                }
            });
            return all_checked;
        }
        $(".perimssion_toggle_on").each(function () {
            var toggle = $(this);
            if (is_all_checked(toggle)) {
                toggle.hide();
            } else {
                toggle.show();
            }
        });
        $(".perimssion_toggle_off").each(function () {
            var toggle = $(this);
            if (is_all_checked(toggle)) {
                toggle.show();
            } else {
                toggle.hide();
            }
        });
    }


    $(".perimssion_toggle").click(function () {
        var toggle = $(this);
        var filter = toggle.data('filter');
        var wrapper = $(toggle.data('wrapper'));
        var checked = toggle.hasClass('perimssion_toggle_on');
        $(filter + ' :checkbox', wrapper).each(function (_, checkbox) {
            $(checkbox).prop('checked', checked);
        });
        check_permission_toggle();
    });

    $(':checkbox').click(check_permission_toggle);
    check_permission_toggle();
})(jQuery);