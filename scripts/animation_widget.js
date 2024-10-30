jQuery(document).ready(function() {
	jQuery('aside .clpp_cat_icon').mousemove(function(e){
		jQuery('.clpp_cat_title_helper', this).show();
		jQuery('.clpp_cat_title_helper', this).css({
            top: (e.pageY + 5) + "px",
            left: (e.pageX + 5) + "px"
        });
	});
	jQuery('aside .clpp_cat_icon').mouseout(function(e){
        jQuery('.clpp_cat_title_helper', this).fadeOut("fast");
    });
});