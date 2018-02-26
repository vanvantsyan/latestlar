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

	$(".tour-top-info").click(function() {
		$(".search-completed-preview-right a.btn-blue").trigger("click");
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
		return false;
	});

	$('.tour-top-info').click(function() {
		$(this).closest('.search-completed-item').find('.search-completed-item-more').slideToggle();
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
});


    