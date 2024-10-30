<?php
class clpp_widget extends WP_Widget {
	private $clpp_widget_options;
	
	public function __construct() {
		parent::WP_Widget( false, __('Category Icons','category-list-portfolio-page') );
		$this->clpp_widget_options = $this->clpp_widget_setup();
	}
	
	private function clpp_widget_setup(){
		$options = get_option("clpp_widget_settings");
		if (!is_array( $options )){
			$options = array(
				'title' => 'Category List',
				'cols' => 2,
				'height' => 50
			);
			update_option("clpp_widget_settings", $options);
		}
		return $options;
	}
	
	public function widget( $args, $instance ) {
		// Widget output		
		echo "<aside class=\"widget\">";
		echo "<h3 class=\"widget-title\">";
		echo $this->clpp_widget_options['title'];
		echo "</h3>";
		//Widget Content
		$list_in_widget = new clppCategoryWidget($this->clpp_widget_options);
		echo $list_in_widget->clpp_the_page();
		echo "</aside>";
		//widget style on visitor pages
		$style = new clppExtendedStyles();
		$style->clpp_extended_style_widget();
		$style->clpp_extended_style_page();
	}

	public function update($new_instance, $old_instance) {
		//Save widget options
		if (isset($_POST["clpp_widget_title"]) || isset($_POST["clpp_widget_cols"]) || isset($_POST["clpp_widget_height"]) ){
			$this->clpp_widget_options['title'] = $_POST["clpp_widget_title"];
			$this->clpp_widget_options['cols'] = clpp_i_want_to_be_number($_POST["clpp_widget_cols"],"0-4", 2, 1, 4);
			$this->clpp_widget_options['height'] = $_POST["clpp_widget_height"];
		}
		update_option("clpp_widget_settings", $this->clpp_widget_options);
	}

	public function form( $instance ) {
		//Output admin widget options form
		_e ('title: ', 'category-list-portfolio-page');
		?><br /><input name="clpp_widget_title" id="clpp_widget_title" type="text" value="<?php echo $this->clpp_widget_options['title'] ?>" /><br /><br /><?php
		_e ('Columns (1-4): ', 'category-list-portfolio-page');
		?><br /><input name="clpp_widget_cols" id="clpp_widget_cols" type="text" value="<?php echo $this->clpp_widget_options['cols'] ?>" /><br /><br /><?php
		_e ('Height of images (pixels):', 'category-list-portfolio-page');
		?><br /><input name="clpp_widget_height" id="clpp_widget_height" type="text" value="<?php echo $this->clpp_widget_options['height'] ?>" /><?php
	}
}
?>