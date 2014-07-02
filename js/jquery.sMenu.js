/************************************************************************
*************************************************************************
@Name    :		sMenu - jQuery Plugin
@Revison :		0.1
@Date    :		01/2013
@Author  :		wffranco
@Support :		FF, IE7, IE8, Safari, Chrome
**************************************************************************
*************************************************************************/

/**
@ IsHovered Plugin
@ Thanks to Chad Smith fr his isHovered Plugin
@ source : http://mktgdept.com/jquery-ishovered
**/
;(function(b,c) {
	b('*').hover(function() {
		b(this).data(c, 1);
	},
	function() {
		b(this).data(c, 0);
	}).data(c, 0);
	b[c] = function(a) {
		return b(a)[c]();
	};
	b.fn[c] = function(a) {
		a = 0;
		b(this).each(function() {
			a += b(this).data(c)
		});
		return a > 0;
	}
})(jQuery, 'isHovered');

/** sMenu Plugin **/
(function($) {
	$.sMenu = {
		/**************/
		/** OPTIONS **/
		/**************/
		defaults: {
			ulWidth:			'auto',
			absoluteTop:		30,
			absoluteLeft:		0,
			TimeBeforeOpening:	100,
			TimeBeforeClosing:	100,
			animatedText:		false,
			paddingLeft:		7,
			openClick:			false,
			effects: {
				effectSpeedOpen:	150,
				effectSpeedClose:	150,
				effectTypeOpen:		'fade',
				effectTypeClose:	'hide',
				effectOpen:			'linear',
				effectClose:		'linear'
			}
		},
		/*****************/
		/** Init Method **/
		/*****************/
		init: function(options) {
			/* vars **/
			var opts = $.extend({}, $.sMenu.defaults, options);
			$('.sMenu li').each(function() {
				var $this = $(this);
				/* Add css submenu */
				if($.sMenu._IsParent($this)) {
					$this.addClass('subMenu');
				}
				/* Add the animation on hover **/
				if(opts.animatedText) {
					$.sMenu._animateText($this);
				}
				/* Actions on hover */
				if(!opts.openClick) {
					$this.bind({
						mouseover:function() {
							$.sMenu._hide($this);
							$.sMenu._showNextChild($this);
						}
					});
				} else {
					$this.bind({
						click:function() {
							$.sMenu._hide($this);
							$.sMenu._showNextChild($this);
						}
					});
				}
			});

			/* Actions on parents links */
			if(!opts.openClick) {
				$('.sMenu li a.submenu').bind({
					mouseover: function() {
						var $this = $(this);
						var $child = $this.children('ul');
						if (($child.length > 0) && ($child.is(':hidden') == false)) {
							return;
						}
						ULWidth = $.sMenu._returnUlWidth($this);
						$.sMenu._closeList($('.sMenu ul'));
						if ($child.is(':hidden')) {
							$.sMenu._showFirstChild($this);
						}
					}
				});
			} else {
				$('.sMenu li a.submenu').bind({
					click: function(e) {
						e.preventDefault();
						var $this = $(this);
						var $child = $this.next();
						ULWidth = $.sMenu._returnUlWidth($this);
						$.sMenu._closeList($('.sMenu ul'));
						if($child.is(':hidden')) {
							$.sMenu._showFirstChild($this);
						}
					}
				});
			}
			/* Close all when mouse  leaves */
			$('.sMenu').bind({
				mouseleave: function() {
					setTimeout(function(){$.sMenu._closeAll();},opts.TimeBeforeClosing);
				}
			});
		},
		/****************************
		*****************************
		**   sMenu Methods Below   **
		*****************************
		****************************/
		/** Show the First Child Lists **/
		_showFirstChild: function(el) {
			if($.sMenu._IsParent(el)) {
				var SecondList = el.next();
				if(SecondList.is(":hidden")) {
					var position = el.position();
					SecondList
						.css({
							top:	position.top + opts.absoluteTop,
							left:	position.left + opts.absoluteLeft,
							width:	ULWidth
						})
						.children().css({
							width: ULWidth
						})
					;
					$.sMenu._show(SecondList);
				}
			} else {
				return false;
			}
		},
		/** Show all others Child lists except the first list **/
		_showNextChild: function(el) {
			if($.sMenu._IsParent(el)) {
				var ChildList = el.next();
				if(ChildList.is(':hidden')) {
					var position = el.position();
					ChildList
						.css({
							top:	position.top,
							left:	position.left + ULWidth,
							width:	ULWidth
						})
						.children().css({
							width:ULWidth
						})
					;
					$.sMenu._show(ChildList);
				}
			} else {
				return false;
			}
		},
		/**************************************/
		/** Short Methods - Generals actions **/
		/**************************************/
		_hide: function(el) {
			if($.sMenu._IsParent(el) && !el.next().is(':hidden')) {
				$.sMenu._closeList(el.next());
			} else if (($.sMenu._IsParent(el) && el.next().is(':hidden')) || !$.sMenu._IsParent(el)) {
				$.sMenu._closeList(el.parent().parent().find('ul'));
			} else {
				return false;
			}
		},
		_show: function(el) {
			switch(opts.effects.effectTypeOpen) {
				case 'slide':
					el.stop(true, true).delay(opts.TimeBeforeOpening).slideDown(opts.effects.effectSpeedOpen, opts.effects.effectOpen);
					break;
				case 'fade':
					el.stop(true, true).delay(opts.TimeBeforeOpening).fadeIn(opts.effects.effectSpeedOpen, opts.effects.effectOpen);
					break;
				default:
					el.stop(true, true).delay(opts.TimeBeforeOpening).show();
			}
		},
		_closeList: function(el) {
			switch(opts.effects.effectTypeClose) {
				case 'slide':
					el.stop(true,true).slideUp(opts.effects.effectSpeedClose, opts.effects.effectClose);
					break;
				case 'fade':
					el.stop(true,true).fadeOut(opts.effects.effectSpeedClose, opts.effects.effectClose);
					break;
				default:
					el.hide();
			}
		},
		_closeAll: function() {
			if (!$('.sMenu').isHovered()) {
				$('.sMenu ul').each(function() {
					$.sMenu._closeList($(this));
				});
			}
		},
		_IsParent: function($el) {
			if ($el.find('ul').length >0) {
				return true;
			} else {
				return false;
			}
		},
		_returnUlWidth: function(el) {
			switch(opts.ulWidth) {
				case 'auto' :
					ULWidth = parseInt(el.outerWidth(true));
					break;
				default:
					ULWidth = parseInt(opts.ulWidth);
			}
			return ULWidth;
		},
		_animateText: function($el) {
			var paddingInit = parseInt($el.css('padding-left'));
			$el.hover(
				function() {
					$(this).stop(true,true)
					.animate({
						paddingLeft: paddingInit + opts.paddingLeft
					}, 100);
				},
				function() {
					$(this).stop(true,true)
					.animate({
						paddingLeft:paddingInit
					}, 100);
				}
			);
		},
		_isReadable: function($el) {
			if ($el.find('a').length > 0) {
				return true;
			} else {
				return false;
			}
		},
		_error: function() {
			alert('Please, check you have the \'.fNiv\' class on your first level links.');
		}
	};

	$.fn.sMenu = function(options){
		$(this).addClass('sMenu');
		$(this).children('li').children('a');
		if($.sMenu._isReadable(this)) {
			$.sMenu.init(options);
		} else {
			$.sMenu._error();
		}
	};
})(jQuery);
