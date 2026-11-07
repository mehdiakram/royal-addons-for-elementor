jQuery(document).ready(function($) {
    var opensearchoverly = function(){
        $(".royalsearchoverly").addClass("displayblock");
    }
    
    var closesearchoverly = function(){
        $(".royalsearchoverly").removeClass("displayblock");
    }
    
        
    $('.royalsearchicon').click( function(event) {
        event.stopPropagation();
        $(this).is('.displayblock') ? closesearchoverly() : opensearchoverly();
    });
    

    $('.royalsearchoverly .closebtn').click( function(event) {
        event.stopPropagation();
        $(this).is('.displayblock') ? opensearchoverly() : closesearchoverly();
    });

    
    $(document).click( function(event){
        if ( !$(event.target).closest('.royalsearchoverly').length ) {
            closesearchoverly();   
        }
    });
    });