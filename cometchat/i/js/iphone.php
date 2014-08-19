<?php
include dirname(dirname(dirname(__FILE__))).DIRECTORY_SEPARATOR."modules.php";
include dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR."lang/en.php";

if (file_exists(dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR."lang/".$lang.".php")) {
	include dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR."lang/".$lang.".php";
}

foreach ($i_language as $i => $l) {
	$i_language[$i] = str_replace("'", "\'", $l);
}
if(false){?><script><?php }?>
(function($){
	$.iphone = (function () {
		var currentChatboxId = 0;
		var onlineScroll;
		var chatScroll;
		var hideWebBar;
		var keyboardOpen = 0;
		var landscapeMode = 0;
		var buddyListName = {};
		var buddyListAvatar = {};
		var buddyListMessages = {};
		var closedList = 0;
		var openList = 0;
		var longNameLength = 20;
//		if(navigator.userAgent.match(/tagbum/)) top = header;
		var baseWidth,baseHeight;
//		var ipad = navigator.userAgent.match(/ipad/i);
		var mobile = 'onorientationchange' in window;
		return {
			playSound: function() {
				var pElement = document.getElementById("audio");
				setTimeout(function() {
					pElement.load();
					setTimeout(function() {
						pElement.play();
					}, 500);
				}, 500);
			},
			detect: function(keyboard) {
				var	header = $('.cometchat .header').first().outerHeight()||0;
				var	footer = $('.cometchat .footer').first().outerHeight()||0;
//				var landscape=window.orientation==90||window.orientation==-90;
//				var keyboardHeight = 268;
				if (baseWidth < 480) {
//					keyboardHeight = 216;
					closedList = 3;
					openList = 9;
				} else if (baseWidth == 480) {
//					keyboardHeight = 0;
					closedList = 0;
					openList = 4;
				} else if (baseWidth == 768) {
//					keyboardHeight = 308;
					closedList = 17;
					openList = 26;
				} else {
//					keyboardHeight = 396;
					openList = 17;
					closedList = 7;
				}
                        
				$('body').css('width',baseWidth);
//				$('.roundedtitle').css('width',baseWidth-30);
//				$('.roundedcenter').css('width',baseWidth-70);
				$('.footer input').css('width',baseWidth-28);
				$('#wrapper').css('height',baseHeight-header);
				$('#cwwrapper').css('height',baseHeight-header-footer);
				console.log('H='+baseHeight+', h='+header+', f='+footer+', H-h='+(baseHeight-header)+', H-h-f='+(baseHeight-header-footer))
				window.scrollTo(0, 50000);
				setTimeout(function () {
					chatScroll&&chatScroll.refresh();
					onlineScroll&&onlineScroll.refresh();
				}, 0);
			},
			init: function() {
				var detect=function(){
					baseWidth = window.innerWidth-1;
					baseHeight = window.innerHeight-1;
					$.iphone.detect();
				};
				onlineScroll = new iScroll('scroller', {desktopCompatibility:true});
				if(mobile) window.addEventListener('orientationchange',detect, false);
				window.addEventListener('resize', detect, false);
				document.addEventListener('touchmove', function (e) { e.preventDefault(); }, false);
				detect();
				$('#header .roundedright').click(function() {
					location.href = $.cometchat.getBaseUrl()+'../';
				});
				$.iphone.hideBar();
			},
			hideBar: function() {
				if (landscapeMode == 1) {
					$('#chatmessage').blur();
					window.scrollTo(0, 0);
				} else {
					window.scrollTo(0, 50000);
				}
				clearTimeout(hideWebBar);
				hideWebBar = setTimeout(function(){$.iphone.hideBar()}, 1000);
			},
			updateBuddyList: function(data) {
				var buddylist = '';
				var buddylisttemp = {};

				buddylisttemp['available'] = '';
				buddylisttemp['busy'] = '';
				buddylisttemp['offline'] = '';
				buddylisttemp['away'] = '';

				$.each(data, function(i,buddy) {
					if (buddy.n.length > longNameLength) {
						longname = buddy.n.substr(0,longNameLength)+'...';
					} else {
						longname = buddy.n;
					}
					buddyListName[buddy.id] = buddy.n;
					buddyListAvatar[buddy.id] = buddy.a;
					if (!buddyListMessages[buddy.id]) {
						buddyListMessages[buddy.id] = 0;
					}
					buddylisttemp[buddy.s] += '<li class="onlinelist" id="onlinelist_'+buddy.id+'" onclick="javascript:jqcc.iphone.loadPanel(\''+buddy.id+'\')"><img src="'+buddy.a+'" class="avatarimage">'+longname+'<div class="status">'+buddy.s+'</div><div class="newmessages"></div></li>';
					$('#onlinelist_'+buddy.id).remove();
				});
				buddylist = buddylisttemp['available']+buddylisttemp['busy']+buddylisttemp['away']+buddylisttemp['offline'];
				if (buddylist == '') {
					buddylist += '<li class="onlinelist" id="nousersonline">'+$.cometchat.getLanguage(14)+'</li>';
				}
				$('#wolist').html(buddylist);
			},
			loggedOut: function() {
				alert('<?php echo $i_language[5];?>');
				//location.href = $.cometchat.getBaseUrl()+'../';
				location.href = jqcc.cometchat.homePage;
			},
			sendMessage: function(id) {
				var message = $('#chatmessage').val();
				$('#chatmessage').val('');
				$.cometchat.sendMessage(id,message);
				$('#chatmessage').focus();

				fromname = '<?php echo $i_language[6];?>';
				selfstyle = 'selfmessage';

				var ts = Math.round(new Date().getTime() / 1000)+''+Math.floor(Math.random()*1000000);
				var temp = (('<li><div class="cometchat_chatboxmessage '+selfstyle+'" id="cometchat_message_'+ts+'"><span class="cometchat_chatboxmessagefrom"><strong>'+fromname+'</strong><?php echo $i_language[7];?></span><span class="cometchat_chatboxmessagecontent">'+message+'</span>'+'</div></li>'));
				if (currentChatboxId == id) {
					$('#cwlist').append(temp);
					if ($("#cwlist li").size() > closedList) {
						setTimeout(function () {chatScroll.scrollToElement('#cwendoftext')}, 200);
					} else {
						setTimeout(function () {chatScroll.scrollToElement('#cwendoftext','0ms')}, 200);
					}
				}
				return false;
			},
			newMessage: function(incoming) {
				if (!buddyListName[incoming.from]) {
					$.cometchat.getUserDetails(incoming.from);
				}
				fromname = buddyListName[incoming.from];
				if (fromname.indexOf(" ") != -1) {
					fromname = fromname.slice(0,fromname.indexOf(" "));
				}
				var ts = Math.round(new Date().getTime() / 1000)+''+Math.floor(Math.random()*1000000);
				var atleastOneNewMessage = 0;
				if (incoming.self == 0) {
					var temp = (('<li><div class="cometchat_chatboxmessage" id="cometchat_message_'+ts+'"><span class="cometchat_chatboxmessagefrom"><strong>'+fromname+'</strong><?php echo $i_language[7];?></span><span class="cometchat_chatboxmessagecontent">'+incoming.message+'</span>'+'</div>'));
					atleastOneNewMessage++;
				}
				if (currentChatboxId == incoming.from) {
					$('#cwlist').append(temp);
					if ((keyboardOpen == 1 && $("#cwlist li").size() < 4) || (keyboardOpen == 0 && $("#cwlist li").size() < 10)) {
						setTimeout(function () {chatScroll.scrollToElement('#cwendoftext','0ms')}, 200);
					} else {
						setTimeout(function () {chatScroll.scrollToElement('#cwendoftext')}, 200);
					}
				} else {
					if (buddyListMessages[incoming.from]) {
						buddyListMessages[incoming.from] += 1;
					} else {
						buddyListMessages[incoming.from] = 1;
					}
					$('#onlinelist_'+incoming.from+' .newmessages').html(buddyListMessages[incoming.from]);
				}
				if (atleastOneNewMessage) {
					$.iphone.playSound();
				}
			},
			loadUserData: function(id,data) {
				buddyListName[id] = data.n;
				buddyListAvatar[id] = data.a;
				if (!buddyListMessages[id]) {
					buddyListMessages[id] = 0;
				}
				if (data.n.length > longNameLength) {
					longname = data.n.substr(0,longNameLength)+'...';
				} else {
					longname = data.n;
				}

				var buddylist = '<li class="onlinelist" id="onlinelist_'+data.id+'" onclick="javascript:jqcc.iphone.loadPanel(\''+data.id+'\')"><img src="'+data.a+'" class="avatarimage">'+longname+'<div class="status">'+data.s+'</div><div class="newmessages"></div></li>';
				$('#nousersonline').css('display','none');
				$('#permanent').prepend(buddylist);
			},
			newMessages: function(data) {
				var temp = '';
				var atleastOneNewMessage = 0;
				$.each(data, function(i,incoming) {
					if (!buddyListName[incoming.from]) {
						$.cometchat.getUserDetails(incoming.from);
					}
					fromname = buddyListName[incoming.from];
					if (fromname.indexOf(" ") != -1) {
						fromname = fromname.slice(0,fromname.indexOf(" "));
					}
					var ts = Math.round(new Date().getTime() / 1000)+''+Math.floor(Math.random()*1000000);
					if (incoming.self == 0) {
						var temp = (('<li><div class="cometchat_chatboxmessage" id="cometchat_message_'+ts+'"><span class="cometchat_chatboxmessagefrom"><strong>'+fromname+'</strong><?php echo $i_language[7];?></span><span class="cometchat_chatboxmessagecontent">'+incoming.message+'</span>'+'</div>'));
						atleastOneNewMessage++;
						if (currentChatboxId == incoming.from) {
							$('#cwlist').append(temp);
							if ((keyboardOpen == 1 && $("#cwlist li").size() < 4) || (keyboardOpen == 0 && $("#cwlist li").size() < openList)) {
								setTimeout(function () {chatScroll.scrollToElement('#cwendoftext','0ms')}, 200);
							} else {
								setTimeout(function () {chatScroll.scrollToElement('#cwendoftext')}, 200);
							}
						} else {
							if (buddyListMessages[incoming.from]) {
								buddyListMessages[incoming.from] += 1;
							} else {
								buddyListMessages[incoming.from] = 1;
							}
							$('#onlinelist_'+incoming.from+' .newmessages').html(buddyListMessages[incoming.from]);
						}
					}
				});
				if (atleastOneNewMessage) {
					$.iphone.playSound();
				}
			},
			loadPanel: function (id) {
				buddyListMessages[id] = 0;
				$('#onlinelist_'+id+' .newmessages').html('');
				$('#chatwindow').html(
					'<div id="cwheader" class="header">'+
						'<div id="menu" class="title">'+
							'<h1>Chat :: '+buddyListName[id]+'</h1>'+
							'<div class="back" onclick="jqcc.iphone.back();"></div>'+
							'<div class="usr" style="background-image:url('+buddyListAvatar[id]+');"></div>'+
						'</div>'+
					'</div>'+
					'<div id="cwwrapper">'+
						'<div id="cwscroller">'+
							'<ul id="cwlist"></ul>'+
							'<div id="cwendoftext"></div>'+
						'</div>'+
					'</div>'+
					'<div id="cwfooter" class="footer">'+
						'<form onsubmit="return jqcc.iphone.sendMessage(\''+id+'\')">'+
							'<input type="text" name="chatmessage" placeholder="<?php echo $i_language[9];?>" id="chatmessage" />'+
					'</div>'
				);
				$('#whosonline').css('display','none');
				$('#chatwindow').css('display','block');
				setTimeout(function(){}, 1000);
				$.iphone.detect();
				currentChatboxId = id;
				$('#cwfooter').click(function() {
					$.iphone.detect(1);
					setTimeout(function () { chatScroll.refresh() }, 0);
					setTimeout(function () { $('#chatmessage').focus(); }, 100);
					setTimeout(function () {  }, 100);
					setTimeout(function () {chatScroll.scrollToElement('#cwendoftext','0ms')}, 200);
					keyboardOpen = 1;
					setTimeout(function () { window.scrollTo(0, 50000); }, 100);
					setTimeout(function () { $('#chatmessage').focus(); }, 200);
				});
				$('#chatwindow .roundedright').click(function() {
					$.iphone.back();
				});
				$('#chatmessage').focus(function() {
					keyboardOpen = 1;
					$.iphone.detect();
					setTimeout(function () { chatScroll.refresh() }, 0)
				}).blur(function() {
					keyboardOpen = 0;
					$.iphone.detect();
					setTimeout(function () { chatScroll.refresh() }, 0)
				});
				$.cometchat.getRecentData(id);
				chatScroll = new iScroll('cwscroller');
				setTimeout(function () {chatScroll.scrollToElement('#cwendoftext','0ms')}, 200);
			},
			loadData: function (id,data) {
				$.each(data, function(type,item){
					if (type == 'messages') {
						var temp = '';
						$.each(item, function(i,incoming) {
							var selfstyle = '';
							if (incoming.self == 1) {
								fromname = '<?php echo $i_language[6];?>';
								selfstyle = 'selfmessage';
							} else {
								fromname = buddyListName[id];
							}
							var ts = new Date(incoming.sent * 1000);
							if (fromname.indexOf(" ") != -1) {
								fromname = fromname.slice(0,fromname.indexOf(" "));
							}
							temp += ('<li><div class="cometchat_chatboxmessage '+selfstyle+'" id="cometchat_message_'+incoming.id+'"><span class="cometchat_chatboxmessagefrom'+selfstyle+'"><strong>'+fromname+'</strong><?php echo $i_language[7];?></span><span class="cometchat_chatboxmessagecontent'+selfstyle+'">'+incoming.message+'</span>'+'</div>');
						});
						if (currentChatboxId == id) {
							$('#cwlist').append(temp);
							setTimeout(function () {chatScroll.scrollToElement('#cwendoftext','0ms')}, 200);
						}
					}
				});
			},
			back: function() {
				$('#chatwindow').css('display','none');
				$('#chatwindow').html('');
				$('#whosonline').css('display','block');
				$('#onlinelist_'+currentChatboxId+' .newmessages').html('');
				currentChatboxId = 0;
			}
		};
	})();
})(jqcc);

var listener = function (e) {
	e.preventDefault();
};

window.onload = function() {
	jqcc.iphone.init();
}
<?php if(false){?></script><?php }?>
