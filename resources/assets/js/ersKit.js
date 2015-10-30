/* For ersKit templates */

jQuery( document ).ready(function() {
   
    
    if (jQuery('div').hasClass('ers-fullscreen')){
        
        jQuery('.ers-container').css('left','0px');
     
    }
    
    else if (jQuery('div').hasClass('ers-metanavitation')){
        
        jQuery('.ers-container').css('left','100px');
     
    }
    else if (jQuery('div').hasClass('ers-metanavigation')){
        
        jQuery('.ers-container').css('left','100px');
     
    }
    else{
        jQuery('.ers-container').css('left','0px');
    }
    
});
