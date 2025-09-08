<?php
/* 
 * display post slider from given product category
 */

class best_shop_countdown_timer_widget extends WP_Widget {

function __construct() {		

		parent::__construct(
		  
		// Base ID of your widget
		'best_shop_countdown_timer_widget', 
		  
		// Widget name will appear in UI
		__('+ Countdown Timer', 'best-shop'), 
		  
		// Widget description
		array( 'description' => __( 'Display a countdown timer.', 'best-shop' ), ) 
		);
}

public function widget( $args, $instance ) {

      $to_date = ( ! empty( $instance['to_date'] ) ) ? absint( $instance['to_date'] ) : 1;
      $show_labels = ( ! empty( $instance['show_labels'] ) ) ? true : false;
      $to_month = (!empty($instance['to_month'])) ?  absint($instance['to_month']) : 12;
      $to_year = (!empty($instance['to_year'])) ? absint($instance['to_year']) : 2024;
      $text_to_show = ( ! empty( $instance['text_to_show'] ) ) ? wp_strip_all_tags( $instance['text_to_show'] ) : '';
    
    ?>    
      <div class="the-countdown" countdown="" data-date="<?php echo absint($to_month).' '; echo absint($to_date).' '; echo absint($to_year);?>" >
        <div class="countdown-item count-days"><span data-days="">0</span><?php if($show_labels){echo esc_html__("Day(s)", "best-shop");}?></div>
        <div class="countdown-item count-hours"><span data-hours="">0</span><?php if($show_labels){echo esc_html__("Hour(s)", "best-shop");}?></div>
        <div class="countdown-item count-minutes"><span data-minutes="">0</span><?php if($show_labels){echo esc_html__("Minute(s)", "best-shop");}?></div>
        <div class="countdown-item count-seconds"><span data-seconds="">0</span><?php if($show_labels){echo esc_html__("Second(s)", "best-shop");}?></div>
      </div>

    <?php 
    
}
		
public function form( $instance ) {
		$to_date = ( ! empty( $instance['to_date'] ) ) ? absint( $instance['to_date'] ) : 1;
        $show_labels = ( ! empty( $instance['show_labels'] )) ? (bool) $instance['show_labels'] : false;
		$to_month = (!empty($instance['to_month'])) ?  absint($instance['to_month']) : 12;
		$to_year = (!empty($instance['animation'])) ? absint($instance['to_year']) : 2024;
		$text_to_show = ( ! empty( $instance['text_to_show'] ) ) ? wp_strip_all_tags( $instance['text_to_show'] ) : esc_html__('Limited time offer', 'best-shop');
    
		?>

		<p>
		<label for="<?php echo esc_attr($this->get_field_id( 'to_date' )); ?>"><?php esc_html_e( 'To date:','best-shop'  ); ?></label> 
		<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'to_date' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'to_date' )); ?>" type="number" value="<?php echo esc_attr( $to_date ); ?>" />
		</p>
		
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('to_year')); ?>">
			<?php esc_html_e( 'To Year:', 'best-shop' ); ?></label><br />
			<input type="text" name="<?php echo esc_attr($this->get_field_name('to_year')); ?>" id="<?php echo esc_attr($this->get_field_id('to_year')); ?>" value="<?php if ($to_year) : echo absint($to_year); endif; ?>" class="widefat" />
		</p>
		
					
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('to_month')); ?>">
			<?php esc_html_e( 'To Month:', 'best-shop' ); ?></label><br />
			<input type="number" name="<?php echo esc_attr($this->get_field_name('to_month')); ?>" id="<?php echo esc_attr($this->get_field_id('to_month')); ?>" value="<?php echo absint($to_month);?>" class="widefat" />
		</p>


		<p>
			<label for="<?php echo esc_attr($this->get_field_id('text_to_show')); ?>">
			<?php esc_html_e( 'Timer message (Keep empty to hide):', 'best-shop' ); ?></label><br />
			<input type="text" name="<?php echo esc_attr($this->get_field_name('text_to_show')); ?>" id="<?php echo esc_attr($this->get_field_id('text_to_show')); ?>" value="<?php if ($text_to_show) : echo esc_attr($text_to_show); endif; ?>" class="widefat" />
		</p>
				

		<p>
		<input class="checkbox" type="checkbox" <?php checked( $show_labels ); ?>  id="<?php echo esc_attr($this->get_field_id( 'show_labels' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'show_labels' )); ?>" />
		<label for="<?php echo esc_attr($this->get_field_id( 'show_labels' )); ?>"><?php esc_html_e( 'Show timer labels','best-shop' ); ?></label> 
		</p>


		
		
		<?php 
		}

public function update( $new_instance, $old_instance ) {

		$instance = array();
		$instance['to_date'] = ( ! empty( $new_instance['to_date'] ) ) ? absint( $new_instance['to_date'] ) : '';
        $instance['show_labels'] = ( ! empty( $new_instance['show_labels'] ) ) ? 1 : 0 ;
		$instance['to_month'] = ( ! empty( $new_instance['to_month'] ) ) ? absint( $new_instance['to_month'] ) : '';
		$instance['to_year'] = (!empty($new_instance['to_year'])) ? absint($new_instance['to_year']): '';
		$instance['text_to_show'] = ( ! empty( $new_instance['text_to_show'] ) ) ? wp_strip_all_tags( $new_instance['text_to_show'] ) : '';
		
		return $instance;
	 }
}

function best_shop_countdown_timer_widget() {
		register_widget( 'best_shop_countdown_timer_widget' );
}
add_action( 'widgets_init', 'best_shop_countdown_timer_widget' );