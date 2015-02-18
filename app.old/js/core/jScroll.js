/**
* jScroll - A jQuery iScroll plugin.
*
* So what makes jScroll different?  If you have iOS5, it will use native scrolling.
* That, and you don't need to have an id on your element.
*
* It works like this:
*
*	$("div").jScroll();  //Done like this, it uses the default options.
*	$("div").jScroll({	 //Done like this, only those options are overridden.
*		lockDirection : false,
*		fadeScrollbar : true,
*		forceIscroll : false
*	});
*	$("div").jScroll("remove");  //Removes iScroll from all elements in this set.
*	$("div").jScroll({
*		zoom : true, //Adds pinch to zoom functionality on this div.
*		run : function(scroll){} //on creation, you can call a function with scroll handler
*	});
*	$("div").jScroll("refresh");  //Refresh iScroll in all elements
*	$("div").jScroll("force",options); //Force iScrool
*	$("div").jScroll("rebuild",options); //Destroy the actual scroll (if exists) and create a new one
*	//You can run a function using the iScrool
*	$("div").jScroll("run",function(iScroll){
*		--do something with the iScroll--
*	}
*	$("div").jScroll(function(iScroll){
*		--do something with the iScroll--
*	}
*
* Note:  If you're using iOS5, the only valid options are vScroll & hScroll, unless you use zoom or force it.
*
* It's not 100% fool-proof though.  It still relies on you knowing how to use iScroll.  If
* you have questions about that, or about possible options, check out: http://cubiq.org/iscroll-4
*
* @author Jack Slingerland (jacks@teamddm.com)
* @link http://www.teamddm.com
* @version 1.4.1
*/
(function($,navigator,console) {

	/* jScroll array to save the scroll references */
	var jScroll=[];

	$.fn.jScroll = function() {
		var customOptions = {},
			action = "scroll",
			func;

		//Determine what action we should be taking.
		if(typeof arguments[0] === "function") {
			action = "run";
			func = arguments[0];
		} else if(typeof arguments[0] === "string") {
			action = arguments[0];
			if(action=="run" && typeof arguments[1] === "function")
				func=arguments[1];
			else
				customOptions = arguments[1];
		} else {
			customOptions = arguments[0];
		}

		var options = $.extend({},$.fn.jScroll.defaultOptions, customOptions);
		return this.each(function() {
			var scroll=$(this).attr("jscroll");
			console.log('jscroll. id='+$(this).attr("id")+', Scroll='+scroll+', action='+action);
			console.log(customOptions);
			if(scroll){//If iScroll already exist, check the action
				console.log('have scroll');
				scroll=jScroll[scroll];
				if(action === "rebuild") {
					remove_scroller.call(this);
					add_scroller.call(this, options);
				}
				if(action === "refresh"){
					setTimeout(function(){ scroll.refresh(); },500);
				}
				if(action === "remove" || options.remove === true) {
					remove_scroller.call(this);
				}
				if(func){
					console.log("run");
					func.call(scroll,scroll);
				}
			} else if( has_native_iscroll() && !options.onRefresh && !options.zoom && !options.forceIscroll && action !== "force" ) {
				console.log('create native scroll');
				//We can use native scrolling if we're on iOS 5, unless we force it or need zoom
				if(action === "remove" || options.remove === true) {
					remove_native_scroller.call(this);
				} else {
					var type = "";
					if(options.hScroll && !options.vScroll) type = "-x";
					if(!options.hScroll && options.vScroll) type = "-y";
					add_native_scroller.call(this, type);
				}
			} else if( action === "scroll" || action === "force" || action == "rebuild" ) {
				console.log('create jScroll');
				//if not scroll, create one.
				add_scroller.call(this, options);
			}
		});
	};

	/* Default options - The same as creating an iScroll object with no parameters */
	$.fn.jScroll.defaultOptions = {
		hScroll : true,
		vScroll : true,
		hScrollbar : true,
		vScrollbar : true,
		fixedScrollbar : false,
		fadeScrollbar : true,
		hideScrollbar : true,
		bounce : true,
		momentum : true,
		lockDirection : false,
		forceIscroll : false,
		zoom : false, //Pinch to zoom.
		useTransition : false,  //Performance mode!
		onBeforeScrollStart: function (e) {
			var target = e.target;
			while (target.nodeType !== 1) {
				target = target.parentNode;
			}
			if (target.tagName !== "SELECT" && target.tagName !== "INPUT" && target.tagName !== "TEXTAREA") {
				e.preventDefault();
			}
		},
		remove : false
	};

	/* Private functions */

	function has_native_iscroll() {
		return navigator.userAgent.match(/OS [56]_[0-9_]+ like Mac OS X/i) != null;
	}
	//native scroller
	function add_native_scroller(type) {
		$(this).css("overflow"+type,"scroll").css("-webkit-overflow-scrolling", "touch");
	}
	function remove_native_scroller() {
		$(this).css({
			"overflow":"",
			"overflow-x":"",
			"overflow-y":"",
			"-webkit-overflow-scrolling":""
		});
	}
	//scroller (iScroll)
	function add_scroller(options) {
		if($(this).attr("jscroll")) return;
		var func;
		if(typeof options.run == "function"){
			func=options.run;
			options.run=null;
			delete options.run;
		}
		var scroll = new iScroll(this, options);
		if(scroll){
			$(this).attr("jscroll",jScroll.length);
			jScroll.push(scroll);
			if(func) func.call(scroll,scroll);
			setTimeout(function(){scroll.refresh();},500);
		}
	}
	function remove_scroller() {
		var scroll = $(this).attr("jscroll");
		if(scroll){
			scroll=jScroll[scroll];
			scroll.destroy();
			$(this).removeAttr("jscroll");
		}
	}
	
	/* refreshing all the scrolls */
	$.jScroll=function(){
		if(arguments[0] === "refresh"){
			setTimeout(function(){
				if($.mobile){
					$('.ui-page-active [jscroll]').each(function(i){
						if(jScroll[i]) jScroll[i].refresh();
					});
				}else{
					for(var i in jScroll){
						if(jScroll[i]) jScroll[i].refresh();
					}
				}
			},500);
		}
	};
	$(window).bind('resize orientationchange',function(){$.jScroll("refresh");});

})(jQuery,navigator,{log:function(){return;}});//console use: enable=console, disable={log:function(){return;}}
