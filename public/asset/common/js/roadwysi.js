tinymce.init({
        selector:'textarea',
        theme: "modern",
        language:'ja',
        menubar: false,   // メニューバーを隠す
        statusbar: false, // ステータスバーを隠す
        plugins: [
                "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker", "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking", "save table contextmenu directionality emoticons template paste textcolor colorpicker"
        ],
        toolbar: 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat | code',
});