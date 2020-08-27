<?php 
	require_once('cFigure.php');
	require_once('auth.php');	
	
	//Connect to mysql server
	$link = ($GLOBALS["___mysqli_ston"] = mysqli_connect(DB_HOST,  DB_USER,  DB_PASSWORD));
	if(!$link) {
		die('Failed to connect to server: ' . ((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
	}
	
	//Select database
	$db = ((bool)mysqli_query($GLOBALS["___mysqli_ston"], "USE " . constant('DB_DATABASE')));
	if(!$db) {
		die("Unable to select database");
	}
	
	//Function to sanitize values received from the form. Prevents SQL injection
	function clean($str) {
		$str = @trim($str);
		if(get_magic_quotes_gpc()) {
			$str = stripslashes($str);
		}
		return ((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $str) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""));
	}		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="js/wysiwyg.js"></script>
<script type="text/javascript" src="js/wysiwyg-editor.js"></script>
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="css/wysiwyg-editor.css" />
</head>
<script type="text/javascript">
$(document).ready(function(){
    // Full featured editor
    $('#a_content').each( function(index, element)
    {
        $(element).wysiwyg({
            classes: 'some-more-classes',
            // 'selection'|'top'|'top-selection'|'bottom'|'bottom-selection'
            toolbar: index == 0 ? 'top-selection' : (index == 1 ? 'bottom' : 'selection'),
            buttons: {
                // Dummy-HTML-Plugin
                dummybutton1: index != 1 ? false : {
                    html: $('<input id="submit" type="button" value="bold" />').click(function(){
                                // We simply make 'bold'
                                if( $(element).wysiwyg('shell').getSelectedHTML() )
                                    $(element).wysiwyg('shell').bold();
                                else
                                    alert( 'Please selection some text' );
                            }),
                    //showstatic: true,    // wanted on the toolbar
                    showselection: false    // wanted on selection
                },
                // Dummy-Button-Plugin
                dummybutton2: index != 1 ? false : {
                    title: 'Dummy',
                    image: '\uf1e7',
                    click: function( $button ) {
                            alert('Do something');
                           },
                    //showstatic: true,    // wanted on the toolbar
                    showselection: false    // wanted on selection
                },
                // Smiley plugin
                smilies: {
                    title: 'Smilies',
                    image: '\uf118', // <img src="path/to/image.png" width="16" height="16" alt="" />
                    popup: function( $popup, $button ) {
                            var list_smilies = [
                                    '<img src="smiley/afraid.png" width="16" height="16" alt="" />',
                                    '<img src="smiley/amorous.png" width="16" height="16" alt="" />',
                                    '<img src="smiley/angel.png" width="16" height="16" alt="" />',
                                    '<img src="smiley/angry.png" width="16" height="16" alt="" />',
                                    '<img src="smiley/bored.png" width="16" height="16" alt="" />',
                                    '<img src="smiley/cold.png" width="16" height="16" alt="" />',
                                    '<img src="smiley/confused.png" width="16" height="16" alt="" />',
                                    '<img src="smiley/cross.png" width="16" height="16" alt="" />',
                                    '<img src="smiley/crying.png" width="16" height="16" alt="" />',
                                    '<img src="smiley/devil.png" width="16" height="16" alt="" />',
                                    '<img src="smiley/disappointed.png" width="16" height="16" alt="" />',
                                    '<img src="smiley/dont-know.png" width="16" height="16" alt="" />',
                                    '<img src="smiley/drool.png" width="16" height="16" alt="" />',
                                    '<img src="smiley/embarrassed.png" width="16" height="16" alt="" />',
                                    '<img src="smiley/excited.png" width="16" height="16" alt="" />',
                                    '<img src="smiley/excruciating.png" width="16" height="16" alt="" />',
                                    '<img src="smiley/eyeroll.png" width="16" height="16" alt="" />',
                                    '<img src="smiley/happy.png" width="16" height="16" alt="" />',
                                    '<img src="smiley/hot.png" width="16" height="16" alt="" />',
                                    '<img src="smiley/hug-left.png" width="16" height="16" alt="" />',
                                    '<img src="smiley/hug-right.png" width="16" height="16" alt="" />',
                                    '<img src="smiley/hungry.png" width="16" height="16" alt="" />',
                                    '<img src="smiley/invincible.png" width="16" height="16" alt="" />',
                                    '<img src="smiley/kiss.png" width="16" height="16" alt="" />',
                                    '<img src="smiley/lying.png" width="16" height="16" alt="" />',
                                    '<img src="smiley/meeting.png" width="16" height="16" alt="" />',
                                    '<img src="smiley/nerdy.png" width="16" height="16" alt="" />',
                                    '<img src="smiley/neutral.png" width="16" height="16" alt="" />',
                                    '<img src="smiley/party.png" width="16" height="16" alt="" />',
                                    '<img src="smiley/pirate.png" width="16" height="16" alt="" />',
                                    '<img src="smiley/pissed-off.png" width="16" height="16" alt="" />',
                                    '<img src="smiley/question.png" width="16" height="16" alt="" />',
                                    '<img src="smiley/sad.png" width="16" height="16" alt="" />',
                                    '<img src="smiley/shame.png" width="16" height="16" alt="" />',
                                    '<img src="smiley/shocked.png" width="16" height="16" alt="" />',
                                    '<img src="smiley/shut-mouth.png" width="16" height="16" alt="" />',
                                    '<img src="smiley/sick.png" width="16" height="16" alt="" />',
                                    '<img src="smiley/silent.png" width="16" height="16" alt="" />',
                                    '<img src="smiley/sleeping.png" width="16" height="16" alt="" />',
                                    '<img src="smiley/sleepy.png" width="16" height="16" alt="" />',
                                    '<img src="smiley/stressed.png" width="16" height="16" alt="" />',
                                    '<img src="smiley/thinking.png" width="16" height="16" alt="" />',
                                    '<img src="smiley/tongue.png" width="16" height="16" alt="" />',
                                    '<img src="smiley/uhm-yeah.png" width="16" height="16" alt="" />',
                                    '<img src="smiley/wink.png" width="16" height="16" alt="" />',
                                    '<img src="smiley/working.png" width="16" height="16" alt="" />',
                                    '<img src="smiley/bathing.png" width="16" height="16" alt="" />',
                                    '<img src="smiley/beer.png" width="16" height="16" alt="" />',
                                    '<img src="smiley/boy.png" width="16" height="16" alt="" />',
                                    '<img src="smiley/camera.png" width="16" height="16" alt="" />',
                                    '<img src="smiley/chilli.png" width="16" height="16" alt="" />',
                                    '<img src="smiley/cigarette.png" width="16" height="16" alt="" />',
                                    '<img src="smiley/cinema.png" width="16" height="16" alt="" />',
                                    '<img src="smiley/coffee.png" width="16" height="16" alt="" />',
                                    '<img src="smiley/girl.png" width="16" height="16" alt="" />',
                                    '<img src="smiley/console.png" width="16" height="16" alt="" />',
                                    '<img src="smiley/grumpy.png" width="16" height="16" alt="" />',
                                    '<img src="smiley/in_love.png" width="16" height="16" alt="" />',
                                    '<img src="smiley/internet.png" width="16" height="16" alt="" />',
                                    '<img src="smiley/lamp.png" width="16" height="16" alt="" />',
                                    '<img src="smiley/mobile.png" width="16" height="16" alt="" />',
                                    '<img src="smiley/mrgreen.png" width="16" height="16" alt="" />',
                                    '<img src="smiley/musical-note.png" width="16" height="16" alt="" />',
                                    '<img src="smiley/music.png" width="16" height="16" alt="" />',
                                    '<img src="smiley/phone.png" width="16" height="16" alt="" />',
                                    '<img src="smiley/plate.png" width="16" height="16" alt="" />',
                                    '<img src="smiley/restroom.png" width="16" height="16" alt="" />',
                                    '<img src="smiley/rose.png" width="16" height="16" alt="" />',
                                    '<img src="smiley/search.png" width="16" height="16" alt="" />',
                                    '<img src="smiley/shopping.png" width="16" height="16" alt="" />',
                                    '<img src="smiley/star.png" width="16" height="16" alt="" />',
                                    '<img src="smiley/studying.png" width="16" height="16" alt="" />',
                                    '<img src="smiley/suit.png" width="16" height="16" alt="" />',
                                    '<img src="smiley/surfing.png" width="16" height="16" alt="" />',
                                    '<img src="smiley/thunder.png" width="16" height="16" alt="" />',
                                    '<img src="smiley/tv.png" width="16" height="16" alt="" />',
                                    '<img src="smiley/typing.png" width="16" height="16" alt="" />',
                                    '<img src="smiley/writing.png" width="16" height="16" alt="" />'
                            ];
                            var $smilies = $('<div/>').addClass('wysiwyg-toolbar-smilies')
                                                      .attr('unselectable','on');
                            $.each( list_smilies, function(index,smiley){
                                if( index != 0 )
                                    $smilies.append(' ');
                                var $image = $(smiley).attr('unselectable','on');
                                // Append smiley
                                var imagehtml = ' '+$('<div/>').append($image.clone()).html()+' ';
                                $image
                                    .css({ cursor: 'pointer' })
                                    .click(function(event){
                                        $(element).wysiwyg('shell').insertHTML(imagehtml); // .closePopup(); - do not close the popup
                                    })
                                    .appendTo( $smilies );
                            });
                            var $container = $(element).wysiwyg('container');
                            $smilies.css({ maxWidth: parseInt($container.width()*0.95)+'px' });
                            $popup.append( $smilies );
                            // Smilies do not close on click, so force the popup-position to cover the toolbar
                            var $toolbar = $button.parents( '.wysiwyg-toolbar' );
                            if( ! $toolbar.length ) // selection toolbar?
                                return ;
                            return { // this prevents applying default position
                                left: parseInt( ($toolbar.outerWidth() - $popup.outerWidth()) / 2 ),
                                top: $toolbar.hasClass('wysiwyg-toolbar-bottom') ? ($container.outerHeight() - parseInt($button.outerHeight()/4)) : (parseInt($button.outerHeight()/4) - $popup.height())
                            };
                           },
                    //showstatic: true,    // wanted on the toolbar
                    showselection: index == 2 ? true : false    // wanted on selection
                },
                insertimage: {
                    title: 'Insert image',
                    image: '\uf030', // <img src="path/to/image.png" width="16" height="16" alt="" />
                    //showstatic: true,    // wanted on the toolbar
                    showselection: index == 2 ? true : false    // wanted on selection
                },
                insertvideo: {
                    title: 'Insert video',
                    image: '\uf03d', // <img src="path/to/image.png" width="16" height="16" alt="" />
                    //showstatic: true,    // wanted on the toolbar
                    showselection: index == 2 ? true : false    // wanted on selection
                },
                insertlink: {
                    title: 'Insert link',
                    image: '\uf08e' // <img src="path/to/image.png" width="16" height="16" alt="" />
                },
                // Fontname plugin
                fontname: index == 1 ? false : {
                    title: 'Font',
                    image: '\uf031', // <img src="path/to/image.png" width="16" height="16" alt="" />
                    popup: function( $popup, $button ) {
                            var list_fontnames = {
                                    // Name : Font
                                    'Arial, Helvetica' : 'Arial,Helvetica',
                                    'Verdana'          : 'Verdana,Geneva',
                                    'Georgia'          : 'Georgia',
                                    'Courier New'      : 'Courier New,Courier',
                                    'Times New Roman'  : 'Times New Roman,Times'
                                };
                            var $list = $('<div/>').addClass('wysiwyg-toolbar-list')
                                                   .attr('unselectable','on');
                            $.each( list_fontnames, function( name, font ){
                                var $link = $('<a/>').attr('href','#')
                                                    .css( 'font-family', font )
                                                    .html( name )
                                                    .click(function(event){
                                                        $(element).wysiwyg('shell').fontName(font).closePopup();
                                                        // prevent link-href-#
                                                        event.stopPropagation();
                                                        event.preventDefault();
                                                        return false;
                                                    });
                                $list.append( $link );
                            });
                            $popup.append( $list );
                           },
                    //showstatic: true,    // wanted on the toolbar
                    showselection: index == 0 ? true : false    // wanted on selection
                },
                // Fontsize plugin
                fontsize: index != 1 ? false : {
                    title: 'Size',
                    image: '\uf034', // <img src="path/to/image.png" width="16" height="16" alt="" />
                    popup: function( $popup, $button ) {
                            // Hack: http://stackoverflow.com/questions/5868295/document-execcommand-fontsize-in-pixels/5870603#5870603
                            var list_fontsizes = [];
                            for( var i=8; i <= 11; ++i )
                                list_fontsizes.push(i+'px');
                            for( var i=12; i <= 28; i+=2 )
                                list_fontsizes.push(i+'px');
                            list_fontsizes.push('36px');
                            list_fontsizes.push('48px');
                            list_fontsizes.push('72px');
                            var $list = $('<div/>').addClass('wysiwyg-toolbar-list')
                                                   .attr('unselectable','on');
                            $.each( list_fontsizes, function( index, size ){
                                var $link = $('<a/>').attr('href','#')
                                                    .html( size )
                                                    .click(function(event){
                                                        $(element).wysiwyg('shell').fontSize(7).closePopup();
                                                        $(element).wysiwyg('container')
                                                                .find('font[size=7]')
                                                                .removeAttr("size")
                                                                .css("font-size", size);
                                                        // prevent link-href-#
                                                        event.stopPropagation();
                                                        event.preventDefault();
                                                        return false;
                                                    });
                                $list.append( $link );
                            });
                            $popup.append( $list );
                            /*
                            var list_fontsizes = {
                                // Name : Size
                                'Huge'    : 7,
                                'Larger'  : 6,
                                'Large'   : 5,
                                'Normal'  : 4,
                                'Small'   : 3,
                                'Smaller' : 2,
                                'Tiny'    : 1
                            };
                            var $list = $('<div/>').addClass('wysiwyg-toolbar-list')
                                                   .attr('unselectable','on');
                            $.each( list_fontsizes, function( name, size ){
                                var $link = $('<a/>').attr('href','#')
                                                    .css( 'font-size', (8 + (size * 3)) + 'px' )
                                                    .html( name )
                                                    .click(function(event){
                                                        $(element).wysiwyg('shell').fontSize(size).closePopup();
                                                        // prevent link-href-#
                                                        event.stopPropagation();
                                                        event.preventDefault();
                                                        return false;
                                                    });
                                $list.append( $link );
                            });
                            $popup.append( $list );
                            */
                           }
                    //showstatic: true,    // wanted on the toolbar
                    //showselection: true    // wanted on selection
                },
                // Header plugin
                header: index != 1 ? false : {
                    title: 'Header',
                    image: '\uf1dc', // <img src="path/to/image.png" width="16" height="16" alt="" />
                    popup: function( $popup, $button ) {
                            var list_headers = {
                                    // Name : Font
                                    'Header 1' : '<h1>',
                                    'Header 2' : '<h2>',
                                    'Header 3' : '<h3>',
                                    'Header 4' : '<h4>',
                                    'Header 5' : '<h5>',
                                    'Header 6' : '<h6>',
                                    'Code'     : '<pre>'
                                };
                            var $list = $('<div/>').addClass('wysiwyg-toolbar-list')
                                                   .attr('unselectable','on');
                            $.each( list_headers, function( name, format ){
                                var $link = $('<a/>').attr('href','#')
                                                     .css( 'font-family', format )
                                                     .html( name )
                                                     .click(function(event){
                                                        $(element).wysiwyg('shell').format(format).closePopup();
                                                        // prevent link-href-#
                                                        event.stopPropagation();
                                                        event.preventDefault();
                                                        return false;
                                                    });
                                $list.append( $link );
                            });
                            $popup.append( $list );
                           }
                    //showstatic: true,    // wanted on the toolbar
                    //showselection: false    // wanted on selection
                },
                bold: {
                    title: 'Bold (Ctrl+B)',
                    image: '\uf032', // <img src="path/to/image.png" width="16" height="16" alt="" />
                    hotkey: 'b'
                },
                italic: {
                    title: 'Italic (Ctrl+I)',
                    image: '\uf033', // <img src="path/to/image.png" width="16" height="16" alt="" />
                    hotkey: 'i'
                },
                underline: {
                    title: 'Underline (Ctrl+U)',
                    image: '\uf0cd', // <img src="path/to/image.png" width="16" height="16" alt="" />
                    hotkey: 'u'
                },
                strikethrough: {
                    title: 'Strikethrough (Ctrl+S)',
                    image: '\uf0cc', // <img src="path/to/image.png" width="16" height="16" alt="" />
                    hotkey: 's'
                },
                forecolor: {
                    title: 'Text color',
                    image: '\uf1fc' // <img src="path/to/image.png" width="16" height="16" alt="" />
                },
                highlight: {
                    title: 'Background color',
                    image: '\uf043' // <img src="path/to/image.png" width="16" height="16" alt="" />
                },
                alignleft: index != 0 ? false : {
                    title: 'Left',
                    image: '\uf036', // <img src="path/to/image.png" width="16" height="16" alt="" />
                    //showstatic: true,    // wanted on the toolbar
                    showselection: false    // wanted on selection
                },
                aligncenter: index != 0 ? false : {
                    title: 'Center',
                    image: '\uf037', // <img src="path/to/image.png" width="16" height="16" alt="" />
                    //showstatic: true,    // wanted on the toolbar
                    showselection: false    // wanted on selection
                },
                alignright: index != 0 ? false : {
                    title: 'Right',
                    image: '\uf038', // <img src="path/to/image.png" width="16" height="16" alt="" />
                    //showstatic: true,    // wanted on the toolbar
                    showselection: false    // wanted on selection
                },
                alignjustify: index != 0 ? false : {
                    title: 'Justify',
                    image: '\uf039', // <img src="path/to/image.png" width="16" height="16" alt="" />
                    //showstatic: true,    // wanted on the toolbar
                    showselection: false    // wanted on selection
                },
                subscript: index == 1 ? false : {
                    title: 'Subscript',
                    image: '\uf12c', // <img src="path/to/image.png" width="16" height="16" alt="" />
                    //showstatic: true,    // wanted on the toolbar
                    showselection: true    // wanted on selection
                },
                superscript: index == 1 ? false : {
                    title: 'Superscript',
                    image: '\uf12b', // <img src="path/to/image.png" width="16" height="16" alt="" />
                    //showstatic: true,    // wanted on the toolbar
                    showselection: true    // wanted on selection
                },
                indent: index != 0 ? false : {
                    title: 'Indent',
                    image: '\uf03c', // <img src="path/to/image.png" width="16" height="16" alt="" />
                    //showstatic: true,    // wanted on the toolbar
                    showselection: false    // wanted on selection
                },
                outdent: index != 0 ? false : {
                    title: 'Outdent',
                    image: '\uf03b', // <img src="path/to/image.png" width="16" height="16" alt="" />
                    //showstatic: true,    // wanted on the toolbar
                    showselection: false    // wanted on selection
                },
                orderedList: index != 0 ? false : {
                    title: 'Ordered list',
                    image: '\uf0cb', // <img src="path/to/image.png" width="16" height="16" alt="" />
                    //showstatic: true,    // wanted on the toolbar
                    showselection: false    // wanted on selection
                },
                unorderedList: index != 0 ? false : {
                    title: 'Unordered list',
                    image: '\uf0ca', // <img src="path/to/image.png" width="16" height="16" alt="" />
                    //showstatic: true,    // wanted on the toolbar
                    showselection: false    // wanted on selection
                },
                removeformat: {
                    title: 'Remove format',
                    image: '\uf12d' // <img src="path/to/image.png" width="16" height="16" alt="" />
                }
            },
            // Submit-Button
            submit: {
                title: 'Submit',
                image: '\uf00c' // <img src="path/to/image.png" width="16" height="16" alt="" />
            },
            // Other properties
            selectImage: 'Click or drop image',
            placeholderUrl: 'www.example.com',
            placeholderEmbed: '<embed/>',
            maxImageSize: [600,200],
            onImageUpload: function( insert_image ) {
                            var iframe_name = 'legacy-uploader-' + Math.random().toString(36).substring(2);
                            $('<iframe>').attr('name',iframe_name)
                                         .load(function() {
                                            // <iframe> is ready - we will find the URL in the iframe-body
                                            var iframe = this;
                                            var iframedoc = iframe.contentDocument ? iframe.contentDocument : 
                                                           (iframe.contentWindow ? iframe.contentWindow.document : iframe.document);
                                            var iframebody = iframedoc.getElementsByTagName('body')[0];
                                            var image_url = iframebody.innerHTML;
                                            insert_image( image_url );
                                            $(iframe).remove();
                                         })
                                         .appendTo(document.body);
                            var $input = $(this);
                            $input.attr('name','upload-filename')
                                  .parents('form')
                                  .attr('action','img-upld.php') // accessing cross domain <iframes> could be difficult
                                  .attr('method','POST')
                                  .attr('enctype','multipart/form-data')
                                  .attr('target',iframe_name)
                                  .submit();
                        },
            forceImageUpload: false,    // upload images even if File-API is present
            videoFromUrl: function( url ) {
                // Contributions are welcome :-)

                // youtube - http://stackoverflow.com/questions/3392993/php-regex-to-get-youtube-video-id
                var youtube_match = url.match( /^(?:http(?:s)?:\/\/)?(?:[a-z0-9.]+\.)?(?:youtu\.be|youtube\.com)\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/)([^\?&\"'>]+)/ );
                if( youtube_match && youtube_match[1].length == 11 )
                    return '<iframe src="//www.youtube.com/embed/' + youtube_match[1] + '" width="640" height="360" frameborder="0" allowfullscreen></iframe>';

                // vimeo - http://embedresponsively.com/
                var vimeo_match = url.match( /^(?:http(?:s)?:\/\/)?(?:[a-z0-9.]+\.)?vimeo\.com\/([0-9]+)$/ );
                if( vimeo_match )
                    return '<iframe src="//player.vimeo.com/video/' + vimeo_match[1] + '" width="640" height="360" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';

                // dailymotion - http://embedresponsively.com/
                var dailymotion_match = url.match( /^(?:http(?:s)?:\/\/)?(?:[a-z0-9.]+\.)?dailymotion\.com\/video\/([0-9a-z]+)$/ );
                if( dailymotion_match )
                    return '<iframe src="//www.dailymotion.com/embed/video/' + dailymotion_match[1] + '" width="640" height="360" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';

                // undefined -> create '<video/>' tag
            },
            onKeyPress: function( code, character, shiftKey, altKey, ctrlKey, metaKey ) {
                            // E.g.: submit form on enter-key:
                            //if( (code == 10 || code == 13) && !shiftKey && !altKey && !ctrlKey && !metaKey ) {
                            //    submit_form();
                            //    return false; // swallow enter
                            //}
                        }
        })
        .change(function(){
         //   if( typeof console != 'undefined' )
          //      console.log( 'change' );
        })
        .focus(function(){
           // if( typeof console != 'undefined' )
             //   console.log( 'focus' );
        })
        .blur(function(){
          //  if( typeof console != 'undefined' )
           //     console.log( 'blur' );
        });
    });

    // Demo-Buttons
    $('#editor3-bold').click(function(){
        $('#editor3').wysiwyg('shell').bold();
        return false;
    });
    $('#editor3-red').click(function(){
        $('#editor3').wysiwyg('shell').highlight('#ff0000');
        return false;
    });
    $('#editor3-sethtml').click(function(){
        $('#editor3').wysiwyg('shell').setHTML('This is the new text.');
        return false;
    });
    $('#editor3-inserthtml').click(function(){
        $('#editor3').wysiwyg('shell').insertHTML('Insert some text.');
        return false;
    });

    // Raw editor
	
    var option = {
        element: $('#a_content').get(0),
//        onkeypress: function( code, character, shiftKey, altKey, ctrlKey, metaKey ) {
//                        if( typeof console != 'undefined' )
//                            console.log( 'RAW: '+character+' key pressed' );
//                    },
//        onselection: function( collapsed, rect, nodes, rightclick ) {
//                        if( typeof console != 'undefined' && rect )
//                            console.log( 'RAW: selection rect('+rect.left+','+rect.top+','+rect.width+','+rect.height+'), '+nodes.length+' nodes' );
//                    },
//        onplaceholder: function( visible ) {
//                        if( typeof console != 'undefined' )
//                            console.log( 'RAW: placeholder ' + (visible ? 'visible' : 'hidden') );
//                    }
    };
    var wysiwygeditor = wysiwyg( option );
    //wysiwygeditor.setHTML( '<html>' );
});
</script>
<body>
<div class="base">
  <h2>Knowledge Base Settings</h2>
  <div class="base_sub" style="margin-bottom:100px;">
    <input type="button" id="create_article" value="Create Article" style="width:102px;position: fixed;margin-left: 560px;z-index: 10;">
    <div class="base_box">
      <h3>New Article</h3>
      <form name="new article" action="javascript:void(0);">
        <div id="tab_holder">
          <div id="tab_items">
            <div id="result"></div>
            <div id="tab_items">Article Title:</div>
            <div id="tab_items">
              <input type="text" name="a_title" />
            </div>
          </div>
        </div>
        <div id="tab_holder">
          <div id="tab_items">
            <div id="tab_items">Category:</div>
            <div id="tab_items">
              <select name="a_category" id="a_category">
                <option value="1">Shifts</option>
                <option value="2">Employees</option>
                <option value="3">Locations</option>
                <option value="4">Settings</option>
                <option value="5">Miscellaneous</option>
              </select>
            </div>
          </div>
        </div>
        <div id="tab_holder">
          <div id="tab_items">
            <div id="tab_items">Article Content:</div>
            <div id="tab_items">
              <div id="a_content" contenteditable="true" style="overflow:visible;text-shadow:none;line-height:24px;width:500px;height:350px;"></div>
            </div>
          </div>
        </div>
      </form>
    </div>
    <div class="bottom_wrap">
      <div class="base_box edit">
        <h3>Edit an Article</h3>
        <select name="a_edit" id="a_edit">
          <option value="">Select an article...</option>
          <?php 
			$query = "SELECT * FROM knowledge_base ORDER BY kb_title";
			$result = mysqli_query($GLOBALS["___mysqli_ston"], $query);
				while($row = mysqli_fetch_assoc($result)){
				echo('<option value="'.$row['kb_id'].'">'.$row['kb_title'].'</option>');
			}
			?>
        </select>
        <script>
						$(document).ready( function() {
							$("#a_edit").change( function() {
								var article_id = $(this).val();
								$("div[data-location='Article Editor']").load("a_edit.php?action=a_edit&article="+article_id);
							});
						});
                    </script>
        <div id="tab_holder" data-location="Article Editor"> </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
$(document).ready(function () {
    $("#create_article").click(function () {
        //get input field values
        var a_title = $('form[name="new article"] input[name=a_title]').val();
        var a_category = $('form[name="new article"] select[name=a_category]').val();
        var a_content = $("#a_content").html()
        //simple validation at client's end
        //we simply change border color to red if empty field using .css()
        var proceed = true;
        if (a_title == "") {
            $('form[name="new article"] input[name=a_title]').css('border-color', 'red');
            proceed = false;
        }
        if (a_content == "") {
            $("#a_content").css('border-color', 'red');
            proceed = false;
        }

        //everything looks good! proceed...
        if (proceed) {
            //data to be sent to server
            post_data = {'title': a_title, 'category': a_category, 'content': a_content, 'action': 'new_a'};
            //Ajax post data to server
            $.post('a_edit.php?action=new_a', post_data, function (response) {
                //load json data from server and output message     
                if (response.type == 'error') {
                    presp = 'error';
					pmsg  = '' + response.text + '';
                } else {
                    presp = 'success';
					pmsg  = '' + response.text + '';
                }
				puno(""+pmsg+"",""+presp+"");
				$.get('kb_settings.php', function(result){
					$result = $(result);
				
					var that = $result.find('.edit');
					$(".bottom_wrap").html(that);
					$result.find('.bottom_wrap script').appendTo('.bottom_wrap');
				}, 'html');
//				$(".bottom_wrap").load('kb_settings.php .edit');
            }, 'json');

        }
    });
});
</script>
</body>
</html>