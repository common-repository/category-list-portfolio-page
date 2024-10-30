<?php
class clppExtendedStyles{
	public function clpp_extended_style_page(){
		global $clpp_radio;
		?>
			<style>
				.clpp_input img, .clpp_cat_icon img, .clpp_cat_content, .clpp_cat_title_helper, aside .clpp_cat_title_helper{
					
					-moz-border-bottom-left-radius:<?php echo $clpp_radio['bottomleft'] ?>px;
					-moz-border-bottom-right-radius:<?php echo $clpp_radio['bottomright'] ?>px;
					
					-khtml-border-bottom-left-radius:<?php echo $clpp_radio['bottomleft'] ?>px;
					-khtml-border-bottom-right-radius:<?php echo $clpp_radio['bottomright'] ?>px;
							
					-webkit-border-bottom-left-radius:<?php echo $clpp_radio['bottomleft'] ?>px;
					-webkit-border-bottom-right-radius:<?php echo $clpp_radio['bottomright'] ?>px;
									
					border-bottom-left-radius:<?php echo $clpp_radio['bottomleft'] ?>px;
					border-bottom-right-radius:<?php echo $clpp_radio['bottomright'] ?>px;
				}
				.clpp_input img, .clpp_cat_icon img, .clpp_cat_content, aside .clpp_cat_title_helper{
					-moz-border-top-left-radius:<?php echo $clpp_radio['topleft'] ?>px;
					-moz-border-top-right-radius:<?php echo $clpp_radio['topright'] ?>px;
					
					-khtml-border-top-left-radius:<?php echo $clpp_radio['topleft'] ?>px;
					-khtml-border-top-right-radius:<?php echo $clpp_radio['topright'] ?>px;
					
					-webkit-border-top-left-radius:<?php echo $clpp_radio['topleft'] ?>px;
					-webkit-border-top-right-radius:<?php echo $clpp_radio['topright'] ?>px;
					
					border-top-left-radius:<?php echo $clpp_radio['topleft'] ?>px;
					border-top-right-radius:<?php echo $clpp_radio['topright'] ?>px;
				}
			</style>
		<?php
	}

	public function clpp_extended_style_widget(){
		$clpp_widget = get_option('clpp_widget_settings');
		if ($clpp_widget['cols'] >= 2){
			?><style>
				aside .clpp_cat_title_helper{
					z-index:999 !important;				
					display:none;
					padding-right:10px;
					filter:alpha(opacity=70);
					-moz-opacity:0.7;
					opacity: 0.7;
				}
			</style><?php
		}
		else{
			?><style>
				aside .clpp_cat_title_helper{
					bottom:0;
					width:100%
				}
				aside .clpp_cat_icon {
					overflow:hidden;
					position:relative;
				}
			</style><?php
		}
	}
}
?>