<!DOCTYPE html>
<html class="wf-museo-i3-active wf-museo-i7-active wf-museo-n3-active wf-museo-n7-active wf-active" style="position: relative; -webkit-transition: right 0.25s ease-in-out; transition: right 0.25s ease-in-out; right: 0px;">

<head>
<title>Verify</title>
<link rel="shortcut icon" href="../img/brand/favicon.ico">
<link rel="stylesheet" type="text/css" href="../css/stylesheet.css">
<link rel="stylesheet" type="text/css" href="../css/LOGREG.css">
<link rel="stylesheet" href="../css/jquery.mCustomScrollbar.css">

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="initial-scale=1, minimum-scale=1">
<meta name="description" content="">
<meta http-equiv="x-dns-prefetch-control" content="off">
<style>
.success{ background: #CFFFF5;padding: 10px; margin-bottom: 10px; border: 1px solid #B9ECCE; border-radius: 5px; font-weight: normal; }
.error{ background: #FFDFDF; padding: 10px; margin-bottom: 10px; border: 1px solid #FFCACA; border-radius: 5px; font-weight: normal;}
</style>
<script src="http://code.jquery.com/jquery-1.7.2.min.js"></script>
<script src="../Yarix.js"></script>
<style>
#location_form{ width:300px; padding:20px; border: 1px solid #DDD;border-radius: 5px; font-family: Arial; font-size: 11px; font-weight: bold;color: #666666; background:#FAFAFA; margin-right: auto; margin-left: auto;}
#location_form legend{font-size: 15px; color: #C9C9C9;}
#location_form label{display: block; margin-bottom:5px;}
#location_form label span{float:left; width:100px; color:#666666;}
#location_form input{height: 25px; border: 1px solid #DBDBDB; border-radius: 3px; padding-left: 4px; color: #666; width: 180px; font-family: Arial, Helvetica, sans-serif;}
#location_form textarea{border: 1px solid #DBDBDB; border-radius: 3px; padding-left: 4px;color: #666; height:100px; width: 180px; font-family: Arial, Helvetica, sans-serif;}
.submit_btn { border: 1px solid #D8D8D8; padding: 5px 15px 5px 15px; color: #8D8D8D; text-shadow: 1px 1px 1px #FFF; border-radius: 3px; background: #F8F8F8;}
.submit_btn:hover { background: #ECECEC;}
.success{ background: #CFFFF5;padding: 10px; margin-bottom: 10px; border: 1px solid #B9ECCE; border-radius: 5px; font-weight: normal; }
.error{ background: #FFDFDF; padding: 10px; margin-bottom: 10px; border: 1px solid #FFCACA; border-radius: 5px; font-weight: normal;}
</style>
</head>

<body>
<form id="location_form">
<legend>My Contact Form</legend>
<div id="result"></div>
    <label for="name"><span>Location Name</span>
    <input type="text" name="name" id="name" placeholder="Enter Your Name" />
    </label>
    <label for="name"><span>Name</span>
    <input type="text" name="name" id="name" placeholder="Enter Your Name" />
    </label>
    <label for="name"><span>Name</span>
    <input type="text" name="name" id="name" placeholder="Enter Your Name" />
    </label>
    <label for="name"><span>Name</span>
    <input type="text" name="name" id="name" placeholder="Enter Your Name" />
    </label>
    <label for="name"><span>Name</span>
    <input type="text" name="name" id="name" placeholder="Enter Your Name" />
    </label>
    <label for="name"><span>Name</span>
    <input type="text" name="name" id="name" placeholder="Enter Your Name" />
    </label>
    <label for="name"><span>Name</span>
    <input type="text" name="name" id="name" placeholder="Enter Your Name" />
    </label>
    <label for="name"><span>Name</span>
    <input type="text" name="name" id="name" placeholder="Enter Your Name" />
    </label>
    <label for="name"><span>Name</span>
    <input type="text" name="name" id="name" placeholder="Enter Your Name" />
    </label>
    <label for="name"><span>Name</span>
    <input type="text" name="name" id="name" placeholder="Enter Your Name" />
    </label>
    <label for="name"><span>Name</span>
    <input type="text" name="name" id="name" placeholder="Enter Your Name" />
    </label>
    <label for="name"><span>Name</span>
    <input type="text" name="name" id="name" placeholder="Enter Your Name" />
    </label>
    <label for="name"><span>Name</span>
    <input type="text" name="name" id="name" placeholder="Enter Your Name" />
    </label>
    <label for="email"><span>Email Address</span>
    <input type="email" name="email" id="email" placeholder="Enter Your Email" />
    </label>
    
    <label for="phone"><span>Phone</span>
    <input type="text" name="phone" id="phone" placeholder="Phone Number" />
    </label>
    
    <label for="message"><span>Message</span>
    <textarea name="message" id="message" placeholder="Enter Your Name"></textarea>
    </label>
    
    <label><span>&nbsp;</span>
    <a href="#" id="verify">Submit</a>
    </label>
</form>
<script type="text/javascript">
$(document).ready(function() {
    $("#verify").click(function() { 
        //get input field values
        var user_name       = $('input[name=name]').val(); 
        var user_email      = $('input[name=email]').val();
        var user_phone      = $('input[name=phone]').val();
        var user_message    = $('textarea[name=message]').val();
        
        //simple validation at client's end
        //we simply change border color to red if empty field using .css()
        var proceed = true;
        if(user_name==""){ 
            $('input[name=name]').css('border-color','red'); 
            proceed = false;
        }
        if(user_email==""){ 
            $('input[name=email]').css('border-color','red'); 
            proceed = false;
        }
        if(user_phone=="") {    
            $('input[name=phone]').css('border-color','red'); 
            proceed = false;
        }
        if(user_message=="") {  
            $('textarea[name=message]').css('border-color','red'); 
            proceed = false;
        }

        //everything looks good! proceed...
        if(proceed) 
        {
            //data to be sent to server
            post_data = {'userName':user_name, 'userEmail':user_email, 'userPhone':user_phone, 'userMessage':user_message};
            
            //Ajax post data to server
            $.post('contact_me.php', post_data, function(response){  
                
                //load json data from server and output message     
                if(response.type == 'error')
                {
                    output = '<div class="error">'+response.text+'</div>';
                }else{
                
                    output = '<div class="success">'+response.text+'</div>';
                    
                    //reset values in all input fields
                    $('#location_form input').val(''); 
                    $('#location_form textarea').val(''); 
                }
                
                $("#result").hide().html(output).slideDown();
            }, 'json');
            
        }
    });
    
    //reset previously set border colors and hide all message on .keyup()
    $("#location_form input, #location_form textarea").keyup(function() { 
        $("#location_form input, #location_form textarea").css('border-color',''); 
        $("#result").slideUp();
    });
    
});
</script>
<script type="text/javascript">
var title_length = $('#header h1 *').contents().filter(function() { return this.nodeType == 3; }).text().length;
var title_width = Math.max(1.5, Math.min(3, 48 / title_length));
$('#header h1').css('font-size', title_width + 'em');
</script>
<script src="../js/jquery.mCustomScrollbar.concat.min.js"></script>
</body>
</html>