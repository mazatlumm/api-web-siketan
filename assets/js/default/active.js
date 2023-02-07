(function ($) {
    'use strict';

    var affanWindow = $(window);

    // :: 1.0 Preloader

    affanWindow.on('load', function () {
        $('#preloader').fadeOut('1000', function () {
            $(this).remove();
        });
    });

    // :: 2.0 Navbar

    var sideNavWrapper = $("#sidenavWrapper");
    var blackOverlay = $(".sidenav-black-overlay");

    $("#affanNavbarToggler").on("click", function () {
        sideNavWrapper.addClass("nav-active");
        blackOverlay.addClass("active");
    });

    $("#goBack").on("click", function () {
        sideNavWrapper.removeClass("nav-active");
        blackOverlay.removeClass("active");
    });

    blackOverlay.on("click", function () {
        $(this).removeClass("active");
        sideNavWrapper.removeClass("nav-active");
    });

    // :: 3.0 Dropdown Menu

    $(".sidenav-nav").find("li.affan-dropdown-menu").append("<div class='dropdown-trigger-btn'><i class='fa fa-angle-right'></i></div>");
    $(".dropdown-trigger-btn").on('click', function () {
        $(this).siblings('ul').stop(true, true).slideToggle(400);
        $(this).toggleClass('active');
    });

    // :: 4.0 Setting Trigger

    $("#settingTriggerBtn").on("click", function () {
        $("#settingCard").toggleClass("active");
        $("#setting-popup-overlay").toggleClass("active");
    });

    // :: 5.0 Setting Card

    $("#settingCardClose").on("click", function () {
        $("#settingCard").removeClass("active");
        $("#setting-popup-overlay").removeClass("active");
    });

    // :: 6.0 Clipboard Code Panel

    $(".codeview-clipboard-btn").on("click", function () {
        $(this).siblings(".codeview-wrapper").slideToggle();
    });

    // :: 7.0 Video Calling Button

    $("#videoCallingButton").on("click", function () {
        $("#videoCallingPopup").addClass('screen-active');
        $(".chat-wrapper").addClass('calling-screen-active');
    });

    $("#videoCallDecline").on("click", function () {
        $("#videoCallingPopup").removeClass('screen-active');
        $(".chat-wrapper").removeClass('calling-screen-active');
    });

    // :: 8.0 Calling Button

    $("#callingButton").on("click", function () {
        $("#callingPopup").addClass('screen-active');
        $(".chat-wrapper").addClass('calling-screen-active');
    });

    $("#callDecline").on("click", function () {
        $("#callingPopup").removeClass('screen-active');
        $(".chat-wrapper").removeClass('calling-screen-active');
    });

    // :: 9.0 Owl Carousel One

    if ($.fn.owlCarousel) {
        var owlCarouselOne = $('.owl-carousel-one');
        owlCarouselOne.owlCarousel({
            items: 1,
            loop: true,
            autoplay: true,
            dots: true,
            center: true,
            margin: 0,
            nav: true,
            navText: [('<i class="fa fa-angle-left"></i>'), ('<i class="fa fa-angle-right"></i>')]
        })

        owlCarouselOne.on('translate.owl.carousel', function () {
            var layer = $("[data-animation]");
            layer.each(function () {
                var anim_name = $(this).data('animation');
                $(this).removeClass('animated ' + anim_name).css('opacity', '0');
            });
        });

        $("[data-delay]").each(function () {
            var anim_del = $(this).data('delay');
            $(this).css('animation-delay', anim_del);
        });

        $("[data-duration]").each(function () {
            var anim_dur = $(this).data('duration');
            $(this).css('animation-duration', anim_dur);
        });

        owlCarouselOne.on('translated.owl.carousel', function () {
            var layer = owlCarouselOne.find('.owl-item.active').find("[data-animation]");
            layer.each(function () {
                var anim_name = $(this).data('animation');
                $(this).addClass('animated ' + anim_name).css('opacity', '1');
            });
        });
    }

    // :: 10.0 Owl Carousel Two

    if ($.fn.owlCarousel) {
        var owlCarouselTwo = $('.owl-carousel-two');
        owlCarouselTwo.owlCarousel({
            items: 1,
            loop: true,
            autoplay: true,
            dots: true,
            center: true,
            margin: 30,
            nav: false,
            animateIn: 'fadeIn',
            animateOut: 'fadeOut'
        });

        var dot = $('.owl-carousel-two .owl-dot');
        dot.each(function () {
            var index = $(this).index() + 1;

            if (index < 10) {
                $(this).html('0' + index);
            } else {
                $(this).html(index);
            }
        });

        var owlDotsCount = $(".owl-carousel-two .owl-dots").children().length;
        if (owlDotsCount < 10) {
            $("#totalowlDotsCount").html('0' + owlDotsCount);
        } else {
            $("#totalowlDotsCount").html(owlDotsCount);
        }
    }

    // :: 11.0 Owl Carousel Three

    if ($.fn.owlCarousel) {
        var owlCarouselThree = $('.owl-carousel-three');
        owlCarouselThree.owlCarousel({
            items: 2,
            loop: true,
            autoplay: true,
            dots: false,
            center: true,
            margin: 8,
            nav: false
        })
    }

    // :: 12.0 Testimonial Slides One

    if ($.fn.owlCarousel) {
        var testimonial1 = $('.testimonial-slide');
        testimonial1.owlCarousel({
            items: 1,
            loop: true,
            autoplay: true,
            dots: true,
            margin: 30,
            nav: false
        })
    }

    // :: 13.0 Testimonial Slides Two

    if ($.fn.owlCarousel) {
        var testimonial2 = $('.testimonial-slide2');
        testimonial2.owlCarousel({
            items: 2,
            loop: true,
            autoplay: true,
            dots: true,
            margin: 0,
            nav: true,
            navText: [('<i class="fa fa-angle-left"></i>'), ('<i class="fa fa-angle-right"></i>')],
            center: true
        })
    }

    // :: 14.0 Partner Slides

    if ($.fn.owlCarousel) {
        var partnerSlide = $('.partner-slide');
        partnerSlide.owlCarousel({
            items: 3,
            margin: 12,
            loop: true,
            autoplay: true,
            autoplayTimeout: 5000,
            dots: true,
            nav: false
        })
    }

    // :: 15.0 Gallery Slides

    if ($.fn.owlCarousel) {
        var galleryCarousel = $('.image-gallery-carousel');
        galleryCarousel.owlCarousel({
            items: 3,
            margin: 8,
            loop: true,
            autoplay: true,
            autoplayTimeout: 5000,
            dots: true,
            nav: false
        })
    }

    // :: 16.0 Product Gallery Slides

    if ($.fn.owlCarousel) {
        var productGalleryCarousel = $('.product-gallery');
        productGalleryCarousel.owlCarousel({
            items: 1,
            margin: 0,
            loop: true,
            autoplay: true,
            autoplayTimeout: 5000,
            dots: true,
            nav: false
        })
    }

    // :: 17.0 Chat User Slide

    if ($.fn.owlCarousel) {
        var userStatusSlide = $('.chat-user-status-slides');
        userStatusSlide.owlCarousel({
            items: 5,
            margin: 8,
            loop: true,
            autoplay: false,
            autoplayTimeout: 5000,
            dots: false,
            nav: false,
            responsive: {
                1200: {
                    items: 13
                },
                992: {
                    items: 11
                },
                768: {
                    items: 9
                },
                576: {
                    items: 7
                },
                480: {
                    items: 5
                }
            }
        })
    }

    // :: 18.0 Magnific Popup One

    if ($.fn.magnificPopup) {
        $('#videobtn').magnificPopup({
            type: 'iframe'
        });
        $('.gallery-img').magnificPopup({
            type: 'image',
            gallery: {
                enabled: true
            },
            removalDelay: 300,
            mainClass: 'mfp-fade',
            preloader: true,
            callbacks: {
                beforeOpen: function () {
                    this.st.image.markup = this.st.image.markup.replace('mfp-figure', 'mfp-figure mfp-with-anim');
                    this.st.mainClass = this.st.el.attr('data-effect');
                }
            },
            closeOnContentClick: true,
            midClick: true
        });
    }

    // :: 19.0 Magnific Popup Two

    if ($.fn.magnificPopup) {
        $('.gallery-img2').magnificPopup({
            type: 'image',
            gallery: {
                enabled: true
            },
            removalDelay: 300,
            mainClass: 'mfp-fade',
            preloader: true,
            callbacks: {
                beforeOpen: function () {
                    this.st.image.markup = this.st.image.markup.replace('mfp-figure', 'mfp-figure mfp-with-anim');
                    this.st.mainClass = this.st.el.attr('data-effect');
                }
            },
            closeOnContentClick: true,
            midClick: true
        });
    }

    // :: 20.0 Masonary Gallery

    if ($.fn.imagesLoaded) {
        $('.gallery-wrapper').imagesLoaded(function () {
            // filter items on button click
            $('.gallery-menu').on('click', 'button', function () {
                var filterValue = $(this).attr('data-filter');
                $grid.isotope({
                    filter: filterValue
                });
            });
            // init Isotope
            var $grid = $('.gallery-wrapper').isotope({
                itemSelector: '.single-image-gallery',
                percentPosition: true,
                masonry: {
                    columnWidth: '.single-image-gallery'
                }
            });
        });
    }
    $('.gallery-menu button').on('click', function () {
        $('.gallery-menu button').removeClass('active');
        $(this).addClass('active');
    })

    // :: 21.0 Countdown One

    if ($.fn.countdown) {
        $('#simpleCountdown').countdown('2021/10/10', function (event) {
            var $this = $(this).html(event.strftime(
                '<span>%D</span> Days ' +
                '<span>%H</span> Hour ' +
                '<span>%M</span> Min ' +
                '<span>%S</span> Sec'));
        });
    }

    // :: 22.0 Countdown Two

    if ($.fn.countdown) {
        $('#countdown2').countdown('2021/12/9', function (event) {
            var $this = $(this).html(event.strftime(
                '<span>%D</span> d' +
                '<span>%H</span> h' +
                '<span>%M</span> m' +
                '<span>%S</span> s'));
        });
    }

    // :: 23.0 Countdown Three

    if ($.fn.countdown) {
        $('#countdown3').countdown('2022/10/10', function (event) {
            var $this = $(this).html(event.strftime(
                '<span>%D</span> days ' +
                '<span>%H</span> : ' +
                '<span>%M</span> : ' +
                '<span>%S</span>'));
        });
    }

    // :: 24.0 Counter Up

    if ($.fn.counterUp) {
        $('.counter').counterUp({
            delay: 100,
            time: 3000
        });
    }

    // :: 25.0 Prevent Default 'a' Click

    $('a[href="#"]').on('click', function ($) {
        $.preventDefault();
    });

    // :: 26.0 Password Strength

    if ($.fn.passwordStrength) {
        $('#registerPassword').passwordStrength({
            minimumChars: 8
        });
    }

    // :: 27.0 Miscellaneous

    $(".form-control, .form-select").on("click", function () {
        $(this).addClass("form-control-clicked");
    })

    $(".active-effect").on("click", function () {
        $(".active-effect").removeClass("active");
        $(this).addClass("active");
    })

    $(".single-image-gallery .fav-icon").on("click", function () {
        $(this).toggleClass("active");
    })

    // :: 28.0 ion Range Slider

    if ($.fn.ionRangeSlider) {
        $(".custom-range-slider").ionRangeSlider({});
    }

    // :: 29.0 Data Table

    if ($.fn.DataTable) {
        $("#dataTable").DataTable({
            "paging": true,
            "ordering": true,
            "info": true
        });
    }

    $("#dataTable_length select").addClass("form-select form-select-sm");
    $("#dataTable_filter input").addClass("form-control form-control-sm");

    // :: 30.0 Price Table

    $(".single-price-table").on("click", function () {
        $(".single-price-table").removeClass("active");
        $(this).addClass("active");
    });

    // :: 31.0 Tooltip

    var affanTooltip = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = affanTooltip.map(function (tooltip) {
        return new bootstrap.Tooltip(tooltip);
    });

    // :: 32.0 Toast

    var affanToast = [].slice.call(document.querySelectorAll('.toast'));
    var toastList = affanToast.map(function (toast) {
        return new bootstrap.Toast(toast);
    });
    toastList.forEach(toast => toast.show());

    $('#toast-showing-btn').on('click', function () {
        var affanToast = [].slice.call(document.querySelectorAll('.toast'));
        var toastList = affanToast.map(function (toast) {
            return new bootstrap.Toast(toast);
        });
        toastList.forEach(toast => toast.show());
    });

    var toastDataDelay = $('.toast-autohide').attr("data-bs-delay");
    var toastAnimDelay = toastDataDelay + "ms";
    $(".toast-autohide").append("<span class='toast-autohide-line-animation'></span>");
    $(".toast-autohide-line-animation").css("animation-duration", toastAnimDelay);

    // :: 33.0 WOW

    if ($.fn.init) {
        new WOW().init();
    }

})(jQuery);