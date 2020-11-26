/*global $, confirm */
$(function () {
    
    'use strict';
    
    // Login & SignUp

    $(".login-page h1 span").click(function(){

        $(this).addClass('selected').siblings().removeClass('selected');

        $(".login-page form").hide();

        $('.' + $(this).data('class')).fadeIn(100);

    });

    // Trigger SelectBox
    
    $("select").selectBoxIt();
    
    // Hide Placeholder On Focus
    
    $('[placeholder]').focus(function () {
        
        $(this).attr('data-text', $(this).attr('placeholder'));
        $(this).attr('placeholder', '');
    }).blur(function () {
        
        $(this).attr('placeholder', $(this).attr('data-text'));
        
    });

    // Add Astrisk To Input Field To Required
    
    $('input').each(function(){
       
        if($(this).attr('required') === 'required'){
            
            $(this).after('<span class="asterisk">*</span>');
            
        }
        
    });


    
    $('.live').keyup(function(){

         $($(this).data('class')).text($(this).val());

    });
    
});