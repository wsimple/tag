var windowFocus = true;
var username;
var chatHeartbeatCount = 0;
var minChatHeartbeat = 2000;
var maxChatHeartbeat = 33000;
var chatHeartbeatTime = minChatHeartbeat;
var originalTitle;
var blinkOrder = 0;
var play=true;
var typing=new Array();
var chatboxFocus = new Array();
var newMessages = new Array();
var newMessagesWin = new Array();
var chatBoxes = new Array();

$(document).ready(function(){
	originalTitle = document.title;
	
	
	$('#hideChat').click(function(){ 
		$('.chatListContainer').slideUp(function(){ $('#chatMainContainer').css("height","20px"); });
		$('#showChat').show(); 
		$('#hideChat').hide();
	});
	
	$('#showChat').click(function(){ 
		$('#chatMainContainer').css("height","100%");
		$('.chatListContainer').slideDown();
		$('#showChat').hide(); 
		$('#hideChat').show();
	});
	
	$('#online').click(function(){ 
		changeStatus(1);
		
		
	});
	
	$('#offline').click(function(){ 
		changeStatus();
		
	});
	

	$([window, document]).blur(function(){
		windowFocus = false;
	}).focus(function(){
		windowFocus = true;
		document.title = originalTitle;
	});
});

function restructureChatBoxes() {
	align = 0;
	for (x in chatBoxes) {
		chatboxtitle = chatBoxes[x];

		if ($("#chatbox_"+chatboxtitle).css('display') != 'none') {
			if (align == 0) {
				$("#chatbox_"+chatboxtitle).css('right', '20px');
			} else {
				width = (align)*(225+7)+20;
				$("#chatbox_"+chatboxtitle).css('right', width+'px');
			}
			align++;
		}
	}
}

function chatWith(chatuser,display) {
	createChatBox(chatuser,0,display);
	
	//$("#chatbox_"+chatuser+" .chatboxtextarea").focus();
}

function createChatBox(chatboxtitle,minimizeChatBox,display) {
	
	if ($("#chatbox_"+chatboxtitle).length > 0) {
		if ($("#chatbox_"+chatboxtitle).css('display') == 'none') {
			$("#chatbox_"+chatboxtitle).css('display','block');
			restructureChatBoxes();
		}
		$("#chatbox_"+chatboxtitle+" .chatboxtextarea").focus();
		
		return;
		
	}
	
	typing[chatboxtitle]=false;
	$(" <div />" ).attr("id","chatbox_"+chatboxtitle)
	.addClass("chatbox")
	.html('<div class="chatboxhead"><div class="chatboxtitle">'+display+'</div><div class="minimize" onclick="javascript:toggleChatBoxGrowth(\''+chatboxtitle+'\')"></div><div class="chatboxoptions"> <a href="javascript:void(0)" onclick="javascript:closeChatBox(\''+chatboxtitle+'\')">X</a></div><br clear="all"/></div><div class="chatboxcontent"></div><div class="typing">'+display+' is typing...</div><div class="chatboxinput"><textarea class="chatboxtextarea" onkeyup="javascript:return checkChatBoxInputKey(event,this,\''+chatboxtitle+'\');"></textarea></div>')
	.appendTo($( "body" ));
			   
	$("#chatbox_"+chatboxtitle).css('bottom', '0px');
	
	chatBoxeslength = 0;

	for (x in chatBoxes) {
		if ($("#chatbox_"+chatBoxes[x]).css('display') != 'none') {
			chatBoxeslength++;
		}
	}

	if (chatBoxeslength == 0) {
		$("#chatbox_"+chatboxtitle).css('right', '20px');
	} else {
		width = (chatBoxeslength)*(225+7)+20;
		$("#chatbox_"+chatboxtitle).css('right', width+'px');
	}
	
	chatBoxes.push(chatboxtitle);

	if (minimizeChatBox == 1) {
		minimizedChatBoxes = new Array();

		if ($.cookie('chatbox_minimized')) {
			minimizedChatBoxes = $.cookie('chatbox_minimized').split(/\|/);
		}
		minimize = 0;
		for (j=0;j<minimizedChatBoxes.length;j++) {
			if (minimizedChatBoxes[j] == chatboxtitle) {
				minimize = 1;
			}
		}

		if (minimize == 1) {
			$('#chatbox_'+chatboxtitle+' .chatboxcontent').css('display','none');
			$('#chatbox_'+chatboxtitle+' .chatboxinput').css('display','none');
		}
	}

	chatboxFocus[chatboxtitle] = false;

	$("#chatbox_"+chatboxtitle+" .chatboxtextarea").blur(function(){
		chatboxFocus[chatboxtitle] = false;
		$("#chatbox_"+chatboxtitle+" .chatboxtextarea").removeClass('chatboxtextareaselected');
	}).focus(function(){
		chatboxFocus[chatboxtitle] = true;
		newMessages[chatboxtitle] = false;
		$('#chatbox_'+chatboxtitle+' .chatboxhead').removeClass('chatboxblink');
		$("#chatbox_"+chatboxtitle+" .chatboxtextarea").addClass('chatboxtextareaselected');
	});

	$("#chatbox_"+chatboxtitle).click(function() {
		if ($('#chatbox_'+chatboxtitle+' .chatboxcontent').css('display') != 'none') {
			$("#chatbox_"+chatboxtitle+" .chatboxtextarea").focus();
		}
	});

	$("#chatbox_"+chatboxtitle).show();
}


function chatHeartbeat(p){

	var itemsfound = 0;
	
	if (windowFocus == false) {
 
		var blinkNumber = 0;
		var titleChanged = 0;
		for (x in newMessagesWin) {
			if (newMessagesWin[x] == true) {
				++blinkNumber;
				if (blinkNumber >= blinkOrder) {
					document.title = '(*)'+originalTitle;
					titleChanged = 1;
					break;	
				}
			}
		}
		
		if (titleChanged == 0) {
			document.title = originalTitle;
			blinkOrder = 0;
		} else {
			++blinkOrder;
		}

	} else {
		for (x in newMessagesWin) {
			newMessagesWin[x] = false;
		}
	}

	for (x in newMessages) {
		if (newMessages[x] == true) {
			if (chatboxFocus[x] == false) {
				//FIXME: add toggle all or none policy, otherwise it looks funny
				$('#chatbox_'+x+' .chatboxhead').toggleClass('chatboxblink');
			}
		}
	}
	data=null;
	$.ajax({
	  url: "chat/chat.php?action=chatheartbeat",
	  cache: false,
	  dataType: "json",
	  success: function(data) {
		if(data!=null){
			
		$.each(data.items, function(i,item){
			if (item)	{ // fix strange ie bug
				chatboxtitle = item.f;

				if ($("#chatbox_"+item.f).length <= 0) {	
					createChatBox(item.f,0,item.u);
				}
				if ($("#chatbox_"+item.f).css('display') == 'none') {
					
					$("#chatbox_"+item.f).css('display','block');
					
					restructureChatBoxes();
					
				}
				
				if (item.s == 1) {
					item.f = username;
					
				}

				if (item.s == 2) {
					$("#chatbox_"+item.f+" .chatboxcontent").append('<div class="chatboxmessage"><span class="chatboxinfo">'+item.m+'</span></div>');
				} else {
					
					newMessages[item.f] = true;
					newMessagesWin[item.f] = true;
					$("#chatbox_"+item.f+" .chatboxcontent").append('<div class="chatboxmessage"><span class="chatboxmessagefrom">'+item.u+':&nbsp;&nbsp;</span><span class="chatboxmessagecontent">'+item.m+'</span></div>');
				}

				$("#chatbox_"+item.f+" .chatboxcontent").scrollTop($("#chatbox_"+item.f+" .chatboxcontent")[0].scrollHeight);
				itemsfound += 1;
			}
		});
		$.each(data.ty, function(i,item){
			if (item)	{ // fix strange ie bug
			
				
				if (item.s == '1') {
					$("#chatbox_"+item.u+" .typing").css('display','block');
					
				}else{
					$("#chatbox_"+item.u+" .typing").css('display','none');
				}
				
			}
		});
	  }

		chatHeartbeatCount++;

		if (itemsfound > 0) {
			chatHeartbeatTime = minChatHeartbeat;
			chatHeartbeatCount = 1;
		} else if (chatHeartbeatCount >= 10) {
			chatHeartbeatTime *= 2;
			chatHeartbeatCount = 1;
			if (chatHeartbeatTime > maxChatHeartbeat) {
				chatHeartbeatTime = maxChatHeartbeat;
			}
		}
		if(play){
			listFriendsChat(p);
			setTimeout('chatHeartbeat();',chatHeartbeatTime);
		}
	}});
}

function closeChatBox(chatboxtitle) {
	$('#chatbox_'+chatboxtitle).css('display','none');
	//$('#chatbox_'+chatboxtitle).remove();
	$('#chatbox_'+chatboxtitle+' .chatboxtextarea').val('');
	
	restructureChatBoxes();
	
	typing[chatboxtitle]=false;
	$.post("chat/chat.php?action=noty", {to: chatboxtitle} );
	$.post("chat/chat.php?action=closechat", { chatbox: chatboxtitle} , function(data){	});

}

function toggleChatBoxGrowth(chatboxtitle) {
	if ($('#chatbox_'+chatboxtitle+' .chatboxcontent').css('display') == 'none') {  
		
		var minimizedChatBoxes = new Array();
		
		if ($.cookie('chatbox_minimized')) {
			minimizedChatBoxes = $.cookie('chatbox_minimized').split(/\|/);
		}

		var newCookie = '';

		for (i=0;i<minimizedChatBoxes.length;i++) {
			if (minimizedChatBoxes[i] != chatboxtitle) {
				newCookie += chatboxtitle+'|';
			}
		}

		newCookie = newCookie.slice(0, -1)


		$.cookie('chatbox_minimized', newCookie);
		$('#chatbox_'+chatboxtitle+' .chatboxcontent').css('display','block');
		$('#chatbox_'+chatboxtitle+' .chatboxinput').css('display','block');
		$("#chatbox_"+chatboxtitle+" .chatboxcontent").scrollTop($("#chatbox_"+chatboxtitle+" .chatboxcontent")[0].scrollHeight);
	} else {
		
		var newCookie = chatboxtitle;

		if ($.cookie('chatbox_minimized')) {
			newCookie += '|'+$.cookie('chatbox_minimized');
		}


		$.cookie('chatbox_minimized',newCookie);
		$('#chatbox_'+chatboxtitle+' .chatboxcontent').css('display','none');
		$('#chatbox_'+chatboxtitle+' .chatboxinput').css('display','none');
	}
	
}

function checkChatBoxInputKey(event,chatboxtextarea,chatboxtitle) { 
	
	
	if($(chatboxtextarea).val()!=''&&!typing[chatboxtitle]){
		
		typing[chatboxtitle]=true;
		$.post("chat/chat.php?action=ty", {to: chatboxtitle} );
	}
	
	if($(chatboxtextarea).val()==''&&typing[chatboxtitle]){
		
		typing[chatboxtitle]=false;
		$.post("chat/chat.php?action=noty", {to: chatboxtitle} );
		
	}
	 
	if(event.keyCode == 13 && event.shiftKey == 0)  {
		message = $(chatboxtextarea).val();
		message = message.replace(/^\s+|\s+$/g,"");

		$(chatboxtextarea).val('');
		
		if(isMobile()){
				$(chatboxtextarea).blur();
		}else{
			    $(chatboxtextarea).focus();
		}
		
		$(chatboxtextarea).css('height','44px');
		if (message != '') { 
			typing[chatboxtitle]=false;
			$.post("chat/chat.php?action=noty", {to: chatboxtitle} );
			
			message = message.replace(/</g,"&lt;").replace(/>/g,"&gt;").replace(/\"/g,"&quot;").replace(/\'/g,"&apos;");
			message=linkify(message);
			message=emoticons(message);
			$("#chatbox_"+chatboxtitle+" .chatboxcontent").append('<div class="chatboxmessage"><span class="chatboxmessagefrom">'+userDisplay+':&nbsp;&nbsp;</span><span class="chatboxmessagecontent">'+message+'</span></div>');
			$("#chatbox_"+chatboxtitle+" .chatboxcontent").scrollTop($("#chatbox_"+chatboxtitle+" .chatboxcontent")[0].scrollHeight);
			
			$.post("chat/chat.php?action=sendchat", {to: chatboxtitle, message: message} , function(data){
				//falta verificar error...
			});
		}
		chatHeartbeatTime = minChatHeartbeat;
		chatHeartbeatCount = 1;

		return false;
	}

	var adjustedHeight = chatboxtextarea.clientHeight;
	var maxHeight = 94;

	if (maxHeight > adjustedHeight) {
		adjustedHeight = Math.max(chatboxtextarea.scrollHeight, adjustedHeight);
		if (maxHeight)
			adjustedHeight = Math.min(maxHeight, adjustedHeight);
		if (adjustedHeight > chatboxtextarea.clientHeight)
			$(chatboxtextarea).css('height',adjustedHeight+8 +'px');
	} else {
		$(chatboxtextarea).css('overflow','auto');
	}
	 
}


function linkify(text) {
    var inputText = text;//el.html();

    //URLs starting with http://, https://, or ftp://
    var replacePattern1 = /(\b(https?|ftp):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/gim;
    var replacedText = inputText.replace(replacePattern1, "<a href=$1 target=_blank>$1</a>");

    //URLs starting with www. (without // before it, or it'd re-link the ones done above)
    var replacePattern2 = /(^|[^\/])(www\.[\S]+(\b|$))/gim;
    replacedText = replacedText.replace(replacePattern2, "$1<a href=http://$2 target=_blank>$2</a>");

    //Change email addresses to mailto:: links
    var replacePattern3 = /(\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,6})/gim;
    replacedText = replacedText.replace(replacePattern3, "<a href=mailto:$1>$1</a>");
	
	var replacePattern4 = /(^|[^\/])(.*\.(net$|com$|org$))/gim;
    replacedText = replacedText.replace(replacePattern4, "$1<a href=http://$2 target=_blank>$2</a>");

    return replacedText;//el.html(replacedText);
}

function emoticons(text) {
    var inputText = text;//el.html();

    inputText = inputText.replace(/:\)/gim, "<div class=smile ></div>");
	inputText = inputText.replace(/:-\)/gim, "<div class=smile ></div>");
	
	inputText = inputText.replace(/:D/gim, "<div class=bigSmile ></div>");
	inputText = inputText.replace(/:-D/gim, "<div class=bigSmile ></div>");
	
	inputText = inputText.replace(/:\(/gim, "<div class=sad ></div>");
	inputText = inputText.replace(/:-\(/gim, "<div class=sad ></div>");
	
	inputText = inputText.replace(/:P/gim, "<div class=tongeOut ></div>");
	inputText = inputText.replace(/:-P/gim, "<div class=tongeOut ></div>");
	
	inputText = inputText.replace(/;\)/gim, "<div class=wink ></div>");
	inputText = inputText.replace(/;-\)/gim, "<div class=wink ></div>");
	
	inputText = inputText.replace(/:o/gim, "<div class=surprise ></div>");
	inputText = inputText.replace(/:-o/gim, "<div class=surprise ></div>");
	
	inputText = inputText.replace(/:s/gim, "<div class=sick ></div>");
	inputText = inputText.replace(/:-s/gim, "<div class=sick ></div>");
	
	inputText = inputText.replace(/:&apos;\(/gim, "<div class=crying ></div>");
	inputText = inputText.replace(/:&apos;-\(/gim, "<div class=crying ></div>");
	
	inputText = inputText.replace(/8\)/gim, "<div class=glasses ></div>");
	inputText = inputText.replace(/8-\)/gim, "<div class=glasses ></div>");

    return inputText;
}

function startChatSession(){  
	
	$.ajax({
	  url: "chat/chat.php?action=startchatsession",
	  cache: false,
	  dataType: "json",
	  success: function(data) {
 
		username = data.username;
		userDisplay = data.userDisplay;
	
		$.each(data.items, function(i,item){
			
			if (item)	{ // fix strange ie bug

				chatboxtitle = item.f;

				if ($("#chatbox_"+chatboxtitle).length <= 0) {
					createChatBox(chatboxtitle,1,item.fu);
				}
				
				if (item.s == 1) {
					item.f = username;
				}
			
				if (item.s == 2) {
					$("#chatbox_"+chatboxtitle+" .chatboxcontent").append('<div class="chatboxmessage"><span class="chatboxinfo">'+item.m+'</span></div>');
				} else {
					$("#chatbox_"+chatboxtitle+" .chatboxcontent").append('<div class="chatboxmessage"><span class="chatboxmessagefrom">'+item.u+':&nbsp;&nbsp;</span><span class="chatboxmessagecontent">'+item.m+'</span></div>');
				}
			}
		});
		
		for (i=0;i<chatBoxes.length;i++) {
			chatboxtitle = chatBoxes[i];
			$("#chatbox_"+chatboxtitle+" .chatboxcontent").scrollTop($("#chatbox_"+chatboxtitle+" .chatboxcontent")[0].scrollHeight);
			setTimeout('$("#chatbox_"+chatboxtitle+" .chatboxcontent").scrollTop($("#chatbox_"+chatboxtitle+" .chatboxcontent")[0].scrollHeight);', 100); // yet another strange ie bug
		}
	
	setTimeout('chatHeartbeat();',chatHeartbeatTime);
		
	}
	});
}


function listFriendsChat(p) {
		if(p==1){
			if($.trim($('.chatListContainer').html())==''){
				$('.chatListContainer').html('<div id="loading"><img src="img/loader.gif" width="32" height="32" /></div>');
				p='?p='+p;
			}
		}else{ 
			p='';
		}
			
		$.ajax({
			cache: false,
	  		dataType: "json",
			url: 'chat/listFriends.php'+p,
			success: onSuccessListFriendsChat
		});
	
	}

	function onSuccessListFriendsChat(data) {
		if(data!=null){ 
			switch(data.a*1)
			{
			case 1: salida='';
					$.each(data.f, function(i,item){ 
							if (item)	{	
								salida+='<div  id="chatList_'+item.c+'" class="listUserChat" onClick="javascript:chatWith(\''+item.c+'\',\''+item.s+'\')" >';
								salida+='<a href="javascript:void(0)" class="listChat"  title="'+item.n+'" >';
								salida+='<img width="20" height="20" src="'+item.p+'" />'+item.s+'<div class="'+item.t+'">&nbsp;</div></a></div>';
							}
					});
					
					$('.chatListContainer').html(salida);
					if(!isMobile())$('.listChat').tipsy({gravity: 'w'});
					
			  break;
			case 2: 
			  //execute code block 2
			  break;
			default: //
			  //code to be executed if n is different from case 1 and 2
			}
			
		}
		
		
	}
	
	function changeStatus(online) {
		
		if(!online){
			for (x in chatBoxes) {
				chatboxtitle = chatBoxes[x];
				$('#chatbox_'+chatboxtitle).css('display','none');
				$('#chatbox_'+chatboxtitle+' .chatboxtextarea').val('');
			
			}
			$('#offline').hide(); 
			$('#online').show();
			$('#showChat').hide(); 
			$('#hideChat').hide();
			$('.chatListContainer').slideUp();
			action='offline';
			play=false;
			
		}else{
			
			$('#online').hide(); 
			$('#offline').show();
			$('#showChat').hide(); 
			$('#hideChat').show();
			$('.chatListContainer').slideDown();
			action='online';
			play=true;
			startChatSession();
			chatHeartbeat(1);
				
		}
		$.post("chat/chat.php?action="+action);
	
	}
 