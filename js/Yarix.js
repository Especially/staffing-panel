// JavaScript Document
root = 'http://staffingpanel.x10.mx/';
var isloaded = null;
var pathway = location.href;
var pathwat = pathway.replace(/main#\//,"");
function isload(){
	isloaded = true;
}
if (pathway !== root+'main'){
history.pushState(isload(),"Mainframe",pathwat);
}
window.onpopstate = function(event) {
  locex();
};

// TIMEOUT SCRIPT

var timeout = null;
var msgt = null;
var idlewake = null;
var AutoRAlive = null;

function wakeup(){
idlewake = true;
     $(document).one('mousemove',function(){
		var path = window.location.hash;
		var pathname = window.location.pathname;	
		if ((pathname+path==='/main#/Home') || (pathname==='/Home')){
			AutoRefresh();	
          console.log('Home Auto Called');
		} else {
			console.log('No restoration script allocated');
		}
		  
     });
}

$(document).on('mousemove', function () {
    if (timeout !== null) {
//        $(document.body).text('');
        clearTimeout(timeout);
        if (msgt == null) {
            msgt = setTimeout(function () {
//                console.log('Not Idle');
            }, 1);
		if (idlewake !== true){
			wakeup();
		}
        msgt = null;
        }
    }
    timeout = setTimeout(function () {1
//        $(document.body).text('Mouse idle for 3 sec');
		idlewake = null;
		AutoRAlive = null;
        console.log('User is IDLE')
                if (typeof Employees != 'undefined'){
                clearInterval(Employ);
                Employ = 'undefined';
                console.log ('Employee auto refresh stopped');
                }
                if (typeof Locations != 'undefined'){
                clearInterval(Locations);
                Locations = 'undefined';
                console.log ('Location auto refresh stopped');
                }
                if (typeof Shifts != 'undefined'){
                clearInterval(Shifts);
                Shifts = 'undefined';
                console.log ('Shift auto refresh stopped');
                }
                if (typeof Refresh != 'undefined'){
                clearInterval(Refresh);
				AutoRAlive = false;
                Refresh = 'undefined';
                console.log ('Home auto refresh stopped');
                }
    }, 60000);
});
// END TIMEOUT SCRIPT
function profile(id) {
    var href = ''+root+'employee_profile?id=' + id;
    jax();
    $('#widget_ep').load(href, function (response, status, xhr) {
        if (status == "error") {
            var msg = "Sorry but there was an error: ";
            $("#error").html(msg + xhr.status + " " + xhr.statusText);
        }

    });
    $('#overlay').fadeIn();
    $('#widget_ep').fadeIn().delay(1000).queue(function (next) {
        if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
            //Do nothing
        } else {
            $('#widget_ep').css({
                'top': '20px'
            });
        }
        next();
    }).dequeue();

};
function viewCal(code) {
    var href = ''+root+'shifts_specific?location=' + code;
    $('#v_cal').load(href, function (response, status, xhr) {
        if (status == "error") {
            var msg = "Sorry but there was an error: ";
            $("#error").html(msg + xhr.status + " " + xhr.statusText);
        }

    });
    $('#overlay').fadeIn();
    if (typeof Locations != 'undefined') {
        clearInterval(Locations);
        console.log('Location auto refresh stopped');
    }
    $('#v_cal').fadeIn().delay(1000).queue(function (next) {
        if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
            //Do nothing
        } else {
            $('#v_cal').css({
                'top': '20px'
            });
        }
        next();
    }

    );

};
function editPE(code, action) {
    var href = ''+root+'UpdatePlacEmploy.php?code=' + code + '&edit=' + action;
    jax();
	var dbh_l = $("#dialogboxholder").length;
	if (dbh_l < 1){
		$("#formarray").after("<div id='dialogboxholder'></div>");
	}
		$('#dialogboxholder').load(href, function (response, status, xhr) {
			if (status == "error") {
				var msg = "Sorry but there was an error: ";
				$("#error").html(msg + xhr.status + " " + xhr.statusText);
			}
		});
		$('#overlay').fadeIn();
		$('#dialogboxholder').fadeIn().delay(1000).queue(function (next) {
			$('#dialogboxholder').css("top", "20px");
			next();
		});
}
function editRow(code,action,fill) {
	var href = ''+root+'edit_shifts.php?code='+code+'&action='+action+'&filled='+fill;
	var dbh_l = $("#dialogboxholder").length;
	if (dbh_l < 1){
		$("#formarray").after("<div id='dialogboxholder'></div>");
	}
			$('#dialogboxholder').load(href, function( response, status, xhr ) {
			  if ( status == "error" ) {
				var full = xhr.status + " " + xhr.statusText;
				puno("full","error");
			  }
// Do Nothing
			  });
			  $('#overlay').fadeIn();
			  $('#dialogboxholder').fadeIn().delay(1000).queue(function (){
				  $('#tab_holder').css("width", "500px");
			  }
			  );

    };
function unfillRow(code,action) {
	var href = ''+root+'edit_shifts.php?code='+code+'&action='+action;
	var dbh_l = $("#dialogboxholder").length;
	if (dbh_l < 1){
		$("#formarray").after("<div id='dialogboxholder'></div>");
	}
			$('#dialogboxholder').load(href, function( response, status, xhr ) {
			  if ( status == "error" ) {
				var full = xhr.status + " " + xhr.statusText;
				puno("full","error");
			  }
// Do Nothing
			  });
			  $('#overlay').fadeIn();
			  $('#dialogboxholder').fadeIn().delay(1000).queue(function (){
				  $('#tab_holder').css("width", "500px");
			  }
			  );

    };
function fillRow(code,action) {
	var href = ''+root+'edit_shifts.php?code='+code+'&action='+action;
	var dbh_l = $("#dialogboxholder").length;
	if (dbh_l < 1){
		$("#formarray").after("<div id='dialogboxholder'></div>");
	}
			$('#dialogboxholder').load(href, function( response, status, xhr ) {
			  if ( status == "error" ) {
				var full = xhr.status + " " + xhr.statusText;
				puno("full","error");
			  }
			  else {
// Do Nothing
			  	}
			  });
			  $('#overlay').fadeIn();
			  $('#dialogboxholder').fadeIn().delay(1000).queue(function (){
				  $('#tab_holder').css("width", "500px");
			  }
			  );

    };
function fillWA(code,euid,bypass) {
	var href = ''+root+'edit_shifts.php?code='+code+'&action=fill&euid='+euid+'&widget=1&bp='+bypass;
	var dbh_l = $("#dialogboxholder").length;
	if (dbh_l < 1){
		$("#formarray").after("<div id='dialogboxholder'></div>");
	}
			$('#dialogboxholder').load(href, function( response, status, xhr ) {
			  if ( status == "error" ) {
				var full = xhr.status + " " + xhr.statusText;
				puno("full","error");
			  }
			  else {
// Do Nothing
			  	}
			  });
			  $('#overlay').fadeIn();
			  $('#dialogboxholder').fadeIn().delay(1000).queue(function (){
				  $('#tab_holder').css("width", "500px");
			  }
			  );

    };
function cancelRow(code,action) {
	var href = ''+root+'edit_shifts.php?code='+code+'&action='+action;
	var dbh_l = $("#dialogboxholder").length;
	if (dbh_l < 1){
		$("#formarray").after("<div id='dialogboxholder'></div>");
	}
			$('#dialogboxholder').load(href, function( response, status, xhr ) {
			  if ( status == "error" ) {
				var msg = "Sorry but there was an error: ";
				$( "#error" ).html( msg + xhr.status + " " + xhr.statusText );
			  }
			  else {
				  $("#holder").mCustomScrollbar("update");
			  	}
			  });
			  $('#overlay').fadeIn();
			  $('#dialogboxholder').fadeIn().delay(1000).queue(function (){
				  $('#tab_holder').css("width", "500px");
			  }
			  );

    };
function deleteRow(code) {
        var proceed = true;
        if (proceed) {
            post_data = {'code': code};
            $.post(''+root+'DeletePush.php', post_data, function (response) {
                if (response.type == 'error') {
                    presp = 'error';
					pmsg  = '' + response.text + '';
                } else {
                    presp = 'success';
					pmsg  = '' + response.text + '';
                }
                if (response.type == 'error') {
				puno(""+pmsg+"",""+presp+"");
				}
				else {
				    refreshTable();
				puno(""+pmsg+"",""+presp+"");				
				}
            }, 'json');
        }
    };
$(document).ready(function(){	
$("a.pl-t").click(function(event){
    event.preventDefault();
    var lhref = $(this).attr("href");
    var ltitle = $(this).data("title");
    var lhref = lhref.replace("#","");
    history.pushState(null, ""+ltitle+"", ""+lhref+"");
	document.title = ""+ltitle+"";
});
var guts, guts2, guts3;

var Click =	$("#click").click(function (){
		guts = $('#guts').css('display');
		guts2 = $('#guts2').css('display');
		guts3 = $('#guts3').css('display');
		$("#guts").slideToggle("fast");
		if (guts2 == 'block') {
			$("#guts2").slideToggle("fast");
		}
		if (guts3 == 'block') {
			$("#guts3").slideToggle("fast");
		}
		$(this).addClass("active").siblings('.active').removeClass('active');
	});
var Click2 =	$("#click2").click(function(){
		guts = $('#guts').css('display');
		guts2 = $('#guts2').css('display');
		guts3 = $('#guts3').css('display');
		$("#guts2").slideToggle("fast");
		if (guts == 'block') {
			$("#guts").slideToggle("fast");
		}
		if (guts3 == 'block') {
			$("#guts3").slideToggle("fast");
		}
		$(this).addClass("active").siblings('.active').removeClass('active');
	});
var Click3 =	$("#click3").click(function(){
		guts = $('#guts').css('display');
		guts2 = $('#guts2').css('display');
		$("#guts3").slideToggle("fast");
		if (guts == 'block') {
			$("#guts").slideToggle("fast");
		}
		if (guts2 == 'block') {
			$("#guts2").slideToggle("fast");
		}
		$(this).addClass("active").siblings('.active').removeClass('active');
  });
$("#home").click(function(){
		jax();
		if (typeof Employees != 'undefined'){
		clearInterval(Employ);
		Employ = 'undefined';
		console.log ('Employee auto refresh stopped');
		}
		if (typeof Locations != 'undefined'){
		clearInterval(Locations);
		Locations = 'undefined';
		console.log ('Location auto refresh stopped');
		}
		if (typeof Shifts != 'undefined'){
		clearInterval(Shifts);
		Shifts = 'undefined';
		console.log ('Shift auto refresh stopped');
		}
		if (typeof Refresh != 'undefined'){
		clearInterval(Refresh);
		AutoRAlive = false;
		Refresh = 'undefined';
		console.log ('Home auto refresh stopped');
		}
		guts = $('#guts').css('display');
		guts2 = $('#guts2').css('display');
		guts3 = $('#guts3').css('display');
		$("#homeguts").slideToggle("fast");
		if (guts == 'block') {
			$("#guts").slideToggle("fast");
		}
		if (guts2 == 'block') {
			$("#guts2").slideToggle("fast");
		}
		if (guts3 == 'block') {
			$("#guts3").slideToggle("fast");
		}
		$(this).addClass("active").siblings('.active').removeClass('active');
		$('#content').load(''+root+'home.php', function( response, status, xhr ) {
			  if ( status == "error" ) {
				var msg = "Sorry but there was an error: ";
				$( "#error" ).html( msg + xhr.status + " " + xhr.statusText );
			  }
			  else {
				  	$('#loader').css("display", "none");
			  }
			  });
	});
$(".kb").click(function(){
		jax();
		if (typeof Employees != 'undefined'){
		clearInterval(Employ);
		Employ = 'undefined';
		console.log ('Employee auto refresh stopped');
		}
		if (typeof Locations != 'undefined'){
		clearInterval(Locations);
		Locations = 'undefined';
		console.log ('Location auto refresh stopped');
		}
		if (typeof Shifts != 'undefined'){
		clearInterval(Shifts);
		Shifts = 'undefined';
		console.log ('Shift auto refresh stopped');
		}
		if (typeof Refresh != 'undefined'){
		clearInterval(Refresh);
		AutoRAlive = false;
		Refresh = 'undefined';
		console.log ('Home auto refresh stopped');
		}
		guts = $('#guts').css('display');
		guts2 = $('#guts2').css('display');
		guts3 = $('#guts3').css('display');
		$("#homeguts").slideToggle("fast");
		if (guts == 'block') {
			$("#guts").slideToggle("fast");
		}
		if (guts2 == 'block') {
			$("#guts2").slideToggle("fast");
		}
		if (guts3 == 'block') {
			$("#guts3").slideToggle("fast");
		}
		$(this).addClass("active").siblings('.active').removeClass('active');
		$('#content').load(''+root+'getting_started.php', function( response, status, xhr ) {
			  if ( status == "error" ) {
				var msg = "Sorry but there was an error: ";
				$( "#error" ).html( msg + xhr.status + " " + xhr.statusText );
			  }
			  else {
				  	$('#loader').css("display", "none");
			  }
			  });
	});
$("#settings").click(function(){
		jax();
		if (typeof Employees != 'undefined'){
		clearInterval(Employ);
		Employ = 'undefined';
		console.log ('Employee auto refresh stopped');
		}
		if (typeof Locations != 'undefined'){
		clearInterval(Locations);
		Locations = 'undefined';
		console.log ('Location auto refresh stopped');
		}
		if (typeof Shifts != 'undefined'){
		clearInterval(Shifts);
		Shifts = 'undefined';
		console.log ('Shift auto refresh stopped');
		}
		if (typeof Refresh != 'undefined'){
		clearInterval(Refresh);
		AutoRAlive = false;
		Refresh = 'undefined';
		console.log ('Home auto refresh stopped');
		}
		guts = $('#guts').css('display');
		guts2 = $('#guts2').css('display');
		guts3 = $('#guts3').css('display');
		$("#homeguts").slideToggle("fast");
		if (guts == 'block') {
			$("#guts").slideToggle("fast");
		}
		if (guts2 == 'block') {
			$("#guts2").slideToggle("fast");
		}
		if (guts3 == 'block') {
			$("#guts3").slideToggle("fast");
		}
		$(this).addClass("active").siblings('.active').removeClass('active');
		$('#content').load(''+root+'settings.php', function( response, status, xhr ) {
			  if ( status == "error" ) {
				var msg = "Sorry but there was an error: ";
				$( "#error" ).html( msg + xhr.status + " " + xhr.statusText );
			  }
			  else {
				  	$('#loader').css("display", "none");
			  }
			  });
	});
$("#loader").click(function(){$(this).css("display","none");});
	$("#locations").click(function(){
		jax();
		if (typeof Employees != 'undefined'){
		clearInterval(Employ);
		Employ = 'undefined';
		console.log ('Employee auto refresh stopped');
		}
		if (typeof Locations != 'undefined'){
		clearInterval(Locations);
		Locations = 'undefined';
		console.log ('Location auto refresh stopped');
		}
		if (typeof Shifts != 'undefined'){
		clearInterval(Shifts);
		Shifts = 'undefined';
		console.log ('Shift auto refresh stopped');
		}
		if (typeof Refresh != 'undefined'){
		clearInterval(Refresh);
		AutoRAlive = false;
		Refresh = 'undefined';
		console.log ('Home auto refresh stopped');
		}
		$('#content').load(''+root+'locations.php', function( response, status, xhr ) {
			  if ( status == "error" ) {
				var msg = "Sorry but there was an error: ";
				$( "#error" ).html( msg + xhr.status + " " + xhr.statusText );
			  }
			  });
	});
	$("#newlocation").click(function(){
		jax();
		$('#formarray').fadeIn();
		$('#overlay').fadeIn();
		$('#formarray').load(''+root+'NewL.php', function( response, status, xhr ) {
			  if ( status == "error" ) {
				var msg = "Sorry but there was an error: ";
				$( "#error" ).html( msg + xhr.status + " " + xhr.statusText );
			  }
			  else {
				  $('#loader').css("display", "none");
				  $("#holder").mCustomScrollbar("update");
			  }
			  });
	});
	$("#employees").click(function(){
		jax();
		if (typeof Locations != 'undefined'){
		clearInterval(Locations);
		Locations = 'undefined';
		console.log ('Location auto refresh stopped');
		}
		if (typeof Shifts != 'undefined'){
		clearInterval(Shifts);
		Shifts = 'undefined';
		console.log ('Shift auto refresh stopped');
		}
		if (typeof Refresh != 'undefined'){
		clearInterval(Refresh);
		AutoRAlive = false;
		Refresh = 'undefined';
		console.log ('Home auto refresh stopped');
		}
		$('#content').load(''+root+'employees.php', function( response, status, xhr ) {
			  if ( status == "error" ) {
				var msg = "Sorry but there was an error: ";
				$( "#error" ).html( msg + xhr.status + " " + xhr.statusText );
			  } else {
					$('#loader').css("display", "none"); 
			  }
			  });
	});
	$("#shifts").click(function(){
		jax();
		if (typeof Employees != 'undefined'){
		clearInterval(Employ);
		Employ = 'undefined';
		console.log ('Employee auto refresh stopped');
		}
		if (typeof Locations != 'undefined'){
		clearInterval(Locations);
		Locations = 'undefined';
		console.log ('Location auto refresh stopped');
		}
		if (typeof Shifts != 'undefined'){
		clearInterval(Shifts);
		Shifts = 'undefined';
		console.log ('Shift auto refresh stopped');
		}
		if (typeof Refresh != 'undefined'){
		clearInterval(Refresh);
		AutoRAlive = false;
		Refresh = 'undefined';
		console.log ('Home auto refresh stopped');
		}
		$('#content').load(''+root+'shifts.php', function( response, status, xhr ) {
			  if ( status == "error" ) {
				var msg = "Sorry but there was an error: ";
				$( "#error" ).html( msg + xhr.status + " " + xhr.statusText );
			  }
			  });
	});
	$("#newemployee").click(function(){
		jax();
		$('#overlay').fadeIn();
		$('#formarray').load(''+root+'NewE.php', function( response, status, xhr ) {
			  if ( status == "error" ) {
				var msg = "Sorry but there was an error: ";
				$( "#error" ).html( msg + xhr.status + " " + xhr.statusText );
			  }
			  else {
				  $("#holder").mCustomScrollbar("update");
			  }
			  });
		$('#formarray').fadeIn();
	});
	$("#payroll").click(function(){
		jax();
		$('#overlay').fadeIn();
		$(this).addClass("active").siblings('.active').removeClass('active');
		$('#overlay').after("<div class='dialog_holder' style='display:none;'></div>");
		$('.dialog_holder').load(''+root+'dialog.php?action=payroll');
		$('.dialog_holder').fadeIn();
	});
	$("#overlay").click(function(){
		if (typeof TimeUpdater != 'undefined'){
		clearInterval(TimeUpdater);
		TimeUpdater = 'undefined';
		}
		$('#formarray').fadeOut().html("");
		$('#overlay').fadeOut();
		$('#dialogboxholder').fadeOut().delay(3000).queue(function () {
					$(this).html('');
					$(this).remove();
				}).dequeue();
		$('#v_cal').slideUp().delay(1000).queue(function(){$(this).html("").dequeue()});
		$('#widget_ep').slideUp().delay(1000).queue(function(){$(this).html("").dequeue()});
	});
	$("#staff").click(function(){
		jax();
		$('#content').load(''+root+'screate.php', function( response, status, xhr ) {
			  if ( status == "error" ) {
				var msg = "Sorry but there was an error: ";
				$( "#error" ).html( msg + xhr.status + " " + xhr.statusText );
			  }
			  });
	});
});
function logout()
{
  if (confirm('Are you sure you want to log out?'))
    location.href = "../logout";
}
/* 
$(document).ready(function (){
	var path = window.location.hash;
	var pathname = window.location.pathname;
	if ((pathname+path==='/main#/Home') || (pathname+path==='/Home')){
				$('#content').load(''+root+'home.php', function( response, status, xhr ) {
			  if ( status == "error" ) {
				var msg = "Sorry but there was an error: ";
				$( "#error" ).html( msg + xhr.status + " " + xhr.statusText );
			  }
			  });
		guts = $('#guts').css('display');
		guts2 = $('#guts2').css('display');
		guts3 = $('#guts3').css('display');
		if (guts2 == 'block') {
			$("#guts").slideToggle("fast");
		}
		if (guts3 == 'block') {
			$("#guts3").slideToggle("fast");
		}
		$("#home").addClass("active").siblings('.active').removeClass('active');
	}
	if ((pathname+path==='/main#/Locations/List') || (pathname+path==='/Locations/List')){
		jax();
				$('#content').load(''+root+'locations.php', function( response, status, xhr ) {
			  if ( status == "error" ) {
				var msg = "Sorry but there was an error: ";
				$( "#error" ).html( msg + xhr.status + " " + xhr.statusText );
			  }
			  });
		guts = $('#guts').css('display');
		guts2 = $('#guts2').css('display');
		guts3 = $('#guts3').css('display');
		$("#guts2").slideToggle("fast");
		if (guts == 'block') {
			$("#guts").slideToggle("fast");
		}
		if (guts3 == 'block') {
			$("#guts3").slideToggle("fast");
		}
		$("#click2").addClass("active").siblings('.active').removeClass('active');
	}
	if ((pathname+path==='/main#/Staff/List') || (pathname+path==='/Staff/List')){
		jax();		
			$('#content').load(''+root+'employees.php', function( response, status, xhr ) {
			  if ( status == "error" ) {
				var msg = "Sorry but there was an error: ";
				$( "#error" ).html( msg + xhr.status + " " + xhr.statusText );
			  }
			  });
		guts = $('#guts').css('display');
		guts2 = $('#guts2').css('display');
		guts3 = $('#guts3').css('display');
		$("#guts").slideToggle("fast");
		if (guts == 'block') {
			$("#guts2").slideToggle("fast");
		}
		if (guts3 == 'block') {
			$("#guts3").slideToggle("fast");
		}
		$("#click").addClass("active").siblings('.active').removeClass('active');
	}
	if ((pathname+path==='/main#/Staff/Log') || (pathname+path==='/Staff/Log')){
		jax();
			$('#content').load(''+root+'shifts.php', function( response, status, xhr ) {
			  if ( status == "error" ) {
				var msg = "Sorry but there was an error: ";
				$( "#error" ).html( msg + xhr.status + " " + xhr.statusText );
			  }
			  });
		guts = $('#guts').css('display');
		guts2 = $('#guts2').css('display');
		guts3 = $('#guts3').css('display');
		$("#guts").slideToggle("fast");
		if (guts == 'block') {
			$("#guts2").slideToggle("fast");
		}
		if (guts3 == 'block') {
			$("#guts3").slideToggle("fast");
		}
		$("#click").addClass("active").siblings('.active').removeClass('active');
	}

})
*/