(function ($) {
    $(function () {
        $('select').material_select();
        $('.button-collapse').sideNav();
        $('.slider').slider();
        $('.modal-trigger').leanModal();
        $('#helpbtn_Chars').tooltip({delay: 60});
        $('.tooltipped').tooltip({delay: 50});
        $(".dropdown-button").dropdown();
        $('.collapsible').collapsible({
            accordion: false // A setting that changes the collapsible behavior to expandable instead of the default accordion style
        });
    }); // end of document ready
})(jQuery); // end of jQuery name space