/*global $, confirm */
$(function () {
    
    'use strict';
    
    $(".login-page h1 span").click(function(){

        $(this).addClass('selected').siblings().removeClass('selected');

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
    
    
    // Confirm Before Delete User
    
    $(".confirm").click(function(){
        
        return confirm('Are You Sure?');
        
    });
    
    
});