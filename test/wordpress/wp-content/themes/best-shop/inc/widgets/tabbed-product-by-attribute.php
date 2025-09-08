<?php
/* 
 * display product grid from given product category
 */
if(!class_exists('WooCommerce')) return;

class best_shop_tabbed_product_by_attribute_grid_widget extends WC_Widget {

function __construct() {
		
      $this->widget_cssclass    = 'woocommerce best_shop_tabbed_product_by_attribute_grid_widget';
      $this->widget_description = __( 'Display Tabbed Product by Attribute.', 'best-shop' );
      $this->widget_id          = 'best_shop_tabbed_tabbed_product_by_attribute_grid_widget';
      $this->widget_name        = __( '+ Tabbed Product by Attribute Grid', 'best-shop' );

      parent::__construct();
}

public function widget( $args, $instance ) {

    $max_items = ( ! empty( $instance['max_items'] ) ) ? absint( $instance['max_items'] ) : 10;
    $category1 = ( ! empty( $instance['category1'] ) ) ? wp_strip_all_tags( $instance['category1'] ) : '';
    $category2 = ( ! empty( $instance['category2'] ) ) ? wp_strip_all_tags( $instance['category2'] ) : '';
    $category3 = ( ! empty( $instance['category3'] ) ) ? wp_strip_all_tags( $instance['category3'] ) : '';
    $colums = (!empty($instance['colums'])) ?  absint($instance['colums']) : 5;
    $pagination = ( ! empty( $instance['pagination'] ) ) ? true : false;
    
    $product_shortcode1 = '';
    $product_shortcode2 = '';
    $product_shortcode3 = '';
    
    $product_shortcode = '';
        
    if($category1 == 'on_sale'){
        $product_shortcode1 = "[products limit='".absint($max_items)."' columns='".absint($colums)."' on_sale='true'  orderby='id'  order='DESC'  paginate=true ]";
    } if($category1 == 'best_selling'){
        $product_shortcode1 = "[products limit='".absint($max_items)."' columns='".absint($colums)."' best_selling='true' orderby='id'  order='DESC'  paginate=true ]";
    } if($category1 == 'featured'){
        $product_shortcode1 = "[products limit='".absint($max_items)."' columns='".absint($colums)."' visibility='featured' orderby='id'  order='DESC'  paginate=true  ]";
    } if($category1 == 'top_rated'){
        $product_shortcode1 = "[products limit='".absint($max_items)."' columns='".absint($colums)."' visibility='top_rated' orderby='id'  order='DESC' paginate=true ]";
    } if($category1 == 'newest'){
        $product_shortcode1 = "[products limit='".absint($max_items)."' columns='".absint($colums)."' orderby='id' order='DESC' visibility='visible'  paginate=true ]";
    } 
    
    if($category2 == 'on_sale'){
        $product_shortcode2 = "[products limit='".absint($max_items)."' columns='".absint($colums)."' on_sale='true'  orderby='id'  order='DESC'  paginate=true ]";
    } if($category2 == 'best_selling'){
        $product_shortcode2 = "[products limit='".absint($max_items)."' columns='".absint($colums)."' best_selling='true' orderby='id'  order='DESC'  paginate=true ]";
    } if($category2 == 'featured'){
        $product_shortcode2 = "[products limit='".absint($max_items)."' columns='".absint($colums)."' visibility='featured' orderby='id'  order='DESC'  paginate=true  ]";
    } if($category2 == 'top_rated'){
        $product_shortcode2 = "[products limit='".absint($max_items)."' columns='".absint($colums)."' visibility='top_rated' orderby='id'  order='DESC' paginate=true ]";
    } if($category2 == 'newest'){
        $product_shortcode2 = "[products limit='".absint($max_items)."' columns='".absint($colums)."' orderby='id' order='DESC' visibility='visible'  paginate=true ]";
    } 
    
    if($category3 == 'on_sale'){
        $product_shortcode3 = "[products limit='".absint($max_items)."' columns='".absint($colums)."' on_sale='true'  orderby='id'  order='DESC'  paginate=true ]";
    } if($category3 == 'best_selling'){
        $product_shortcode3 = "[products limit='".absint($max_items)."' columns='".absint($colums)."' best_selling='true' orderby='id'  order='DESC'  paginate=true ]";
    } if($category3 == 'featured'){
        $product_shortcode3 = "[products limit='".absint($max_items)."' columns='".absint($colums)."' visibility='featured' orderby='id'  order='DESC'  paginate=true  ]";
    } if($category3 == 'top_rated'){
        $product_shortcode3 = "[products limit='".absint($max_items)."' columns='".absint($colums)."' visibility='top_rated' orderby='id'  order='DESC' paginate=true ]";
    } if($category3 == 'newest'){
        $product_shortcode3 = "[products limit='".absint($max_items)."' columns='".absint($colums)."' orderby='id' order='DESC' visibility='visible'  paginate=true ]";
    } 
    
    if(!$pagination) { $product_shortcode1 = str_replace("paginate=true", " paginate=false", $product_shortcode1); }
    if(!$pagination) { $product_shortcode2 = str_replace("paginate=true", " paginate=false", $product_shortcode2); }
    if(!$pagination) { $product_shortcode3 = str_replace("paginate=true", " paginate=false", $product_shortcode3); }
    
    global $best_shop_uniqueue_id ;
    $tab1_id1 = ++$best_shop_uniqueue_id; //used for class name in all tabs
    $tab1_id2 = ++$best_shop_uniqueue_id;
    $tab1_id3 = ++$best_shop_uniqueue_id;
    
?>
    <div class="tabbed_product_widget">

        
    <ul class="product-tab-list">
    <?php if($category1 != '-1' && $category1 != ''): ?>
    <li><a href="javascript:rudrSwitchTab('tb_<?php echo absint($tab1_id1); ?>', 'content_<?php echo absint($tab1_id1); ?>', 'tabcontent_<?php echo absint($tab1_id1); ?>');" id="tb_<?php echo absint($tab1_id1); ?>" class="tabmenu active button"><?php echo esc_html(str_replace('_',' ',$category1)); ?></a></li>
    <?php endif; 
    if($category2 != '-1' && $category2 != ''): ?>
    <li><a href="javascript:rudrSwitchTab('tb_<?php echo absint($tab1_id2); ?>', 'content_<?php echo absint($tab1_id2); ?>', 'tabcontent_<?php echo absint($tab1_id1); ?>');" id="tb_<?php echo absint($tab1_id2); ?>" class="tabmenu button"><?php echo esc_html(str_replace('_',' ',$category2)); ?></a></li>
    <?php endif; 
    if($category3 != '-1' && $category3 != ''): ?>
    <li><a href="javascript:rudrSwitchTab('tb_<?php echo absint($tab1_id3); ?>', 'content_<?php echo absint($tab1_id3); ?>', 'tabcontent_<?php echo absint($tab1_id1); ?>');" id="tb_<?php echo absint($tab1_id3); ?>" class="tabmenu button"><?php echo esc_html(str_replace('_',' ',$category3)); ?></a></li>
    <?php endif; ?> 
    </ul>


    <?php if($category1 != '-1' && $category1 != ''): ?>        
    <div id="content_<?php echo absint($tab1_id1); ?>" class="tabcontent_<?php echo absint($tab1_id1); ?>"> 
      <?php  echo do_shortcode(wp_kses_post($product_shortcode1));?>
    </div>
    <?php endif; ?>

    <?php if($category2 != '-1' && $category2 != ''): ?>
    <div id="content_<?php echo absint($tab1_id2); ?>" class="tabcontent_<?php echo absint($tab1_id1); ?>" style="display:none;">
      <?php  echo do_shortcode(wp_kses_post($product_shortcode2));?>
    </div>
    <?php endif; ?>

    <?php if($category2 != '-1' && $category2 != ''): ?>
    <div id="content_<?php echo absint($tab1_id3); ?>" class="tabcontent_<?php echo absint($tab1_id1); ?>" style="display:none;">
      <?php  echo do_shortcode(wp_kses_post($product_shortcode3));?>
    </div>     
    <?php endif; ?>

        
</div> <!--end of html code-->
<?php
    $best_shop_uniqueue_id++;

}
		
public function form( $instance ) {
		$max_items = ( ! empty( $instance['max_items'] ) ) ? absint( $instance['max_items'] ) : 10;
		$category1 = ( ! empty( $instance['category1'] ) ) ? wp_strip_all_tags( $instance['category1'] ) : '';
		$category2 = ( ! empty( $instance['category2'] ) ) ? wp_strip_all_tags( $instance['category2'] ) : '';
		$category3 = ( ! empty( $instance['category3'] ) ) ? wp_strip_all_tags( $instance['category3'] ) : '';
		$colums = (!empty($instance['colums'])) ?  absint($instance['colums']) : 5;
        $pagination = ( ! empty( $instance['pagination'] )) ? (bool) $instance['pagination'] : false;

		 
		$categories = array( 'on_sale'=> esc_html__('On Sale','best-shop') , 
                             'best_selling'=>esc_html__('Best Selling','best-shop'), 
                             'top_rated'=>esc_html__('Top Rated','best-shop')  , 
                             'featured'=> esc_html__('Featured','best-shop'),
                             'newest'=> esc_html__('Newest','best-shop'),
                            
                           );
    
		$category_list1 = '';
        $category_list2 = '';
        $category_list3 = '';
		
		if(0 == $category1){
			$category_list1 = $category_list1.'<option value="-1" Selected=selected>'.esc_html__( 'Select Attribute','best-shop').'</option>';
		} else{
			$category_list1 = $category_list1.'<option value="-1">'.esc_html__( 'Select Attribute','best-shop').'</option>';
		}
    
		if(0 == $category2){
			$category_list2 = $category_list2.'<option value="-1" Selected=selected>'.esc_html__( 'Select Attribute','best-shop').'</option>';
		} else{
			$category_list2 = $category_list2.'<option value="-1">'.esc_html__( 'Select Attribute','best-shop').'</option>';
		}
    
		if(0 == $category3){
			$category_list3 = $category_list3.'<option value="-1" Selected=selected>'.esc_html__( 'Select Attribute','best-shop').'</option>';
		} else{
			$category_list3 = $category_list3.'<option value="-1">'.esc_html__( 'Select Attribute','best-shop').'</option>';
		}    
		
		foreach ( $categories as $cat=>$value ) {
			$selected ='';
            
			if( ($cat)==$category1 ){
				$selected ='Selected=selected';
			}
			$category_list1 = $category_list1.'<option value="'.esc_attr($cat).'" '.esc_attr($selected).' >'.esc_html($value).'</option>';
		}
    
		foreach ( $categories as $cat=>$value ) {
			$selected ='';
			if( ($cat)==$category2 ){
				$selected ='Selected=selected';
			}
			$category_list2 = $category_list2.'<option value="'.esc_attr($cat).'" '.esc_attr($selected).' >'.esc_html($value).'</option>';
		}
    
		foreach ( $categories as $cat=>$value ) {
			$selected ='';
			if( ($cat)==$category3 ){
				$selected ='Selected=selected';
			}
			$category_list3 = $category_list3.'<option value="'.esc_attr($cat).'" '.esc_attr($selected).' >'.esc_html($value).'</option>';
		}
    
		?>
		
		<p>
		<label for="<?php echo esc_attr($this->get_field_id( 'category1' )); ?>"><?php esc_html_e( 'Select Product Attribute:','best-shop'  ); ?></label> 
		<select class="widefat" id="<?php echo esc_attr($this->get_field_id( 'category1' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'category1' )); ?>" type="text">
		<?php echo $category_list1; ?>
		</select>
		</p>

		
		<p>
		<label for="<?php echo esc_attr($this->get_field_id( 'category2' )); ?>"><?php esc_html_e( 'Select Product Attribute:','best-shop'  ); ?></label> 
		<select class="widefat" id="<?php echo esc_attr($this->get_field_id( 'category2' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'category2' )); ?>" type="text">
		<?php echo $category_list2; ?>
		</select>
		</p>

		
		<p>
		<label for="<?php echo esc_attr($this->get_field_id( 'category3' )); ?>"><?php esc_html_e( 'Select Product Attribute:','best-shop'  ); ?></label> 
		<select class="widefat" id="<?php echo esc_attr($this->get_field_id( 'category3' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'category3' )); ?>" type="text">
		<?php echo $category_list3; ?>
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
		$instance['category1'] = ( ! empty( $new_instance['category1'] ) ) ? wp_strip_all_tags( $new_instance['category1'] ) : '' ;
		$instance['category2'] = ( ! empty( $new_instance['category2'] ) ) ? wp_strip_all_tags( $new_instance['category2'] ) : '' ;
		$instance['category3'] = ( ! empty( $new_instance['category3'] ) ) ? wp_strip_all_tags( $new_instance['category3'] ) : '' ;
    
		$instance['colums'] = ( ! empty( $new_instance['colums'] ) ) ? absint( $new_instance['colums'] ) : '';
		$instance['pagination'] = ( ! empty( $new_instance['pagination'] ) ) ? 1 : 0 ;
    
		return $instance;
	 }
}

function best_shop_tabbed_product_by_attribute_grid_widget() {
		register_widget( 'best_shop_tabbed_product_by_attribute_grid_widget' );
}
add_action( 'widgets_init', 'best_shop_tabbed_product_by_attribute_grid_widget' );