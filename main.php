<?php
	require_once('auth.php');
	$type = $_SESSION['SESS_CONTROL_TYPE'];
?>
<!DOCTYPE html>
<html class="wf-museo-i3-active wf-museo-i7-active wf-museo-n3-active wf-museo-n7-active wf-active" style="position: relative; -webkit-transition: right 0.25s ease-in-out; transition: right 0.25s ease-in-out; right: 0px;">

<head>
<title>Always Care Staffing Panel</title>
<?php $main = true;
require_once('includes.php'); ?>
<meta name="description" content="Robots rule.txt">
<script>
$(document).ready( function(){
	if (!isloaded){
		$('#content').load(''+root+'home.php', function( response, status, xhr ) {
			  if ( status == "error" ) {
				var msg = "Sorry but there was an error: ";
				$( "#error" ).html( msg + xhr.status + " " + xhr.statusText );
			  }
			  else {
				  	$('#loader').css("display", "none");
			  }
			  });
	}
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
		if (status == false) {
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
</script>
<style>
.qt_update {
	background-image: url(../img/misc/bell_img_blk.png);
	background-size:32px;
}
.qt_ns{
	background-image: url(../img/misc/new_shift.png);
	background-size:32px;
}
</style>
<script>
$(document).ready(function () {
	$(".le-search").click (function(){
		$("#le-search-ol").slideDown();
		$('input.le-search-box').focus();
	});
	$(".le-close").click( function(){
		$("#le-search-ol").slideUp();
	});

	// Live Search
	// On Search Submit and Get Results
	function search() {
		var query_value = $('input.le-search-box').val();
		$('b#search-string').html(query_value);
		if(query_value !== ''){
			$.ajax({
				type: "POST",
				url: ""+root+"findr_search.php",
				data: { query: query_value },
				cache: false,
				success: function(html){
					$("ul#results").html(html);
					$("ul#results li").click(function(){$("#le-search-ol").slideUp();});
				}
			});
		}return false;    
	}

	$("input.le-search-box").on("keyup", function(e) {
		// Set Timeout
		clearTimeout($.data(this, 'timer'));

		// Set Search String
		var search_string = $(this).val();

		// Do Search
		if (search_string == '') {
			$("ul#results").fadeOut();
			$('h4#results-text').fadeOut();
		}else{
			$("ul#results").fadeIn();
			$('h4#results-text').fadeIn();
			$(this).data('timer', setTimeout(search, 100));
		};
	});

	$('.secondary_notif_menu').click(function(){
		$(this).fadeOut();
		$('.main_notif_menu').fadeOut();
	});
    $('.secondary_notif_menu').mouseleave(function(){
     if ($('.secondary_notif_menu:hover').length != 0) {
    // do something ;)
     }else{
        $('.secondary_notif_menu').fadeOut();
     }
    });
    $('.nm-more').hover(function () {
        var item_num = $(this).data('stg-id');
		var menu_height = (16+((item_num-1)*(40)))+'px';
		$('.secondary_notif_menu').css({'bottom':menu_height});
        $('.secondary_notif_menu').fadeIn();
        var item_names = $(this).data('stg-items');
        var item_classes = $(this).data('stg-class');
		var allornone = $(this).data('stg-aon');
        console.log(item_classes);
		console.log(allornone);
        $('.secondary_notif').html('');
            item_names.forEach(function (entry) {
                var item_index = item_classes[item_names.indexOf(entry)];
                $('.secondary_notif').append('<li data-aon="'+allornone+'" class="'+item_index+'">'+entry+'</li>');
            });
$(document).ready(function(){
$('.notif-readx').click(function(){
	var aon = $(this).data('aon');
	if (aon == 'all'){
		$('.chk-notif').each(function() {
			var notif_id = $(this).data('chk-notif');
			var notif_flag = $(this).data('chk-flag');
		if (notif_flag == '0') {
			var myid = '<?php $myid = $_SESSION['SESS_CONTROL_ID']; echo($myid); ?>';
		$.ajax({
					type:"POST",
					url:""+root+"notification_push.php",
					data: {'action': 'readit', 'notif_id': notif_id, 'user': myid},
					success: function(){
						$("div[data-location='qt_primary_notifications']").load(''+root+'widget_display.php?action=get_notifications_open');
						$('.chk-notif:checked').attr('checked', false);
						$('#notif_holder').load(''+root+'notifications.php?action=holder');
					}
				}		
				);
		} else {
			// Do Nothing
		}
		});
	}
	if (aon == 'select'){
		$('.chk-notif:checked').each(function() {
			var notif_flag = $(this).data('chk-flag');
			var notif_id = $(this).data('chk-notif');
			var myid = '<?php $myid = $_SESSION['SESS_CONTROL_ID']; echo($myid); ?>';
			if (notif_flag == '0') {
		$.ajax({
					type:"POST",
					url:""+root+"notification_push.php",
					data: {'action': 'readit', 'notif_id': notif_id, 'user': myid},
					success: function(){
						$("div[data-location='qt_primary_notifications']").load(''+root+'widget_display.php?action=get_notifications_open');
						$('.chk-notif:checked').attr('checked', false);
						$('#notif_holder').load(''+root+'notifications.php?action=holder');
					}
				}		
				);
			} else {
				// Do nothing
			}
		});

	}
});
$('.notif-unreadx').click(function(){
	var aon = $(this).data('aon');
	if (aon == 'all'){
		$('.chk-notif').each(function() {
			var notif_id = $(this).data('chk-notif');
			var myid = '<?php $myid = $_SESSION['SESS_CONTROL_ID']; echo($myid); ?>';
		$.ajax({
					type:"POST",
					url:""+root+"notification_push.php",
					data: {'action': 'unreadit', 'notif_id': notif_id, 'user': myid},
					success: function(){
						$("div[data-location='qt_primary_notifications']").load('widget_display.php?action=get_notifications_open');
						$('.chk-notif:checked').attr('checked', false);
						$('#notif_holder').load('notifications.php?action=holder');
					}
				}		
				);
		});
	}
	if (aon == 'select'){
		$('.chk-notif:checked').each(function() {
			var notif_id = $(this).data('chk-notif');
			var myid = '<?php $myid = $_SESSION['SESS_CONTROL_ID']; echo($myid); ?>';
		$.ajax({
					type:"POST",
					url:"notification_push.php",
					data: {'action': 'unreadit', 'notif_id': notif_id, 'user': myid},
					success: function(){
						$("div[data-location='qt_primary_notifications']").load('widget_display.php?action=get_notifications_open');
						$('.chk-notif:checked').attr('checked', false);
						$('#notif_holder').load(''+root+'notifications.php?action=holder');
					}
				}		
				);
		});
	}
});
});
    });
$('.notif_stgs').click(function(){
	$('.main_notif_menu').toggle();
});
$.ajaxPrefilter(function( options ) {
    options.global = true;
});
    $.ajaxSetup({
        beforeSend: function(xhr, status) {
            // TODO: show spinner
			var call = this.url;
		if ( ((/unfilled_5.php/i.test(call)) !== true) && ((/\/js\//i.test(call)) !== true)  && (typeof call !== "undefined") ){
            	$('#loader').show();
				console.log(call);
			}
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
		var call = this.url;
		if ( ((/unfilled_5.php/i.test(call)) !== true) && ((/\/js\//i.test(call)) !== true)  && (typeof call !== "undefined") ){
			$('#loader').show();
			console.log(call);
		}
		console.log('Ajax Start');
    });
	$(document).ajaxSuccess(function() {
        $('#loader').hide();
		console.log('Ajax Success');
	});
	return false;
};
function puno(pmsg,ptyp){
	if (ptyp == "success"){
//		var punco = 'rgba(99, 184, 129, 0.7)';
		var punco = 'rgba(151, 114, 81, 0.7)';
		var punicon = '<i class="fa fa-check" style="color:rgb(134, 205, 114);"></i>';
		var punot = 'SUCCESS:';
	}
	if (ptyp == "alert"){
		var punco = 'rgba(151, 114, 81, 0.7)';
		var punicon = '<i class="fa fa-exclamation-triangle" style="color:rgb(247, 159, 45);"></i>';
		var punot = 'WARNING:';
	}
	if (ptyp == "error"){
//		var punco = 'rgba(184, 99, 99, 0.7)';
		var punco = 'rgba(151, 114, 81, 0.7)';
		var punicon = '<i class="fa fa-times" style="color:rgb(229, 110, 109);"></i>';
		var punot = 'ERROR:';
	}
	var plength = $(".puno-box").length;
	var punid = Math.random().toString(36).substr(2, 5);
	if (plength > 4){
		setTimeout(function(){ puno(pmsg,ptyp); }, 2000);
	} else {
		$('.puno').prepend("<div class='puno-box' data-puno-id='"+punid+"' style='background-color:"+punco+";display:none;'><div class='puno-icon'>"+punicon+"</div><div class='puno-title'>"+punot+"</div><div class='puno-msg'>"+pmsg+"</div></div>");
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
<ul id="loader" style="display:none;">
  <li></li>
  <li></li>
  <li></li>
</ul>
<div id="overlay"></div>
<div id="widget_notif">
    <div id="widget_notif_header">Notifications</div>
    <div id="exit" style="position: absolute;right: 9px;top: 3px;">
        <div class="sprite_fail" title="Exit"></div>
    </div>
    <div id="notif_stgs">
        <div class="notif_stgs" title="Settings"></div>
    </div>
    <div id="notif_stgs_menu_h" class="main_notif_menu" style="display:none;">
        <div id="notif_stgs_menu" class="notif-menu nm-open" style="display: block;">
            <ul>
                <li class="nm-more" data-stg-id="2" data-stg-aon="all" data-stg-items='["Mark as read", "Mark as unread"]' data-stg-class='["notif-readx", "notif-unreadx"]'>Mark all</li>
                <li class="nm-more" data-stg-id="1" data-stg-aon="select" data-stg-items='["Mark as read", "Mark as unread"]' data-stg-class='["notif-readx", "notif-unreadx"]'>Selected</li>
            </ul>
        </div>
    </div>
    <div id="notif_stgs_menu_h" class="secondary_notif_menu" style="display:none;">
        <div id="notif_stgs_menu" class="notif-menu nm-open" style="display: block;">
            <ul class="secondary_notif">
            </ul>
        </div>
    </div>
    <div id="notif_holder"></div>
</div>
<div id="v_cal"></div>
<div id="widget_prl"></div>
<div id="widget_ep"></div>
<div id="formarray"></div>
<div id="qt_holder"><div class="qt_box" style="display:inline-block;"><div class="qt_items qt_update" data-location="qt_primary_notifications" title="Notifications"></div><div class="qt_items qt_ns"></div></div><div class="qt_arrow"><div class="qt_arrow_cover"></div></div></div><div id="qt_thgs_holder"><div id="qt_thgs" data-location="qt_box" class="qt_thgs_closed"></div></div>
<div id="le-search-ol">
	<div class="le-close">
    	<i class="fa fa-close"></i>
    </div>
    <input type="text" placeholder="Start typing an employee/location name" class="le-search-box"/>
    <h4 id="results-text">Showing results for: <b id="search-string">Array</b></h4>
	<ul id="results"></ul>
</div>
<div id="bod">
<div id="header" class="header mCustomScrollbar" data-mcs-theme="minimal">
<div class="content" data-object="content" data-location="main" style="cursor:default;">
<p style="position:absolute;top:0px;left:0px;padding:0px;margin:0px;">Logged in as <?php echo($_SESSION['SESS_CONTROL_LOGIN']); ?></p>
<div style="
    float: right;
    position: absolute;
    right: 15px;
    top: 5px;
" class="le-search"><i class="fa fa-search" style="cursor:pointer;"></i></div>
    <h1 style="font-size: 2em;"><a href="/">Always Care Staffing Panel</a></h1>
<!--
    <script>
    $(document).ready(function(){
		var loc = $("div[data-object='content']").data("location");
		alert(loc);
	});
    </script>
-->
    <div id="description">
        <p>"Your health begins with peace of mind." <br/>v2.0</p>
    </div>

    <div id="links">
        <a href="/Home" id="home" class="active pl-t" data-title="Home - Always Care Staffing Panel" style="background-image: url(../img/misc/home_white.png);background-position: left 10px center;background-repeat: no-repeat;cursor: pointer;background-size: 33px;">Home</a>
        <a href="/Staff" id="click" class="pl-t" data-title="Staffing - Always Care Staffing Panel" style="background-image: url(../img/misc/staff.png);background-position: left 10px center;background-repeat: no-repeat;cursor: pointer;background-size: 33px;">Staffing</a>
            <div id="guts">
                <a href="/Staff/List" class="guts pl-t" data-title="Staff List - Always Care Staffing Panel" id="employees" style="background-image: url(../img/misc/staffl_img.png);background-position: left 10px center;background-repeat: no-repeat;cursor: pointer;background-size: 33px;">Staff List</a>
                <a href="/Staff/Log" class="guts pl-t" data-title="Staff Log - Always Care Staffing Panel" id="shifts" style="background-image: url(../img/misc/log_img.png);background-position: left 10px center;background-repeat: no-repeat;cursor: pointer;background-size: 33px;">View Staff Log</a>
                <a href="/New/Employee" class="guts pl-t" data-title="New Employee - Always Care Staffing Panel" id="newemployee" style="background-image: url(../img/misc/nstaff_img.png);background-position: left 10px center;background-repeat: no-repeat;cursor: pointer;background-size: 24px;">Add New Employee</a>
            </div>
        <a href="/Locations" class="pl-t" data-title="Employee Sites - Always Care Staffing Panel" id="click2" style="background-image: url(../img/misc/loc_img.png);background-position: left 10px center;background-repeat: no-repeat;cursor: pointer;background-size: 33px;">Employee Sites</a>
            <div id="guts2">
                <a href="/Locations/List" class="guts pl-t" data-title="Work Sites - Always Care Staffing Panel" id="locations" style="background-image: url(../img/misc/locl_img.png);background-position: left 10px center;background-repeat: no-repeat;cursor: pointer;background-size: 33px;">Work Sites</a>
                <a href="/New/Location" class="guts pl-t" data-title="New Location - Always Care Staffing Panel" id="newlocation" style="background-image: url(../img/misc/nloc_img.png);background-position: left 10px center;background-repeat: no-repeat;cursor: pointer;background-size: 24px;">Add New Location</a>
            </div>
        <a href="/Payroll" class="pl-t" data-title="Payroll - Always Care Staffing Panel" id="payroll" style="background-image: url(../img/misc/payroll_img.png);background-position: left 10px center;background-repeat: no-repeat;cursor: pointer;background-size: 33px;">Payroll</a>  
		<a href="/Account/Settings" class="pl-t" data-title="Settings - Always Care Staffing Panel" id="settings" style="background-image: url(../img/misc/stgs_white.png);background-position: left 10px center;background-repeat: no-repeat;cursor: pointer;background-size: 33px;">Settings</a>
<!--        <a href="/KB" id="click3" class="kb pl-t" data-title="Knowledge Base - Always Care Staffing Panel" style="background-image: url(../img/misc/bulb_img.png);background-position: left 10px center;background-repeat: no-repeat;cursor: pointer;background-size: 33px;">Knowledge Base</a> -->
        <a href="#" onclick=javscript:logout(); style="background-color: rgba(255, 0, 0, 0.4);background-image: url(../img/misc/logout_img.png);background-position: left 10px center;background-repeat: no-repeat;cursor: pointer;background-size: 33px;" id="log_out">Log Out</a>   
<?php
	$admin = "		<a href=\"../admin/main#Home\" id=\"admin\" style=\"background-color: #FFA400;background-image: url(../img/misc/admin_grey.png);background-position: left 10px center;background-repeat: no-repeat;cursor: pointer;background-size: 33px;\">Admin Tools</a>";
if ($type== '3'){
	echo ($admin);
}
?>
    </div>
    <div id="footer"> 		
<div id="logo_title"></div>
        
    </div>
    </div>
</div>
    <button class="menu-btn grid-button collapse" type="button" role="button" aria-label="Toggle Navigation" style="position:fixed;z-index:100">
  <span class="grid grid-lines"></span>
</button>
<script>
$('.qt_ns').click( function (){
	var thgs = $("div[data-location='qt_box']").hasClass("qt_thgs_closed"); 
	if (thgs == true){
	$("div[data-location='qt_box']").load(''+root+'widget_qt_ns.php').slideToggle("slide").removeClass("qt_thgs_closed qt_id_updates").addClass("qt_thgs_open qt_id_ns");
		}
	if (thgs == false){
	$("div[data-location='qt_box']").slideToggle("slide").html("").removeClass("qt_thgs_open qt_id_updates qt_id_ns").addClass("qt_thgs_closed");
		}
	});
$('.qt_update').click( function (){
	var thgs = $("div[data-location='qt_box']").hasClass("qt_thgs_closed"); 
	if (thgs == true){
	$("div[data-location='qt_box']").load(''+root+'notifications.php?action=sidebar').slideToggle("slide").removeClass("qt_thgs_closed qt_id_ns").addClass("qt_thgs_open qt_id_updates");
		}
	if (thgs == false){
	$("div[data-location='qt_box']").slideToggle("slide").html("").removeClass("qt_thgs_open qt_id_updates qt_id_ns").addClass("qt_thgs_closed");
		}
	});
	$('.qt_arrow').click( function() {
		var qt_box = $('.qt_box').css('width'); 
		var thgs = $("div[data-location='qt_box']").hasClass("qt_thgs_closed"); 
		if(qt_box == "0px"){
			$('.qt_arrow').css({"right":"-1px"});$('.qt_box').css({"border-left":"1px solid white","width":"125px"});$('.qt_notif_count').css({"display":"block"});$("div[data-location='qt_primary_notifications']").load(''+root+'widget_display.php?action=get_notifications_open');
			}
		if(qt_box !== "0px"){
			$('.qt_box').css({"border-left":"none","width":"0px"});$('.qt_notif_count').css({"display":"none"});
			if (thgs == false){
				$("div[data-location='qt_box']").css({"right":"-180px"}).slideToggle("slide").html("").removeClass("qt_thgs_open").addClass("qt_thgs_closed");$("div[data-location='qt_primary_notifications']").load(''+root+'widget_display.php?action=get_notifications');
				}
			$('.qt_arrow').css({"right":"0px"});
			}
		});
</script>
    <div id="content">
	    <div id="error"></div>
    </div>
</div>
<script type="text/javascript">
var title_length = $('#header h1 *').contents().filter(function() { return this.nodeType == 3; }).text().length;
var title_width = Math.max(1.5, Math.min(3, 48 / title_length));
$('#header h1').css('font-size', title_width + 'em');
$(document).ready( function(){
	$("div[data-location='qt_primary_notifications']").load(''+root+'widget_display.php?action=get_notifications');
});
(function($){
		
		$("#holder").mCustomScrollbar({
			theme:"light-thick",
			scrollInertia: 0
		});
		
})(jQuery);
</script>
<?php
	$script = "<script>map = {}; //I know most use an array, but the use of string indexes in arrays is questionable
onkeydown = onkeyup = function (e) {
    e = e || event; //to deal with IE
    map[e.keyCode] = e.type == 'keydown' ? true : false;
    if (map[17] && map[16] && map[85]) { //CTRL+SHIFT+U
        $('#dialogboxholder').load(''+root+'notification_new.php', function (response, status, xhr) {
            if (status == \"error\") {
                var msg = \"Sorry but there was an error: \";
                $(\"#error\").html(msg + xhr.status + \" \" + xhr.statusText);
            }

        });
        $('#overlay').fadeIn();
        $('#dialogboxholder').fadeIn().delay(1000).queue(function () {
            $('#tab_holder').css(\"width\", \"450px\");
        });
        map = [];
        return false;
    } else if (map[17] && map[16] && map[66]) { //CTRL+SHIFT+B
        alert('Control Shift B');
        map = [];
        return false;
    } else if (map[17] && map[16] && map[67]) { //CTRL+SHIFT+C
        alert('Control Shift C');
        map = [];
        return false;
    }
};
</script>";
if ($type== '3'){
	echo ($script);
}
?>
</body>
</html>