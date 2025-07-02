<?php 
/**
* Best Shop Metabox for Header Layout
*
* @package Best_Shop
*
*/ 

function best_shop_add_header_layout_box(){
    $postID         = isset( $_GET['post'] ) ? sanitize_text_field( wp_unslash(($_GET['post']))) : '';
    $shop_id        = get_option( 'woocommerce_shop_page_id' );
    $template       = get_post_meta( $postID, '_wp_page_template', true );
    $page_templates = array( 'templates/contact.php' );
    /**
     * Remove sidebar metabox in shop page
    */
    if( ! in_array( $template, $page_templates ) && ( $shop_id != $postID )  ){
        add_meta_box( 
            'best_shop_header_layout',
            __( 'Header Layout', 'best-shop' ),
            'best_shop_header_layout_callback', 
            array( 'page','post'),
            'normal',
            'high'
        );
    }
}
add_action( 'add_meta_boxes', 'best_shop_add_header_layout_box' );


function best_shop_header_layout_callback(){
    global $post , $best_shop_header_layout;
    wp_nonce_field( basename( __FILE__ ), 'best_shop_pro_header_nounce' );
    ?>     
    <table class="form-table">
        <tr>
            <td colspan="4"><em class="f13"><?php esc_html_e( 'Choose Header Layout for current page. More options, See Customize > Theme Options > Header', 'best-shop' ); ?></em></td>
        </tr>    
        <tr>
            <td>
                <?php  
                  foreach( $best_shop_header_layout as $field ){  
                      $layout = get_post_meta( $post->ID, '_best_shop_header_layout', true ); 
                          if( empty( $layout ) ){
                              $layout = 'default';
                          }
                ?>
                
                        <div class="radio-image-wrapper" style="float:left; margin-right:30px;">
                            <input id="<?php echo esc_attr( $field['value'] ); ?>" type="radio" name="best_shop_header_layout" value="<?php echo esc_attr( $field['value'] ); ?> " <?php  echo(esc_attr(checked( $layout, $field['value'], false )) );   ?>/>
                            <label class="description" for="<?php echo esc_attr( $field['value'] ); ?>">                          
                                <?php echo(esc_html($field['label'] )); ?>
                            </label>
                        </div>
                        <?php 
                    } // end foreach 
                ?>
                <div class="clear"></div>
            </td>
        </tr>
    </table>
 <?php 
}

function best_shop_save_header_layout( $post_id ){
    global $best_shop_header_layout;

    // Verify the nonce before proceeding.
    if( !isset(  $_POST[ 'best_shop_pro_header_nounce' ] ) || !wp_verify_nonce( sanitize_key( $_POST[ 'best_shop_pro_header_nounce' ]), basename( __FILE__ ) ) )
        return;
    
    // Stop WP from clearing custom fields on autosave
    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )  
        return;
    
    $layout = isset( $_POST['best_shop_header_layout'] ) ? sanitize_key( $_POST['best_shop_header_layout'] ) : 'customizer-setting';

    if( array_key_exists( $layout, $best_shop_header_layout ) ){
        update_post_meta( $post_id, '_best_shop_header_layout', $layout );
    }else{
        delete_post_meta( $post_id, '_best_shop_header_layout' );
    }
      
}
add_action( 'save_post' , 'best_shop_save_header_layout' );