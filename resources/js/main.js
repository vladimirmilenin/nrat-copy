"use strict";

import jQuery from 'jquery';

(function($){

    /** Search Trick */
    $("#headerSearchForm, #mainSearchForm").on('submit', function(e){
        const $input = $(this).find('.search-input');
        if ($input.val().trim().length < 3){
            e.preventDefault();
        }
    });

    /** Scroll to top */
    function scrollRoutine(){
        var scrollDistance = $(document).scrollTop();
        if (scrollDistance > 100) {
            $('.scroll-to-top').fadeIn();
        } else {
            $('.scroll-to-top').fadeOut();
        }
    };
    scrollRoutine();
    $(document).on('scroll', function() {
        scrollRoutine();
    })

})(jQuery);
