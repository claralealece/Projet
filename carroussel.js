$(document).ready(function() {
    $('.carrousel').each(function() {
        var $carrousel = $(this),
            $img = $carrousel.find('ul li'),
            indexImg = $img.length - 1,
            i = 0,
            $currentImg = $img.eq(i),
            changeImg = function(newIndex) {
                $img.removeClass('active').css('opacity', '0');
                $img.eq(newIndex).addClass('active').css('opacity', '1');
                i = newIndex;
            },
            slideImg = function() {
                setTimeout(function() {
                    var nextIndex = i < indexImg ? i + 1 : 0;
                    changeImg(nextIndex);
                    slideImg();
                }, 4000);
            };

        $img.not('.active').css('opacity', '0');
        $currentImg.addClass('active');

        $carrousel.append('<div class="controls"><span class="prev">Précédent</span><span class="next">Suivant</span></div>');

        $carrousel.find('.next').click(function() {
            var nextIndex = i < indexImg ? i + 1 : 0;
            changeImg(nextIndex);
        });

        $carrousel.find('.prev').click(function() {
            var prevIndex = i > 0 ? i - 1 : indexImg;
            changeImg(prevIndex);
        });

        slideImg();
    });
});
