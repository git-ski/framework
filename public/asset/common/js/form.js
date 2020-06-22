(function ($) {
  // double clickを2秒間阻止する、そして２秒を超える連打も対応。
  var blockClickTimer;
  var updateBlockClick = function ($button) {
    if (blockClickTimer) {
      clearTimeout(blockClickTimer);
    }
    blockClickTimer = setTimeout(function () {
      $button.data('clicked', false);
    }, 2000);
    return $button.data('clicked', true);;
  }
  $(document).on('click', '[name=submit]', function () {
    var isClicked = $(this).data('clicked');
    updateBlockClick($(this));
    return isClicked ? false : true;
  });
  $(document).on('click', 'label > img', function(){
    var label = $(this).parent();
    if(!label.attr('for')[0]) return false;
    var tarId = label.attr('for');
    $('#' + tarId).prop('checked', true);
    return false;
  });

  $(window).keydown(function(event){
    if(event.keyCode == 13) {
      event.preventDefault();
      return false;
    }
  });

})(jQuery);