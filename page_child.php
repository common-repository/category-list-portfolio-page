<?php
class clppCategoryWidget extends clppCategoryPage{
	private $clpp_widget_options;
	
	function __construct($options){
		$this->clpp_widget_options = $options;
		$this->url = get_site_url();
		$this->permalink = $this->clpp_permalink();
		$this->colnumber = $this->clpp_widget_options['cols'];
		$this->width = $this->clpp_col_width();
		$this->clpp_img_size();
	}
	private function clpp_img_size(){
		$this->imgheight = $this->clpp_widget_options['height'];
	}
}


?>