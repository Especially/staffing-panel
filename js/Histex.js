// JavaScript Document
$(document).ready(function(){
// Push Shift Location
	$("a.psl-t").click(function(event){
		event.preventDefault();
		var lhref = $(this).attr("href");
		var ltitle = $(this).data("shift-title");
		history.pushState(null, ""+ltitle+"", ""+lhref+"");
		document.title = ""+ltitle+"";
	});
// Push Employee Location	
	$("a.pel-t").click(function(event){
		event.preventDefault();
		var lhref = $(this).attr("href");
		var ltitle = $(this).data("profile-title");
		history.pushState(null, ""+ltitle+"", ""+lhref+"");
		document.title = ""+ltitle+"";
	});
// Push Location Location
	$("a.pll-t").click(function(event){
		event.preventDefault();
		var lhref = $(this).attr("href");
		var ltitle = $(this).data("calendar-title");
		history.pushState(null, ""+ltitle+"", ""+lhref+"");
//		document.title = ""+ltitle+"";
	});
});