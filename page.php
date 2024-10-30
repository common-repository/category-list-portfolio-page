<?php
class clppCategoryPage{
	protected $colnumber;
	protected $permalink;
	protected $url;
	protected $width;
	protected $imgwidth;
	protected $imgheight;
	
	function __construct(){
		global $clpp_sizes;
		$this->colnumber = $clpp_sizes['columns'];
		$this->url = get_site_url();
		$this->permalink = $this->clpp_permalink();
		$this->width = $this->clpp_col_width();
		$this->clpp_img_size();
	}
	
	private function clpp_img_size(){
		global $clpp_sizes;
		$this->imgwidth = $clpp_sizes['width'];
		$this->imgheight = $clpp_sizes['height'];
	}
	
	protected function clpp_permalink(){
		if (get_option('permalink_structure') == ''){
			return false;
		}
		return true;
	}
	
	protected function clpp_col_width(){
		if ($this->colnumber == 1){
			return 100;
		}
		elseif ($this->colnumber == 2){
			return 50;
		}
		elseif ($this->colnumber == 3){
			return 33;
		}
		return 25;
	}
	
	protected function clpp_categories(){
		global $clpp_name;
		global $clpp_sizes;
		global $clpp_urls;
		$page;
		$cats = get_categories();
		$imagescript = plugins_url( $clpp_name . '/scripts/timthumb.php?src=' , dirname(__FILE__) );
		$i = 0;
		
		$page .= "<div style=\"float:left;\">";
		foreach ($cats as $cat){
			$link;
			if ($this->permalink == true){
				$link = $this->url . "/category/" . $cat->slug . '/';
			}
			else{
				$link = $this->url . "/?cat=" . $cat->cat_ID;
			}
			if (($i) % $this->colnumber == 0){
				$float = "float:left;clear:both;";
			}
			else{
				$float = "float:left;";
			}
			
			$image = $clpp_urls[$cat->cat_ID];
			$page .= "<div class=\"clpp_cat_box\" style=\"". $float .";width:". $this->width ."%;\">
				<div class=\"clpp_cat_content\">
					<div class=\"clpp_cat_icon\">
						<div class=\"clpp_cat_title_helper\">
							<div class=\"clpp_cat_title\">
								<a href=\"". $link ."\" target=\"_self\" title=\"". $cat->cat_name ."\" rel=\"title\">
									" . $cat->cat_name . "
								</a>
							</div>
						</div>
						<a href=\"". $link ."\" target=\"_self\" title=\"". $cat->cat_name ."\" rel=\"title\">
							<img src=\"". $image ."\" width=\"".$this->imgwidth."\" height=\"".$this->imgheight."\" alt=\"\">
						</a>
					</div>
				</div>
			</div>";
			$i++;
		}
		$page .= "</div>";
		return $page;
	}
	
	public function clpp_the_page(){
		return $this->clpp_categories();
	}
}


?>