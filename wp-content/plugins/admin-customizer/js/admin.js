var image_field;

jQuery(document).ready(function($) {

    var adns_easytabs = $('#tab-container').easytabs({
      animate: false,
      defaultTab: "span:first-child",
      tabs: "> h2 > span ",
      animationSpeed: "fast",
      tabActiveClass: "nav-tab-active"
    }) ;


    $('.adns-select-color').wpColorPicker();


  $(document).on('click', 'input.adns-select-img', function(evt){
    image_field = $(this).siblings('.img');
    tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
    return false;
  });

  window.send_to_editor = function(html) {
    imgurl = $('img', html).attr('src');
    image_field.val(imgurl);
    tb_remove();
  }

});
