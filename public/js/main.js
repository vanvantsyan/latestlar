$(document).ready(function() {
	var docWidth = $(document).width();
	if(docWidth < 1200) {
		$(".burning-tours-items").mCustomScrollbar({
		    axis:"x",
		    scrollbarPosition: "inside"
		});
	}

	if(docWidth < 767) {
		$(".partners-items").mCustomScrollbar({
		    axis:"x",
		    scrollbarPosition: "inside"
		});
	}

	$(".search-completed-item-preview").click(function() {
		$(".search-completed-preview-right a.btn-blue").trigger("click");
	});

	$('select').styler({
		selectSearch: true
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

	$('.tours-sorting a').click(function() {
		$('.tours-sorting-items').toggleClass('active');
		return false;
	});

	$('.search-completed-preview-right a.btn-blue').click(function() {
		$(this).closest('.search-completed-item').find('.search-completed-item-more').slideToggle();
		return false;
	});

	$('.sorting-btn').click(function() {
		$('.search-completed-item-more').slideUp();
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
    	return false;
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
	    arrows: false,
	    responsive: [ {
			breakpoint: 650,
			settings: {
				dots: false
			}
		} ]
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

	$(".card-schedule-day").click(function() {
		$(this).toggleClass("active");
		$(this).next().slideToggle();
		return false;
	});

	$(".accommodation-options-table").mCustomScrollbar({
	    axis:"x",
	    scrollbarPosition: "inside"
	});

	$(".card-tour-dates-item").mCustomScrollbar({
	    axis:"x",
	    scrollbarPosition: "inside"
	});
});


    