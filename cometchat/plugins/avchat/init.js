<?php
		if (file_exists(dirname(__FILE__).DIRECTORY_SEPARATOR."lang/".$lang.".php")) {
			include dirname(__FILE__).DIRECTORY_SEPARATOR."lang/".$lang.".php";
		} else {
			include dirname(__FILE__).DIRECTORY_SEPARATOR."lang/en.php";
		}

		foreach ($avchat_language as $i => $l) {
			$avchat_language[$i] = str_replace("'", "\'", $l);
		}
?>

/*
 * CometChat
 * Copyright (c) 2011 Inscripts - support@cometchat.com | http://www.cometchat.com | http://www.inscripts.com
*/

(function($){

	$.ccavchat = (function () {

		var title = '<?php echo $avchat_language[0];?>';
		var lastcall = 0;

        return {

			getTitle: function() {
				return title;
			},

			init: function (id) {
				var currenttime = new Date();
				currenttime = parseInt(currenttime.getTime()/1000);
				if (currenttime-lastcall > 10) {
					baseUrl = $.cometchat.getBaseUrl();
					baseData = $.cometchat.getBaseData();
					$.getJSON(baseUrl+'plugins/avchat/index.php?action=request&callback=?', {to: id, basedata: baseData});
					lastcall = currenttime;
				} else {
					alert('<?php echo $avchat_language[1];?>');
				}
			},

			accept: function (id,grp) {
				baseUrl = $.cometchat.getBaseUrl();
				baseData = $.cometchat.getBaseData();
				$.getJSON(baseUrl+'plugins/avchat/index.php?action=accept&callback=?', {to: id,grp: grp, basedata: baseData});
				var w = window.open (baseUrl+'plugins/avchat/index.php?action=call&grp='+grp+'&basedata='+baseData, 'audiovideochat',"status=0,toolbar=0,menubar=0,directories=0,resizable=1,location=0,status=0,scrollbars=0, width=434,height=356");
				w.focus();
			},

			accept_fid: function (id,grp) {
				baseUrl = $.cometchat.getBaseUrl();
				baseData = $.cometchat.getBaseData();
				var w =window.open (baseUrl+'plugins/avchat/index.php?action=call&grp='+grp+'&basedata='+baseData, 'audiovideochat',"status=0,toolbar=0,menubar=0,directories=0,resizable=1,location=0,status=0,scrollbars=0, width=434,height=356");
				w.focus();
			}

        };
    })();

})(jqcc);