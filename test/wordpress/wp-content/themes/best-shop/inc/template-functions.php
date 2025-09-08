<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Best_Shop
 */

if( ! function_exists( 'best_shop_doctype' ) ) :
	/**
	 * Doctype Declaration
	*/
	function best_shop_doctype(){
		?>
		<!DOCTYPE html>
		<html <?php language_attributes(); ?>>
		<?php
	}
endif;
add_action( 'best_shop_doctype', 'best_shop_doctype' );

if( ! function_exists( 'best_shop_head' ) ) :
	/**
	 * Before wp_head 
	*/
	function best_shop_head(){
		?>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<?php
	}
endif;
add_action( 'best_shop_before_wp_head', 'best_shop_head' );

if( ! function_exists( 'best_shop_page_start' ) ) :
	/**
	 * Page Start
	*/
	function best_shop_page_start(){
		?>
		<div id="page" class="site">
			<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'best-shop' ); ?></a>
		<?php
	}
endif;
add_action( 'best_shop_before_header', 'best_shop_page_start' );



if( ! function_exists( 'best_shop_primary_page_header' ) ) :
/**
 * Page Header
*/
function best_shop_primary_page_header(){ 
	if( is_front_page() ) return;

	if( is_search() || is_home() || is_archive() || is_singular( 'product' ) ){ ?>
		<header class="page-header">
			<div class="container">
				<div class="breadcrumb-wrapper">
					<?php best_shop_breadcrumb(); ?>
				</div>
				<?php 
				if( best_shop_is_woocommerce_activated() && is_singular( 'product' ) ){
					the_title( '<h2 class="page-title">','</h2>' ); 
				}
				if( is_search() ) { ?>
					<h1 class="page-title">
						<?php
						/* translators: %s: search query. */
						printf( esc_html__( '%s', 'best-shop' ), get_search_query() );
						?>
					</h1>
				<?php } elseif( is_home() && ! is_front_page() ) { 	?>			
					<h1 class="page-title">
						<?php echo esc_html( best_shop_get_setting( 'blog_section_title' ) ); ?>
					</h1>					
				<?php }
				 elseif ( is_archive() ) { 	
					if( best_shop_is_woocommerce_activated() && is_shop() ){
						echo '<h1 class="page-title">';
						echo esc_html( get_the_title( wc_get_page_id( 'shop' ) ) );
						echo '</h1>';
					}elseif( is_author() ){
						the_archive_title( '<h1 class="page-title">', '</h1>' );
					}else{
						the_archive_title( '<h1 class="page-title">', '</h1>' );
					}
				} ?>
			</div>
		</header><!-- .page-header -->
	<?php 
	}
}
endif;
add_action( 'best_shop_before_posts_content', 'best_shop_primary_page_header', 10 );

if( ! function_exists( 'best_shop_entry_header' ) ) :
/**
 * Entry Header
*/
function best_shop_entry_header(){ 
	if ( is_single() ) { ?>
		<header class="entry-header">
			<div class="category--wrapper">
				<?php best_shop_category(); ?>
			</div>
			<div class="entry-title-wrapper">
				<?php the_title('<h1 class="entry-title">', '</h1>'); ?>
			</div>
			<?php best_shop_single_author_meta(); ?>
		</header>
	<?php } else { ?>
		<header class="entry-header">
			<div class="entry-meta">
				<?php best_shop_category(); ?>
			</div><!-- .entry-meta -->
			<div class="entry-details">
				<?php the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );	?>
			</div>
		</header><!-- .entry-header -->
	<?php }
}
endif;
add_action( 'best_shop_post_entry_header', 'best_shop_entry_header' );

if( ! function_exists( 'best_shop_entry_content' ) ) :
/**
 * Entry Content
*/
function best_shop_entry_content(){ 
	if( is_front_page() ) return;
	?>
	<div class="entry-content" itemprop="text">
		<?php
			if( is_singular() ){
				the_content();    
				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'best-shop' ),
					'after'  => '</div>',
				) );
			}elseif( is_archive() ){
				the_excerpt();
				best_shop_author_meta();
			}else{
				the_excerpt();
			}
		?>
	</div><!-- .entry-content -->
	<?php
}
endif;
add_action( 'best_shop_post_entry_content', 'best_shop_entry_content', 15 );

if( ! function_exists( 'best_shop_entry_footer' ) ) :
/**
 * Entry Footer
*/
function best_shop_entry_footer(){ 

	if( is_single() ){ ?>
		<footer class="entry-footer">
			<?php
				best_shop_tag();
				if( get_edit_post_link() ){
					edit_post_link(
						sprintf(
							wp_kses(
								/* translators: %s: Name of current post. Only visible to screen readers */
								__( 'Edit <span class="screen-reader-text">%s</span>', 'best-shop' ),
								array(
									'span' => array(
										'class' => array(),
									),
								)
							),
							get_the_title()
						),
						'<span class="edit-link">',
						'</span>'
					);
				}
			?>
		</footer><!-- .entry-footer -->
	<?php }
}
endif;
add_action( 'best_shop_post_entry_content', 'best_shop_entry_footer', 20 );


		
if( ! function_exists( 'best_shop_mail' ) ) :
/**
 * Mail Settings
 */
function best_shop_mail(){
	$mail_title       = best_shop_get_setting( 'mail_title' );
	$mail_address     = best_shop_get_setting( 'mail_description' );
	$emails           = explode( ',', $mail_address);
	if( $mail_title || $mail_address ){ ?>
		<div class="email-wrapper">
			<li>
				<div class="email-wrap">
					<div class="icon">
						<?php echo wp_kses( best_shop_social_icons_svg_list( 'email' ), best_shop_kses_extended_ruleset() ); ?>	
					</div>
				</div>
				<div class="email-details">
					<?php if( $mail_title ){ ?>
						<span class="email-title">
							<?php echo esc_html( $mail_title ); ?>
						</span>
					<?php }
					if( $mail_address ){ ?>
						<div class="email-desc">
							<?php foreach( $emails as $email ){ ?>
								<a href="<?php echo esc_url( 'mailto:' . sanitize_email( $email ) ); ?>" class="email-link">
									<?php echo esc_html( $email ); ?>
								</a>
							<?php } ?>
						</div>
					<?php } ?>
				</div>
			</li>
		</div>
	<?php }
}
endif;
add_action( 'best_shop_contact_page_details', 'best_shop_mail', 20 );
		
if( ! function_exists( 'best_shop_phone' ) ) :
/**
 * Phone Settings
 */
function best_shop_phone(){
	$phone_title        = best_shop_get_setting( 'phone_title' ); 
	$phone_number       = best_shop_get_setting( 'phone_number' ); 

	$phones = explode( ',', $phone_number);

	if( $phone_title || $phone_number ){ ?>
		<div class="phone-wrapper">
			<li>
				<div class="phone-wrap">
					<div class="icon">
					<?php echo wp_kses( best_shop_social_icons_svg_list( 'phone' ), best_shop_kses_extended_ruleset() ); ?>					
					</div>
				</div>
				<div class="phone-details">
					<?php if( $phone_title ){ ?>
						<span class="phone-title">
							<?php echo esc_html( $phone_title ); ?>
						</span>
					<?php } 
					if( $phone_number ){ ?>
						<div class="phone-number">
							<?php foreach( $phones as $phone ){ ?>
								<a href="<?php echo esc_url( 'tel:' . preg_replace( '/[^\d+]/', '', $phone ) ); ?>" class="tel-link">
									<?php echo esc_html( $phone ); ?>
								</a>
							<?php } ?>
						</div>
					<?php } ?>
				</div>
			</li>
		</div>
	<?php }
}
endif;
add_action( 'best_shop_contact_page_details', 'best_shop_phone', 30 );

if( ! function_exists( 'best_shop_breadcrumb' ) ) :
/**
 * Breadcrumbs
*/
function best_shop_breadcrumb(){ 
    global $post;
    $post_page  = get_option( 'page_for_posts' ); //The ID of the page that displays posts.
    $show_front = get_option( 'show_on_front' ); //What to show on the front page    
    $home       = best_shop_get_setting( 'home_text', __( 'Home', 'best-shop' ) ); // text for the 'Home' link
    $delimiter  = '<span class="separator"><svg width="13" height="13" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg" aria-label="Breadcrumb Icon"><path d="M6.839 12.02L5.424 10.607L10.024 6.007L5.424 1.407L6.839 0L12.849 6.01L6.84 12.02H6.839ZM1.414 12.02L0 10.607L4.6 6.007L0 1.414L1.414 0L7.425 6.01L1.415 12.02H1.414V12.02Z" /></svg></span>';
    $before     = '<span class="current" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">'; // tag before the current crumb
    $after      = '</span>'; // tag after the current crumb
    
    if( best_shop_get_setting( 'enable_breadcrumb', true ) ){
        $depth = 1;
        echo '<header class="page-header"> <div ><div class="breadcrumb-wrapper"><div id="crumbs" itemscope itemtype="http://schema.org/BreadcrumbList">
                <span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                    <a href="' . esc_url( home_url() ) . '" itemprop="item"><span itemprop="name">' . esc_html( $home ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" />' . $delimiter . '</span>';
        
        if( is_home() ){ 
            $depth = 2;                       
            echo $before . '<a itemprop="item" href="'. esc_url( get_the_permalink() ) .'"><span itemprop="name">' . esc_html( single_post_title( '', false ) ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" />' . $after;            
        }elseif( is_category() ){  
            $depth = 2;          
            $thisCat = get_category( get_query_var( 'cat' ), false );            
            if( $show_front === 'page' && $post_page ){ //If static blog post page is set
                $p = get_post( $post_page );
                echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url( get_permalink( $post_page ) ) . '" itemprop="item"><span itemprop="name">' . esc_html( $p->post_title ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" />' . $delimiter . '</span>';
                $depth++;  
            }            
            if( $thisCat->parent != 0 ){
                $parent_categories = get_category_parents( $thisCat->parent, false, ',' );
                $parent_categories = explode( ',', $parent_categories );
                foreach( $parent_categories as $parent_term ){
                    $parent_obj = get_term_by( 'name', $parent_term, 'category' );
                    if( is_object( $parent_obj ) ){
                        $term_url  = get_term_link( $parent_obj->term_id );
                        $term_name = $parent_obj->name;
                        echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url( $term_url ) . '"><span itemprop="name">' . esc_html( $term_name ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" />' . $delimiter . '</span>';
                        $depth++;
                    }
                }
            }
            echo $before . '<a itemprop="item" href="' . esc_url( get_term_link( $thisCat->term_id) ) . '"><span itemprop="name">' .  esc_html( single_cat_title( '', false ) ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" />' . $after;       
        }elseif( best_shop_is_woocommerce_activated() && ( is_product_category() || is_product_tag() ) ){ //For Woocommerce archive page
            $depth = 2;
            $current_term = $GLOBALS['wp_query']->get_queried_object();            
            if( wc_get_page_id( 'shop' ) ){ //Displaying Shop link in woocommerce archive page
                $_name = wc_get_page_id( 'shop' ) ? get_the_title( wc_get_page_id( 'shop' ) ) : '';
                if ( ! $_name ) {
                    $product_post_type = get_post_type_object( 'product' );
                    $_name = $product_post_type->labels->singular_name;
                }
                echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ) . '" itemprop="item"><span itemprop="name">' . esc_html( $_name ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" />' . $delimiter . '</span>';
                $depth++;
            }
            if( is_product_category() ){
                $ancestors = get_ancestors( $current_term->term_id, 'product_cat' );
                $ancestors = array_reverse( $ancestors );
                foreach ( $ancestors as $ancestor ) {
                    $ancestor = get_term( $ancestor, 'product_cat' );    
                    if ( ! is_wp_error( $ancestor ) && $ancestor ) {
                        echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url( get_term_link( $ancestor ) ) . '" itemprop="item"><span itemprop="name">' . esc_html( $ancestor->name ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" />' . $delimiter . '</span>';
                        $depth++;
                    }
                }
            }
            echo $before . '<a itemprop="item" href="' . esc_url( get_term_link( $current_term->term_id ) ) . '"><span itemprop="name">' . esc_html( $current_term->name ) .'</span></a><meta itemprop="position" content="'. absint( $depth ).'" />' . $after;
        }elseif( best_shop_is_woocommerce_activated() && is_shop() ){ //Shop Archive page
            $depth = 2;
            if( get_option( 'page_on_front' ) == wc_get_page_id( 'shop' ) ){
                return;
            }
            $_name    = wc_get_page_id( 'shop' ) ? get_the_title( wc_get_page_id( 'shop' ) ) : '';
            $shop_url = ( wc_get_page_id( 'shop' ) && wc_get_page_id( 'shop' ) > 0 )  ? get_the_permalink( wc_get_page_id( 'shop' ) ) : home_url( '/shop' );
            if( ! $_name ){
                $product_post_type = get_post_type_object( 'product' );
                $_name             = $product_post_type->labels->singular_name;
            }
            echo $before . '<a itemprop="item" href="' . esc_url( $shop_url ) . '"><span itemprop="name">' . esc_html( $_name ) . '</span></a><meta itemprop="position" content="' . absint( $depth ) . '" />' . $after;
        }elseif( is_tag() ){ 
            $depth          = 2;
            $queried_object = get_queried_object();
            echo $before . '<a itemprop="item" href="' . esc_url( get_term_link( $queried_object->term_id ) ) . '"><span itemprop="name">' . esc_html( single_tag_title( '', false ) ) . '</span></a><meta itemprop="position" content="' . absint( $depth ). '" />'. $after;
        }elseif( is_author() ){  
            global $author;
            $depth    = 2;
            $userdata = get_userdata( $author );
            echo $before . '<a itemprop="item" href="' . esc_url( get_author_posts_url( $author ) ) . '"><span itemprop="name">' . esc_html( $userdata->display_name ) .'</span></a><meta itemprop="position" content="' . absint( $depth ) . '" />' . $after;     
        }elseif( is_search() ){ 
            $depth       = 2;
            $request_uri = sanitize_text_field(wp_unslash($_SERVER['REQUEST_URI']));
            echo $before . '<a itemprop="item" href="'. esc_url( $request_uri ) . '"><span itemprop="name">' . sprintf( esc_html__( 'Search Results for "%s"', 'best-shop' ), esc_html( get_search_query() ) ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" />' . $after;        
        }elseif( is_day() ){            
            $depth = 2;
            echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url( get_year_link( get_the_time( __( 'Y', 'best-shop' ) ) ) ) . '" itemprop="item"><span itemprop="name">' . esc_html( get_the_time( __( 'Y', 'best-shop' ) ) ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" />' . $delimiter . '</span>';
            $depth++;
            echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url( get_month_link( get_the_time( __( 'Y', 'best-shop' ) ), get_the_time( __( 'm', 'best-shop' ) ) ) ) . '" itemprop="item"><span itemprop="name">' . esc_html( get_the_time( __( 'F', 'best-shop' ) ) ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" />' . $delimiter . '</span>';
            $depth++;
            echo $before . '<a itemprop="item" href="' . esc_url( get_day_link( get_the_time( __( 'Y', 'best-shop' ) ), get_the_time( __( 'm', 'best-shop' ) ), get_the_time( __( 'd', 'best-shop' ) ) ) ) . '"><span itemprop="name">' . esc_html( get_the_time( __( 'd', 'best-shop' ) ) ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" />' . $after;        
        }elseif( is_month() ){            
            $depth = 2;
            echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url( get_year_link( get_the_time( __( 'Y', 'best-shop' ) ) ) ) . '" itemprop="item"><span itemprop="name">' . esc_html( get_the_time( __( 'Y', 'best-shop' ) ) ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" />' . $delimiter . '</span>';
            $depth++;
            echo $before . '<a itemprop="item" href="' . esc_url( get_month_link( get_the_time( __( 'Y', 'best-shop' ) ), get_the_time( __( 'm', 'best-shop' ) ) ) ) . '"><span itemprop="name">' . esc_html( get_the_time( __( 'F', 'best-shop' ) ) ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" />' . $after;        
        }elseif( is_year() ){ 
            $depth = 2;
            echo $before .'<a itemprop="item" href="' . esc_url( get_year_link( get_the_time( __( 'Y', 'best-shop' ) ) ) ) . '"><span itemprop="name">'. esc_html( get_the_time( __( 'Y', 'best-shop' ) ) ) .'</span></a><meta itemprop="position" content="'. absint( $depth ).'" />'. $after;  
        }elseif( is_single() && !is_attachment() ){   
            $depth = 2;         
            if( best_shop_is_woocommerce_activated() && 'product' === get_post_type() ){ //For Woocommerce single product
                if( wc_get_page_id( 'shop' ) ){ //Displaying Shop link in woocommerce archive page
                    $_name = wc_get_page_id( 'shop' ) ? get_the_title( wc_get_page_id( 'shop' ) ) : '';
                    if ( ! $_name ) {
                        $product_post_type = get_post_type_object( 'product' );
                        $_name = $product_post_type->labels->singular_name;
                    }
                    echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ) . '" itemprop="item"><span itemprop="name">' . esc_html( $_name ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" />' . $delimiter . '</span>';
                    $depth++;                    
                }           
                if( $terms = wc_get_product_terms( $post->ID, 'product_cat', array( 'orderby' => 'parent', 'order' => 'DESC' ) ) ){
                    $main_term = apply_filters( 'woocommerce_breadcrumb_main_term', $terms[0], $terms );
                    $ancestors = get_ancestors( $main_term->term_id, 'product_cat' );
                    $ancestors = array_reverse( $ancestors );
                    foreach ( $ancestors as $ancestor ) {
                        $ancestor = get_term( $ancestor, 'product_cat' );    
                        if ( ! is_wp_error( $ancestor ) && $ancestor ) {
                            echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url( get_term_link( $ancestor ) ) . '" itemprop="item"><span itemprop="name">' . esc_html( $ancestor->name ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" />' . $delimiter . '</span>';
                            $depth++;
                        }
                    }
                    echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url( get_term_link( $main_term ) ) . '" itemprop="item"><span itemprop="name">' . esc_html( $main_term->name ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" />' . $delimiter . '</span>';
                    $depth++;
                }
                echo $before . '<a href="' . esc_url( get_the_permalink() ) . '" itemprop="item"><span itemprop="name">' . esc_html( get_the_title() ) .'</span></a><meta itemprop="position" content="'. absint( $depth ).'" />' . $after;
            }elseif( get_post_type() != 'post' ){                
                $post_type = get_post_type_object( get_post_type() );                
                if( $post_type->has_archive == true ){// For CPT Archive Link                   
                    // Add support for a non-standard label of 'archive_title' (special use case).
                    $label = !empty( $post_type->labels->archive_title ) ? $post_type->labels->archive_title : $post_type->labels->name;
                    echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url( get_post_type_archive_link( get_post_type() ) ) . '" itemprop="item"><span itemprop="name">' . esc_html( $label ) . '</span></a><meta itemprop="position" content="' . absint( $depth ) . '" />' . $delimiter . '</span>';
                    $depth++;    
                }
                echo $before . '<a href="' . esc_url( get_the_permalink() ) . '" itemprop="item"><span itemprop="name">' . esc_html( get_the_title() ) . '</span></a><meta itemprop="position" content="' . absint( $depth ) . '" />' . $after;
            }else{ //For Post                
                $cat_object       = get_the_category();
                $potential_parent = 0;
                
                if( $show_front === 'page' && $post_page ){ //If static blog post page is set
                    $p = get_post( $post_page );
                    echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url( get_permalink( $post_page ) ) . '" itemprop="item"><span itemprop="name">' . esc_html( $p->post_title ) . '</span></a><meta itemprop="position" content="' . absint( $depth ) . '" />' . $delimiter . '</span>';  
                    $depth++; 
                }
                
                if( $cat_object ){ //Getting category hierarchy if any        
                    //Now try to find the deepest term of those that we know of
                    $use_term = key( $cat_object );
                    foreach( $cat_object as $key => $object ){
                        //Can't use the next($cat_object) trick since order is unknown
                        if( $object->parent > 0  && ( $potential_parent === 0 || $object->parent === $potential_parent ) ){
                            $use_term         = $key;
                            $potential_parent = $object->term_id;
                        }
                    }                    
                    $cat  = $cat_object[$use_term];              
                    $cats = get_category_parents( $cat, false, ',' );
                    $cats = explode( ',', $cats );
                    foreach ( $cats as $cat ) {
                        $cat_obj = get_term_by( 'name', $cat, 'category' );
                        if( is_object( $cat_obj ) ){
                            $term_url  = get_term_link( $cat_obj->term_id );
                            $term_name = $cat_obj->name;
                            echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url( $term_url ) . '"><span itemprop="name">' . esc_html( $term_name ) . '</span></a><meta itemprop="position" content="' . absint( $depth ). '" />' . $delimiter . '</span>';
                            $depth++;
                        }
                    }
                }
                echo $before . '<a itemprop="item" href="' . esc_url( get_the_permalink() ) . '"><span itemprop="name">' . esc_html( get_the_title() ) . '</span></a><meta itemprop="position" content="' . absint( $depth ) . '" />' . $after;   
            }        
        }elseif( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ){ //For Custom Post Archive
            $depth     = 2;
            $post_type = get_post_type_object( get_post_type() );
            if( get_query_var('paged') ){
                echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url( get_post_type_archive_link( $post_type->name ) ) . '" itemprop="item"><span itemprop="name">' . esc_html( $post_type->label ) . '</span></a><meta itemprop="position" content="' . absint( $depth ) . '" />' . $delimiter . '/</span>';
                echo $before . sprintf( __('Page %s', 'best-shop'), esc_html(get_query_var('paged')) ) . $after; 
            }else{
                echo $before . '<a itemprop="item" href="' . esc_url( get_post_type_archive_link( $post_type->name ) ) . '"><span itemprop="name">' . esc_html( $post_type->label ) . '</span></a><meta itemprop="position" content="' . absint( $depth ). '" />' . $after;
            }    
        }elseif( is_attachment() ){ 
            $depth = 2;           
            echo $before . '<a itemprop="item" href="' . esc_url( get_the_permalink() ) . '"><span itemprop="name">' . esc_html( get_the_title() ) . '</span></a><meta itemprop="position" content="' . absint( $depth ) . '" />' . $after;
        }elseif( is_page() && !$post->post_parent ){            
            $depth = 2;
            echo $before . '<a itemprop="item" href="' . esc_url( get_the_permalink() ) . '"><span itemprop="name">' . esc_html( get_the_title() ) . '</span></a><meta itemprop="position" content="' . absint( $depth ) . '" />' . $after;
        }elseif( is_page() && $post->post_parent ){            
            $depth       = 2;
            $parent_id   = $post->post_parent;
            $breadcrumbs = array();
            while( $parent_id ){
                $current_page  = get_post( $parent_id );
                $breadcrumbs[] = $current_page->ID;
                $parent_id     = $current_page->post_parent;
            }
            $breadcrumbs = array_reverse( $breadcrumbs );
            for ( $i = 0; $i < count( $breadcrumbs) ; $i++ ){
                echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url( get_permalink( $breadcrumbs[$i] ) ) . '" itemprop="item"><span itemprop="name">' . esc_html( get_the_title( $breadcrumbs[$i] ) ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" />' . $delimiter . '</span>';
                $depth++;
            }
            echo $before . '<a href="' . get_permalink() . '" itemprop="item"><span itemprop="name">' . esc_html( get_the_title() ) . '</span></a><meta itemprop="position" content="' . absint( $depth ) . '" /></span>' . $after;
        }elseif( is_404() ){
            $depth = 2;
            echo $before . '<a itemprop="item" href="' . esc_url( home_url() ) . '"><span itemprop="name">' . '</span></a><meta itemprop="position" content="' . absint( $depth ). '" />' . $after;
        }
        
        if( get_query_var('paged') ) printf( __( ' (Page %s)', 'best-shop' ), esc_html(get_query_var('paged')) );
        
        echo '</div></div></header><!-- .crumbs -->';
        
    }                
}
endif;
