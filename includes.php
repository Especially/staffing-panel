<?php
	$root = "http://staffingpanel.x10.mx";
if ($main == 'true'){
	echo("
	<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">
	<meta http-equiv=\"x-dns-prefetch-control\" content=\"off\">
	<link rel='shortcut icon' href='$root/img/brand/favicon.ico'>
	<link rel='stylesheet' type='text/css' href='$root/css/stylesheet.css'>
	<link href=\"http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css\" rel=\"stylesheet\">
	<link rel='stylesheet' type='text/css' href='$root/css/Xufax.css'>
	<link rel='stylesheet' href='$root/css/jquery.mCustomScrollbar.css'>
	<link rel=\"stylesheet\" href=\"$root/css/jquery.webui-popover.css\">
	<script src='http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js'></script>
	<script src=\"//code.jquery.com/ui/1.11.2/jquery-ui.js\"></script>
	<script>
	$(document).ready( function(){
			if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
		$('head').append(\"<meta name=\\\"viewport\\\" content=\\\"width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no\\\" /\"+\">\");
		window.onscroll = function (event) {
				guts = $('#guts').css('display');
				guts2 = $('#guts2').css('display');
				guts3 = $('#guts3').css('display');
				if (guts == 'block') {
					$(\"#guts\").css(\"display\",\"none\");
				}
				if (guts2 == 'block') {
					$(\"#guts2\").css(\"display\",\"none\");
				}
				if (guts3 == 'block') {
					$(\"#guts3\").css(\"display\",\"none\");
				}
		}
		}else
		{
		$('body').append('<script src=\"$root/js/jquery.mCustomScrollbar.concat.min.js\"></sc'+'ript>');
		}
		});
	</script>
	<script src='$root/js/Yarix.js'></script>
	<script src='$root/js/Locex.js'></script>
	<script src='$root/js/jquery.webui-popover.js'></script>
	");
} if ($floor == 'true') {
	echo("
		<script type='text/javascript'>
			function setPage(){
				var lroot = $('.root').data('root-location');
				var title = $('.root').data('title-location');
				//alert(lroot+' '+title);
				history.pushState(null,title,lroot);
				document.title = title;
			}
			$('#overlay').click(function(){
				setPage();
			});
		</script>
	");
	} if ($widget == 'true') {
	echo("
		<script type='text/javascript'>
			$('.close, .cancel, .close-widget').each(function(){
				$(this).click(function(){
					setPage();
				});
			});
		</script>
	");
	}

?>