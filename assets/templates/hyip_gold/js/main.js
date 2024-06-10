(function ($) {
  "user strict";

  var windowOn = $(window);
  ////////////////////////////////////////////////////
  // 01. PreLoader Js
  windowOn.on("load", function () {
    $("#loading").delay(350).fadeOut("slow");
  });
  ////////////////////////////////////////////////////
  // Mobile Menu Js

  $("#mobile-menu2").meanmenu({
    meanMenuContainer: ".mobile-menu2",
    meanScreenWidth: "991",
    meanExpand: ['<i class="fal fa-plus"></i>'],
  });

  // side - info
  $(".side-info-close,.offcanvas-overlay").on("click", function () {
    $(".side-info").removeClass("info-open");
    $(".offcanvas-overlay").removeClass("overlay-open");
  });
  $(".side-toggle").on("click", function () {
    $(".side-info").addClass("info-open");
    $(".offcanvas-overlay").addClass("overlay-open");
  });

  ////////////////////////////////////////////////////
  // 03. Sticky Header Js
  $(window).on("scroll", function () {
    var scroll = $(window).scrollTop();
    if (scroll < 200) {
      $("#header-sticky").removeClass("header-sticky");
    } else {
      $("#header-sticky").addClass("header-sticky");
    }
  });

  // Scroll To Top Event
  var scrollTop = $(".scrollToTop");
  $(window).on("scroll", function () {
    if ($(this).scrollTop() < 500) {
      scrollTop.removeClass("active");
    } else {
      scrollTop.addClass("active");
    }
  });

  // Click event to scroll to top
  $(".scrollToTop").on("click", function () {
    $("html, body").animate(
      {
        scrollTop: 0,
      },
      300
    );
    return false;
  });

  // menu

  // ========================= Toggle Dashbaord Menu Js Start =====================
  $(".has-submenu").on("click", function () {
    $(this).find(".sub-menu").slideToggle(300);
  });
  //  Add Class On Arrow Icon To Change it
  $(".dashboard-menu__item.has-submenu").on("click", function () {
    $(this).find(".dashboard-menu__link-arrow").toggleClass("show");
  });
  // ========================= Toggle Dashbaord Menu Js End =====================

  // ========================= Dashbaord Header Dropdown Show & Hide Js Start =====================
  var profileElement = $(".dashboard-header__profile");
  var profileDropdownElement = $(".dashboard-header-dropdown");

  profileElement.on("click", function () {
    if ($(this).hasClass("show")) {
      $(this).removeClass("show");
    } else {
      $(this).addClass("show");
    }
    profileDropdownElement.slideToggle(300);
  });

  $(document).on("click", function (event) {
    if (!$(event.target).closest("#hide-dropdown").length) {
      if (profileElement.hasClass("show")) {
        profileElement.removeClass("show");
        profileDropdownElement.slideToggle(300);
      } else {
        profileDropdownElement.addClass("show");
      }
    }
  });
  // ========================= Dashbaord Header Dropdown Show & Hide Js End =====================

  // ========================= Toggle Dashboard Icon Js Start =====================
  $(".hambarger-btn").click(function () {
    $(".dashboard-sidebar").toggleClass("show");
  });
  $(".dashboard-sidebar").click(function () {
    $(this).removeClass("show");
  });
  // ========================= Toggle Dashboard Icon Js End =====================

  // service slider start here

  $(".testimonial-slider").slick({
    slidesToShow: 2,
    slidesToScroll: 1,
    autoplay: true,
    autoplaySpeed: 3000,
    speed: 1500,
    dots: false,
    arrows: true,
    prevArrow:
      '<button type="button" class="slick-prev slider-nav-btn"><i class="las la-long-arrow-alt-left"></i></button>',
    nextArrow:
      '<button type="button" class="slick-next slider-nav-btn"><i class="las la-long-arrow-alt-right"></i></button>',
    responsive: [
      {
        breakpoint: 1199,
        settings: {
          slidesToShow: 2,
        },
      },
      {
        breakpoint: 991,
        settings: {
          slidesToShow: 2,
        },
      },
      {
        breakpoint: 768,
        settings: {
          slidesToShow: 1,
        },
      },

      {
        breakpoint: 575,
        settings: {
          slidesToShow: 1,
        },
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 1,
        },
      },
    ],
  });

  ////////////////////////////////////////////////////
  // . Counter Js
  $(".counter").counterUp({
    delay: 10,
    time: 1000,
  });

  $.each($("input, select, textarea"), function (i, element) {
    if (element.hasAttribute("required")) {
      $(element)
        .closest(".form-group")
        .find("label")
        .first()
        .addClass("required");
    }
  });

  // service slider end here

  // Odometer Counter
  let counter = $(".counter-item");
  if (counter) {
    counter.each(function () {
      $(this).isInViewport(function (status) {
        if (status === "entered") {
          for (
            var i = 0;
            i < document.querySelectorAll(".odometer").length;
            i++
          ) {
            var el = document.querySelectorAll(".odometer")[i];
            el.innerHTML = el.getAttribute("data-odometer-final");
          }
        }
      });
    });
  }

  // Active Path Active
  var path = location.pathname.split("/");
  var current = location.pathname.split("/")[path.length - 1];
  $(".menu li a").each(function () {
    if ($(this).attr("href").indexOf(current) !== -1 && current != "") {
      $(this).addClass("active");
    }
  });

  // ========================= Sidebar Menu Js Start =====================
  // Sidebar Dropdown Menu Start
  $(".sidebar-menu-list__item > a").click(function () {
    $(".sidebar-submenu").slideUp(200);
    if ($(this).parent().hasClass("active")) {
      $(".sidebar-menu-list__item").removeClass("active");
      $(this).parent().removeClass("active");
    } else {
      $(".sidebar-menu-list__item").removeClass("active");
      $(this).next(".sidebar-submenu").slideDown(200);
      $(this).parent().addClass("active");
    }
  });
  // Sidebar Dropdown Menu End
  $(".side-menu--open").addClass("active");
  $(".sidebar-submenu__open").css("display", "block");
})(jQuery);
