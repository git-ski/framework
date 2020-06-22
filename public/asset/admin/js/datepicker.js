(function ($) {
    $(".datepicker").each(function (_, datepicker) {
        $(datepicker).datepicker({
            autoclose: true,
            container: datepicker
        });
    });

    $(".datepicker-material").each(function (_, datepicker) {
        $(datepicker).bootstrapMaterialDatePicker({
            format: 'YYYY-MM-DD',
            clearButton: true,
            weekStart: 1,
            time: false
        });
    });

})(jQuery);