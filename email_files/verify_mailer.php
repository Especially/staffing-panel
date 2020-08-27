<html>
<head>
<style>
html, body {
margin: 0;
padding: 0;
background-attachment: fixed;
background-position: 50% 50%;
background-size: cover;
}
#email{ 
margin: 0;
outline: none;
box-shadow: 0 0 20px rgba(0,0,0,.3);
font: 13px/1.55 'Open Sans', Helvetica, Arial, sans-serif;
color: #666;
max-width: 450px;
margin: 0 auto;
padding: 40px;
}
.bg-purple {
background-image: url(../img/misc/NewLocation.jpg);
}
#email legend{
display: block;
padding: 20px 30px;
border-bottom: 1px solid rgba(0,0,0,.1);
background: rgba(22, 21, 21, 0.9);
font-size: 25px;
font-weight: 300;
color: #FFFFFF;
box-shadow: 0 0 20px rgba(255, 255, 255, 0.3);
outline: none;
}
#email fieldset{
display: block;
padding: 25px 30px 5px;
border: none;
background: rgba(255,255,255,.9);
}
#email label{display: block; margin-bottom:5px;overflow:hidden;}
#email label span{float:left; width:150px; color:#666666;}
#email input{height: 25px; border: 1px solid #DBDBDB; border-radius: 3px; padding-left: 4px; color: #666; width: 180px; font-family: Arial, Helvetica, sans-serif;}
#email textarea{border: 1px solid #DBDBDB; border-radius: 3px; padding-left: 4px;color: #666; height:100px; width: 180px; font-family: Arial, Helvetica, sans-serif;}
/*(.submit_btn { border: 1px solid #D8D8D8; padding: 5px 15px 5px 15px; color: #8D8D8D; text-shadow: 1px 1px 1px #FFF; border-radius: 3px; background: #F8F8F8;}
.submit_btn:hover { background: #ECECEC;} */
.success{ background: #CFFFF5;padding: 10px; margin-bottom: 10px; border: 1px solid #B9ECCE; border-radius: 5px; font-weight: normal; }
.error{ background: #FFDFDF; padding: 10px; margin-bottom: 10px; border: 1px solid #FFCACA; border-radius: 5px; font-weight: normal;}
.submit_btn{
  width:100%;
  padding:15px;
  background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#000000), to(#636363));
  background-image: -webkit-linear-gradient(#000000 0%, #636363 100%);
  background-image: -moz-linear-gradient(#000000 0%, #636363 100%);
  background-image: -o-linear-gradient(#000000 0%, #636363 100%);
  background-image: linear-gradient(#000000 0%, #636363 100%);
  color:#FFF;
  text-transform:uppercase;
  text-shadow:#000 0px 1px 5px;
  border:1px solid #000;
  opacity:0.7;
	-webkit-box-shadow: 0 8px 6px -6px rgba(0,0,0,0.7);
  -moz-box-shadow: 0 8px 6px -6px rgba(0,0,0,0.7);
	box-shadow: 0 8px 6px -6px rgba(0,0,0,0.7);
  border-top:1px solid #000)!important;
  -webkit-box-reflect: below 0px -webkit-gradient(linear, left top, left bottom, from(transparent), color-stop(50%, transparent), to(rgba(255,255,255,0.2)));
}
.submit_btn:hover{
  opacity:1;
  cursor:pointer;
}
#email .input input,
#email .select,
#email .textarea textarea,
#email .radio i,
#email .checkbox i,
#email .toggle i,
#email .icon-append,
#email .icon-prepend {
	border-color: #e5e5e5;
	transition: border-color 0.3s;
	-o-transition: border-color 0.3s;
	-ms-transition: border-color 0.3s;
	-moz-transition: border-color 0.3s;
	-webkit-transition: border-color 0.3s;
}
#email .toggle i:before {
	background-color: #2da5da;	
}
#email .rating label {
	color: #ccc;
	transition: color 0.3s;
	-o-transition: color 0.3s;
	-ms-transition: color 0.3s;
	-moz-transition: color 0.3s;
	-webkit-transition: color 0.3s;
}


/**/
/* hover state */
/**/
#email .input:hover input,
#email .select:hover select,
#email .textarea:hover textarea,
#email .radio:hover i,
#email .checkbox:hover i,
#email .toggle:hover i {
	border-color: #8dc9e5;
}
#email .rating input + label:hover,
#email .rating input + label:hover ~ label {
	color: #2da5da;
}
#email .button:hover {
	opacity: 1;
}


/**/
/* focus state */
/**/
#email .input input:focus,
#email .select select:focus,
#email .textarea textarea:focus,
#email .radio input:focus + i,
#email .checkbox input:focus + i,
#email .toggle input:focus + i {
	border-color: #2da5da;
}


/**/
/* checked state */
/**/
#email .radio input + i:after {
	background-color: #2da5da;	
}
#email .checkbox input + i:after {
	color: #2da5da;
}
#email .radio input:checked + i,
#email .checkbox input:checked + i,
#email .toggle input:checked + i {
	border-color: #2da5da;	
}
#email .rating input:checked ~ label {
	color: #2da5da;	
}
* {
-webkit-user-select: none;
-khtml-user-select: none;
-moz-user-select: -moz-none;
-ms-user-select: none;
-o-user-select: none;
user-select: none;
}
.click {display: block;
padding: 1em;
border-top: 1px solid rgba(255, 255, 255, .08);
border-bottom: 1px solid rgba(0, 0, 0, .4);
background-color: rgb(32, 30, 30);
-webkit-transition: all 0.4s, ease-in-out;
transition: all 0.4s ease-in-out;color:white;font-weight:bold;}
.click:hover {display: block;
padding: 1em;
border-top: 1px solid rgba(255, 255, 255, .08);
border-bottom: 1px solid rgba(0, 0, 0, 0);
background-color: rgba(32, 30, 30,0.2);
-webkit-transition: all 0.4s ease-in-out;
transition: all 0.4s ease-in-out;
color: white;}
.credit {
color:white;
font-family: Arial, Helvetica, sans-serif;
}
#logo {
background-image: url(../img/brand/iLogo.png);
background-size:50px;
background-position: center;
background-repeat: no-repeat;
position: relative;
height: 60px;
width:60px;
}
</style>
</head>
<body>
    <div style='background-image: url(../img/misc/NewLocation.jpg);margin: 0;padding: 0;background-attachment: fixed;background-position: 50% 50%;background-size: cover;'>
<div id='email'>
    <fieldset>
    <legend>Verify Your Email</legend>
    				Hello $name,<br><br>
				You're receiving this email because you have registered the account <b>$login</b>. In order to verify your account, please click the link following this message. If you did not register, please disregard this email.<br><br>
				<center><a class='click' href='http://staffingpanel.x10.mx/verification.php?ticket=$vcode'>Click Here To Verify</a></center><br>
    </fieldset>
    </div>
    <center><div class='credit'> This email was powered by Project Humming Bird</div></center>
    <center><div id='logo'></div></center>
    </div>
</body>
</html>