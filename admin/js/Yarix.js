// JavaScript Document
function profile(id) {
    var href = 'employee_profile?id=' + id;
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
    });

};
function viewCal(code) {
    var href = 'shifts_specific?location=' + code;
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
    var href = 'UpdatePlacEmploy.php?code=' + code + '&edit=' + action;
    jax();
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
$(document).ready(function(){	
var guts, guts2, guts3;

var Click =	$("#click").click(function(){
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
		$('#content').load('home.php', function( response, status, xhr ) {
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
		$(this).addClass("active").siblings('.active').removeClass('active');
		$('#content').load('kb_settings.php', function( response, status, xhr ) {
			  if ( status == "error" ) {
				var msg = "Sorry but there was an error: ";
				$( "#error" ).html( msg + xhr.status + " " + xhr.statusText );
			  }
			  else {
				  	$('#loader').css("display", "none");
			  }
			  });
	});
$(".nt").click(function(){
		jax();
		$(this).addClass("active").siblings('.active').removeClass('active');
		$('#content').load('nt_settings.php', function( response, status, xhr ) {
			  if ( status == "error" ) {
				var msg = "Sorry but there was an error: ";
				$( "#error" ).html( msg + xhr.status + " " + xhr.statusText );
			  }
			  else {
				  	$('#loader').css("display", "none");
			  }
			  });
	});
$(".us").click(function(){
		jax();
		$(this).addClass("active").siblings('.active').removeClass('active');
		$('#content').load('user_settings.php', function( response, status, xhr ) {
			  if ( status == "error" ) {
				var msg = "Sorry but there was an error: ";
				$( "#error" ).html( msg + xhr.status + " " + xhr.statusText );
			  }
			  else {
				  	$('#loader').css("display", "none");
			  }
			  });
	});
	$("#admin").click(function(){
		jax();
		$('#content').load('create.php', function( response, status, xhr ) {
			  if ( status == "error" ) {
				var msg = "Sorry but there was an error: ";
				$( "#error" ).html( msg + xhr.status + " " + xhr.statusText );
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
		Refresh = 'undefined';
		console.log ('Home auto refresh stopped');
		}
		$('#content').load('locations.php', function( response, status, xhr ) {
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
		$('#formarray').load('NewL.php', function( response, status, xhr ) {
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
		Refresh = 'undefined';
		console.log ('Home auto refresh stopped');
		}
		$('#content').load('employees.php', function( response, status, xhr ) {
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
		Refresh = 'undefined';
		console.log ('Home auto refresh stopped');
		}
		$('#content').load('shifts.php', function( response, status, xhr ) {
			  if ( status == "error" ) {
				var msg = "Sorry but there was an error: ";
				$( "#error" ).html( msg + xhr.status + " " + xhr.statusText );
			  }
			  });
	});
	$("#newemployee").click(function(){
		jax();
		$('#formarray').fadeIn();
		$('#overlay').fadeIn();
		$('#formarray').load('NewE.php', function( response, status, xhr ) {
			  if ( status == "error" ) {
				var msg = "Sorry but there was an error: ";
				$( "#error" ).html( msg + xhr.status + " " + xhr.statusText );
			  }
			  else {
				  $("#holder").mCustomScrollbar("update");
			  }
			  });
	});
	$("#overlay").click(function(){
		if (typeof TimeUpdater != 'undefined'){
		clearInterval(TimeUpdater);
		TimeUpdater = 'undefined';
		}
		$('#formarray').fadeOut().html("");
		$('#overlay').fadeOut().html("");
		$('#dialogboxholder').fadeOut().html("");
		$('#v_cal').slideUp().delay(1000).queue(function(){$(this).html("").dequeue()});
		$('#widget_ep').slideUp().delay(1000).queue(function(){$(this).html("").dequeue()});
	});
	$("#staff").click(function(){
		jax();
		$('#content').load('screate.php', function( response, status, xhr ) {
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
$(document).ready(function(){
		jax();
	var path = window.location.hash;
	var pathname = window.location.pathname;	
	if (pathname+path==='/main#/Home'){
				$('#content').load('home.php', function( response, status, xhr ) {
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
	if (pathname+path==='/main#/Locations/List'){
		jax();
				$('#content').load('locations.php', function( response, status, xhr ) {
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
	if (pathname+path==='/main#/Staff/List'){
		jax();		
			$('#content').load('employees.php', function( response, status, xhr ) {
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
	if (pathname+path==='/main#/Staff/Log'){
		jax();
			$('#content').load('shifts.php', function( response, status, xhr ) {
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