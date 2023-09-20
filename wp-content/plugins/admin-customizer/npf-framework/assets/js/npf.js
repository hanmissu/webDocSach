var file_frame;
jQuery(document).ready(function($){

	// Tabs
    var $npf_tab_container = $('#npf-tab-container');
    var default_tab_value = 'span:first-child';
    var npf_selected_tab = cookie.get('npf-selected-tab');
    if ( npf_selected_tab && 'undefined' != npf_selected_tab ) {
        default_tab_value = '#' + npf_selected_tab;
    }
    $npf_tab_container.easytabs({
        defaultTab: default_tab_value,
        tabs: "> h2 > span ",
        tabActiveClass: "nav-tab-active",
        updateHash: false,
    }).bind('easytabs:after', function(){
        var selected_tab = $(this).find('.nav-tab-active').attr('id');
        cookie.set( 'npf-selected-tab', selected_tab );
    });

	// Date picker
	$('input.select-date').datepicker();
	$('input.select-time').timepicker();
	$('input.select-datetime').datetimepicker();

	// Select2
  $("select").select2({
    containerCss : {"min-width":"200px"}
  });


  // On Off
  $('input.npf-on-off').css('border','1px red solid').tzCheckbox();

  // Color picker
  $('input.select-color').each(function(){
      $(this).wpColorPicker();
  });

  // Numeric Slider
  $(".npf-numeric-slider").bind("slider:changed", function (event, data) {
    // The currently selected value of the slider
    $(this).parent().find('.npf-slider-output').val(data.value);

  });

  // Uploads
  jQuery(document).on('click', 'input.select-img', function( event ){

    var $this = $(this);

    event.preventDefault();

    // If the media frame already exists, reopen it.
    // if ( file_frame ) {
    //   file_frame.open();
    //   return;
    // }

    // Create the media frame.
    file_frame = wp.media.frames.file_frame = wp.media({
      title: jQuery( this ).data( 'uploader_title' ),
      button: {
        text: jQuery( this ).data( 'uploader_button_text' ),
      },
      multiple: false  // Set to true to allow multiple files to be selected
    });

    // When an image is selected, run a callback.
    file_frame.on( 'select', function() {
      // We set multiple to false so only get one image from the uploader
      attachment = file_frame.state().get('selection').first().toJSON();
      image_field = $this.siblings('.img');
      var imgurl = attachment.url;
      image_field.val(imgurl);
      image_field.parent().find('.image-preview-wrap').hide();
      image_field.parent().find('.img-preview').attr('src',imgurl);
      image_field.parent().find('.image-preview-wrap').fadeIn();

    });

    // Finally, open the modal
    file_frame.open();
  });
  $(document).on('click', 'input.btn-remove-upload', function(evt){
    evt.preventDefault();
    var $this = $(this);
    $this.siblings('.img-preview').hide();
    $this.parent().parent().find('.img-preview').fadeOut();
    $this.parent().parent().siblings('.img').val('');
    $this.fadeOut();
  });

});
