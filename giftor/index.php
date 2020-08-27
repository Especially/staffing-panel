<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Giftor</title>
<style>
#g_login {
    margin: auto auto;
    position: relative;
    padding-left: 25%;	
}
.g_login {
	padding:8px;
	margin:3px;
	background-color:#fff;
	border:1px solid #ADADAD;
	border-radius:5px;
	width: 227px;	
}
.g_login input {
	border:none;
	outline:none;
}
.g_login input:focus {
	border:none;
	outline:none;
}
.email_login {
	background-image: url(./img/password_login.svg);
	float: left;
	background-color: #D2D2D2;
	height: 33.2px;
	width: 42px;
	margin-right: 3px;
	margin-top: -8px;
	margin-left: -8px;
	border-radius: 4px 3px 3px 4px;
	background-position: center;
	background-size: 35px;
	background-repeat: no-repeat;
}
.password_login {
	background-image: url(./img/email_login.svg);
	float: left;
	background-color: #D2D2D2;
	height: 33.2px;
	width: 42px;
	margin-right: 3px;
	margin-top: -8px;
	margin-left: -8px;
	border-radius: 4px 3px 3px 4px;
	background-position: center;
	background-size: 35px;
	background-repeat: no-repeat;
}
::-webkit-input-placeholder {
   font-style:italic;
}

:-moz-placeholder { /* Firefox 18- */
   font-style:italic;
}

::-moz-placeholder {  /* Firefox 19+ */
   font-style:italic; 
}

:-ms-input-placeholder {  
   font-style:italic;
}
</style>
<link rel="icon" href="./img/giftor.ico" type="image/x-icon" />
</head>

<body>
<div id="g_content" style="
    width: 100%;
    height: 100%;
">
<div id="g_holder" style="
    position: relative;
    margin: auto auto;
    width: 500px;
    height: 500px;
    border-radius: 10px;
    background-color: rgb(228, 229, 231);
                          "><div id="g_logo" style="
    margin: auto;
    position: relative;
    height: 300px;
    width: 300px;
    background-image: url(./img/giftor.svg);
    background-repeat: no-repeat;
	background-size: 100%;
"></div>
  <div id="g_login"><form><div class="g_login"><div class="email_login"></div><input type="text" placeholder="Username or Email..."></div><div class="g_login"><div class="password_login"></div><input type="password" placeholder="***********"></div></form></div>
  
  </div></div>
</body>
</html>