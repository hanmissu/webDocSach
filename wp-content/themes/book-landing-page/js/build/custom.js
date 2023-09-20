jQuery(document).ready(function ($) {
  if (book_landing_page_ajax.ed_scrollbar) {
    $("body").niceScroll({
      cursorcolor: "#63b03e",
      zindex: "10",
      cursorborder: "none",
      cursoropacitymin: "0",
      cursoropacitymax: "1",
      cursorwidth: "8px",
      cursorborderradius: "0px;",
    });
  }

  $(".widget_newsletterwidget .widget-title").each(function () {
    $(this.nextSibling).wrap("<span></span>");
  });

  //mobile-menu
  var winWidth = $(window).width();

  if (winWidth < 1025) {
    $("#menu-opener").click(function () {
      $("body").addClass("menu-open");
      $(".mobile-menu-wrapper .primary-menu-list").addClass("toggled");

    });

    $(".mobile-menu-wrapper .close-main-nav-toggle ").click(function () {
      $("body").removeClass("menu-open");
      $(".mobile-menu-wrapper .primary-menu-list").removeClass("toggled");
    });

    $(".overlay").click(function () {
      $("body").removeClass("menu-open");
      $(".mobile-menu-wrapper .primary-menu-list").removeClass("toggled");
    });
  }

  //ul accessibility 
  $('<button class="angle-down"></button>').insertAfter(
    $(".main-navigation.mobile-navigation ul .menu-item-has-children > a")
  );
  $(".main-navigation.mobile-navigation ul li .angle-down").click(function () {
    $(this).next().slideToggle();
    $(this).toggleClass("active");
  });

  //menu opener
  $("#menu-opener").click(function () {
    $("body").addClass("menu-open");
    $(".mobile-menu-wrapper .primary-menu-list").addClass("toggled");

  });

  $(".mobile-menu-wrapper .close-main-nav-toggle ").click(function () {
    $("body").removeClass("menu-open");
    $(".mobile-menu-wrapper .primary-menu-list").removeClass("toggled");
  });


  $(window).on("load, resize", function() {
    var viewportWidth = $(window).width();
    if (viewportWidth < 1025) {
        $('.overlay').click(function() {
            $('body').removeClass('menu-open');
       $('.mobile-menu-wrapper .primary-menu-list').removeClass('toggled'); 
        });
    }
    else if (viewportWidth> 1025) {
        $('body').removeClass('menu-open');
    }
});




  if (winWidth > 1024) {
    //accessible menu in IE
    jQuery("#site-navigation ul li a")
      .focus(function () {
        jQuery(this).parents("li").addClass("focus");
      })
      .blur(function () {
        jQuery(this).parents("li").removeClass("focus");
      });
  }
});
