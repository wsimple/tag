/***
@title:
Colour Picker

@version:
2.0

@author:
Andreas Lagerkvist

@date:
2008-09-16

@url:
http://andreaslagerkvist.com/jquery/colour-picker/

@license:
http://creativecommons.org/licenses/by/3.0/

@copyright:
2008 Andreas Lagerkvist (andreaslagerkvist.com)

@requires:
jquery, jquery.colourPicker.css, jquery.colourPicker.gif

@does:
Use this plug-in on a normal <select>-element filled with colours to turn it in to a colour-picker widget that allows users to view all the colours in the drop-down as well as enter their own, preferred, custom colour. Only about 1k compressed.

@howto:
jQuery('select[name="colour"]').colourPicker({ico: 'my-icon.gif', title: 'Select a colour from the list'}); Would replace the select with 'my-icon.gif' which, when clicked, would open a dialogue with the title 'Select a colour from the list'.

*/

jQuery.fn.colourPicker = function (conf) {
	// Config for plug
	var config = jQuery.extend({
		id:			'jquery-colour-picker',	// id of colour-picker container
		title:		'Pick a colour',		// Default dialogue title
		inputBG:	true,					// Whether to change the input's background to the selected colour's
		speed:		500,					// Speed of dialogue-animation
		openTxt:	'Open colour picker'
	}, conf);

	// Inverts a hex-colour
	var hexInvert = function (hex) {
		hex=hex.substr(1);
		var l = hex.length>3?2:1;
		var r = hex.substr(0*l,1);
		var g = hex.substr(l*l,1);
		var b = hex.substr(2*l,1);

		return 0.212671 * r + 0.715160 * g + 0.072169 * b < 0.5 ? 'fff' : '000'
	};

	// Add the colour-picker dialogue if not added
	var colourPicker = jQuery('#' + config.id);

	if (!colourPicker.length) {
		colourPicker = jQuery('<div id="' + config.id + '" class="color-picker"></div>').appendTo(document.body).hide();

		// Remove the colour-picker if you click outside it (on body)
		jQuery(document.body).click(function(event) {
			if (!(jQuery(event.target).is('#' + config.id) || jQuery(event.target).parents('#' + config.id).length)) {
				colourPicker.hide(config.speed);
			}
			if (typeof config.close === "function"){
				config.close.call(this);
			}
		});
	}

	// For every select passed to the plug-in
	return this.each(function () {
		// Insert icon and input
		var select	= jQuery(this);
		var input	= jQuery('<input type="hidden" name="' + select.attr('name') + '" value="' + select.val() + '" size="6" />').insertAfter(select);
		var loc		= '';
		var icon	= jQuery(
			'<a href="#">'+
				(config.ico?('<img src="' + config.ico + '" alt="' + config.openTxt + '" />'):('<div class="color-picker-selected"></div>'))+
			'</a>'
		).insertAfter(select);

		// Build a list of colours based on the colours in the select
		jQuery('option', select).each(function () {
			var option	= jQuery(this);
			var hex		= option.val();
			var title	= option.text();

			loc += '<li><a href="#" title="' 
					+ title 
					+ '" rel="' 
					+ hex 
					+ '" style="background: #' 
					+ hex 
					+ '; colour: ' 
					+ hexInvert(hex) 
					+ ';">' 
					+ title 
					+ '</a></li>';
		});

		// Remove select
		select.remove();

		// If user wants to, change the input's BG to reflect the newly selected colour
		if (config.inputBG) {
			input.change(function () {
				input.css({background: input.val(), color: hexInvert(input.val())});
				var _icon = icon.attr('title',input.val()).find('.color-picker-selected');
				if(_icon)
					_icon.css({background: input.val(), color: hexInvert(input.val())});
				if (typeof config.colorChange === "function"){
					config.colorChange.call(this,input.val());
				}
			});

			if(config.color) input.val(config.color);
			input.change();
		}

		// When you click the icon
		icon.click(function () {
			// Show the colour-picker next to the icon and fill it with the colours in the select that used to be there
			var iconPos	= icon.offset();
			var heading	= config.title ? '<h2>' + config.title + '</h2>' : '';

			colourPicker.html(heading + '<ul>' + loc + '</ul>').css({
				position: 'absolute', 
				left: iconPos.left + 'px', 
				top: iconPos.top + 'px'
			});
            
			if(config.css) colourPicker.css(config.css);
			if (typeof config.open === "function"){
				config.open.call(this);
			}
			
            colourPicker.show(config.speed);

			// When you click a colour in the colour-picker
			jQuery('a', colourPicker).click(function () {
				// The hex is stored in the link's rel-attribute
				var hex = jQuery(this).attr('rel');

				input.val( '#' + hex );

				// If user wants to, change the input's BG to reflect the newly selected colour
				if (config.inputBG) {
					input.css({background: '#' + hex, color: '#' + hexInvert(hex)});
				}

				// Trigger change-event on input
				input.change();

				// Hide the colour-picker and return false
				colourPicker.hide(config.speed);

				if (typeof config.close === "function"){
					config.close.call(this);
				}
				return false;
			});

			return false;
		});
	});
};


// var supportTouch = $.support.touch,
//         scrollEvent = "touchmove scroll",
//         touchStartEvent = supportTouch ? "touchstart" : "mousedown",
//         touchStopEvent = supportTouch ? "touchend" : "mouseup",
//         touchMoveEvent = supportTouch ? "touchmove" : "mousemove";
// $.event.special.swipeupdown = {
//     setup: function() {
//         var thisObject = this;
//         var $this = $(thisObject);
//         $this.bind(touchStartEvent, function(event) {
//             var data = event.originalEvent.touches ?
//                     event.originalEvent.touches[ 0 ] :
//                     event,
//                     start = {
//                         time: (new Date).getTime(),
//                         coords: [ data.pageX, data.pageY ],
//                         origin: $(event.target)
//                     },
//                     stop;

//             function moveHandler(event) {
//                 if (!start) {
//                     return;
//                 }
//                 var data = event.originalEvent.touches ?
//                         event.originalEvent.touches[ 0 ] :
//                         event;
//                 stop = {
//                     time: (new Date).getTime(),
//                     coords: [ data.pageX, data.pageY ]
//                 };

//                 // prevent scrolling
//                 if (Math.abs(start.coords[1] - stop.coords[1]) > 10) {
//                     event.preventDefault();
//                 }
//             }
//             $this
//                     .bind(touchMoveEvent, moveHandler)
//                     .one(touchStopEvent, function(event) {
//                 $this.unbind(touchMoveEvent, moveHandler);
//                 if (start && stop) {
//                     if (stop.time - start.time < 1000 &&
//                             Math.abs(start.coords[1] - stop.coords[1]) > 30 &&
//                             Math.abs(start.coords[0] - stop.coords[0]) < 75) {
//                         start.origin
//                                 .trigger("swipeupdown")
//                                 .trigger(start.coords[1] > stop.coords[1] ? "swipeup" : "swipedown");
//                     }
//                 }
//                 start = stop = undefined;
//             });
//         });
//     }
// };
// $.each({
//     swipedown: "swipeupdown",
//     swipeup: "swipeupdown"
// }, function(event, sourceEvent){
//     $.event.special[event] = {
//         setup: function(){
//             $(this).bind(sourceEvent, $.noop);
//         }
//     };
// });