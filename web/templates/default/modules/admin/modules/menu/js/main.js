var menuOpen;

/**
 * Dropy
 */
var dropy = {
	$dropys: null, 
	openClass: 'open', 
	selectClass: 'selected', 
	init: function () {
		var self = this;
		self.$dropys = $('.dropy');
		self.eventHandler();
	}, 
	eventHandler: function () {
		var self = this;
		// Opening a dropy
		self.$dropys.find('.dropy__title').click(function () {
			self.$dropys.removeClass(self.openClass);
			$(this).parents('.dropy').addClass(self.openClass);
		});
		// Click on a dropy list
		self.$dropys.find('.dropy__content ul li a').click(function () {
			var $that = $(this);
			var $dropy = $that.parents('.dropy');
			var $input = $dropy.find('input');
			var $title = $(this).parents('.dropy').find('.dropy__title span');
			// Remove selected class
			$dropy.find('.dropy__content a').each(function () {
				$(this).removeClass(self.selectClass);
			});
			// Update selected value
			$title.html($that.html());
			$input.val($that.attr('data-value')).trigger('change');
			// If back to default, remove selected class else addclass on right element
			if ($that.hasClass('dropy__header')) {
				$title.removeClass(self.selectClass);
				$title.html($title.attr('data-title'));
			}
			else {
				$title.addClass(self.selectClass);
				$that.addClass(self.selectClass);
			}
			// Close dropdown
			$dropy.removeClass(self.openClass);
		});
		// Close all dropdown onclick on another element
		$(document).bind('click', function (e) {
			if (!$(e.target).parents().hasClass('dropy')) {
				self.$dropys.removeClass(self.openClass);
			}
		});
	}
};



$(function () {
			dropy.init();
});


function initMenu(){
	
	if($('.filter-bar').hasClass("open")){
		$('.final-content .content-col').css({'margin-top' : '70px'});
	}
	
	// Toggle filters	
	$('#toggle-filter').click(function(){
		if ($('.dropy ul li').css('text-align') == 'center'){
			if($('.filter-bar').hasClass("open")){
				$('.filter-bar').css('bottom', '0px');
				$('.filter-bar').removeClass('open');
			}
			else {
				var l = -50 * $('.search_tri_content').length;
				$('.filter-bar').css('bottom', l+'px');
				$('.filter-bar').addClass('open');
			}
		}
		else {
			if($('.filter-bar').hasClass("open")){
				$('.filter-bar').css({'top' : '20px'});
				$('.final-content .content-col').css({'margin-top' : '20px'});
				$('.filter-bar').removeClass('open');
			}
			else{
				$('.filter-bar').css({'top' : '70px'});
				$('.final-content .content-col').css({'margin-top' : '70px'});
				$('.filter-bar').addClass('open');
			}
		}
	});
	
	// Menu open close	
	$('div#picto_menu').click(function(){
		toggleMenu();
	});
	
	$('.final-content').click(function(){
		if(menuOpen == true && $('body').width() < 1200){
			toggleMenu();
		}
	});
	
	
	$('div.top-content ul li').click(function(){
		var i_rel = $(this).attr('rel');
		$('form#engine_form div.content-col').each(function(){
			if($(this).attr('rel') == i_rel) $(this).css('display','block');
			else $(this).css('display','none');
		});
	});
	
	$('div#left-content div#menu-responsive div.content-bloc ul li.menu_part > span').click(function(){
		$('li.menu_part > span').removeClass('open');
		var iHeight = $(this).parent().children('div.smenu').children('ul').height();
		$this = $(this);
		$('div#left-content div#menu-responsive div.content-bloc ul li.menu_part div.smenu').stop();
		$('div#left-content div#menu-responsive div.content-bloc ul li.menu_part div.smenu').animate({'height':0+'px'},200,'easeOutQuart', function(){});
		if($this.parent().children('div.smenu').height() == 0){
			$this.parent().children('div.smenu').animate({'height':iHeight + 'px'},500,'easeOutQuart', function(){});
			$this.addClass('open');
		}
		else{
			$this.parent().children('div.smenu').animate({'height':0+'px'},500,'easeOutQuart', function(){});
			$this.removeClass('open');
		}
	});
}

function toggleMenu(){
	var rightOffset = 75;
	var time = 500;

	iPosition = $('div#left-content').position();

	if(iPosition.left == '0'){
		$('.content-col').removeClass('pointerOFF')
		$('.final-content').removeClass('opacityOFF');
		$('div#left-content').stop();
		$('div#right-content').stop();

		$('div#left-content').animate({'left':-250+'px'},time,'easeOutQuart', function(){$(this).css('left',-250+'px');});
		$('div#right-content').animate({'margin-left':0},time,'easeOutQuart', function(){$(this).css('margin-left','0');});
		$('div#top-content ').animate({'left':0},time,'easeOutQuart', function(){$(this).css('left','0');});
		menuOpen = false;
	}
	else{
		$('.content-col').addClass('pointerOFF')
		$('.final-content').addClass('opacityOFF');
		
		$('div#left-content').stop();
		$('div#right-content').stop();

		$('div#left-content').animate({'left':0},time,'easeOutQuart', function(){});
		$('div#right-content').animate({'margin-left':250+'px'},500,'easeOutQuart', function(){$(this).css('margin-left','250px');});
		$('div#top-content').animate({'left':250+'px'},500,'easeOutQuart', function(){$(this).css('left','250px');});
			
		menuOpen = true;
	}
}

$(document).ready(function() {
	initMenu();
});