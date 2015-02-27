(function($){
	//compatibility with older jquery codes.
	if(!$.browser){
		$.browser={};
		var agent=navigator.userAgent;
		$.browser.chrome=!!agent.match(/chrome/i);
		$.browser.safari=!$.browser.chrome&&!!agent.match(/safari/i);
		$.browser.firefox=!!agent.match(/firefox/i);
		$.browser.webkit=!!agent.match(/webkit/i);
		$.browser.msie=!!agent.match(/msie/i);
		if($.browser.msie) $.browser.version=agent.match(/msie (.+)/i)[1];
	}
	if(!$.fn.live){
		$.fn.live=function(events,handler){
			var c=($.c&&$.c('live'))||console;
			c.log('calling live:',events,handler);
			if(events!='') $(document).on(events,this.selector,handler);
			return this;
		};
		$.fn.die=function(events,handler){
			if(events!='') $(document).off(events,this.selector,handler);
			return this;
		};
	}
})(jQuery);
