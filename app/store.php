<?php include 'inc/header.php'; ?>
<div id="page-lstStore" data-role="page" data-cache="false" class="no-footer no-header">
	<div data-role="header" data-position="fixed" data-theme="f"><h1></h1></div>
	<div data-role="content" class="list-content">
		<div>
			<ul data-role="listview" id="infoList" data-inset="false" data-divider-theme="b" class="list-info"></ul>
		</div>
	</div><!-- content -->
	<div id="cart-footer" data-role="footer" data-position="fixed" data-theme="f" style="display: none">
		<div data-role="navbar"><ul></ul></div>
	</div>
    <div id="footer" data-role="footer" data-position="fixed" data-theme="f">
		<div data-role="navbar">
			<ul id="storeNav">
				<li><a href="#" id="goBack" opc="1"></a></li>
				<li><a href="#"  opc="2"></a></li>
			</ul>
		</div>
	</div>
	<script type="text/javascript">
		pageShow({
			id:'#page-lstStore',
			title:lang['STORE'],
			backButton:true,
			before:function(){
				//languaje
				$('#category').html(lang.STORE_CATEGORY);
				$('#btnGroupCreated').html(lang.GROUPS_TITLEWINDOWSNEW);
				$('#searchPreferences').attr('placeholder',lang.PREFERENCES_HOLDERSEARCH);
				$('#cart-footer ul').html(
					'<li>'+
						'<a class="ui-btn-active">'+
							lang.STORE_VIEWORDERINCART+
						'</a>'+
					'</li>'
				);
                $('#storeNav #goBack').html(lang.goback+' '+lang.store);
			},
			after:function(){
				var layer='#infoList';
				$(layer).wrap('<div class="list-wrapper"><div id="scroller"></div></div>');
				$('.list-wrapper').jScroll({hScroll:false});
				$('input[data-type="search"]',layer).keyup(function(){
					$('.list-wrapper').jScroll('refresh');
				});
				$(layer).on('click','li[idPro]',function(){
					redir(PAGE['detailsproduct']+'?id='+$(this).attr('idPro'));
				});				
                $('#storeNav').on('click','li a[opc]',function(){
					switch($(this).attr('opc')){
                        case '1': redir(PAGE['storeCat']); break;
                        case '2': redir(PAGE['storeSubCate']+'?id='+$(this).attr('code')); break;
                    }
				});
				getProducts(layer,$_GET['c'], $_GET['sc']);
			}
		});
	</script>
</div>
<?php include 'inc/footer.php'; ?>
