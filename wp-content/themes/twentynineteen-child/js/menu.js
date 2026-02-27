// nav arrow set in moblie view
jQuery("ul.nav li.sub-menu div").each(function() {
    jQuery(this).children("a").after("<span class='arrow'><i class='fa fa-plus'></i></span>");
});
jQuery("ul.nav li.sub-menu div.menu .arrow").click(function() {
    if (jQuery(this).next().is(":visible")) {
        jQuery(this).children(".fa").removeClass("fa-minus");
        jQuery(this).children(".fa").addClass("fa-plus");
        jQuery(this).next().slideUp();
    } else {
        jQuery("ul.nav li.sub-menu div.menu .arrow .fa").removeClass("fa-minus");
        jQuery("ul.nav li.sub-menu div.menu .arrow .fa").addClass("fa-plus");
        jQuery("ul.nav li.sub-menu div.menu .arrow").next().slideUp();
        jQuery(this).children(".fa").removeClass("fa-plus");
        jQuery(this).children(".fa").addClass("fa-minus");
        jQuery(this).next().slideDown();
    }
});