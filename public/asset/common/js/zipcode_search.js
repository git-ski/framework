/*select inquiry type*/
$(document).ready( function () {

    $("input[name*='zipCd']").blur(function(){
        var input = $(this).val();
        $.ajax({
            url : "/rest/v1/zipcodeja",
            type : "GET",
            dataType : "json",
            data : {
                zipCd: input,
            },
            success : function(data){
                if(data){
                    $("select[name*='Prefecture']").val(data['data']['mPrefectureId']);
                    $("input[name*='address01']").val(data['data']['address01'] + data['data']['address02']);
                }
            }
        })
    });

});