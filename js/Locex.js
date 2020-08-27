// JavaScript Document
function locex(){
place = (location.pathname).split("/");
ar1 = ["","Home","Staff","Locations","New","Payroll","KB","Account","Payroll"];
ar2 = ["","List","Log","Employee","Location","Settings"];
ar3 = ["","Profile","Calendar"];
// Home
	if (place[1] == ar1[1]){
			$('#content').load(''+root+'home.php', function( response, status, xhr ) {
			  if ( status == "error" ) {
				var msg = "Sorry but there was an error: ";
				$( "#error" ).html( msg + xhr.status + " " + xhr.statusText );
			  }
			 });
	}
// Staff
	if (place[1] == ar1[2]){
		console.log("Location: Staff");
		//Staff Sidebar
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
				$("#click").addClass("active").siblings('.active').removeClass('active');
		//Load Page
				$('#content').load(''+root+'employees.php', function( response, status, xhr ) {
					  if ( status == "error" ) {
						var msg = "Sorry but there was an error: ";
						$( "#error" ).html( msg + xhr.status + " " + xhr.statusText );
					  }
					  else {
							$('#loader').css("display", "none");
					  }
					  });
		if(place[2] == ar2[1]){
			console.log("Location: Staff List");
			if(place[3] == ar3[1]){
				var euid = place[4];
				console.log("Location: Staff List - Profile ID: "+euid);
				profile(euid);
			}
		}
		if(place[2] == ar2[2]){
			console.log("Location: Staff Log");
		//Load Page
				$('#content').load(''+root+'shifts.php', function( response, status, xhr ) {
					  if ( status == "error" ) {
						var msg = "Sorry but there was an error: ";
						$( "#error" ).html( msg + xhr.status + " " + xhr.statusText );
					  }
					  else {
							$('#loader').css("display", "none");
					  }
					  });
		}
	}
// Locations
	if (place[1] == ar1[3]){
		console.log("Location: Locations");
		// Locations Sidebar
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
		// Locations Load
				$('#content').load(''+root+'locations.php', function( response, status, xhr ) {
					  if ( status == "error" ) {
						var msg = "Sorry but there was an error: ";
						$( "#error" ).html( msg + xhr.status + " " + xhr.statusText );
					  } else {
							$('#loader').css("display", "none"); 
					  }
					  });
		if(place[2] == ar2[1]){
			console.log("Location: Location List");
			if(place[3] == ar3[2]){
				var cid = place[4];
				console.log("Location: Location List - Calendar ID: "+cid);
				viewCal(cid);
			}
		}
	}
// Knowledge Base
	if (place[1] == ar1[6]){
		console.log("Location: Knowledge Base");
				$("#click3").addClass("active").siblings('.active').removeClass('active');
		// KB Load
				$('#content').load(''+root+'getting_started.php', function( response, status, xhr ) {
					  if ( status == "error" ) {
						var msg = "Sorry but there was an error: ";
						$( "#error" ).html( msg + xhr.status + " " + xhr.statusText );
					  } else {
							$('#loader').css("display", "none"); 
					  }
					  });
	}
// Account Settings Base
	if (place[1] == ar1[7]){
		console.log("Location: Account");
				$("#settings").addClass("active").siblings('.active').removeClass('active');
		// KB Load
				$('#content').load(''+root+'settings.php', function( response, status, xhr ) {
					  if ( status == "error" ) {
						var msg = "Sorry but there was an error: ";
						$( "#error" ).html( msg + xhr.status + " " + xhr.statusText );
					  } else {
							$('#loader').css("display", "none"); 
					  }
					  });
	}
// Account Settings Base
	if (place[1] == ar1[8]){
		console.log("Location: Payroll");
		$("#payroll").addClass("active").siblings('.active').removeClass('active');
		// Payroll Query Load
		$('#overlay').fadeIn();
		$('#overlay').after("<div class='payroll_holder' style='display:none;'></div>");
		$('.payroll_holder').load(''+root+'dialog.php?action=payroll');
		$('.payroll_holder').fadeIn();
	}

}
$(document).ready( function(){
	locex();
});

/*
eval(function(p,a,c,k,e,d){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--){d[e(c)]=k[c]||e(c)}k=[function(e){return d[e]}];e=function(){return'\\w+'};c=1};while(c--){if(k[c]){p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c])}}return p}('$(S).12(o(){8=(11.X).Y("/");p=["","Z","m","O","13","U","W","V"];z=["","n","N","T","9","10"];H=["","K","L"];0(8[1]==p[1]){$(\'#t\').v(\'\'+w+\'15.s\',o(r,7,5){0(7=="6"){k d="q u y C D 6: ";$("#6").B(d+5.7+" "+5.A)}})}0(8[1]==p[2]){e.f("9: m");g=$(\'#g\').a(\'b\');h=$(\'#h\').a(\'b\');c=$(\'#c\').a(\'b\');$("#g").l("j");0(h==\'x\'){$("#h").l("j")}0(c==\'x\'){$("#c").l("j")}$("#1a").Q("i").P(\'.i\').R(\'i\');$(\'#t\').v(\'\'+w+\'1b.s\',o(r,7,5){0(7=="6"){k d="q u y C D 6: ";$("#6").B(d+5.7+" "+5.A)}J{$(\'#G\').a("b","E")}});0(8[2]==z[1]){e.f("9: m n");0(8[3]==H[1]){k F=8[4];e.f("9: m n - K M: "+F);19(F)}}0(8[2]==z[2]){e.f("9: m N");$(\'#t\').v(\'\'+w+\'17.s\',o(r,7,5){0(7=="6"){k d="q u y C D 6: ";$("#6").B(d+5.7+" "+5.A)}J{$(\'#G\').a("b","E")}})}}0(8[1]==p[3]){e.f("9: O");g=$(\'#g\').a(\'b\');h=$(\'#h\').a(\'b\');c=$(\'#c\').a(\'b\');$("#h").l("j");0(g==\'x\'){$("#g").l("j")}0(c==\'x\'){$("#c").l("j")}$("#18").Q("i").P(\'.i\').R(\'i\');$(\'#t\').v(\'\'+w+\'14.s\',o(r,7,5){0(7=="6"){k d="q u y C D 6: ";$("#6").B(d+5.7+" "+5.A)}J{$(\'#G\').a("b","E")}});0(8[2]==z[1]){e.f("9: 9 n");0(8[3]==H[2]){k I=8[4];e.f("9: 9 n - L M: "+I);16(I)}}}});',62,74,'if|||||xhr|error|status|place|Location|css|display|guts3|msg|console|log|guts|guts2|active|fast|var|slideToggle|Staff|List|function|ar1|Sorry|response|php|content|but|load|root|block|there|ar2|statusText|html|was|an|none|euid|loader|ar3|cid|else|Profile|Calendar|ID|Log|Locations|siblings|addClass|removeClass|document|Employee|Payroll|Account|KB|pathname|split|Home|Settings|location|ready|New|locations|home|viewCal|shifts|click2|profile|click|employees'.split('|'),0,{}))
*/