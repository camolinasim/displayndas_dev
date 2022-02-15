(function ($) {
    $.fn.playVideo = function () {
        var $carrousel = this;
        var transferSlide = function(elem){

            var $elem = $(elem);
            var title = $elem.find('h1').clone();
            var learnMore = $elem.find('a').clone();
            $carrousel.find('.add-text').html(title).append(learnMore);   
            $carrousel.find('.add-text a').wrap('<div class="text-center carousel-learn-more"></div>');
        };
        
        $carrousel.find(".item.active video").each(function (i, elem) {
            try{
                elem.play();
            }
            catch(ex){
                console.error(ex);
            }
        });
        $carrousel.bind('slide.bs.carousel', function (e) {
            $(this).find("video").each(function (i, elem) {
                setTimeout(function () {
                    try{
                        elem.pause();
                    }catch(ex){
                        console.error(ex);
                    }
                }, 50);
            });
        });
        $carrousel.bind('slid.bs.carousel', function (e) {
            $(this).find("video").each(function (i, elem) {
                try{
                    elem.play()
                }catch(ex){
                    console.error(ex);
                }
            });
             $(this).find(".item.active  .carousel-caption").each(function (i, elem) {
                 transferSlide(elem);
            });
        });
        
        
        $carrousel.find(".item.active .carousel-caption").each(function (i, elem) {
             transferSlide(elem);
        });
        
        

        return this;
    };
}(jQuery));
