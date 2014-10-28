(function($){
	$.m = (function () {
		var currentChatboxId = 0;
		var onlineScroll;
		var hideWebBar;
		var keyboardOpen = 0;
		var landscapeMode = 0;
		var buddyListName = {};
		var buddyListAvatar = {};
		var buddyListMessages = {};
		var longNameLength = 20;
		var detectTimer;
		return {
			playSound: function() {
			},
			detect: function(keyboard) {
				var baseWidth = $(window).width();
				var baseHeight = $(window).height();
				var baseHeight = window.innerHeight;
				var userListHeight = baseHeight-$("#header").outerHeight(1);
				var chatBoxHeight = baseHeight-$("#header").outerHeight(1)-$("#cwfooter").outerHeight(1)-14;
				$("body").css('width',baseWidth+'px');
				$("#header").css('width',baseWidth+'px');
				$(".roundedcenter").css('width',(baseWidth-70)+'px');
				$("#cwwrapper").css('height',chatBoxHeight+'px');
				$(".roundedtitle").css('width',baseWidth+'px');
				$(".footer").css('width',baseWidth+'px');
				$(".footer input").css('width',(baseWidth-32)+'px');
				$('body').css('display','block');
				clearTimeout(detectTimer);
				detectTimer = setTimeout(function() {
					$.m.detect();
				},1000);
			},
			init: function() {
				$.ajaxSetup({ xhrFields:{ withCredentials: true } });
				$.m.detect();
				window.addEventListener('onorientationchange' in window ? 'orientationchange' : 'resize', function() {
					$.m.detect();
				}, false);
				$('#header .roundedright').click(function() {
					location.href = $.cometchat.getBaseUrl()+'../';
				});
				$.m.hideBar();
			},
			hideBar: function() {
				if (landscapeMode == 1) {
					$('#chatmessage').blur();
				} else {
				}
				clearTimeout(hideWebBar);
				hideWebBar = setTimeout(function(){jqcc.m.hideBar()}, 1000);
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
					buddylisttemp[buddy.s] += '<li class="onlinelist" id="onlinelist_'+buddy.id+'" onclick="javascript:jqcc.m.loadPanel(\''+buddy.id+'\')"><img src="'+buddy.a+'" class="avatarimage">'+longname+'<div class="status">'+buddy.s+'</div><div class="newmessages"></div></li>';
					$('#onlinelist_'+buddy.id).remove();
				});
				buddylist = buddylisttemp['available']+buddylisttemp['busy']+buddylisttemp['away']+buddylisttemp['offline'];
				if (buddylist == '') {
					buddylist += '<li class="onlinelist" id="nousersonline">'+$.cometchat.getLanguage(14)+'</li>';
				}
				$('#wolist').html(buddylist);
			},
			loggedOut: function() {
				alert('Sorry you have logged out');
				//location.href = '../../';
			},
			sendMessage: function(id) {
				var message = $('#chatmessage').val();
				$('#chatmessage').val('');
				$.cometchat.sendMessage(id,message);
				$('#chatmessage').focus();
				fromname = 'Me';
				selfstyle = 'selfmessage';
				var ts = Math.round(new Date().getTime() / 1000)+''+Math.floor(Math.random()*1000000);
				var temp = (('<li><div class="cometchat_chatboxmessage '+selfstyle+'" id="cometchat_message_'+ts+'"><span class="cometchat_chatboxmessagefrom"><strong>'+fromname+'</strong>:  </span><span class="cometchat_chatboxmessagecontent">'+message+'</span>'+'</div></li>'));
				if (currentChatboxId == id) {
					$('#cwlist').append(temp);
					setTimeout(function () {var o = document.getElementById("cwwrapper");o.scrollTop = o.scrollHeight;}, 200);
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
					var temp = (('<li><div class="cometchat_chatboxmessage" id="cometchat_message_'+ts+'"><span class="cometchat_chatboxmessagefrom"><strong>'+fromname+'</strong>:  </span><span class="cometchat_chatboxmessagecontent">'+incoming.message+'</span>'+'</div>'));
					atleastOneNewMessage++;
				}
				if (currentChatboxId == incoming.from) {
					$('#cwlist').append(temp);
					var o = document.getElementById("cwwrapper");o.scrollTop = o.scrollHeight;
				} else {
					if (buddyListMessages[incoming.from]) {
						buddyListMessages[incoming.from] += 1;
					} else {
						buddyListMessages[incoming.from] = 1;
					}
					$('#onlinelist_'+incoming.from+' .newmessages').html(buddyListMessages[incoming.from]);
				}
				if (atleastOneNewMessage) {
					$.m.playSound();
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
				var buddylist = '<li class="onlinelist" id="onlinelist_'+data.id+'" onclick="javascript:jqcc.m.loadPanel(\''+data.id+'\')"><img src="'+data.a+'" class="avatarimage">'+longname+'<div class="status">'+data.s+'</div><div class="newmessages"></div></li>';
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
						var temp = (('<li><div class="cometchat_chatboxmessage" id="cometchat_message_'+ts+'"><span class="cometchat_chatboxmessagefrom"><strong>'+fromname+'</strong>:  </span><span class="cometchat_chatboxmessagecontent">'+incoming.message+'</span>'+'</div>'));
						atleastOneNewMessage++;
						if (currentChatboxId == incoming.from) {
							$('#cwlist').append(temp);
							var o = document.getElementById("cwwrapper");
							o.scrollTop = o.scrollHeight;
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
					$.m.playSound();
				}
			},
			loadPanel: function (id,name) {
				buddyListMessages[id] = 0;
				$('#onlinelist_'+id+' .newmessages').html('');
				$('#chatwindow').html(
					'<div id="cwheader" class="header">'+
						'<div id="menu" class="title">'+
							'<h1>Chat :: '+buddyListName[id]+'</h1>'+
							'<div class="back" onclick="jqcc.m.back();"></div>'+
							'<div class="usr" style="background-image:url('+buddyListAvatar[id]+');"></div>'+
						'</div>'+
					'</div>'+
					'<div id="cwwrapper">'+
						'<div id="cwscroller">'+
							'<ul id="cwlist"></ul>'+
						'</div>'+
					'</div>'+
					'<div id="cwfooter" class="footer">'+
						'<form onsubmit="return jqcc.m.sendMessage(\''+id+'\')">'+
							'<input type="text" name="chatmessage" placeholder="Type your message" id="chatmessage" />'+
					'</div>'
				);
				$('#whosonline').css('display','none');
				$('#chatwindow').css('display','block');
				setTimeout(function(){}, 1000);
				$.m.detect();
				currentChatboxId = id;
				$('#chatwindow .roundedright').click(function() {
					$.m.back();
				});
				$('#chatmessage').blur(function() {
					keyboardOpen = 0;
					$.m.detect();
				});
				$.cometchat.getRecentData(id);
			},
			loadData: function (id,data) {
				$.each(data, function(type,item){
					if (type == 'messages') {
						var temp = '';
						$.each(item, function(i,incoming) {
							var selfstyle = '';
							if (incoming.self == 1) {
								fromname = 'Me';
								selfstyle = 'selfmessage';
							} else {
								fromname = buddyListName[id];
							}
							var ts = new Date(incoming.sent * 1000);
							if (fromname.indexOf(" ") != -1) {
								fromname = fromname.slice(0,fromname.indexOf(" "));
							}
							temp += ('<li><div class="cometchat_chatboxmessage '+selfstyle+'" id="cometchat_message_'+incoming.id+'"><span class="cometchat_chatboxmessagefrom'+selfstyle+'"><strong>'+fromname+'</strong>:  </span><span class="cometchat_chatboxmessagecontent'+selfstyle+'">'+incoming.message+'</span>'+'</div>');
						});
						if (currentChatboxId == id) {
							$('#cwlist').append(temp);
							setTimeout(function () {var o = document.getElementById("cwwrapper");o.scrollTop = o.scrollHeight;}, 200);
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
	jqcc.m.init();
}
