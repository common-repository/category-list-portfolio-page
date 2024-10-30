<?php
//register menu for admin page and start the main function
add_action('admin_menu', 'clpp_admin_actions');
function clpp_admin_actions() {
	add_plugins_page("Category List Portfolio Page", __('Options of the Category List Portfolio Page', 'category-list-portfolio-page'), current_user_can('administrator'),"category-list-portfolio-page", "clpp_admin_page");
	add_action('admin_init', 'clpp_admin_style');
	
}
//set css file
function clpp_admin_style() {
	global $clpp_name;
	wp_enqueue_style("clpp_admin_style", plugins_url( $clpp_name . '/admin-style.css' , dirname(__FILE__) ), false, "1.0", "all");  
}
//switcher or main function
function clpp_admin_page(){
	clpp_title();
	if (isset($_REQUEST['save'])){
		clpp_save();
		clpp_all_right(__('URLs are saved', 'category-list-portfolio-page'),
						__('Ok. If images are not refreshed, please rename your new images. The page only display images from your url, example: http://myblog.com/something/myimage.jpg, not from other sites: http://othersite/something/image.jpg ', 'category-list-portfolio-page'));
	}
	elseif (isset($_REQUEST['mod_size'])){
		clpp_save_sizes();
		clpp_all_right(__('Width and height of images are saved', 'category-list-portfolio-page'),
						__('Ok. If width will be too wide, images will be scaled.', 'category-list-portfolio-page'));
	}
	elseif (isset($_REQUEST['mod_cols'])){
		clpp_save_columns();
		clpp_all_right(__('Columns are saved', 'category-list-portfolio-page'),
						__('Ok. One (1) is the minimum and Four (4) is the maximum.', 'category-list-portfolio-page'));
	}
	elseif (isset($_REQUEST['mod_radio'])){
		clpp_save_radio();
		clpp_all_right(__('Rounded CSS3 options are saved', 'category-list-portfolio-page'),
						__('Ok. Zero (0) is the minimum and fifteen (15) is the maximum.', 'category-list-portfolio-page'));
	}
	clpp_install_settings();
	clpp_radio_number();
	clpp_cat_col_number();
	clpp_imgsize_form();
	clpp_cat_list();
	//clpp_extended_style(); //none-compatibility
}

function clpp_install_settings(){
	global $clpp_sizes;
	global $clpp_urls;
	global $clpp_radio;
	global $clpp_name;
	if ($clpp_sizes['width'] == ''){
		$clpp_sizes['width'] = 250;
		$clpp_sizes['height'] = 100;
		$clpp_sizes['columns'] = 2;
		update_option('clpp_settings_sizes', $clpp_sizes);
	}
	$image = plugins_url( $clpp_name . '/images/default.jpg' , dirname(__FILE__) );
	$cats = get_categories();
	foreach ($cats as $cat){
		if ($clpp_urls[$cat->cat_ID] == ''){
			$clpp_urls[$cat->cat_ID] = $image;
		}
	}
	update_option('clpp_settings_urls', $clpp_urls);
	
	if (count($clpp_radio) != 4){
		$clpp_radio['topleft'] = 4;
		$clpp_radio['topright'] = 4;
		$clpp_radio['bottomleft'] = 4;
		$clpp_radio['bottomright'] = 4;
		
		update_option('clpp_settings_radio', $clpp_radio);
	}
}

function clpp_save_radio(){
	global $clpp_radio;
	$clpp_radio['topleft'] = clpp_i_want_to_be_number($_REQUEST['clpp_topleft'], "0-9", 4, 0, 15);
	$clpp_radio['topright'] = clpp_i_want_to_be_number($_REQUEST['clpp_topright'], "0-9", 4, 0, 15);
	$clpp_radio['bottomleft'] = clpp_i_want_to_be_number($_REQUEST['clpp_bottomleft'], "0-9", 4, 0, 15);
	$clpp_radio['bottomright'] = clpp_i_want_to_be_number($_REQUEST['clpp_bottomright'], "0-9", 4, 0, 15);
	
	update_option('clpp_settings_radio', $clpp_radio);
}

function clpp_save_sizes(){
	global $clpp_sizes;
	$clpp_sizes['width'] = clpp_i_want_to_be_number($_REQUEST['clpp_width'], "0-9", 300, 10, 1000);
	$clpp_sizes['height'] = clpp_i_want_to_be_number($_REQUEST['clpp_height'], "0-9", 200, 10, 700);
	
	update_option('clpp_settings_sizes', $clpp_sizes);
}

function clpp_save_columns(){
	global $clpp_sizes;
	$clpp_sizes['columns'] = clpp_i_want_to_be_number($_REQUEST['clpp_cols'], "0-4", 2, 1, 4);
	
	update_option('clpp_settings_sizes', $clpp_sizes);
}

function clpp_save(){
	global $clpp_urls;
	$image;
	$cats = get_categories();
	
	foreach ($cats as $cat){
		$clpp_urls[$cat->cat_ID] = esc_attr($_REQUEST['clpp_link_'.$cat->cat_ID]);
	}
	update_option('clpp_settings_urls', $clpp_urls);
}
//if user really want to delete
function clpp_i_want_to_be_number($number_in_string = '', $allowed_nums, $standard_value, $min, $max){
	if ( preg_match( "/[^".$allowed_nums.".]/", $number_in_string ) ){
		$number_in_string = $standard_value;
	}
	else{
		$number_in_string = intval($number_in_string);
		if ($number_in_string > $max){
			$number_in_string = $max;
		}
		elseif ($number_in_string < $min){
			$number_in_string = $min;
		}
	}
	return $number_in_string;
}

//display plugin's admin page title
function clpp_title(){
	?><table class="clpp-table clpp_title">
		<tr>
			<th><?php _e('Category List Portfolio Page', 'category-list-portfolio-page') ?></th>
		</tr>
		<tr>
			<td><?php _e('This is a Category lister plugin. Create a page and paste this shortcode: <strong>[clpp-belicza]</strong>. Now, You and anybody can see the Post\'s Category List of your site. You can upload new images for Category icons, but you must use urls only from your site, not from other sites. And yes, there is some other nice options.', 'category-list-portfolio-page'); _e('You can activate the listing in Page or in Widget','category-list-portfolio-page'); ?></td>
		</tr>
	</table><?php
}
//ok window
function clpp_all_right($title,$message){
	?><table class="clpp-table clpp_ok">
		<tr>
			<th><?php echo $title ?></th>
		</tr>
		<tr>
			<td class="clpp_input"><?php echo $message ?></td>
		</tr>
	</table><?php
}

function clpp_radio_number(){
	global $clpp_radio;
	?><form action="" method="post">
		<table class="clpp-table">
			<tr>
				<td>
					<input id="mod_radio" name="mod_radio" type="submit" value="<?php _e('Save radius','category-list-portfolio-page') ?>" />
				</td><td></td>
			</tr>	
			<tr>
				<th><?php _e('Border name', 'category-list-portfolio-page') ?></th>
				<th><?php _e('Rounded border radius', 'category-list-portfolio-page') ?></th>
			</tr>
			<tr class="clpp_line">
				<td class="clpp_input">
					<?php _e('Top-Left', 'category-list-portfolio-page') ?>
				</td>
				<td class="clpp_input">
					<input name="clpp_topleft" id="clpp_topleft" type="text" value="<?php echo $clpp_radio['topleft'] ?>" />
				</td>
			</tr>
			<tr class="clpp_line">
				<td class="clpp_input">
					<?php _e('Top-Right', 'category-list-portfolio-page') ?>
				</td>
				<td class="clpp_input">
					<input name="clpp_topright" id="clpp_topright" type="text" value="<?php echo $clpp_radio['topright'] ?>" />
				</td>
			</tr>
			<tr class="clpp_line">
				<td class="clpp_input">
					<?php _e('Bottom-Left', 'category-list-portfolio-page') ?>
				</td>
				<td class="clpp_input">
					<input name="clpp_bottomleft" id="clpp_bottomleft" type="text" value="<?php echo $clpp_radio['bottomleft'] ?>" />
				</td>
			</tr>
			<tr class="clpp_line">
				<td class="clpp_input">
					<?php _e('Bottom-Right', 'category-list-portfolio-page') ?>
				</td>
				<td class="clpp_input">
					<input name="clpp_bottomright" id="clpp_bottomright" type="text" value="<?php echo $clpp_radio['bottomright'] ?>" />
				</td>
			</tr>
			<tr>
				<td>
					<input id="mod_radio" name="mod_radio" type="submit" value="<?php _e('Save radius','category-list-portfolio-page') ?>" />
				</td><td></td>
			</tr>
		</table>
	</form><?php	
}

function clpp_cat_col_number(){
	global $clpp_sizes;
	?><form action="" method="post">
		<table class="clpp-table">
			<tr>
				<td>
					<input id="mod_cols" name="mod_cols" type="submit" value="<?php _e('Save Columns','category-list-portfolio-page') ?>" />
				</td><td></td>
			</tr>	
			<tr>
				<th><?php _e('Columns', 'category-list-portfolio-page') ?></th>
				<th><?php _e('Value', 'category-list-portfolio-page') ?></th>
			</tr>
			<tr class="clpp_line">
				<td class="clpp_input">
					<?php _e('Numbers of the Category Page\'s columns', 'category-list-portfolio-page') ?>
				</td>
				<td class="clpp_input">
					<input name="clpp_cols" id="clpp_cols" type="text" value="<?php echo $clpp_sizes['columns'] ?>" />
				</td>
			</tr>
			<tr>
				<td>
					<input id="mod_cols" name="mod_cols" type="submit" value="<?php _e('Save Columns','category-list-portfolio-page') ?>" />
				</td><td></td>
			</tr>
		</table>
	</form><?php		
}

function clpp_imgsize_form(){
	global $clpp_sizes;
	?><form action="" method="post">
		<table class="clpp-table">
			<tr>
				<td>
					<input id="mod_size" name="mod_size" type="submit" value="<?php _e('Save sizes','category-list-portfolio-page') ?>" />
				</td><td></td>
			</tr>
			<tr>
				<th><?php _e('Dimension', 'category-list-portfolio-page') ?></th>
				<th><?php _e('Value', 'category-list-portfolio-page') ?></th>
			</tr>
			<tr class="clpp_line">
				<td class="clpp_input">
					<?php _e('Width', 'category-list-portfolio-page') ?>
				</td>
				<td class="clpp_input">
					<input name="clpp_width" id="clpp_width" type="text" value="<?php echo $clpp_sizes['width'] ?>" />
				</td>
			</tr>
			<tr class="clpp_line">	
				<td class="clpp_input">
					<?php _e('Height', 'category-list-portfolio-page') ?>
				</td>
				<td class="clpp_input">
					<input name="clpp_height" id="clpp_height" type="text" value="<?php echo $clpp_sizes['height'] ?>" />
				</td>
			<tr>
				<td>
					<input id="mod_size" name="mod_size" type="submit" value="<?php _e('Save sizes','category-list-portfolio-page') ?>" />
				</td><td></td>
			</tr>
		</table>
	</form><?php
}
//quote list for modify
function clpp_cat_list(){
	global $clpp_name;
	global $clpp_urls;
	global $clpp_sizes;
	$image;
	$cats = get_categories();
	//$imagescript = plugins_url( $clpp_name . '/scripts/timthumb.php?src=' , dirname(__FILE__) );
	
	?><form action="" method="post">
		<table class="clpp-table">
			<tr>
				<td>
					<input id="save" name="save" type="submit" value="<?php _e('Save Urls','category-list-portfolio-page') ?>" />
				</td><td></td><td></td><td></td>
			</tr>
			<tr>
				<th><?php _e('Image', 'category-list-portfolio-page') ?></th>
				<th><?php _e('Category Name', 'category-list-portfolio-page') ?></th>
				<th><?php _e('URL of the image', 'category-list-portfolio-page') ?></th>
			</tr><?php
	//one line
	foreach ($cats as $cat){
		//$image = $imagescript . $clpp_urls[$cat->cat_ID];
		$image = $clpp_urls[$cat->cat_ID];
		?>
			<tr class="clpp_line">
				<td class="clpp_input">
					<img src="<?php echo $image ?>" width="<?php echo $clpp_sizes['width'] ?>" height="<?php echo $clpp_sizes['height'] ?>" alt="">
				</td>
				<td class="clpp_input">
					<?php echo $cat->name ?>
				</td>
				<td class="clpp_input">
					<input name="clpp_link_<?php echo $cat->cat_ID ?>" id="clpp_link_<?php echo $cat->cat_ID ?>" type="text" value="<?php echo stripslashes($clpp_urls[$cat->cat_ID]) ?>" />
					<input type="hidden" name="clpp_id" value="<?php $cat->cat_ID ?>">
				</td>
			</tr>
		<?php
	}
			?><tr>
				<td>
					<input id="save" name="save" type="submit" value="<?php _e('Save Urls','category-list-portfolio-page') ?>" />
				</td><td></td><td></td><td></td>
			</tr>
		</table>
	</form><?php
}
?>