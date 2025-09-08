<?php
/**
 * Best Shop Customizer Note Control.
 * 
 * @package Best_Shop
*/

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( ! class_exists( 'best_shop_Notice_Control' ) ){

	class best_shop_Notice_Control extends WP_Customize_Control {
		
		public function render_content(){ ?>
            <div class="customizer_note_control">
            <a href="https://www.gradientthemes.com/product/wordpress-shopping-cart-theme/"  target="_blank" >
    	    <span class="customize-control-title"> 
    			<?php echo wp_kses_post( $this->label ); ?>
    		</span>
    
    		<?php if( $this->description ){ ?>
    			<span class="description customize-control-description">
    			<?php echo wp_kses_post( $this->description ); ?>
                </span></a>
            </div>
    		<?php }
        }
	}
}