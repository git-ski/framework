/*select inquiry type*/
(function ($) {

    $("input[name*='zipCd']").change(function(){
        var input = $(this).val();
        input = input.replace('-', '');

        $.ajax({
            url : "/rest/v1/zipcodeja",
            type : "GET",
            dataType : "json",
            data : {
                zipCd: input,
            }
        }).done(function (result) {
            if (result.success) {
                if (result.data) {
                    $("select[name*='Prefecture']").val(result.data.mPrefectureId);
                    $("input[name*='address01']").val(result.data.address01 + result.data.address02);
                } else {
                    alert('登録されている住所がありません。');
                }
            } else {
                alert('登録されている住所がありません。');
            }
        }).fail(function (jqXHR, textStatus, errorThrown) {
            alert(textStatus + '：' + ex.data.message + "\n" + 'status：' + jqXHR.status);
        });
    });

})(jQuery);
