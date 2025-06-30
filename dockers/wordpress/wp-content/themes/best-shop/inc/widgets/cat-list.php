<?php
/*
 * Display product category meta
 */
if (!class_exists('WooCommerce')) return;

class best_shop_product_category_meta_widget extends WC_Widget {

		function __construct() {
			
				$this->widget_cssclass    = 'woocommerce product_category_meta_widget';
				$this->widget_description = __( 'Display product Category with a product count', 'best-shop' );
				$this->widget_id          = 'best_shop_product_cat_meta_widget';
				$this->widget_name        = __( '+ Product Category List', 'best-shop' );
		
				parent::__construct();
				
		}

		public function widget($args, $instance) {
		
				$max_items = (!empty($instance['max_items'])) ? strip_tags($instance['max_items']) : 6;
				$min_height = (!empty($instance['min_height'])) ? strip_tags($instance['min_height']) : 200;
				$category = (!empty($instance['category'])) ? strip_tags($instance['category']) : '';
				$colums = (!empty($instance['colums'])) ? strip_tags($instance['colums']) : "col-md-12 col-sm-12 col-lg-12 col-xs-12";
				
				$cat_count = 0;
				
				global $best_shop_product_categories;
				
				best_shop_set_all_product_categories();
				$all_categories = $best_shop_product_categories;
				

                echo '<div class="category-list-widget-container multi-columns-row">';
            
				foreach ($all_categories as $cat) {			
				
				
				$cat_count++;
				
					if($cat_count>$max_items) {
						continue;	
					}
					$image = $cat->image_url;
					if ($image == '') $image = get_template_directory_uri() . '/images/no-image.png';
					
					if ( ($category && $cat->id == $category) || (!$category) ) {
						echo '<div class="' . esc_attr($colums) . ' category-list-widget" >';
						echo '<a href="' . esc_url($cat->link) . '">';
						echo '<img src="' . esc_url($image) . '" style="height:'.absint($min_height).'px;width:'.absint($min_height).'px" />';
						echo '<div class="category-meta">' . esc_html($cat->name) . '<br />(' . absint($cat->count) . ')</div>';
						echo '</a>';
						echo '</div>';
					}
				} /* end for each */
            
                echo '</div>';


		}

		public function form($instance) {
				$max_items = (!empty($instance['max_items'])) ? strip_tags($instance['max_items']) : 6;
				$min_height = (!empty($instance['min_height'])) ? strip_tags($instance['min_height']) : 200;
				$category = (!empty($instance['category'])) ? strip_tags($instance['category']) : '';
				$colums = (!empty($instance['colums'])) ? strip_tags($instance['colums']) : "col-md-12 col-sm-12 col-lg-12 col-xs-12";

				$product_colums = array(
					"col-md-12 col-sm-12 col-lg-12 col-xs-12" => 1,
					"col-md-6 col-sm-6 col-lg-6 col-xs-12" => 2,
					"col-md-4 col-sm-4 col-lg-4 col-xs-12" => 3,
					"col-md-3 col-sm-3 col-lg-3 col-xs-12" => 4,
					"col-md-2 col-sm-2 col-lg-2 col-xs-12" => 6,
				);

				$args = array(
					'taxonomy' => 'product_cat',
					'orderby' => 'date',
					'order' => 'ASC',
					'show_count' => 1,
					'pad_counts' => 0,
					'hierarchical' => 0,
					'title_li' => '',
					'hide_empty' => 1,
				);

				$categories = get_categories($args);
				$category_list = '';
				if (0 == $category) {
						$category_list = $category_list . '<option value="0" Selected=selected>' . __('All', 'best-shop') . '</option>';
				}
				else {
						$category_list = $category_list . '<option value="0">' . __('All', 'best-shop') . '</option>';
				}
				foreach ($categories as $cat) {
						$selected = '';
						if (($cat->term_id) == $category) {
								$selected = 'Selected=selected';
						}
						$category_list = $category_list . '<option value="' . esc_attr($cat->term_id) . '" ' . $selected . ' >' . esc_html($cat->name) . '</option>';
				}
		?>
		<p>
		<label for="<?php echo esc_attr($this->get_field_id('category')); ?>"><?php esc_html_e('Select Category:', 'best-shop'); ?></label> 
		<select class="widefat" id="<?php echo esc_attr($this->get_field_id('category')); ?>" name="<?php echo esc_attr($this->get_field_name('category')); ?>" type="text">
		<?php echo $category_list; ?>
		</select>
		</p>		
		
		<p>
		<label for="<?php echo esc_attr($this->get_field_id('max_items')); ?>"><?php esc_html_e('Number of categories to Show:', 'best-shop'); ?></label> 
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id('max_items')); ?>" name="<?php echo esc_attr($this->get_field_name('max_items')); ?>" type="number" value="<?php echo esc_attr($max_items); ?>" />
		</p>
		
		<p>
		<label for="<?php echo esc_attr($this->get_field_id('colums')); ?>"><?php esc_html_e('Number of colums (If single category selected above):', 'best-shop'); ?></label> 
		<select class="widefat" id="<?php echo esc_attr($this->get_field_id('colums')); ?>" name="<?php echo esc_attr($this->get_field_name('colums')); ?>" type="text">
			<?php
				foreach ($product_colums as $key => $value) {
						if ($key == $colums) {
								echo '<option value="' . esc_attr($key) . '" Selected=selected>' . esc_html($value) . '</option>';
						}
						else {
								echo '<option value="' . esc_attr($key) . '" >' . esc_html($value) . '</option>';
						}
				}
			?>
		</select>
		</p>
		
		
		<p>
		<label for="<?php echo esc_attr($this->get_field_id('min_height')); ?>"><?php esc_html_e('Height (px):', 'best-shop'); ?></label> 
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id('min_height')); ?>" name="<?php echo esc_attr($this->get_field_name('min_height')); ?>" type="number" value="<?php echo esc_attr($min_height); ?>" />
		</p>
		
		<?php
		}

		public function update($new_instance, $old_instance) {
				$instance = array();
				$instance['max_items'] = (!empty($new_instance['max_items'])) ? strip_tags($new_instance['max_items']) : 6;
				$instance['min_height'] = (!empty($new_instance['min_height'])) ? strip_tags($new_instance['min_height']) : '';
				$instance['category'] = (!empty($new_instance['category'])) ? strip_tags($new_instance['category']) : '';
				$instance['colums'] = (!empty($new_instance['colums'])) ? strip_tags($new_instance['colums']) : "col-md-2 col-sm-2 col-lg-2 col-xs-12";
				return $instance;
		}
}

function best_shop_product_category_meta_widget() {
		register_widget('best_shop_product_category_meta_widget');
}
add_action('widgets_init', 'best_shop_product_category_meta_widget');