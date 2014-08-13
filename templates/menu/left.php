<?php 
	$wid=CON::getVal('SELECT id FROM users WHERE email="wpanel@tagbum.com";'); 
	if (!$wid) $wid=CON::getVal('SELECT id FROM users WHERE email="wpanel@tagbum.com";');
	$trendings = get_trending(10);
?>
<article class="side-box menu">
	<header><span></span></header>
	<ul id="menuLeft">
		<li id="cretationTag"><a href="<?=base_url('creation')?>"><?=MAINMNU_CREATETAG?></a></li>
		<!-- <li id="profile">
			<span><?=MAINMNU_ACCOUNT?></span>
			<ul>
				<li><a href="<?=base_url('user')?>"><?=USERPROFILE_PERSONALINFO?></a></li>
				<li><a href="<?=base_url('user/preferences')?>"><?=USERPROFILE_PREFERENCES?></a></li>
				<li><a href="<?=base_url('user/password')?>"><?=MAINSMNU_PASSWORD?></a></li>
				<li><a href="<?=base_url('user/cards')?>"><?=USERPROFILE_BUSINESSCARD?></a></li>
				<li><a href="<?=base_url('setting?sc=1')?>"><?=NOTIFICATIONS_CONFIGURATIONSECTION?></a></li>
			</ul>
		</li> -->
		<li id="friends">
			<span><?=USER_FINDFRIENDSTITLELINKS?></span>
			<ul>
				<li><a href="<?=base_url('friends?sc=1')?>"><?=MAINMNU_FINDFRIENDS?></a></li>
				<li><a href="<?=base_url('friends?sc=2')?>"><?=EDITFRIEND_VIEWTAB1?></a></li>
				<li><a href="<?=base_url('friends?sc=3')?>"><?=EDITFRIEND_VIEWTAB2?></a></li>
			</ul>
		</li>
		<li id="groups">
			<span><?=MAINMNU_GROUPS?></span>
			<ul>
				<li><a href="<?=base_url('groups?sc=1')?>"><?=GROUPS_LABELTABLSTMYGROUPS?></a></li>
				<li><a href="<?=base_url('groups')?>"><?=GROUPS_LABELTABLSTALL?></a></li>
			</ul>
		</li>
		<li id="store">
			<a href="<?=base_url('store')?>"><span><?=STORE?></span></a>
			<ul>
				<li><a href="<?=base_url('store')?>"><?=PRODUCT_TITLE?></a></li>
				<?php if ($_SESSION['ws-tags']['ws-user']['type']==1 || $_SESSION['ws-tags']['ws-user']['id']==$wid){ ?>
				<li><a href="<?=base_url('newproduct')?>"><?=PRODUCTS_ADD?></a></li>
				<li><a href="<?=base_url('mypublications')?>"><?=STORE_MISPUBLICATION?></a></li>
				<?php } ?>
				<li id="menu-l-li-shoppingCart" >
					<a href="<?=base_url('shoppingcart')?>"><?=STORE_SHOPPINGCART?></a>
					<div id="menu-lshoppingCart" class="menu-l-shoppingCart" style="display: none;"></div>
					<div class="clearfix"></div>
				</li>
				<li id="menu-l-li-wishList" ><a href="<?=base_url('wishList')?>"><?=STORE_WISH_LIST?></a></li>
				<li><a href="<?=base_url('freeproducts')?>"><?=PRODUCTS_RAFFLE?></a></li>
				<li class="menu-l-youOrders" style="display: none;"><a href="<?=base_url('orders')?>"><?=STORE_YOURORDES?></a></li>
				<?php if ($_SESSION['ws-tags']['ws-user']['type']==1 || $_SESSION['ws-tags']['ws-user']['id']==$wid){ ?>
				<li class="menu-l-youSales" style="display: none;"><a href="<?=base_url('sales')?>"><?=STORE_SALES?></a></li>
				<?php } ?>

				<?php if (PAYPAL_PAYMENTS): ?>
					<li><a href="<?=HREF_DEFAULT?>" action="buyPoints"><?=STORE_SALE_POINTS?></a></li>
				<?php endif ?>
			</ul>
		</li>
	</ul>
</article>
<article class="side-box trendings">
	<header><span><?=LEFTSIDE_TRENDING?></span></header>
	<?php if (mysql_num_rows($trendings) > 0): ?>
		<ul>
		<?php while($trending = mysql_fetch_assoc($trendings)): ?>
			<li><a href="searchall?srh=<?php echo  urlencode($trending['word']) ?>"><?php echo ucwords($trending['word']) ?></a></li>
		<?php endwhile; ?>
		</ul>
	<?php else: ?>
		<div><?php LEFTSIDE_NOHAVE_TRENDINGS_TOPINGS ?></div>
	<?php endif; ?>
</article>
<?php if ($section!='news'){ 
	require('views/news/news.php');
?>
<article id="adsListPubli" class="side-box news">
	<header><span><?=MAINMNU_NEWS_TITLE?></span></header>
	<table width="155" border="0" align="left" cellpadding="0" cellspacing="0" class="tableNews" id="info-container">
		<tr id="noticeInsertTop" style="display:none;"><td><div class="clearfix"></div></td></tr>
		<tr id="news-loader" style="font-size:11px;color:#f82;"><td>&nbsp;&nbsp;&nbsp;<?=NEWS_RIGHTSIDE_LOADING?></td></tr>
		<tr id="NewsInfo" style="font-size:11px;color:#f82;display:none;"><td></td>
			<td style="padding:10px;"><a style="color: #77c574;" href="<?=base_url('news')?>"><?=INVITEUSERS_LBLVIEWALLSENDTAG?></a></td>
		</tr>
		<tr id="waitNewsInfo" style="font-size:11px;color:#f82;display:none;text-align: center;">
			<td  colspan="2" style="padding:10px;">&nbsp;&nbsp;&nbsp;<?=NEWS_WAITMESSAGEFRIENDS?></td>
		</tr>
	</table>
</article>
<?php } ?>
<script type="text/javascript">
	$(function(){
		$.on({
			open:function(){
				var menu=$('#menuLeft')[0];
				$(menu).on('click','li>span',function(){
					//buscamos ul hijo (submenu)
					var ul=$(this).parent().find('ul')[0];
					if(ul){
						$('ul',menu).not(ul).slideUp(300);
						$(ul).slideToggle(300);
					}
				});
				var el;
				if(SECTION){
					switch(SECTION){
						case 'myfreeproducts':
						case 'newproduct':
						case 'mypublications':
						case 'shoppingcart':
						case 'freeproducts':
						case 'orders':
						case 'myparticipation':
						case 'shippingaddress':
						case 'detailprod':
						case 'salepoints':
						case 'sales':
                        case 'wishList':
							el='store';
						break;
						case 'creation':
							el='cretationTag';
						break;
                        case 'groupsDetails':
							el='groups';
						break;
                        case 'user':
							el='profile';
						break;
						default: el=SECTION;//elemento del menu principal
					}
					$(menu).children('#'+el)//li
					.addClass('selected')
					.children('ul').show();
				}
			},
			close:function(){
				$('#menuLeft').off();
				$.smt.news = $('#info-container').html();
			}
		})
	});
</script>
