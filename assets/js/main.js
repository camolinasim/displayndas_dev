$(function () {  
    var $body;
    $body = $('body');
    window.searching = false;

    $('#search-trigger').on('click', function (e) {
        if ($('#myutep-search').is(':hidden')) {
            $body.addClass('search-engaged');
           $('#myutep-search').slideDown(200);
            $('#search-query').focus()
        }

        else {
            $('#search-query').blur();
        }

        e.preventDefault();
    });
    

    $('#search-query').on('focus', function () {
        return window.searching = true;
    }).on('blur', function () {
        

        $('#myutep-search').slideUp();
        $body.removeClass('search-engaged');
        return window.searching = false;
    })

    function updateText(event) {
        var input = $(this);
        
        setTimeout(function () {
            var val = input.val();
            if (val != "")
                input.parent().addClass('floating-label');

            else
                input.parent().removeClass('floating-label');

        }, 100);
    }
    $('#myutep-search input, #myutep-search-mobile input').keydown(updateText);
    $('#myutep-search input, #myutep-search-mobile input').change(updateText);
  
        
    $('#simple-menu').sidr({
        side: 'right',
        
        /* Fix for UC-78: Floating menu keeps left when closed */
         onOpen: function(){
            $("#header").css('left', 'auto');
        },
          onCloseEnd: function () {
            $("#header").css('left', 0);
        },
        /*Fix for UC-78 ends*/
                        
    });
    $('.close-sidr').click(function () { $.sidr('close', 'sidr') });
    $( window ).resize(function() {
        $.sidr('close', 'sidr')
    });
                   
    $carrousel = $('#carrousel');
    $carrousel.find(".carousel-aside-pause").addClass("sr-only");
    
    $('video').get().forEach(makeVideoPlayableInline)
    $carrousel.playVideo();
 



    $('.show-video').click(function (e) {
        var src = $(this).attr("data-video");
        $('#myModal').modal('show');
        $('#myModal iframe').attr('src', src);
        

        
        if($('#myModal iframe').width() > $(window).width())
        {
         
             $('#myModal iframe').attr('width',  $(window).width());
        }
         return false;
    });
    $('#myModal button').click(function () {
        $('#myModal iframe').removeAttr('src');
       
    });
     
       (function showMinerAlert() {

        $.ajax({
            url: "//www.utep.edu/alerts"
        }).done(
         function (data, status, xhr) {
             var $data = $(data);
             var alertMessage = $data.find('h3').find('span').html().trim();

             if (alertMessage) {
                $("#alert-message").html(alertMessage);
                $("#UC-alertMessage").removeClass("hidden");
                $('#header').addClass("alert-active");
             }
         }).always(function () {
             $('#header').affix({ offset: { top: $("#UC-alertMessage").outerHeight() } });
         });
    })();
     
     $( '#header' ).on( 'affix.bs.affix', function(){
     /*Fix affix class jumping around when the page is all the way to the top and you click oanywhere.*/
         if( !$( window ).scrollTop() ) return false;
     } );
     
    $('#bs-example-navbar-collapse-1').on('shown.bs.collapse', function(e) {
        /*fix iphone menu*/
        $(".navbar-collapse").css({ maxHeight: $(window).height() - $(".navbar-header").height() + "px"  });
    });


    window.fbAsyncInit = function() {
        FB.Canvas.setAutoGrow();
    };
   
});