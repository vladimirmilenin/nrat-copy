"use strict";

import jQuery from 'jquery';

(function($){
    $.fn.readMore = function(){
        return this.each(function() {
            const $this = $(this);
            const $expandBlock = $this.find('.expanded-block');
            const $toggleButton = $this.find('a.read-more-link');
            const $gradientOvarlay = $this.find('.gradient-overlay');

            $toggleButton.on('click', function(){
                $gradientOvarlay.remove();
                $toggleButton.remove();
                $expandBlock.removeClass('expanded-block');
            });
        })

    }
})(jQuery);
