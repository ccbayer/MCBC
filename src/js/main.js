'use strict';
;(function() {
	var bLazy = new Blazy({
	   offset: 100,
	   success: function(element) {
		   var $el = $(element);
		   if( $el.data('x') && $el.data('y') ) {
			   var position = $el.data('x') + 'px ' + $el.data('y') + 'px';
			   $el.css({'background-position':  position });
		   }
	   }
	});

	$(window).resize(function() {
		bLazy.revalidate();
	});


})();

function setBackgroundImage($element, img) {
	if($element.length && img) {
		$element.css({
			'background-image': 'url("' + img + '")'
		});
		$element.fadeIn();
	}
}



// sliders
$(function() {

	var bLazy = new Blazy({
		offset: 100,
		breakpoints: [{
			width: 480,
			src: 'data-src-small'
		},
		{
			width: 768,
			src: 'data-src-med'
		}],
		success: function(element) {
			var $el = $(element);
			if( $el.data('x') && $el.data('y') ) {
				var position = $el.data('x') + 'px ' + $el.data('y') + 'px';
				$el.css({'background-position':  position });
			}
		}
	});

	$(window).resize(function() {
  		bLazy.revalidate();
	});

  	$('.slick-wrapper').on('afterChange', function(event, slick, currentSlide, nextSlide){
	  	// reinitialize lazy
  		bLazy.revalidate();
  	});

  	$('.slick-wrapper').each(function(){
  		var
  			$this = $(this),
  			time = $this.data('time') ? $this.data('time') : 10000,
  			autoplay = $this.data('autoplay') === 1 ? true : false,
  			pausehov = $this.data('pauseOnHover') === 1 ? true : false
  		;

	  	$this.slick({
			dots: true,
			fade: true,
			arrows: false,
			autoplay: autoplay,
			pauseOnHover: pausehov,
			autoplaySpeed: time
		});
  	});




	$('.menu-item').on('show.bs.dropdown', function () {
		$('.inner-body-wrapper').addClass('dropdown');
	});

	$('.menu-item').on('hide.bs.dropdown', function () {
		$('.inner-body-wrapper').removeClass('dropdown');
	});

  	// equlize
  	var initEqualize = function() {
	  	$('.equalize').each(function() {
			var $this = $(this);
			if($this.data('equalizeMin')) {
				if($(window).width() > $this.data('equalizeMin')) {
						$this.equalize({reset: true });
					} else {
						$this.children().removeAttr('style');
					}
			} else {
				$this.equalize({reset: true });
			}
		 });

	 }

	$(window).load(function() {
		initEqualize();
	});

	 $(window).resize(function() {
		initEqualize();
	 });

	 // Mean Menu

 	var $prependEl = $('#meanMenu').html();
 	$('.nav.navbar').meanmenu({
		'meanMenuContainer': '#mobile-nav-target',
		'meanScreenWidth': '768',
		'prependEl': $prependEl
	});
	$('#meanMenu').hide();

	// trigger mean menu when parent is clicked
	$('.mean-container li.menu-item-has-children').on('click', function(event) {
			event.stopPropagation();
			var $target = $(event.target);
			if(!$target.hasClass('mean-expand')) {
				var $expander = $(this).find('.mean-expand');
				if ($expander.hasClass('mean-clicked')) {
						$expander.text('+');
					$expander.prev('ul').slideUp(300, function(){});
			} else {
					$expander.text('-');
					$expander.prev('ul').slideDown(300, function(){});
			}
			$expander.toggleClass('mean-clicked');
		}
	});


	// waypoints
	var sticky = new Waypoint.Sticky({
		element: $('header')[0]
	});

	function updateTheIndicators(id) {
		$('.navindicator').removeClass('active');
		$('#indicator-' + id).addClass('active');
	}

	var $section = $('section[id^="section-"]');

	$section.waypoint(function(direction) {
	  if (direction === 'down') {
	    // Do stuff
	  	  updateTheIndicators($(this)[0].element.id.split('section-')[1]);
		}
	}, {
	  offset: '20px'
	});

	$section.waypoint(function(direction) {
	  if (direction === 'up') {
	    // Do stuff
		updateTheIndicators($(this)[0].element.id.split('section-')[1]);
	  }
	}, {
	  offset: '-100%'
	});

	// down-arrow
	$('.down-arrow, .scroll-to').click(function(event) {
		event.preventDefault();
		var
			$this = $(this),
			target = $this.attr('href')
		;
		$.scrollTo($(target), 800);

	});

	// mobile btn

	// rollover panel
	$('.panel-module-wrapper .panel').on('mouseover', function(){

		var
			$this = $(this),
			$target = $this.find('.img-wrap'),
			hoverImg = $target.data('hoverImg');

		if(hoverImg) {
			$target.css('background-image', 'url(' + hoverImg + ')');
		}
	});

	$('.panel-module-wrapper .panel').on('mouseout', function(){
		$(this).find('.img-wrap').removeAttr('style');
	});

	/* AJAX */
	function ajaxSubmitForm(form) {
		var data = $(form).serialize();
	}

	if($('form.sml_subscribe').length) {
		var target = $('.sml_email');
		var $field = $('<p><label>1 + 5 =</label><input type="text" name="math" id="math"/><input type="hidden" id="math2" value="6"/></p>');
		target.append($field);
	}
	$('form.sml_subscribe').validate({
		rules: {
			sml_email: {
				required: true,
				email: true
			},
			sml_name: {
				required: true
			},
			math: {
				required: true,
				number: true,
				equalTo: $('#math2')
			}
		},
		messages: {
			math: 'Try again'
		}

	});
	// modal search on nav
	$('.search-header-item').on('click', function(event){
		event.preventDefault();
		// invoke search dialog
		$('#search-modal').modal();
	});

	$(document).on( 'click', '.more-posts', function( event ) {
		event.preventDefault();
		var
			$this = $(this),
			href = $this.attr('href'),
			page = ''
		;

		if(href.indexOf('#?page=') > -1) {
			page = href.split('page=');
			page = page[1];
		} else {
			page = href.split('/');
			page = page[page.length - 2];
		}
		// console.log('page:' + page);

		$.ajax({
			url: ajaxpagination.ajaxurl,
			type: 'post',
			data: {
				action: 'ajax_pagination',
				query_vars: ajaxpagination.query_vars,
				page: page
			},
			success: function( result ) {
				// append results
				$('#ajax-target').append(result);
				var nextUrl = $(result).filter('.nextpage').data('nextUrl');
				var re = new RegExp('(\/page\/(.*)\/)', 'g');
				if(nextUrl === 1) {
					$this.fadeOut();
				} else {
					// not used
					var href = $this.attr('href').replace(re, '/page/' + nextUrl);
					$this.attr('href', '#?page=' + nextUrl);
				}
				$('#ajax-target').not('.search').equalize();
			},
		});
	});
	
	// RESPONSIVE IMAGES
	// strip out legacy images that have hard-coded width-height attributes in them.
	$('article .content img').each(function() {
		var $this = $(this);
		
		$this.removeAttr('width');
		$this.removeAttr('height');
		$this.addClass('ready');
	});
});
