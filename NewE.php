<?php
	require_once('auth.php');
?>
<html>
<head>
<title>New Employee</title>
<?php 	require_once('includes.php'); ?>
<meta name="description" content="Robots rule.txt">
<style>
html, body {
margin: 0;
padding: 0;
background-attachment: fixed;
background-position: 50% 50%;
background-size: cover;
}
#Employee_form{ 
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
background-image: url(<../img/misc/NewEmployee.jpg);
}
#Employee_form legend{
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
#Employee_form fieldset{
display: block;
padding: 25px 30px 5px;
border: none;
background: rgba(255,255,255,.9);
}
#Employee_form label{display: block; margin-bottom:5px;overflow:hidden;}
#Employee_form label span{float:left; width:150px; color:#666666;}
#Employee_form input{height: 25px; border: 1px solid #DBDBDB; border-radius: 3px; padding-left: 4px; color: #666; width: 180px; font-family: Arial, Helvetica, sans-serif;}
#Employee_form textarea{border: 1px solid #DBDBDB; border-radius: 3px; padding-left: 4px;color: #666; height:100px; width: 180px; font-family: Arial, Helvetica, sans-serif;}
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
#Employee_form .input input,
#Employee_form .select,
#Employee_form .textarea textarea,
#Employee_form .radio i,
#Employee_form .checkbox i,
#Employee_form .toggle i,
#Employee_form .icon-append,
#Employee_form .icon-prepend {
	border-color: #e5e5e5;
	transition: border-color 0.3s;
	-o-transition: border-color 0.3s;
	-ms-transition: border-color 0.3s;
	-moz-transition: border-color 0.3s;
	-webkit-transition: border-color 0.3s;
}
#Employee_form .toggle i:before {
	background-color: #2da5da;	
}
#Employee_form .rating label {
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
#Employee_form .input:hover input,
#Employee_form .select:hover select,
#Employee_form .textarea:hover textarea,
#Employee_form .radio:hover i,
#Employee_form .checkbox:hover i,
#Employee_form .toggle:hover i {
	border-color: #8dc9e5;
}
#Employee_form .rating input + label:hover,
#Employee_form .rating input + label:hover ~ label {
	color: #2da5da;
}
#Employee_form .button:hover {

	opacity: 1;
}


/**/
/* focus state */
/**/
#Employee_form .input input:focus,
#Employee_form .select select:focus,
#Employee_form .textarea textarea:focus,
#Employee_form .radio input:focus + i,
#Employee_form .checkbox input:focus + i,
#Employee_form .toggle input:focus + i {
	border-color: #2da5da;
}


/**/
/* checked state */
/**/
#Employee_form .radio input + i:after {
	background-color: #2da5da;	
}
#Employee_form .checkbox input + i:after {
	color: #2da5da;
}
#Employee_form .radio input:checked + i,
#Employee_form .checkbox input:checked + i,
#Employee_form .toggle input:checked + i {
	border-color: #2da5da;	
}
#Employee_form .rating input:checked ~ label {
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
</style>
</head>
<body>
    <div id="holder" style="background-image: url(../img/misc/NewEmployee.jpg);margin: 0;
padding: 0;
background-attachment: fixed;
background-position: 50% 50%;
background-size: cover;">
<form id="Employee_form" action="javascript:void(0);">
    <fieldset>
    <legend>New Employee</legend>
    <div id="result"></div>
        <label for="fname"><span>First Name</span>
        <input type="text" name="fname" id="fname" placeholder="First Name" />
        </label>
        
        <label for="fname"><span>Surname</span>
        <input type="text" name="sname" id="sname" placeholder="Surname" />
        </label>
        
        <label for="gender"><span>Gender</span>
        <select id="gender" name="gender" class="select">
        	<option value="Female">Female</option>
        	<option value="Male">Male</option>
            <option value="Other">Other</option>
        </select>
        </label>
        
        <label for="positon"><span>Position</span>
        <select id="position" name="position" class="select">
        	<option value="RN">RN</option>
        	<option value="RPN">RPN</option>
            <option value="PSW" selected>PSW</option>
        </select>
        </label>
        
        <label for="subu"><span>Do they reside in an appartment/complex?</span>
        <input type="checkbox" name="subu" id="subu" class="checkbox1" style="height: 20px; float: left; margin-left: 0px; padding-left: 0px; text-align: left; width: 15px;" />
        </label>
        
        <div id="subloc" style="display:none;">
        <label for="type"><span>Unit/Appartment</span>
        <select id="type" name="type" class="select">
        	<option value="None">None</option>
        	<option value="Unit">Unit</option>
            <option value="Appt">Appartment</option>
        </select>
        </label>
        <label for="tnum"><span>Number</span>
        <input type="number" name="tnum" id="tnum" placeholder="If Unit 43, put 43" />
        </label>
        </div>
        
        <label for="street"><span>Street</span>
        <input type="text" name="street" id="street" placeholder="123 Address Lane" />
        </label>

        <label for="city"><span>City</span>
<select name="city" id="city" class="city">
							<option value="City">City</option>
							<optgroup class="main" label="Main cities"><option value="Barrie">Barrie</option><option value="Hamilton">Hamilton</option><option value="Kingston">Kingston</option><option value="London">London</option><option value="Mississauga">Mississauga</option><option value="Oakville">Oakville</option><option value="Oshawa">Oshawa</option><option value="Ottawa">Ottawa</option><option value="Sudbury">Sudbury</option><option value="Thunder Bay">Thunder Bay</option><option value="Toronto">Toronto</option><option value="Windsor">Windsor</option></optgroup>
							<optgroup class="all" label="All cities"><option value="Ajax">Ajax</option><option value="Arnprior">Arnprior</option><option value="Aurora">Aurora</option><option value="Barrie">Barrie</option><option value="Barry's Bay">Barry's Bay</option><option value="Belleville">Belleville</option><option value="Bowmanville">Bowmanville</option><option value="Bracebridge">Bracebridge</option><option value="Brampton">Brampton</option><option value="Brantford">Brantford</option><option value="Brockville">Brockville</option><option value="Burlington">Burlington</option><option value="Cambridge">Cambridge</option><option value="Casselman">Casselman</option><option value="Chelmsford">Chelmsford</option><option value="Cobourg">Cobourg</option><option value="Collingwood">Collingwood</option><option value="Cornwall">Cornwall</option><option value="Dundas">Dundas</option><option value="Etobicoke">Etobicoke</option><option value="Gananoque">Gananoque</option><option value="Georgetown">Georgetown</option><option value="Gloucester">Gloucester</option><option value="Guelph">Guelph</option><option value="Hamilton">Hamilton</option><option value="Huntsville">Huntsville</option><option value="Kanata">Kanata</option><option value="Kingston">Kingston</option><option value="London">London</option><option value="Markham">Markham</option><option value="Milton">Milton</option><option value="Mississauga">Mississauga</option><option value="Napanee">Napanee</option><option value="Nepean">Nepean</option><option value="Newmarket">Newmarket</option><option value="North Bay">North Bay</option><option value="North York">North York</option><option value="Oakville">Oakville</option><option value="Orangeville">Orangeville</option><option value="Orillia">Orillia</option><option value="Orleans">Orleans</option><option value="Oshawa">Oshawa</option><option value="Ottawa">Ottawa</option><option value="Owen Sound">Owen Sound</option><option value="Perth">Perth</option><option value="Peterborough">Peterborough</option><option value="Pickering">Pickering</option><option value="Picton">Picton</option><option value="Port Hope">Port Hope</option><option value="Renfrew">Renfrew</option><option value="Richmond Hill">Richmond Hill</option><option value="Sarnia">Sarnia</option><option value="Sault Ste. Marie">Sault Ste. Marie</option><option value="Scarborough">Scarborough</option><option value="South Porcupine">South Porcupine</option><option value="St. Catharines">St. Catharines</option><option value="St. Thomas">St. Thomas</option><option value="Stouffville">Stouffville</option><option value="Sturgeon Falls">Sturgeon Falls</option><option value="Sudbury">Sudbury</option><option value="Thunder Bay">Thunder Bay</option><option value="Tillsonburg">Tillsonburg</option><option value="Timmins">Timmins</option><option value="Toronto">Toronto</option><option value="Trenton">Trenton</option><option value="Val Caron">Val Caron</option><option value="Whitby">Whitby</option><option value="Windsor">Windsor</option><option value="Woodbridge">Woodbridge</option></optgroup>
						</select>
        </label>
        
        <label for="postal"><span>Postal Code</span>
        <input type="text" name="postal" id="postal" placeholder="X5X 5X5" onBlur="checkPostal(postal)" style="text-transform:uppercase;" />
        </label>
        
        <label for="phone"><span>Phone</span>
        <input type="text" name="number" id="number" placeholder="Phone Number"/>
        </label>
       
        <label for="alter"><span>Is there an alternate number?</span>
        <input type="checkbox" name="alter" id="alter" class="checkbox2" style="height: 20px; float: left; margin-left: 0px; padding-left: 0px; text-align: left; width: 15px;" />
        </label>
        <div id="alt" style="display:none;">
        <label for="alternate"><span>Alternate Phone</span>
        <input type="text" name="alternate" id="alternate" placeholder="Alternate Phone Number"/>
        </label>
        </div>
        
        
        <label for="majint"><span>Major Intersection</span>
        <input type="text" name="majint" id="majint" placeholder="S1/S2" />
        </label>
        
        <label for="add"><span>Any additional comments?</span>
        <input type="checkbox" name="add" id="add" class="checkbox3" style="height: 20px; float: left; margin-left: 0px; padding-left: 0px; text-align: left; width: 15px;" />
        </label>
        <div id="comm" style="display:none;">
        <label for="additional"><span>Comments</span>
        <textarea name="additional" id="additional" placeholder="Additional information... Use proper text formatting!"></textarea>
        </label>
        </div>
        
        <label><span>&nbsp;</span>
        <button id="verify" type="submit" class="submit_btn">Add Employee</button>
        </label>
    </fieldset>
    </form>
    </div>
	<script>
		(function($){
			$(window).load(function(){
				$("#holder").mCustomScrollbar({
					theme:"minimal"
				});
				
			});
		})(jQuery);
	</script>
    <script>
$(".checkbox1").click(function()  {
	subloc = $("#subloc").css('display');
	if (subloc == 'block'){
		$("#subloc").slideUp();
		$("input[name=tnum]").val('');
		$("#type").val('None');
	}
	if (subloc == 'none') {
		$("#subloc").slideDown();
	}
	});
$(".checkbox2").click(function()  {
	alter = $("#alt").css('display');
	if (alter == 'block'){
		$("#alt").slideUp();
		$("input[name=alternate]").val('');
	}
	if (alter == 'none') {
		$("#alt").slideDown();
	}
	});
$(".checkbox3").click(function()  {
	comm = $("#comm").css('display');
	if (comm == 'block'){
		$("#comm").slideUp();
	}
	if (comm == 'none') {
		$("#comm").slideDown();
	}
	});
	</script>
    <script>
	function checkPostal(postal) {
    var regex = new RegExp(/^[ABCEGHJKLMNPRSTVXY]\d[ABCEGHJKLMNPRSTVWXYZ]( )?\d[ABCEGHJKLMNPRSTVWXYZ]\d$/i);
	var outputin = '<div class="error">Invalid Postal Code</div>';
    if (regex.test(postal.value))
        $("#result").hide().html(outputin).slideUp();
    else 
		$("#result").hide().html(outputin).slideDown();
	}	
	</script>
    <script>
	$('input[type="text"]').keyup(function(evt){
    var txt = $(this).val();


    // Regex taken from php.js (http://phpjs.org/functions/ucwords:569)
    $(this).val(txt.replace(/^(.)|\s(.)/g, function($1){ return $1.toUpperCase( ); }));
});
</script>
<script>
/* FORMAT PHONE BEHAVIOR MASK */ 
function FormatPhone (e,input) { 
    /* to prevent backspace, enter and other keys from  
     interfering w mask code apply by attribute  
     onkeydown=FormatPhone(control) 
    */ 
    evt = e || window.event; /* firefox uses reserved object e for event */ 
    var pressedkey = evt.which || evt.keyCode; 
    var BlockedKeyCodes = new Array(8,27,13,9); //8 is backspace key 
    var len = BlockedKeyCodes.length; 
    var block = false; 
    var str = ''; 
    for (i=0; i<len; i++){ 
       str=BlockedKeyCodes[i].toString(); 
       if (str.indexOf(pressedkey) >=0 ) block=true;  
    } 
    if (block) return true; 

   s = input.value; 
   if (s.charAt(0) =='+') return false; 
   filteredValues = '"`!@#$%^&*()_+|~-=\QWERT YUIOP{}ASDFGHJKL:ZXCVBNM<>?qwertyuiop[]asdfghjkl;zxcvbnm,./\\\'';  
   var i; 
   var returnString = ''; 

   /* Search through string and append to unfiltered values  
      to returnString. */ 

   for (i = 0; i < s.length; i++) {  
         var c = s.charAt(i); 

         //11-Digit number format if leading number is 1

         if (s.charAt(0) == 1){
            if ((filteredValues.indexOf(c) == -1) & (returnString.length <  14 )) { 
                if (returnString.length==1) returnString +='('; 
                if (returnString.length==5) returnString +=')'; 
                if (returnString.length==6) returnString +='-'; 
                if (returnString.length==10) returnString +='-'; 
                returnString += c; 
            } 
         }

        //10-digit number format 
         else{
             if ((filteredValues.indexOf(c) == -1) & (returnString.length <  13 )) { 
                    if (returnString.length==0) returnString +='('; 
                    if (returnString.length==4) returnString +=')'; 
                    if (returnString.length==5) returnString +='-'; 
                    if (returnString.length==9) returnString +='-'; 
                    returnString += c; 
                }
         } 

    } 
   input.value = returnString; 

    return false}
        
 document.getElementById('number').onkeydown = function (e) { FormatPhone(e, this) }
  document.getElementById('alternate').onkeydown = function (e) { FormatPhone(e, this) }
</script>
<script type="text/javascript">
$(document).ready(function () {
    $("#verify").click(function () {
        //get input field values
        var fname = $('input[name=fname]').val();
		var sname = $('input[name=sname]').val();
		var gender = $('select[name=gender]').val();
		var position = $('select[name=position]').val();
		var result = $("#result").css('display');
        var check1 = $(".checkbox1").is(":checked");
		var check2 = $(".checkbox2").is(":checked");
		var check3 = $(".checkbox3").is(":checked");
        var type = $('select[name=type]').val();
        var tnum = $('input[name=tnum]').val();
        var number = $('input[name=number]').val();
        var alternate = $('input[name=alternate]').val();
        var street = $('input[name=street]').val();
        var postal = $('input[name=postal]').val();
        var city = $('select[name=city]').val();
        var majint = $('input[name=majint]').val();
        var comments = $('textarea[name=additional]').val();

        //simple validation at client's end
        //we simply change border color to red if empty field using .css()
        var proceed = true;
		if (result == "block") {
			proceed = false;
		}
        if (fname == "") {
            $('input[name=fname]').css('border-color', 'red');
            proceed = false;
        }
        if (sname == "") {
            $('input[name=sname]').css('border-color', 'red');
            proceed = false;
        }
        if (check1===true) {
            if (type==="None") {
                $('select[name=type]').css('border-color', 'red');
                proceed = false;
            }
            if (tnum == "") {
                $('input[name=tnum]').css('border-color', 'red');
                proceed = false;
            }
        }
        if (number == "") {
            $('input[name=number]').css('border-color', 'red');
            proceed = false;
        }
        if (check2===true) {
		        if(alternate=="") {                                             
                    $('input[name=alternate]').css('border-color','red'); 
                    proceed = false;
                }
		}
        if (street == "") {
            $('input[name=street]').css('border-color', 'red');
            proceed = false;
        }
        if (city==="City") {
            $('select[name=city]').css('border-color', 'red');
            proceed = false;
        }
        if (postal == "") {
            $('input[name=postal]').css('border-color', 'red');
            proceed = false;
        }
        if (city == "") {
            $('input[name=city]').css('border-color', 'red');
            proceed = false;
        }
        if (majint == "") {
            $('input[name=majint]').css('border-color', 'red');
            proceed = false;
        }
        if (check3===true) {
		        if(comments=="") {                                           
                    $('textarea[name=additional]').css('border-color','red'); 
                    proceed = false;
                }
		}

        //everything looks good! proceed...
        if (proceed) {
            //data to be sent to server
            post_data = {'fname': fname, 'sname': sname, 'gender': gender, 'check1': check1, 'check2': check2, 'check3': check3, 'type': type, 'tnum': tnum, 'number': number, 'alternate': alternate, 'street': street, 'postal': postal, 'city': city, 'majint': majint, 'comments': comments};

            //Ajax post data to server
            $.post(''+root+'NewEPush.php', post_data, function (response) {

                //load json data from server and output message     
                if (response.type == 'error') {
                    presp = 'error';
					pmsg  = '' + response.text + '';
                } else {
                    presp = 'success';
					pmsg  = '' + response.text + '';
                    //reset values in all input fields
                    $('#Employee_form input').val('');
                    $('#Employee_form textarea').val('');
                }
				puno(""+pmsg+"",""+presp+"");
            }, 'json');

        }
    });

    //reset previously set border colors and hide all message on .keyup()
    $("#Employee_form input, #Employee_form textarea").keyup(function () {
        $("#Employee_form input, #Employee_form textarea, #Employee_form select").css('border-color', '');
    });

});
</script>
</body>
</html>