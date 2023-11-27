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
    $('#searchDateFrom, #searchDateTo').on('change', function(){
	    const dFrom = $('#searchDateFrom');
	    const dTo = $('#searchDateTo');
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
    });
});
