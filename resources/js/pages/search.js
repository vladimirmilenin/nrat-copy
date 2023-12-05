$(function(){

    function setDefaultSearchPanel($default_panel){
        if ($default_panel == 'advanced'){
            Cookies.remove('panelFormalizedSearch');
            $('#panelFormalizedSearch').removeClass('active');
            $('#formalized-tab').removeClass('active show');

            Cookies.set('panelAdvancedSearch', '1');
            $('#panelAdvancedSearch').addClass('active');
            $('#advanced-tab').addClass('active show');
        } else {
            Cookies.remove('panelAdvancedSearch');
            $('#panelAdvancedSearch').removeClass('active');
            $('#advanced-tab').removeClass('active show');

            Cookies.set('panelFormalizedSearch', '1');
            $('#panelFormalizedSearch').addClass('active');
            $('#formalized-tab').addClass('active show');
        }
    }

    if ($('#advancedSearchForm input[name="searchFilter[]"]').length > 1){
        setDefaultSearchPanel('advanced');
    }

    if (Cookies.get('panelFormalizedSearch') == undefined && Cookies.get('panelAdvancedSearch') == undefined){
        setDefaultSearchPanel('formalized');
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
        $('#advancedSubmitButton').trigger('click');
    });

    $advancedSearchForm.on('submit', function (e) {
        if ($('#advancedSearchForm input[name="searchFilter[]"]').length <= 1 && $("#lastField").val().trim() == ''){
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


