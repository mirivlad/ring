   $('.menu li a').each(function(){
     var href = $(this).attr('href');
     var pos = document.location.pathname.indexOf(href);

     if( pos >= 0 && href != '/' || href == document.location.pathname ){
       $(this).parent().addClass('active');
     }
   });

