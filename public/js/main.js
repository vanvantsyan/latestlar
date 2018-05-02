$(document).ready(function() {
	var docWidth = $(document).width();
	if(docWidth < 1200) {
		$(".burning-tours-items").mCustomScrollbar({
		    axis:"x",
		    scrollbarPosition: "inside"
		});
	}
	$(".partners-items").mCustomScrollbar({
	    axis:"x",
	    scrollbarPosition: "inside"
	});

	$(".search-completed-item-preview > div:first-child").click(function() {
        $(this).closest('.search-completed-item').find('.search-completed-item-more').slideToggle();
        return false;
	});

	$('select').styler({
		selectSearch: false
	});

	$('.seo-txt-btn').click(function() {
		$('.seo-txt-more').slideToggle();
		return false;
	});

	$('.menu li.submenu').hover(function() {
		$(this).toggleClass('active');
	});

	$('.city').hover(function() {
		$(this).toggleClass('active');
	});

	$('.tours-sorting-items a').click(function() {
		$('.tours-sorting-items').toggleClass('active');

        $('body').toggleClass('sort-open');

        if ($('body').hasClass('sort-open')) {

            $('body.sort-open').on('click', function () {
                $('.tours-sorting span')[0].click();
            });
        } else {
            $('body').off();
        }

		return false;
	});

	$('.sorting-btn').click(function() {
		$('.search-completed-item-more').slideToggle();
		var text = $('.sorting-btn').text();
	    $('.sorting-btn').text(
	        text == "Подробно" ? "Кратко" : "Подробно");
		return false;
	});
	
	// $('.date-pick').datePicker().val(new Date().asString()).trigger('change');

	$(".tour-filter-tabs a").click( function () {
        $(".tour-filter-tabs a").removeClass("current");
        $(this).addClass("current");

        $(".tour-filter-content>div").hide();
        t_content=$(this).attr("href");
        $(t_content).show();
        return false;
    });

    $(".phones").click(function() {
    	$(this).toggleClass("active");
    });

	$(".main-slider-left").slick({
	    autoplay: true,
	    autoplaySpeed: 2000,
	    dots: true,
	    arrows: false
	});

	$(".main-slider-right").slick({
	    autoplay: true,
	    autoplaySpeed: 2000,
	    dots: true,
	    arrows: false
	});

	$(".card-slider").slick({
	    autoplay: true,
	    autoplaySpeed: 2000,
	    dots: true,
	    arrows: false
	});

	$(".reviews-slider").slick({
		slidesToShow: 3,
		slidesToScroll: 1,
	    dots: false,
	    arrows: true
	});

	$(".card-tour-photo").mCustomScrollbar({
	    axis:"x",
	    scrollbarPosition: "inside"
	});

	$(".card-schedule-day, .accommodation-options-day").click(function() {

		$(this).toggleClass("active");
		$(this).next().slideToggle();

		var btnEx =  $('.card-schedule .btn-expand');

        if($('.card-schedule-day').hasClass('active')) {
        	if(!btnEx.hasClass('active')) {
        		btnEx.addClass('active');
			}
            btnEx.text('Закрыть все');
        } else {
            if(btnEx.hasClass('active')) {
                btnEx.removeClass('active');
            }
            btnEx.text('Раскрыть все');
		}

		return false;
	});

	$(".card-tour-dates-item").mCustomScrollbar({
	    axis:"x",
	    scrollbarPosition: "inside"
	});

	$(".card-tour-filter").mCustomScrollbar({
	    axis:"x",
	    scrollbarPosition: "outside"
	});

    $(".accommodation-options-table-item .accommodation-options-day-cont").mCustomScrollbar({
        axis:"x",
        scrollbarPosition: "inside"
    });

    $(".accommodation-options-table").mCustomScrollbar({
        axis:"x",
        scrollbarPosition: "inside"
    });

    $('.header .menu .navbar-collapse li a').click(function() {
    	$(this).parent().find('.header-submenu').toggleClass('active');
    	if($(this).parent().find('ul').hasClass('header-submenu')) {
    		return false;
    	}
    });

    $(".card-tour-filter a").click(function () {
        var elementClick = $(this).attr("href");
        var destination = $(elementClick).offset().top;
        $('html,body').animate( { scrollTop: destination }, 1100 );
        $('.card-tour-filter a').removeClass('active');
        $(this).addClass('active');
        return false;
    });

    $(".burning-tours-filter-wrap").mCustomScrollbar({
        axis:"x",
        scrollbarPosition: "inside"
    });
    $('.tour-filter-more').on("click", function(e){

    	e.preventDefault();

    	moreLink = this;

    	$('.filterDate').toggle('slow', function() {
			$(moreLink).toggleClass('active');
			if($(moreLink).hasClass('active')) {
                $(moreLink).find('div').html(" &#x25B2;");
			} else {
                $(moreLink).find('div').html(" &#9660;");
			}
		});
	});
});


    