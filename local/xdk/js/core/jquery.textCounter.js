/*
	Name:		textCounter - style input field character countdown jQuery plugin
	Legal:		Copyright - Andy Matthews
	Version:	1.0
	Released:	11/17/2010
*/
(function($){

	$.fn.extend({

		//pass the options variable to the function
		textCounter: function(options) {

			//Set the default values, use comma to separate the settings, example:
			var defaults = {
				count: 140,
				alertAt: 20,
				warnAt: 0,
				target: '',
				stopAtLimit: false
			}

			var options =  $.extend(defaults, options);

			return this.each(function() { 
				var o = options;
				var $e = $(this);

				$e.html(o.count);
				$(o.target).keyup(function(){ 
					var cnt = this.value.length;
					if (cnt <= (o.count-o.alertAt)) {
						// clear skies
						$e.removeClass('tcAlert tcWarn');
					} else if ( (cnt > (o.count-o.alertAt)) && (cnt <= (o.count-o.warnAt)) ) {
						// getting close
						$e.removeClass('tcAlert tcWarn').addClass('tcAlert');
					} else {
						// over limit
						$e.removeClass('tcAlert tcWarn').addClass('tcWarn');
						if (o.stopAtLimit) this.value = this.value.substring(0, o.count);
					}
					$e.html(o.count-this.value.length);
					//$e.load();
				}).trigger('keyup');
			});
		}
	});
})(jQuery);