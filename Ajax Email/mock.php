<title>mock scripts</title>
<!-- SEND EMAIL -->
<script type="text/javascript">
$(document).ready(function() {
    $("#verify").click(function() { 
        var ndxr = <?php $to_Email = $_SESSION['SESS_CONTROL_FIRST']; echo json_encode($to_Email); ?>;
        var proceed = true;
        if(proceed) 
        {
            post_data = {'ndxr':ndxr};
            $.post('vsender.php', post_data, function(response){  
                if(response.type == 'error')
                {
                    output = '<div class="error">'+response.text+'</div>';
                }else{
                    output = '<div class="success">'+response.text+'</div>';
                    $('#contact_form input').val(''); 
                    $('#contact_form textarea').val(''); 
                }
                $("#result").hide().html(output).slideDown();
            }, 'json');
        }
    });
    
    //reset previously set border colors and hide all message on .keyup()
    $("#contact_form input, #contact_form textarea").keyup(function() { 
        $("#contact_form input, #contact_form textarea").css('border-color',''); 
        $("#result").slideUp();
    });
    
});
</script>
<!-- SEND EMAIL -->