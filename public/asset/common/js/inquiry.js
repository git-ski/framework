/*select inquiry type*/
$(document).ready( function () {

    var description = $("#inquiry-description .inquiryTypeId_"+$('#inquiry-select select').val()).html()
    $('#inquiry-detail').html(description);

        $('#inquiry-select').change(function(){
            description = $("#inquiry-description .inquiryTypeId_"+$('#inquiry-select select').val()).html()
            $('#inquiry-detail').html(description);
            return false;
        });
});
/*select inquiry type*/
