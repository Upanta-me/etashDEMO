/*-----------------------------------------------------------------

Template Name: Transko - Transport & Logistics HTML Template
Author:  pixel-drop
Author URI: https://themeforest.net/user/pixel-drop/portfolio/portfolio
Version: 1.0.0
Description: Transko - Transport & Logistics HTML Template<

-------------------------------------------------------------------
CSS TABLE OF CONTENTS
-------------------------------------------------------------------

01. Mobile Menu Initialization
02. Sidebar Toggle
03. Body Overlay
04. Sticky Header
05. Popup for Images and Videos
06. Counter Animation:
07. Wow Animation
08. Custom Select Elements
09. Active Class Toggle on Hover 
10. Progress Bar Animation
11. Swiper Sliders Initializatio
12. Project Hover Effect
13. Back to Top Button
14. Search Popup
15. Custom Mouse Cursor 
16. Preloader 


------------------------------------------------------------------*/

(function($) {
    "use strict";

    $(document).ready(function() {

        //>> Mobile Menu Js Start <<//
        $('#mobile-menu').meanmenu({
            meanMenuContainer: '.mobile-menu',
            meanScreenWidth: "1199",
            meanExpand: ['<i class="far fa-plus"></i>'],
        });

        //>> Sidebar Toggle Js Start <<//
        $(".offcanvas__close,.offcanvas__overlay").on("click", function() {
            $(".offcanvas__info").removeClass("info-open");
            $(".offcanvas__overlay").removeClass("overlay-open");
        });
        $(".sidebar__toggle").on("click", function() {
            $(".offcanvas__info").addClass("info-open");
            $(".offcanvas__overlay").addClass("overlay-open");
        });

        //>> Body Overlay Js Start <<//
        $(".body-overlay").on("click", function() {
            $(".offcanvas__area").removeClass("offcanvas-opened");
            $(".df-search-area").removeClass("opened");
            $(".body-overlay").removeClass("opened");
        });

        //>> Sticky Header Js Start <<//
        $(window).scroll(function() {
            if ($(this).scrollTop() > 250) {
                $("#header-sticky").addClass("sticky");
            } else {
                $("#header-sticky").removeClass("sticky");
            }
        });

        //>> Video Popup Start <<//
        $(".img-popup").magnificPopup({
            type: "image",
            gallery: {
                enabled: true,
            },
        });

        $('.video-popup').magnificPopup({
            type: 'iframe',
            callbacks: {}
        });

        //>> Counterup Start <<//
        $(".count").counterUp({
            delay: 15,
            time: 1000,
        });

        //>> Wow Animation Start <<//
        new WOW().init();

        //>> Nice Select Start <<//
        $('select').niceSelect();

        //>> Active Js Start <<//
        $(".team-box-items, .news-box-items").hover(
            function() {
                $(".team-box-items, .news-box-items").removeClass("active");
                $(this).addClass("active");
            }
        );

        //>> Progress Bar Js Start <<//
        $('.progress-bar').waypoint(function() {
            $('.progress-bar').css({
                animation: "animate-positive 2.6s",
                opacity: "1"
            });
        }, { offset: '75%' });

        //>> Hero-3 Slider Start <<//
        const sliderActive1 = ".hero-slider-2";
        const sliderInit1 = new Swiper(sliderActive1, {
            loop: true,
            slidesPerView: 1,
            effect: "fade",
            speed: 2000,
            autoplay: {
            delay: 4000,
            disableOnInteraction: false,
            },
            
            pagination: {
                el: ".dot-2",
                clickable: true,
            },
            
        });
        // content animation when active start here
        function animated_swiper(selector, init) {
             let animated = function animated() {
                 $(selector + " [data-animation]").each(function () {
                     let anim = $(this).data("animation");
                     let delay = $(this).data("delay");
                     let duration = $(this).data("duration");
                     $(this)
                         .removeClass("anim" + anim)
                         .addClass(anim + " animated")
                         .css({
                             webkitAnimationDelay: delay,
                             animationDelay: delay,
                             webkitAnimationDuration: duration,
                             animationDuration: duration,
                         })
                         .one("animationend", function () {
                             $(this).removeClass(anim + " animated");
                         });
                 });
             };
             animated();
             init.on("slideChange", function () {
                 $(sliderActive1 + " [data-animation]").removeClass("animated");
             });
             init.on("slideChange", animated);
        }
        animated_swiper(sliderActive1, sliderInit1);

        //>> Hero Slider Start <<//
        if ($('.hero-slider').length > 0) {
            const heroSlider = new Swiper(".hero-slider", {
                spaceBetween: 30,
                speed: 2000,
                loop: true,
                autoplay: {
                    delay: 2000,
                    disableOnInteraction: false,
                },
                navigation: {
                    prevEl: ".array-prevs",
                    nextEl: ".array-nexts",
                },
                breakpoints: {
                    1199: {
                        slidesPerView: 2,
                    },
                    991: {
                        slidesPerView: 2,
                    },
                    767: {
                        slidesPerView: 2,
                    },
                    575: {
                        slidesPerView: 1,
                    },
                    0: {
                        slidesPerView: 1,
                    },
                },
            });
        }

        //>> Service Slider Start <<//
        if ($('.service-slider').length > 0) {
            const serviceSlider = new Swiper(".service-slider", {
                spaceBetween: 30,
                speed: 2000,
                loop: true,
                autoplay: {
                    delay: 2000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: ".dot",
                    clickable: true,
                },
                navigation: {
                    nextEl: ".array-prev",
                    prevEl: ".array-next",
                },
                breakpoints: {
                    1399: {
                        slidesPerView: 4,
                    },
                    1199: {
                        slidesPerView: 3,
                    },
                    991: {
                        slidesPerView: 2,
                    },
                    767: {
                        slidesPerView: 2,
                    },
                    575: {
                        slidesPerView: 1,
                    },
                    0: {
                        slidesPerView: 1,
                    },
                },
            });
        }

        if ($('.service-slider-2').length > 0) {
            const serviceSlider2 = new Swiper(".service-slider-2", {
                spaceBetween: 30,
                speed: 2000,
                loop: true,
                autoplay: {
                    delay: 2000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: ".service-dot",
                },
                navigation: {
                    prevEl: ".array-prev",
                    nextEl: ".array-next",
                },
                breakpoints: {
                    1399: {
                        slidesPerView: 4,
                    },
                    1199: {
                        slidesPerView: 3,
                    },
                    991: {
                        slidesPerView: 2,
                    },
                    767: {
                        slidesPerView: 2,
                    },
                    575: {
                        slidesPerView: 1,
                    },
                    0: {
                        slidesPerView: 1,
                    },
                },
            });
        }

        //>> Testimonial Slider Start <<//
        if ($('.testimonial-slider').length > 0) {
            const testimonialSlider = new Swiper(".testimonial-slider", {
                spaceBetween: 30,
                speed: 2000,
                loop: true,
                autoplay: {
                    delay: 2000,
                    disableOnInteraction: false,
                },
                navigation: {
                    nextEl: ".array-prev",
                    prevEl: ".array-next",
                },
            });
        }

        if ($('.testimonial-slider-2').length > 0) {
            const testimonialSlider2 = new Swiper(".testimonial-slider-2", {
                spaceBetween: 30,
                speed: 2000,
                loop: true,
                autoplay: {
                    delay: 2000,
                    disableOnInteraction: false,
                },
                navigation: {
                    nextEl: ".array-prev",
                    prevEl: ".array-next",
                },
                breakpoints: {
                    991: {
                        slidesPerView: 2,
                    },
                    767: {
                        slidesPerView: 1,
                    },
                    575: {
                        slidesPerView: 1,
                    },
                    0: {
                        slidesPerView: 1,
                    },
                },
            });
        }

        //>> Project Slider Start <<//
        if ($('.project-slider').length > 0) {
            const projectSlider = new Swiper(".project-slider", {
                spaceBetween: 30,
                speed: 2000,
                loop: true,
                centeredSlides: true,
                autoplay: {
                    delay: 2000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: ".project-dot",
                },
                breakpoints: {
                    1199: {
                        slidesPerView: 3,
                    },
                    991: {
                        slidesPerView: 2,
                    },
                    767: {
                        slidesPerView: 2,
                    },
                    575: {
                        slidesPerView: 1,
                    },
                    0: {
                        slidesPerView: 1,
                    },
                },
            });
        }

        //>> Brand Slider Start <<//
        if ($('.brand-slider').length > 0) {
            const brandSlider = new Swiper(".brand-slider", {
                spaceBetween: 30,
                speed: 2500,
                loop: true,
                autoplay: {
                    delay: 2500,
                    disableOnInteraction: false,
                },
                breakpoints: {
                    1199: {
                        slidesPerView: 5,
                    },
                    991: {
                        slidesPerView: 4,
                    },
                    767: {
                        slidesPerView: 3,
                    },
                    575: {
                        slidesPerView: 2,
                    },
                    0: {
                        slidesPerView: 1,
                    },
                },
            });
        }

        //>> News Post Slider Start <<//
        if ($('.news-post-slider').length > 0) {
            const newsPostSlider = new Swiper(".news-post-slider", { // Corrected variable name from "newsPostPlider"
                spaceBetween: 30,
                speed: 2000,
                loop: true,
                autoplay: {
                    delay: 2000,
                    disableOnInteraction: false,
                },
                navigation: {
                    nextEl: ".array-prev",
                    prevEl: ".array-next",
                },
            });
        }

        //>> Project Hover Js Start <<//
        const getSlide = $('.main-box, .box').length - 1;
        const slideCal = 100 / getSlide + '%';

        $('.box').css({
            "width": slideCal
        });

        $('.box').hover(function() {
            $('.box').removeClass('active');
            $(this).addClass('active');
        });

        //>> Back To Top Start <<//
        $(window).scroll(function () {
            if ($(this).scrollTop() > 20) {
                $("#back-top").addClass("show");
            } else {
                $("#back-top").removeClass("show");
            }
        });
        $("#back-top").click(function () {
            $("html, body").animate({ scrollTop: 0 }, 800);
            return false;
        });

        //>> Search Popup Start <<//
        const $searchWrap = $(".search-wrap");
        const $navSearch = $(".nav-search");
        const $searchClose = $("#search-close");

        $(".search-trigger").on("click", function (e) {
            e.preventDefault();
            $searchWrap.animate({ opacity: "toggle" }, 500);
            $navSearch.add($searchClose).addClass("open");
        });

        $(".search-close").on("click", function (e) {
            e.preventDefault();
            $searchWrap.animate({ opacity: "toggle" }, 500);
            $navSearch.add($searchClose).removeClass("open");
        });

        function closeSearch() {
            $searchWrap.fadeOut(200);
            $navSearch.add($searchClose).removeClass("open");
        }

        $(document.body).on("click", function (e) {
            closeSearch();
        });

        $(".search-trigger, .main-search-input").on("click", function (e) {
            e.stopPropagation();
        });

        //>> Mouse Cursor Start <<//
        function mousecursor() {
            if ($("body")) {
                const e = document.querySelector(".cursor-inner"),
                    t = document.querySelector(".cursor-outer");
                let n,
                    i = 0,
                    o = !1;
                (window.onmousemove = function(s) {
                    o ||
                        (t.style.transform =
                            "translate(" + s.clientX + "px, " + s.clientY + "px)"),
                        (e.style.transform =
                            "translate(" + s.clientX + "px, " + s.clientY + "px)"),
                        (n = s.clientY),
                        (i = s.clientX);
                }),
                $("body").on("mouseenter", "a, .cursor-pointer", function() {
                    e.classList.add("cursor-hover");
                    t.classList.add("cursor-hover");
                }),
                $("body").on("mouseleave", "a, .cursor-pointer", function() {
                    ($(this).is("a") && $(this).closest(".cursor-pointer").length) ||
                    (e.classList.remove("cursor-hover"),
                        t.classList.remove("cursor-hover"));
                }),
                (e.style.visibility = "visible"),
                (t.style.visibility = "visible");
            }
        }
        $(function() {
            mousecursor();
        });

    }); // End Document Ready Function

    function loader() {
        $(window).on('load', function() {
            // Animate loader off screen
            $(".preloader").addClass('loaded');
            $(".preloader").delay(600).fadeOut();
        });
    }

    loader();

})(jQuery); // End jQuery

