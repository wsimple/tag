<container class="bg" style="padding-top: 170px;">
	<div class="ui-box-outline" style="display: block;width: 800px;">
		<div class="ui-box">
			<h3 class="ui-single-box-title"><?=SIGNUP_CTRTITLEMSGEXITO.' '.formatoCadena($_SESSION['ws-tags']['ws-user']['full_name']).'! '.WELCOMETITLE?>
			</h3>
			<div id="welcomediv" >
				<ul>
					<li>
						<div class="b_actionTag">
							<a>
								<img src="css/smt/email/creat_tag_icon.png" ><br>
							</a>
						</div>
						<strong><?=EMAILCREATETAGS?></strong>
						<div class="b_actionTags">
							<span class="classNoColor"><?=TEXTWELCOMETAGS1?></span>
							<?=MAKEPOINTS?>
						</div>
					</li>
					<li>
						<div class="b_actionTag">
							<a>
								<img src="css/smt/email/share_tag_icon.png"  ><br>
							</a>
						</div>
						<strong><?=EMAILSTAGS?></strong>
						<div class="b_actionTags">
							<span class="classNoColor"><?=TEXTWELCOMETAGS2?></span>
							<?=MAKEPOINTS?>
						</div>
					</li>
					<li>
						<div class="b_actionTag">
							<a>
								<img src="css/smt/email/redistribute_tags_icon.png"><br>
							</a>
						</div>
						<strong><?=EMAILRTAGS?></strong>
						<div class="b_actionTags">
							<span class="classNoColor"><?=TEXTWELCOMETAGS3?></span>
							<input type="button" value="<?=SIGNUP_H5TITLE1?>"/>
							<span><?=TEXTWELCOMETAGS4?></span>
						</div>
					</li>
					<li>
						<div class="b_actionTag">
							<a>
								<img src="css/smt/email/sponsor_tags_icon.png"  ><br>
							</a>
						</div>
						<strong><?=EMAILSPTAGS?></strong>
						<div class="b_actionTags">
							<span class="classNoColor"><?=TEXTWELCOMETAGS5?></span>
							<input type="button" value="<?=SIGNUP_H5TITLE1?>"/>
							<span><?=TEXTWELCOMETAGS6?></span>
						</div>
					</li>
				</ul>
					<div class="clearfix"></div>
					<div id="b_actionPoint">
						<div action="redeemPoinst" style="width: 190px;">
							<div id="backgroundRedeenPoint">
								<div class="number">1000</div>
                                <div class="text"><?=STORE_TITLEPOINTS?></div>
							</div>
							<div>
							<h2>
								<span class="color-d">$</span>
								<span><?=EMAIL_REDEEMPOINTS?></span>
								<span class="color-d">$</span>
							</h2>
							<span style="color: #000"><?=EMAIL_POINTSCollect?></span>
							<?=EMAIL_POINTS?>
							</div>
						</div>
						<div id="backgroundGetStater">
							<input type="button" value="<?=EMAIL_INI?>"/>
						</div>
					</div>
			</div>
		</div>
	</div>
</container>
<script>
	$(document).ready(function(){
		$('.b_actionTags input,#backgroundGetStater input, header content a,#lihome').click(function(){
			redir();
		});
	});
</script>