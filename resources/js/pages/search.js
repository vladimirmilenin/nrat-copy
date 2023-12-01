$(function(){
    if (Cookies.get('panelFormalizedSearch') == undefined && Cookies.get('panelAdvancedSearch') == undefined){
        Cookies.set('panelFormalizedSearch', '1');
        $('#panelFormalizedSearch').addClass('show');
        $('#panelFormalizedSearch-open button').removeClass('collapsed');
    }
    $("#accordionSearchPanels .accordion-collapse").on('shown.bs.collapse', function () {
        Cookies.set($(this).attr('id'), '1');
    });
    $("#accordionSearchPanels .accordion-collapse").on('hidden.bs.collapse', function () {
        Cookies.remove($(this).attr('id'));
    });
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
    if ($("#isBtnSearch").val()){
        $('html').animate(
            {
                scrollTop: $("#searchResults").offset().top,
            },
            500
        );
    }
});


