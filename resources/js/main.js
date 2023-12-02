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

})(jQuery);
