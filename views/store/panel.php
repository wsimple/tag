<?php 
//valida el menu left
$numIt=createSessionCar('','','count');
?>
<aside style="display: none;">
	<div class="shoppingCart" style="display: none;">
		<div class="bgCart"></div>
		<!--div class="textCart"><?=STORE_CART?></div-->
		<div class="numCart" <?=$numIt!='' && $numIt!='0'?'style="display:inline-block;"':'style="display: none;"'?>><span><?=$numIt?></span></div>
	</div>
	<div id="divSubMenuAdminPublications"></div>
	<div id="divSubMenuAdminFilters"></div>
	<?php //generateDivMessaje('massageItem','200',NEWTAG_CTRMSGDATASAVE)?>
	<br/>
	<input name="txtSearchProduct" id="txtSearchProduct" type="text" class="ui-single-search" placeholder="<?=STORE_BROWSERPRODUCTLBL?>" style="width:93%;background-repeat:no-repeat;"/>
    <br/><br/>
	<article class="side-box store-category">
		<header><span><?=STORE_CATEGORIES?></span></header>
		<ul id="menuStore">
			<li><a id="allPStore" href=""><?=STORE_ALLPRODUCTS?></a></li>
		</ul>
	</article>
	<br/>
	<div id="searchHashProduct"></div>
</aside>
<div id="totalANDsugestProduct" style="display: none;">
	<div id="totalPriceProduct">
		<div id="headerShopingCar"  h="">
			<article id="headerStoreCar" class="side-box shop" style="display: none;">
	               <header><span><?=STORE_TITLE_SUBMIT_ORDERS?></span></header>
            	<!--<div class="error_addNewProductsView limitComent" style="width: auto"><?=STOREMESSAGENOPOINTSFORBUY?></div>-->
				<div class="totalPointsSC">
					<strong><?=STORE_SUMMARY?>: </strong><br><br>
					<div class="conten-span-tp"><strong id="spanTotalPrice"><?=' '.STORE_TITLEPOINTS.': '?></strong><span id="totalPrice" class="nameSP"></span></div>
					<input type="hidden" value="" id="moveTotal">
					<!--<br><span id="spanTotalPriceMoney"><?=TYPEPRICEMONEY?>: </span><span id="totalPriceMoney"></span>-->
					<br><div class="conten-span-tp"><strong id="spanTotalPriceMoney">$: </strong><span id="totalPriceMoney" class="nameSP"></span></div>
					<input type="hidden" value="" id="moveTotalMoney">
				</div><br>
				<!--<span id="buyOrder" class="button"><?=STORE_CHECKOUT?></span>-->
				<input id="buyOrder" type="button" value="<?=STORE_PROCEED?>"/>
				<br><br><div class="footer-buy-store"><?=STORE_DELETEORDERCART?></div>
			</article>
			<div class="store-wrapper"><div id="divSubMenuAdminFilters"></div></div><br/>
			<div id="ordersProces"></div>
			<div id="makeSugesStoreProducts" style="display: none;">
                <article id="titleSuggest" class="side-box imagenSug">
	               <header><span><?=EDITFRIEND_VIEWTITLESUGGES?></span></header>
				    <div class="he"></div>
					<div class="clearfix"></div>
                </article>
			</div>
		</div>
	</div>
	<div class="clearfix"></div>
</div>
