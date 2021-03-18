jQuery(function ($) {
    'use strict';

    $('#calc-bmi').click(function(e) {
        $('#formBMI').validate({
            rules: {
                cannang: {
                    required: true,
                    number: true
                },
                chieucao: {
                    required: true,
                    number: true
                }
            },
            messages: {
                cannang: {
                    required: "Vui lòng nhập cân nặng.",
                    number: "Chỉ chấp nhận số."
                },
                chieucao: {
                    required: "Vui lòng nhập chiều cao.",
                    number: "Chỉ chấp nhận số."
                }
            },
            highlight: function (element) {
                $(element).addClass('has-error');
            },
            unhighlight: function (element) {
                $(element).removeClass('has-error');
            },
            errorPlacement: function(error, element) {
                if (element.is(":input") ) {
                    error.appendTo( element.parents('.form-group') );
                }
            },
            submitHandler: function(form) {
                var cannang = $('input[name="cannang"]').val(),
                chieucao = $('input[name="chieucao"]').val(),
                resulText = $('#result-text'),
                calc = parseFloat(cannang / (chieucao * chieucao)).toFixed(2);
                $('#result-number').text(calc);
                switch (true) {
                    case (calc < 18.5):
                        resulText.text('Bạn thiếu cân')
                        break;
                    case (calc > 18.5 && calc < 22.9):
                        resulText.text('Bạn bình thường')
                        break;
                    case (calc == 23):
                        resulText.text('Bạn bị thừa cân')
                        break;          
                    case (calc > 23 && calc < 24.9):
                        resulText.text('Bạn bị béo phì')
                        break;
                    case (calc > 25 && calc < 29.9):
                        resulText.text('Bạn bị béo phì độ 1')
                        break;
                    case (calc > 30 && calc < 40):
                        resulText.text('Bạn bị béo phì độ 2')
                        break;
                    default:
                        resulText.text('Bạn bị béo phì độ 3')
                        break;
                }
                return false
            }
        })
    })

    $('.owl-inner').trigger('refresh.owl.carousel');

    $('.slide-promotion').find('.carousel-inner').slick({
        dots: true,
        infinite: true,
        speed: 300,
        slidesToShow: 1,
        adaptiveHeight: true,
        autoplay:true,
        prevArrow: '<i class="fa fa-angle-left"></i>',
        nextArrow: "<i class='fa fa-angle-right'></i>"
    })

    $('.navbar-collapse ul li.scroll a').on('click', function (event) {
        $('html, body').animate({scrollTop: $(this.hash).offset().top - 5}, 1000);
        return false;
    });
    var detectCustom = $('body').find('.custom-responsive-table');
    if(detectCustom[0] == undefined) {
        $('body').find('table').addClass('table-hover table').wrap('<div class="table-responsive"></div>');
        $('body').find('table').css({'width': '100%'});
        $('body').find('table').attr({'border': '1'});
    }
    
    $('#tohash').on('click', function () {
        $('html, body').animate({scrollTop: $(this.hash).offset().top - 5}, 1000);
        return false;
    });
    
    // accordion
    $('.accordion-toggle').on('click', function () {
        $(this).closest('.panel-group').children().each(function () {
            $(this).find('>.panel-heading').removeClass('active');
        });
        
        $(this).closest('.panel-heading').toggleClass('active');
    });
    
    //Slider
    $(document).ready(function () {
        limitEndVideo()
        var has_children = $('#nav .menu-item-has-children');
        has_children.click(function (e) {
            has_children.find('.submenu_changed').removeClass('open');
            if($(this).hasClass('opened')) {
                $(this).removeClass('opened')
                $(this).find('.submenu_changed').removeClass('open')
                
            } else {
                $(this).addClass('opened');
                $(this).find('.submenu_changed').addClass('open')
            }
            e.stopPropagation();
        });
        $('.navbar-toggle.collapsed').click(function () {
            $('#navMain').slideToggle('fast')
        })
        
        var header = $('#header');
        $(window).scroll(function () {
            if ($(window).scrollTop() > 173) {
                header.addClass('fixed');
            } else {
                header.removeClass('fixed');
            }
        });
        
        var time = 7; // time in seconds
        
        var $progressBar,
            $bar,
            $elem,
            isPause,
            tick,
            percentTime;
        
        var $progressBarGallery,
            $barGallery,
            $elemGallery,
            isPauseGallery,
            tickGallery,
            percentTimeGallery;
        //Init the carousel
        $("#main-slider").find('.carousel-inner').owlCarousel({
            slideSpeed: 500,
            paginationSpeed: 500,
            autoplay: true,
            singleItem: true,
            loop: true,
            navigation: true,
            navigationText: [
                "<i class='fa fa-angle-left'></i>",
                "<i class='fa fa-angle-right'></i>"
            ],
            afterInit: progressBar,
            afterMove: moved,
            startDragging: pauseOnDragging,
            transitionStyle: "fadeUp",
            autoHeight: true
        });
        
        $(".services-slider").find('.carousel-inner').owlCarousel({
            slideSpeed: 700,
            paginationSpeed: 500,
            autoplay: true,
            navigation: false,
            dots: false,
            navigationText: [
                "<i class='fa fa-angle-left'></i>",
                "<i class='fa fa-angle-right'></i>"
            ],
            items: 4,
            afterMove: moved,
            startDragging: pauseOnDragging
        });
        $('.tu-van-slider').find('.carousel-inner').owlCarousel({
            slideSpeed: 700,
            navigation: false,
            dots: false,
            items: 4,
            autoplay: true,
            singleItem: false,
            autoWidth:true,
        })

        $('#video_intro').find('.carousel-inner').owlCarousel({
            slideSpeed: 700,
            navigation: false,
            dots: false,
            items: 1,
            autoplay: true,
            singleItem: true,
            autoWidth:false,
        })
        
        $("#gallery-slider ").find('.carousel-inner').owlCarousel({
            slideSpeed: 700,
            paginationSpeed: 500,
            autoplay: true,
            navigation: false,
            dots: false,
            items: 5,
            autoWidth:true,
            afterMove: movedGallery,
            afterInit: progressBarGallery,
            startDragging: pauseOnDraggingGallery
        });
        //Init progressBar where elem is $("#owl-demo")
        function progressBarGallery(elemGallery) {
            $elemGallery = elemGallery;
            //build progress bar elements
            buildProgressBarGallery();
            //start counting
            startGallery();
        }
        
        //create div#progressBar and div#bar then append to $(".owl-carousel")
        function buildProgressBarGallery() {
            $progressBarGallery = $("<div>", {
                id: "progressBarGallery"
            });
            $barGallery = $("<div>", {
                id: "barGallery"
            });
            $progressBar.append($barGallery).appendTo($elem);
        }
        
        function startGallery() {
            //reset timer
            percentTimeGallery = 0;
            isPauseGallery = false;
            //run interval every 0.01 second
            tickGallery = setInterval(intervalGallery, 10);
        };
        
        function intervalGallery() {
            if (isPauseGallery === false) {
                percentTimeGallery += 1 / time;
                $barGallery.css({
                    width: percentTimeGallery + "%"
                });
                //if percentTime is equal or greater than 100
                if (percentTimeGallery >= 100) {
                    //slide to next item
                    $elemGallery.trigger('owl.next')
                }
            }
        }
        
        //pause while dragging
        function pauseOnDraggingGallery() {
            isPauseGallery = true;
        }
        
        //moved callback
        function movedGallery() {
            //clear interval
            clearTimeout(tickGallery);
            //start again
            startGallery();
        }
        
        
        //Init progressBar where elem is $("#owl-demo")
        function progressBar(elem) {
            $elem = elem;
            //build progress bar elements
            buildProgressBar();
            //start counting
            start();
        }
        
        //create div#progressBar and div#bar then append to $(".owl-carousel")
        function buildProgressBar() {
            $progressBar = $("<div>", {
                id: "progressBar"
            });
            $bar = $("<div>", {
                id: "bar"
            });
            $progressBar.append($bar).appendTo($elem);
        }
        
        function start() {
            //reset timer
            percentTime = 0;
            isPause = false;
            //run interval every 0.01 second
            tick = setInterval(interval, 10);
        };
        
        function interval() {
            if (isPause === false) {
                percentTime += 1 / time;
                $bar.css({
                    width: percentTime + "%"
                });
                //if percentTime is equal or greater than 100
                if (percentTime >= 100) {
                    //slide to next item
                    $elem.trigger('owl.next')
                }
            }
        }
        
        //pause while dragging
        function pauseOnDragging() {
            isPause = true;
        }
        
        //moved callback
        function moved() {
            //clear interval
            clearTimeout(tick);
            //start again
            start();
        }
    });
    
    //Initial WOW JS
    new WOW().init();
    //smoothScroll
    smoothScroll.init();

    /**
     * VideoJS init
     */
    function limitEndVideo() {
        var player;
        $('#video_intro .embed-responsive').each(function(element, key) {
            var srcVid = $('#playerId-'+element).attr('srccur')
            player = videojs('vid-'+element, {
                autoplay: false,
                controls: true,
                techOrder: ["youtube"],
                sources: [{
                    "src": srcVid,
                    "type": "video/youtube",
                    "youtube": {
                        "customVars": { "wmode": "transparent" }
                    }
                }]
            }, function() {
                this.on('ended', function() {
                    if(player.currentTime() == 0) {
                        player.trigger('loadstart');
                        player.trigger('pause')
                    }
                })
            })
        })
    }

    // portfolio filter
    $(window).load(function () {
        'use strict';
        var $portfolio_selectors = $('.portfolio-filter >li>a');
        var $portfolio = $('.portfolio-items');
        $portfolio.isotope({
            itemSelector: '.portfolio-item',
            layoutMode: 'fitRows'
        });
        
        $portfolio_selectors.on('click', function () {
            $portfolio_selectors.removeClass('active');
            $(this).addClass('active');
            var selector = $(this).attr('data-filter');
            $portfolio.isotope({filter: selector});
            return false;
        });
        
        $('.slide-cnkh').find('.carousel-inner').slick({
            loop: true,
            autoHeight: true,
            dots: true,
            slidesToShow: 4,
            arrows: false,
            centerPadding: '10px',
            responsive: [
                {
                  breakpoint: 1720,
                  settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                    infinite: true,
                  }
                },
                {
                  breakpoint: 1280,
                  settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                  }
                },
                {
                  breakpoint: 750,
                  settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                  }
                }
            ]
        })
    });
    
    $(document).ready(function () {
        //Menu
        if ($(window).width() <= 767) {
            $(".node").on("click", function () {
                var ul = $(this).next();
                //Get css
                var display = $(ul).css("display");
                if (display == "none")
                    $(ul).css("display", "block");
                else
                    $(ul).css("display", "none");
            });
        }
        //Animated Progress
        $('.progress-bar').bind('inview', function (event, visible, visiblePartX, visiblePartY) {
            if (visible) {
                $(this).css('width', $(this).data('width') + '%');
                $(this).unbind('inview');
            }
        });
        
        //Animated Number
        $.fn.animateNumbers = function (stop, commas, duration, ease) {
            return this.each(function () {
                var $this = $(this);
                var start = parseInt($this.text().replace(/,/g, ""));
                commas = (commas === undefined) ? true : commas;
                $({value: start}).animate({value: stop}, {
                    duration: duration == undefined ? 1000 : duration,
                    easing: ease == undefined ? "swing" : ease,
                    step: function () {
                        $this.text(Math.floor(this.value));
                        if (commas) {
                            $this.text($this.text().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
                        }
                    },
                    complete: function () {
                        if (parseInt($this.text()) !== stop) {
                            $this.text(stop);
                            if (commas) {
                                $this.text($this.text().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
                            }
                        }
                    }
                });
            });
        };
        
        $('.animated-number').bind('inview', function (event, visible, visiblePartX, visiblePartY) {
            var $this = $(this);
            if (visible) {
                $this.animateNumbers($this.data('digit'), false, $this.data('duration'));
                $this.unbind('inview');
            }
        });
    });
    
    // Contact form
    var form = $('#main-contact-form');
    form.submit(function (event) {
        event.preventDefault();
        var form_status = $('<div class="form_status"></div>');
        $.ajax({
            url: $(this).attr('action'),
            beforeSend: function () {
                form.prepend(form_status.html('<p><i class="fa fa-spinner fa-spin"></i> Mail đang được gửi...</p>').fadeIn());
            },
            error: function (request, status, error) {
                form_status.html(error).delay(3000).fadeOut();
            }
        }).complete(function (data) {
            form_status.html('<p class="text-success">Cảm ơn bạn đã liên hệ với chúng tôi. Chúng tôi sẽ liên hệ với bạn ngay khi có thể</p>').delay(3000).fadeOut();
        });
    });
    
    //Pretty Photo
    $("a[rel^='prettyPhoto']").prettyPhoto({
        social_tools: false
    });
    
    //scroll horizontal
    $(document).ready(function () {
        var owl = $('.slider_horizontal');
        owl.mCustomScrollbar({
            axis: "x",
            theme: "dark-3",
        });
    })
    var form = $('#main-form-contact');
    form.submit(function(evt) {
        evt.preventDefault();
        var form_status = $('<div class="form_status"></div>');
        $.ajax({
            type:'POST',
            url: my_ajax_insert_db.ajax_url,
            data: {
                action: 'action_send_mail_contact',
                name: form.find('input[name="name"]').val(),
                email: form.find('input[name="email"]').val(),
                subject: form.find('input[name="subject"]').val(),
                phongban: form.find('select[name="phongban"]').val(),
                message: form.find('textarea[name="message"]').val()
            },
            beforeSend: function() {
                form.prepend(form_status.html('<p><i class="fa fa-spinner fa-spin"></i> Mail đang được gửi...</p>').fadeIn());
            },
            error: function (request, status, error) {
                form_status.html(error).delay(3000).fadeOut();
            },
            success: function() {
                form_status.html('<p class="text-success">Cảm ơn bạn đã liên hệ với chúng tôi. Chúng tôi sẽ liên hệ với bạn ngay khi có thể</p>').delay(3000).fadeOut();
            }
        })
    })
});
