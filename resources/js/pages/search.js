$(function(){
    if (Cookies.get('panelFormalizedSearch') == undefined && Cookies.get('panelAdvancedSearch') == undefined){
        Cookies.set('panelFormalizedSearch', '1');
        $('#panelFormalizedSearch, #formalized-tab').addClass('active');
        $('#formalized-tab').addClass('show');
    }

    $('#tabContainer button[data-bs-toggle="tab"]').on('shown.bs.tab', function(){
        Cookies.set($(this).attr('id'), '1');
        if ($(this).attr('id') == 'panelAdvancedSearch'){
            setAdvancedControls();
        }
    });
    $('#tabContainer button[data-bs-toggle="tab"]').on('hidden.bs.tab', function(){
        Cookies.remove($(this).attr('id'));
    });


    if (Cookies.get('panelAdvancedSearch') == 1){
        setAdvancedControls();
    }
    function setAdvancedControls(){
        $('#lastField').trigger('focus');
    }

});

$(function(){
    const dFrom = $('#searchDateFrom');
    const dTo = $('#searchDateTo');

    function setDateRange(){
	    if (dFrom.val()){
            dTo.attr('min', dFrom.val());
        } else {
            dTo.removeAttr('min');
        }
        if (dTo.val()){
    	    dFrom.attr('max', dTo.val());
        } else {
	        dFrom.removeAttr('max');
        }
    }
    setDateRange();
    $('#searchDateFrom, #searchDateTo').on('change', function(){
        setDateRange();
    });
});


$(function(){
    const $advancedSearchForm = $('#advancedSearchForm');

    $('.remove-input').on('click', function () {
        $(this).parent().remove();
        $advancedSearchForm.data('submit-allowed', 1);
        $('#advancedSubmitButton').trigger('click');
    });

    $advancedSearchForm.on('submit', function (e) {
        if (!$(this).data('submit-allowed') && $("#lastField").val().trim() == ''){
            e.preventDefault();
        }
    });
});


$(function(){
    if ($("#isBtnSearch").val() == 1){
        $('html').animate(
            {
                scrollTop: $("#searchResults").offset().top,
            },
            500
        );
    }
});


