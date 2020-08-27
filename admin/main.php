<?php
	require_once('auth.php');
	$type = $_SESSION['SESS_CONTROL_TYPE'];
?>
<!DOCTYPE html>
<html class="wf-museo-i3-active wf-museo-i7-active wf-museo-n3-active wf-museo-n7-active wf-active" style="position: relative; -webkit-transition: right 0.25s ease-in-out; transition: right 0.25s ease-in-out; right: 0px;">

<head>
<title>Administration Panel</title>
<link rel="shortcut icon" href="./img/brand/favicon.ico">
<link rel="stylesheet" type="text/css" href="./../css/stylesheet.css">
<link rel="stylesheet" type="text/css" href="./../css/Xufax.css">
<link rel="stylesheet" type="text/css" href="./css/stylesheet.css">
<link rel="stylesheet" href="./../css/jquery.mCustomScrollbar.css">

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>
$(document).ready( function(){
//		$('#content').load('getting_started.php', function( response, status, xhr ) {
//			  if ( status == "error" ) {
//				var msg = "Sorry but there was an error: ";
//				$( "#error" ).html( msg + xhr.status + " " + xhr.statusText );
//			  }
//			  else {
//				  	$('#loader').css("display", "none");
//			  }
//			  });
if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
$('head').append("<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no\" /"+">");
window.onscroll = function (event) {
  		guts = $('#guts').css('display');
		guts2 = $('#guts2').css('display');
		guts3 = $('#guts3').css('display');
		if (guts == 'block') {
			$("#guts").css("display","none");
		}
		if (guts2 == 'block') {
			$("#guts2").css("display","none");
		}
		if (guts3 == 'block') {
			$("#guts3").css("display","none");
		}
}
}else
{
$('body').append('<script src="./js/jquery.mCustomScrollbar.concat.min.js"></sc'+'ript>');
}
});
</script>
<style>
.qt_update {
	background-image: url(../img/misc/update_img.png);
	background-size:32px;
}
.qt_ns{
	background-image: url(../img/misc/new_shift.png);
	background-size:32px;
}
</style>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="initial-scale=1, minimum-scale=1">
<meta name="description" content="">
<meta http-equiv="x-dns-prefetch-control" content="off">

<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="./js/Yarix.js"></script>
<script>
$(document).ready(function () {
$.ajaxPrefilter(function( options ) {
    options.global = true;
});
    $.ajaxSetup({
        beforeSend: function(xhr, status) {
            // TODO: show spinner
            $('#loader').show();
				console.log('Ajax Before Send');
        },
        complete: function() {
            // TODO: hide spinner
            $('#loader').hide();
		console.log('Ajax Complete');
        }
    });
});
function jax (){
    $(document).ajaxStart(function() {
        $('#loader').show();
				console.log('Ajax Start');
    });
	$(document).ajaxSuccess(function() {
        $('#loader').hide();
		console.log('Ajax Success');
	});
};
function puno(pmsg,ptyp){
	if (ptyp == "success"){
		var punco = 'rgb(123, 237, 123)';
		var punot = 'SUCCESS: ';
	}
	if (ptyp == "alert"){
		var punco = 'rgb(230, 209, 36)';
		var punot = 'WARNING: ';
	}
	if (ptyp == "error"){
		var punco = 'rgb(237, 123, 123)';
		var punot = 'ERROR: ';
	}
	var plength = $(".puno-box").length;
	var punid = Math.random().toString(36).substr(2, 5);
	if (plength > 4){
		setTimeout(function(){ puno(pmsg,ptyp); }, 2000);
	} else {
		$('.puno').prepend("<div class='puno-box' data-puno-id='"+punid+"' style='background-color:"+punco+";display:none;'><div class='puno-msg'>"+punot+pmsg+"</div></div>");
		$("div[data-puno-id='"+punid+"']").slideDown();
		$("div[data-puno-id='"+punid+"']").click( function() {
			$(this).slideUp(800).fadeOut(500, function(){
			$(this).remove();
			// Find out how to make it slide up and fade out simultaneously
		});
		});
		if (ptyp == "success"){
			$("div[data-puno-id='"+punid+"']").delay(4000).slideUp().fadeOut(500, function(){
			$(this).remove();
			// Find out how to make it slide up and fade out simultaneously
		});
		}
	}
}
</script>
</head>
<body>
<div class="puno"></div>
<div id="loader" style="display:none;-webkit-animation:spin 1s linear infinite;"></div>
<div id="overlay"></div>
<div id="header" class="header" data-mcs-theme="minimal">
<div class="content" data-object="content" data-location="main">
    <h1 style="font-size: 3em;"><a href="/">Admin Panel</a></h1>
<!--
    <script>
    $(document).ready(function(){
		var loc = $("div[data-object='content']").data("location");
		alert(loc);
	});
    </script>
-->
    <div id="description">
        <p>"v.1.0.0"</p>
    </div>

    <div id="links">
        <a href="#/Home" id="home" class="active" style="background-image: url(../../img/misc/home_white.png);background-position: left 10px center;background-repeat: no-repeat;cursor: pointer;background-size: 33px;">Home</a>
        <a href="#/Users" id="click" class="us" style="background-image: url(../../img/misc/staff.png);background-position: left 10px center;background-repeat: no-repeat;cursor: pointer;background-size: 33px;">Users</a>
        <a href="#/Notifications" id="click2" class="nt" style="background-image: url(../../img/misc/bell_img.png);background-position: left 10px center;background-repeat: no-repeat;cursor: pointer;background-size: 33px;">Notifications</a>
        <a href="#/Knowledge Base" id="click3" class="kb" style="background-image: url(../../img/misc/bulb_img.png);background-position: left 10px center;background-repeat: no-repeat;cursor: pointer;background-size: 33px;">Knowledge Base</a>
        <a href="#" onclick=javscript:logout(); style="background-color: rgba(195, 0, 0, 1);" id="log_out">Log Out</a>   
<!-- NEW OBSFUNCATE
        <a href="#/New" id="click3">New</a>  
            <div id="guts3">
                <a href="#/New/Admin" class="guts" id="admin">• Administrator</a>
            </div>
-->
    </div>
    <div id="footer"> 		
<div id="logo_title"></div>
        
    </div>
    </div>
</div>
    <button class="menu-btn grid-button collapse" type="button" role="button" aria-label="Toggle Navigation" style="position:fixed;left:300px;z-index:100">
  <span class="grid grid-lines"></span>
</button>
<div id="formarray"></div>
<div id="dialogboxholder"></div>
<div id="content" class="mCustomScrollbar light" data-mcs-theme="minimal" style="overflow:scroll;">
<div id="error"></div>
</div>
<script type="text/javascript">
$(document).ready( function() {
    var anchor = document.querySelectorAll('.menu-btn');
    
    [].forEach.call(anchor, function(anchor){
      var open = false;
      anchor.onclick = function(event){
		var btn = document.getElementsByClassName('grid'); //REMOVEABLE FOR NON LINE
        event.preventDefault();
        if(!open){
          this.classList.add('close-btn');
		  $(".grid").removeClass('grid-lines'); //REMOVEABLE FOR NON LINE
          open = true;
        }
        else{
          this.classList.remove('close-btn');
		  $(".grid").addClass('grid-lines'); //REMOVEABLE FOR NON LINE
          open = false;
        }
      }
    }); 	
	$('.menu-btn').click( function () {
		var status = $('.menu-btn').hasClass('close-btn');
		if (status == true) {
			$('#header').css("width","0px");
			$('#content').css("left","0px");
			$('.menu-btn').css("left","0px");
		} else {
			$('#header').css("width","300px");
			$('#content').css("left","300px");
			$('.menu-btn').css("left","300px");
		}
	});
});
var title_length = $('#header h1 *').contents().filter(function() { return this.nodeType == 3; }).text().length;
var title_width = Math.max(1.5, Math.min(3, 48 / title_length));
$('#header h1').css('font-size', title_width + 'em');
</script>
<script>window.jQuery || document.write('<script src="./../js/jquery-1.11.1.min.js"><\/script>')</script>
</body>
</html>