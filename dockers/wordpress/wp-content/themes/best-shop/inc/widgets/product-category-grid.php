<?php
/* 
 * display product grid from given product category
 */
if(!class_exists('WooCommerce')) return;

class best_shop_product_category_grid_widget extends WC_Widget {

function __construct() {
		
      $this->widget_cssclass    = 'woocommerce best_shop_product_category_grid_widget';
      $this->widget_description = __( 'Display Product Category.', 'best-shop' );
      $this->widget_id          = 'best_shop_product_category_grid_widget';
      $this->widget_name        = __( '+ Product by Category Grid', 'best-shop' );

      parent::__construct();
}

public function widget( $args, $instance ) {

      $max_items = ( ! empty( $instance['max_items'] ) ) ? absint( $instance['max_items'] ) : 10;
      $category = ( ! empty( $instance['category'] ) ) ? wp_strip_all_tags( $instance['category'] ) : -1;
      $colums = (!empty($instance['colums'])) ?  absint($instance['colums']) : 5;
      $pagination = ( ! empty( $instance['pagination'] ) ) ? true : false;
    
    
      $product_shortcode = '';

      if($category === '-1'){
          $product_shortcode = "[products limit='".$max_items."' columns='".$colums."' paginate='true' orderby='id'  order='DESC' ]";
      } else {
          $product_shortcode = "[products limit='".$max_items."' columns='".$colums."' category='".$category."'  orderby='id'  order='DESC' paginate='true' ]";
      }

      if(!$pagination) { $product_shortcode= str_replace("paginate='true'", '', $product_shortcode); }

      ?><div class="custom_product_widget"><?php

        echo do_shortcode(wp_kses_post($product_shortcode));

      ?></div><?php

}
		
public function form( $instance ) {
		$max_items = ( ! empty( $instance['max_items'] ) ) ? absint( $instance['max_items'] ) : 10;
		$category = ( ! empty( $instance['category'] ) ) ? wp_strip_all_tags( $instance['category'] ) : -1;
		$colums = (!empty($instance['colums'])) ?  absint($instance['colums']) : 5;
        $pagination = ( ! empty( $instance['pagination'] )) ? (bool) $instance['pagination'] : false;
		
    
		$args =	array(	'taxonomy'     => 'product_cat',
						'orderby'      => 'date',
						'order'      => 'ASC',
						'show_count'   => 1,
						'pad_counts'   => 0,
						'hierarchical' => 0,
						'title_li'     => '',
						'hide_empty'   => 1,
					);
		 
		$categories = get_categories( $args );
		$category_list = '';
		
		if(0 == $category){
			$category_list = $category_list.'<option value="-1" Selected=selected>'.esc_html__( 'All','best-shop').'</option>';
		} else{
			$category_list = $category_list.'<option value="-1">'.esc_html__( 'All','best-shop').'</option>';
		}
		
		foreach ( $categories as $cat ) {
			$selected ='';
			if( ($cat->slug)==$category ){
				$selected ='Selected=selected';
			}
			$category_list = $category_list.'<option value="'.esc_attr($cat->slug).'" '.esc_attr($selected).' >'.esc_html($cat->name).'</option>';
		}
		?>
		
		<p>
		<label for="<?php echo esc_attr($this->get_field_id( 'category' )); ?>"><?php esc_html_e( 'Select Product Category:','best-shop'  ); ?></label> 
		<select class="widefat" id="<?php echo esc_attr($this->get_field_id( 'category' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'category' )); ?>" type="text">
		<?php echo $category_list; ?>
		</select>
		</p>

		<p>
		<label for="<?php echo esc_attr($this->get_field_id( 'max_items' )); ?>"><?php esc_html_e( 'Number of Products to Show:','best-shop'  ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'max_items' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'max_items' )); ?>" type="number" value="<?php echo esc_attr( $max_items ); ?>" />
		</p>
		
		<p>
		<label for="<?php echo esc_attr($this->get_field_id( 'colums' )); ?>"><?php esc_html_e( 'Columns Per Row:','best-shop'  ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'colums' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'colums' )); ?>" type="number" value="<?php echo esc_attr( $colums ); ?>" />
		</p>

		<p>
		<input class="checkbox" type="checkbox" <?php checked( $pagination ); ?>  id="<?php echo esc_attr($this->get_field_id( 'pagination' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'pagination' )); ?>" />
		<label for="<?php echo esc_attr($this->get_field_id( 'pagination' )); ?>"><?php esc_html_e( 'Enable Pagination','best-shop' ); ?></label> 
		</p>
				
		
		<?php 
		}

public function update( $new_instance, $old_instance ) {

		$instance = array();
		$instance['max_items'] = ( ! empty( $new_instance['max_items'] ) ) ? absint( $new_instance['max_items'] ) : '';
		$instance['category'] = ( ! empty( $new_instance['category'] ) ) ? wp_strip_all_tags( $new_instance['category'] ) : '' ;
		$instance['colums'] = ( ! empty( $new_instance['colums'] ) ) ? absint( $new_instance['colums'] ) : '';
		$instance['pagination'] = ( ! empty( $new_instance['pagination'] ) ) ? 1 : 0 ;
    
		return $instance;
	 }
}

function best_shop_product_category_grid_widget() {
		register_widget( 'best_shop_product_category_grid_widget' );
}
add_action( 'widgets_init', 'best_shop_product_category_grid_widget' );