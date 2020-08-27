<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Giftor Landing Page</title>

<style>
#g_content {
	border-radius:5px;
	padding:10px;
	border:1px solid rgb(212, 212, 212);
	box-shadow: 3px 3px 0px -1px grey;
	height: 600px;
	margin: 20px 40px 20px 40px;
}
.g_menu_ribbon {
 font-size: 16px !important;
 /* This ribbon is based on a 16px font side and a 24px vertical rhythm. I've used em's to position each element for scalability. If you want to use a different font size you may have to play with the position of the ribbon elements */

 width: 50%;
    
 position: relative;
 background: rgb(43, 57, 144);
 color: #fff;
 text-align: center;
 padding: 0.3em 2em; /* Adjust to suit */
}
.g_menu_ribbon:before, .g_menu_ribbon:after {
 content: "";
 position: absolute;
 display: block;
 bottom: -1em;
 border: 1.5em solid rgb(29, 39, 101);
 z-index: -1;
}
.g_menu_ribbon:before {
 left: -2em;
 border-right-width: 1.5em;
 border-left-color: transparent;
}
.g_menu_ribbon:after {
 right: -2em;
 border-left-width: 1.5em;
 border-right-color: transparent;
}
.g_menu_ribbon .g_menu_ribbon-content:before, .g_menu_ribbon .g_menu_ribbon-content:after {
 content: "";
 position: absolute;
 display: block;
 border-style: solid;
 border-color: rgb(22, 29, 75) transparent transparent transparent;
 bottom: -1em;
}
.g_menu_ribbon .g_menu_ribbon-content {
	border-top: 3px solid white;
	border-bottom: 3px solid white;
	width: 110%;
	margin-left: -32px;
	padding: 0px;
}
.g_menu_ribbon .g_menu_ribbon-content:before {
 left: 0;
 border-width: 1em 0 0 1em;
}
.g_menu_ribbon .g_menu_ribbon-content:after {
 right: 0;
 border-width: 1em 1em 0 0;
}
.g_non-semantic-protector { 
	position: absolute;
	z-index: 1;
	width: 1285px;
	margin-left: 24px;
}
.g_menu_ribbon ul {
    list-style: none;
    display: inline-block;
    padding: 0px;
    margin: 0px;
}
.g_menu_ribbon li {
    float:left;
	padding:5px;
}
.g_menu_ribbon a {
	color:white;
	text-decoration:none;
}
.g_menu_ribbon li:hover {
    float:left;
	padding:5px;
}
.g_menu_ribbon active {
    float:left;
	padding:5px;
}
</style>
</head>

<body>
<div class="g_non-semantic-protector"> 
	<h1 class="g_menu_ribbon">
   <div class="g_menu_ribbon-content"><ul><li><a href="/landing">Home</a></li><li><a href="/help">Help</a></li></ul></div>
	</h1>
</div>
    <div id="g_content">
    </div>

</body>
</html>