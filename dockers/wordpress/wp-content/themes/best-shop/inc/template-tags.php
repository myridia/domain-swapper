<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Best_Shop
 */

if ( ! function_exists( 'best_shop_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function best_shop_posted_on() {

		$time_string = '<time class="entry-date published updated" datetime="%1$s" itemprop="datePublished">%2$s</time><time class="updated" datetime="%3$s" itemprop="dateModified">%4$s</time>';   
		
		$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
		);
    
    	$posted_on = '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>';
	
		echo '<span class="posted-on">' . $posted_on . '</span>'; 

	}
endif;

if ( ! function_exists( 'best_shop_posted_by' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function best_shop_posted_by() {
		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x( 'By %s', 'post author', 'best-shop' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" itemprop="url"><span itemprop="name">' . esc_html( get_the_author() ) . '</span></a></span>'
		);

		echo '<span class="byline" itemprop="author" itemscope itemtype="https://schema.org/Person"> ' . $byline . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	}
endif;

if ( ! function_exists( 'best_shop_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function best_shop_post_thumbnail() {
	
		if ( post_password_required() || is_attachment() ) {
			return;
		}

		if ( is_singular() ) :

            if(has_post_thumbnail()): 
        ?>

			<div class="post-thumbnail">
				<?php the_post_thumbnail( 'full', array( 'itemprop' => 'image' ) ); ?>
			</div><!-- .post-thumbnail -->


              <?php
              $caption = get_the_post_thumbnail_caption();

              if ( $caption ) {
                  ?>

                  <figcaption class="wp-caption-text"><?php echo wp_kses_post( $caption ); ?></figcaption>

                  <?php
              }           



		      endif; 
        
              else : 
        ?>

			<figure class="post-thumbnail">
				<a href="<?php the_permalink(); ?>">
					<?php if( has_post_thumbnail() ) { ?>
						<?php the_post_thumbnail( 'best_shop_popular_posts', array( 'itemprop' => 'image' ) );
                                                      
                          $caption = get_the_post_thumbnail_caption();

                          if ( $caption ) {
                              ?>

                              <figcaption class="wp-caption-text"><?php echo wp_kses_post( $caption ); ?></figcaption>

                              <?php
                          }                                                      
                                                      
					}else{
						best_shop_get_fallback_svg( 'best_shop_popular_posts' );
					} ?>
				</a>
			</figure>

			<?php
		endif; // End is_singular().
	}
endif;

if ( ! function_exists( 'wp_body_open' ) ) :
	/**
	 * Shim for sites older than 5.2.
	 *
	 * @link https://core.trac.wordpress.org/ticket/12563
	 */
	function wp_body_open() {
		/**
         * Triggered after the opening <body> tag.
         *
         */
		do_action( 'wp_body_open' );
	}
endif;

if( ! function_exists( 'best_shop_get_posts' ) ) :
	/**
	 * Fuction to list Custom Post Type
	*/
	function best_shop_get_posts( $post_type = 'post', $slug = false ){    
		$args = array(
			'posts_per_page'   => -1,
			'post_type'        => $post_type,
			'post_status'      => 'publish',
			'suppress_filters' => true 
		);
		$posts_array = get_posts( $args );
		
		// Initate an empty array
		$post_options = array();
		$post_options[''] = __( ' -- Choose -- ', 'best-shop' );
		if ( ! empty( $posts_array ) ) {
			foreach ( $posts_array as $posts ) {
				if( $slug ){
					$post_options[ $posts->post_title ] = $posts->post_title;
				}else{
					$post_options[ $posts->ID ] = $posts->post_title;    
				}
			}
		}
		return $post_options;
		wp_reset_postdata();
	}
endif;

if ( ! function_exists( 'best_shop_tag' ) ) :
/**
 * Prints tags
 */
function best_shop_tag(){
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {
		$tags_list = get_the_tag_list( '', ' ' );
		if ( $tags_list ) {
			/* translators: 1: list of tags. */
			printf( '<div class="cat-tags" itemprop="about">' . esc_html__( '%1$sTags:%2$s %3$s', 'best-shop' ) . '</div>', '<span class="tags-title">', '</span>', $tags_list );
		}
	}
}
endif;

if( ! function_exists( 'best_shop_get_svg_icons' ) ) :
	/**
	 * Fuction to list svg
	*/
	function best_shop_get_svg_icons(){    

		$social_media = [ 'facebook', 'twitter', 'digg', 'instagram', 'pinterest', 'telegram', 'getpocket', 'dribbble', 'behance', 'unsplash', 'five-hundred-px', 'linkedin', 'wordpress', 'parler', 'mastodon', 'medium', 'slack', 'codepen', 'reddit', 'twitch', 'tiktok', 'snapchat', 'spotify', 'soundcloud', 'apple_podcast', 'patreon', 'alignable', 'skype', 'github', 'gitlab', 'youtube', 'vimeo', 'dtube', 'vk', 'ok', 'rss', 'facebook_group', 'discord', 'tripadvisor', 'foursquare', 'yelp', 'hacker_news', 'xing', 'flipboard', 'weibo', 'tumblr', 'qq', 'strava', 'flickr' ];
		
		// Initate an empty array
		$svg_options = array();
		$svg_options[''] = __( ' -- Choose -- ', 'best-shop' );
		
			foreach ( $social_media as $svg ) {			
				$svg_options[ $svg ] = esc_html( $svg );				
			}
		
		return $svg_options;
	}
endif;


/**
 * Primary Functions
 */

if ( ! function_exists( 'best_shop_site_branding' ) ) :
    /**
     * Site Branding
     */
    function best_shop_site_branding(){
        ?>
        <div class="site-branding" itemscope itemtype="https://schema.org/Organization">
            <?php if( function_exists( 'has_custom_logo' ) && has_custom_logo() ){            
                the_custom_logo();               
            } ?><div class="site-title-logo"><?php
           
            if ( is_front_page() ) :
                ?>
                <h2 class="site-title" itemprop="name"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" itemprop="url"><?php bloginfo( 'name' ); ?></a></h2>
                <?php
            else :
                ?>
                <p class="site-title" itemprop="name"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" itemprop="url"><?php bloginfo( 'name' ); ?></a></p>
                <?php
            endif;
            $best_shop_description = get_bloginfo( 'description', 'display' );
            if ( $best_shop_description || is_customize_preview() ) :
                ?>
                <p class="site-description" itemprop="description"><?php echo $best_shop_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
            <?php endif; ?>
            </div>
        </div><!-- .site-branding -->
        <?php
    }
endif;

if ( ! function_exists( 'best_shop_primary_navigation' ) ) :
    /**
    * Primary Navigation
    */
    function best_shop_primary_navigation( $schema = true ){
        if ( current_user_can( 'manage_options' ) || has_nav_menu( 'primary-menu' ) ) {  
        $schema_class = '';
        $mobile_id  = 'mobile-navigation';

        if( $schema ){
            $schema_class = ' itemscope itemtype=https://schema.org/SiteNavigationElement';
            $mobile_id  = 'site-navigation';
        }
        ?>
            <nav id="<?php echo esc_attr( $mobile_id ); ?>" class="main-navigation" <?php echo esc_attr( $schema_class ); ?>>
                <?php
                    wp_nav_menu(
                        array(
                            'theme_location'  => 'primary-menu',
                            'menu_id'         => 'primary-menu',
                            'container_class' => 'primary-menu-container',
                            'fallback_cb'     => 'best_shop_primary_menu_fallback',
                        )
                    );
                ?>
            </nav>
        <?php }
    }
endif;

if( ! function_exists( 'best_shop_social_links' ) ) :
	/**
	 * Social Links 
	*/
    function best_shop_social_links( $echo = true ){
        
        $social_links = best_shop_get_setting( 'social_links' );
        if( $social_links && $echo ){ ?>
        <ul class="social-links">
            <?php 
            foreach( $social_links as $link ){
                $new_tab = isset( $link['best_shop_checkbox'] ) && $link['best_shop_checkbox'] ? '_blank' : '_self';
                if( isset( $link['best_shop_link'] ) ){ ?>
                <li>
                    <a href="<?php echo esc_url( $link['best_shop_link'] ); ?>" target="<?php echo esc_attr( $new_tab ); ?>" rel="nofollow noopener">
                        <?php echo wp_kses( best_shop_social_icons_svg_list( $link['best_shop_icon'] ), best_shop_kses_extended_ruleset() ); ?>
                    </a>
                </li>	   
                <?php
                } 
            } 
            ?>
        </ul>
        <?php    
        }elseif( $social_links ){
            return true;
        }else{
            return false;
        }
        ?>
        <?php                                
    }
endif;

if( ! function_exists( 'best_shop_header_search' ) ) :
/**
 * Header search
 */
function best_shop_header_search(){

$enable_search = best_shop_get_setting( 'enable_search', false );
if ( $enable_search ) { ?>
	<div class="header-search">
		<button class="header-search-icon" aria-label="<?php esc_attr_e( 'search form toggle', 'best-shop' ); ?>" data-toggle-target=".search-modal" data-toggle-body-class="showing-search-modal" data-set-focus=".search-modal .search-field" aria-expanded="false">
			<svg xmlns="http://www.w3.org/2000/svg" width="16.197" height="16.546"
                viewBox="0 0 16.197 16.546" aria-label="Search Icon">
                <path id="icons8-search"
                    d="M9.939,3a5.939,5.939,0,1,0,3.472,10.754l4.6,4.585.983-.983L14.448,12.8A5.939,5.939,0,0,0,9.939,3Zm0,.7A5.24,5.24,0,1,1,4.7,8.939,5.235,5.235,0,0,1,9.939,3.7Z"
                    transform="translate(-3.5 -2.5) "
                    stroke-width="2"  />
            </svg>
		</button>
		<div class="header-search-form search-modal cover-modal" data-modal-target-string=".search-modal">
			<div class="header-search-inner-wrap">'
				<?php get_search_form(); ?>
				<button aria-label="<?php esc_attr_e( 'search form close', 'best-shop' ); ?>" class="close" data-toggle-target=".search-modal" data-toggle-body-class="showing-search-modal" data-set-focus=".search-modal .search-field" aria-expanded="false"></button>
			</div>
		</div>
	</div><!-- .header-seearch -->
<?php } 
}
endif;

if( ! function_exists( 'best_shop_primary_menu_fallback' ) ) :
/**
 * Fallback for primary menu
*/
function best_shop_primary_menu_fallback(){
	?>
        <div class="primary-menu-container">
			<ul id="primary-menu" class="nav-menu">
				<li><a href="<?php echo esc_url( admin_url( 'nav-menus.php' ) ); ?>"><?php echo esc_html__( 'Click here to add a menu', 'best-shop' ); ?></a></li>
			</ul>
        </div>
	<?php 
}
endif;

if( ! function_exists( 'best_shop_nav' ) ) :
/**
 * navigation
 */
function best_shop_nav(){
	if( is_singular() ){ 
		$next_post	= get_next_post();
		$prev_post  = get_previous_post();
		
		if( $next_post || $prev_post ){ ?>
			<nav class="post-navigation pagination">
				<div class="nav-links">
					<?php if( $prev_post ){ ?>
						<div class="nav-previous">
							<a href="<?php the_permalink( $prev_post->ID ); ?>" rel="prev">
								<article class="post">
									<figure class="post-thumbnail">
										<?php $prev_img = get_post_thumbnail_id( $prev_post->ID ); 
										if( $prev_img ){
											echo wp_get_attachment_image( $prev_img, 'thumbnail', false, array( 'itemprop' => 'image' ) );
										}else{
											best_shop_get_fallback_svg( 'thumbnail' );
										}?>
									</figure>
								<div class="pagination-details">
									<span class="meta-nav"><?php echo esc_html__( 'Previous', 'best-shop' ); ?></span>
									<header class="entry-header">
										<h3 class="entry-title"><?php echo esc_html( get_the_title( $prev_post->ID ) ); ?></h3>  
									</header>
								</div>
								</article>
							</a>
						</div>
					<?php }
					if( $next_post ){ ?>
						<div class="nav-next">
							<a href="<?php the_permalink( $next_post->ID ); ?>" rel="next">
								<article class="post">
									<figure class="post-thumbnail">
										<?php $next_img = get_post_thumbnail_id( $next_post->ID ); 
										if( $next_img ){
											echo wp_get_attachment_image( $next_img, 'thumbnail', false, array( 'itemprop' => 'image' ) );
										}else{
											best_shop_get_fallback_svg( 'thumbnail' );
										}?>									
									</figure>
									<div class="pagination-details">
										<span class="meta-nav"><?php echo esc_html__( 'Next', 'best-shop' ); ?></span>
									<header class="entry-header">
										<h3 class="entry-title"><?php echo esc_html( get_the_title( $next_post->ID ) ); ?></h3>
									</header>
								</article>
							</a>
						</div>
					<?php } ?>
				</div>	
			</nav>
		<?php }
	} else { ?>	
		<div class="default">			
			<?php the_posts_navigation(); ?>
		</div>
		<?php
	}
}
endif;

if ( ! function_exists( 'best_shop_category' ) ) :
/**
 * Prints categories
 */
function best_shop_category(){
    // Hide category and tag text for pages.
    if ( 'post' === get_post_type()) {
        /* translators: used between list items, there is a space after the comma */
        $categories_list = get_the_category();
        echo '<span class="category">';
        foreach( $categories_list as $cat_list ){
            echo '<a href="' . esc_url( get_category_link( $cat_list->term_id ) ) . '">' . esc_html( $cat_list->name ) . '</a>';
        }
        echo '</span>';
    }
}
endif;
    
if ( ! function_exists( 'best_shop_tag' ) ) :
/**
 * Prints tags
 */
function best_shop_tag(){
    // Hide category and tag text for pages.
    if ( 'post' === get_post_type() ) {
        $tags_list = get_the_tag_list( '', ' ' );
        if ( $tags_list ) {
            /* translators: 1: list of tags. */
            printf( '<div class="tags">' . esc_html__( '%1$sTags:%2$s %3$s', 'best-shop' ) . '</div>', '<span>', '</span>', $tags_list );
        }
    }
}
endif;


if( ! function_exists( 'best_shop_get_image_sizes' ) ) :
/**
 * Get information about available image sizes
 */
function best_shop_get_image_sizes( $size = '' ) {
    
    global $_wp_additional_image_sizes;
    
    $sizes = array();
    $get_intermediate_image_sizes = get_intermediate_image_sizes();
    
    // Create the full array with sizes and crop info
    foreach( $get_intermediate_image_sizes as $_size ) {
        if ( in_array( $_size, array( 'thumbnail', 'medium', 'medium_large', 'large' ) ) ) {
            $sizes[ $_size ]['width'] = get_option( $_size . '_size_w' );
            $sizes[ $_size ]['height'] = get_option( $_size . '_size_h' );
            $sizes[ $_size ]['crop'] = (bool) get_option( $_size . '_crop' );
        } elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {
            $sizes[ $_size ] = array( 
                'width' => $_wp_additional_image_sizes[ $_size ]['width'],
                'height' => $_wp_additional_image_sizes[ $_size ]['height'],
                'crop' =>  $_wp_additional_image_sizes[ $_size ]['crop']
            );
        }
    } 
    // Get only 1 size if found
    if ( $size ) {
        if( isset( $sizes[ $size ] ) ) {
            return $sizes[ $size ];
        } else {
            return false;
        }
    }
    return $sizes;
}
endif;

if ( ! function_exists( 'best_shop_get_fallback_svg' ) ) :    
/**
 * Get Fallback SVG
*/
function best_shop_get_fallback_svg( $post_thumbnail ) {
    if( ! $post_thumbnail ){
        return;
    }


    $image_size = best_shop_get_image_sizes( $post_thumbnail );
        
    if( $image_size ){ ?>
        <div class="svg-holder">
            <svg class="fallback-svg" viewBox="0 0 <?php echo esc_attr( $image_size['width'] ); ?> <?php echo esc_attr( $image_size['height'] ); ?>" preserveAspectRatio="none">
                <rect width="<?php echo esc_attr( $image_size['width'] ); ?>" height="<?php echo esc_attr( $image_size['height'] ); ?>" style="fill:#dddcdc7a;"></rect>
            </svg>
        </div>
        <?php
    }
}
endif;

if ( ! function_exists( 'best_shop_author_meta' ) ) :
    /**
     * Author info for Banner and Editor Picks
     */
    function best_shop_author_meta(){ ?>
        <div class="auth-details">
            <div class="author-desc">            
                <div class="author-details">
                    <?php echo get_avatar( get_the_author_meta( 'ID' ), 28, '', 'author' ); ?>
                    <div class="author-name">
                        <?php best_shop_posted_by(); ?>
                    </div>
                </div>
                <span class="date">
                    <?php best_shop_posted_on(); ?>
                </span>
				<?php if( get_comments_number() > 0 )  { ?>
					<div class="comments">
                        <span>
                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-square-quote" viewBox="0 0 16 16">
                            <path d="M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1h-2.5a2 2 0 0 0-1.6.8L8 14.333 6.1 11.8a2 2 0 0 0-1.6-.8H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h2.5a1 1 0 0 1 .8.4l1.9 2.533a1 1 0 0 0 1.6 0l1.9-2.533a1 1 0 0 1 .8-.4H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                            <path d="M7.066 4.76A1.665 1.665 0 0 0 4 5.668a1.667 1.667 0 0 0 2.561 1.406c-.131.389-.375.804-.777 1.22a.417.417 0 1 0 .6.58c1.486-1.54 1.293-3.214.682-4.112zm4 0A1.665 1.665 0 0 0 8 5.668a1.667 1.667 0 0 0 2.561 1.406c-.131.389-.375.804-.777 1.22a.417.417 0 1 0 .6.58c1.486-1.54 1.293-3.214.682-4.112z"/>
                          </svg>				
						</span><?php echo absint( get_comments_number() ); ?>
					</div>
				<?php } ?>
            </div>
        </div>
    <?php    
    }
endif;

if ( ! function_exists( 'best_shop_single_author_meta' ) ) :
    /**
     * Author info for Single Post Banner
     */
    function best_shop_single_author_meta(){   
        $ed_author          = best_shop_get_setting( 'enable_post_author', false );
        $ed_read_calc       = best_shop_get_setting( 'enable_post_read_calc', false );
		$ed_date            = best_shop_get_setting( 'enable_post_date', false );
		$ed_comments        = best_shop_get_setting( 'enable_banner_comments', false );     
        ?>
        <div class="auth-details">
            <div class="author-desc">
                <?php if( ! $ed_author ){ ?> 
                    <div class="author-details">
                        <?php echo get_avatar( get_the_author_meta( 'ID' ), 28, '', 'author' ); ?>
                        <div class="author-name">
                            <?php best_shop_posted_by(); ?>
                        </div>

                    </div>
                <?php } if ( ! $ed_date ) { ?>
                    <span class="date">
                        <?php best_shop_posted_on(); ?>
                    </span>
                <?php } if ( ! $ed_comments && get_comments_number() > 0 ) { ?>
                    <div class="comments">
                        <span>
                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-square-quote" viewBox="0 0 16 16">
                            <path d="M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1h-2.5a2 2 0 0 0-1.6.8L8 14.333 6.1 11.8a2 2 0 0 0-1.6-.8H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h2.5a1 1 0 0 1 .8.4l1.9 2.533a1 1 0 0 0 1.6 0l1.9-2.533a1 1 0 0 1 .8-.4H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                            <path d="M7.066 4.76A1.665 1.665 0 0 0 4 5.668a1.667 1.667 0 0 0 2.561 1.406c-.131.389-.375.804-.777 1.22a.417.417 0 1 0 .6.58c1.486-1.54 1.293-3.214.682-4.112zm4 0A1.665 1.665 0 0 0 8 5.668a1.667 1.667 0 0 0 2.561 1.406c-.131.389-.375.804-.777 1.22a.417.417 0 1 0 .6.58c1.486-1.54 1.293-3.214.682-4.112z"/>
                          </svg>                        
                        </span><?php echo absint( get_comments_number() ); ?>
                    </div>
                <?php } if( ! $ed_read_calc ) best_shop_single_reading_calc( get_post( get_the_ID() )->post_content ); ?>
            </div>
        </div>
    <?php    
    }
endif;

if( ! function_exists( 'best_shop_get_posts_list' ) ) :
/**
 * Returns Latest & Related 
*/
function best_shop_get_posts_list( $status ){
    global $post;
    
    $args = array(
        'post_type'           => 'post',
        'posts_status'        => 'publish',
        'ignore_sticky_posts' => true
    );
    
    switch( $status ){
        case 'latest':        
        $args['posts_per_page'] = 3;
		$reltitle         = __( 'You might also like', 'best-shop' );
		$class            = 'recent-posts';
		$image_size       = 'best_shop_popular_posts';
        break;
        
        case 'related':
        $args['posts_per_page'] = 2;
        $args['post__not_in']   = array( $post->ID );
        $args['orderby']        = 'rand';
		$reltitle         		= best_shop_get_setting( 'related_post_title', __( 'You might also like', 'best-shop' ) );
		$image_size       		= 'best_shop_archive';
    
        $cats = get_the_category( $post->ID );        
        if( $cats ){
            $c = array();
            foreach( $cats as $cat ){
                $c[] = $cat->term_id; 
            }
            $args['category__in'] = $c;
        }
        break;      
    }
    
    $qry = new WP_Query( $args );
    
    if( $qry->have_posts() ){     
        if ( ! is_single() ) echo '<div class="' . esc_attr( $class ) . '">';
            
            if( $reltitle ) echo '<h3 class="post-title">' . esc_html( $reltitle ) . '</h3>'; ?>
            <div class="section-grid">
                <?php while( $qry->have_posts() ){ $qry->the_post(); ?>
                <article class="post">
                    <div class="image">
                        <a href="<?php the_permalink(); ?>" class="post-thumbnail">
                            <?php
                                if( has_post_thumbnail() ){
                                    the_post_thumbnail( $image_size, array( 'itemprop' => 'image' ) );
                                }else{ 
                                    best_shop_get_fallback_svg( $image_size );//fallback
                                }
                            ?>
                        </a>
                    </div>
                    <header class="entry-header">
                        <div class="entry-meta">
                            <?php best_shop_category(); ?>      
                        </div> 
						<div class="entry-details">
							<?php the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' ); 
							?>
						</div>
                        <?php best_shop_author_meta(); ?>                 
                    </header>
                </article>
                <?php } ?>    		
            </div>
            
        <?php if ( ! is_single() ) echo '</div>'; ?>
        <?php
    } wp_reset_postdata();
}
endif;

if( ! function_exists( 'best_shop_sidebar_layout' ) ) :
/**
 * Return sidebar layouts for pages/posts
 */
function best_shop_sidebar_layout(){
    global $post;
	$return      = false;
	$page_layout = best_shop_get_setting( 'page_sidebar_layout'); //Default Layout Style for Pages
	$post_layout = best_shop_get_setting( 'post_sidebar_layout'); //Default Layout Style for Posts
    $layout      = best_shop_get_setting( 'layout_style'); //Default Layout Style for Archive and Search Pages
    $woo_layout  = best_shop_get_setting( 'woo_sidebar_layout'); //Woo Sidebar Layout
    $product_layout = best_shop_get_setting( 'product_sidebar_layout'); //prod Sidebar Layout
    $checkout_layout = best_shop_get_setting( 'checkout_sidebar_layout'); //prod Sidebar Layout
    
    
    if(class_exists('WooCommerce') && is_checkout() ) {
        
        if ( $checkout_layout == 'no-sidebar' ){
                $return = 'full-width';
            } elseif( $checkout_layout == 'right-sidebar' ){
                $return = 'rightsidebar';
            } elseif( $checkout_layout == 'left-sidebar' ) {
                $return = 'leftsidebar';
        } else {
            $return = 'full-width';
        }
        return $return;
        
    }   
    
    
    if(class_exists('WooCommerce') && is_product()) {
        
        if ( $product_layout == 'no-sidebar' ){
                $return = 'full-width';
            } elseif( $product_layout == 'right-sidebar' ){
                $return = 'rightsidebar';
            } elseif( $product_layout == 'left-sidebar' ) {
                $return = 'leftsidebar';
        } else {
            $return = 'full-width';
        }
        return $return;
        
    }
    
    
    
	if(class_exists('WooCommerce') && is_woocommerce()) {
        
        if ( $woo_layout == 'no-sidebar' ){
                $return = 'full-width';
            } elseif( $woo_layout == 'right-sidebar' ){
                $return = 'rightsidebar';
            } elseif( $woo_layout == 'left-sidebar' ) {
                $return = 'leftsidebar';
        } else {
            $return = 'full-width';
        }
        return $return;
    }    
    
    if( is_singular() ){         
        
		if( is_page() ){
			if( is_active_sidebar( 'sidebar-1' ) ){
				if( $page_layout == 'right-sidebar'){
					$return = 'rightsidebar';
				}elseif( $page_layout == 'left-sidebar' ){
					$return = 'leftsidebar';
				}elseif( $page_layout == 'no-sidebar' ){
					$return = 'full-width';
				}
			}else{
				$return = 'full-width';
			}
		}elseif( is_single() ){
			if( is_active_sidebar( 'sidebar-1' ) ){
				if( $post_layout == 'right-sidebar' ){
					$return = 'rightsidebar';
				}elseif( $post_layout == 'left-sidebar' ) {
					$return = 'leftsidebar';
				}elseif( $post_layout == 'no-sidebar' ){
					$return = 'full-width';
				}
			}else{
				$return = 'full-width';
			}
		}
	}elseif( is_archive() || is_search() ){
        //archive page                  
		if( is_active_sidebar( 'sidebar-1' ) ){
			if( $layout == 'no-sidebar' ){
				$return = 'full-width';
			}elseif( $layout == 'right-sidebar' ){
				$return = 'rightsidebar';
			}elseif( $layout == 'left-sidebar' ) {
				$return = 'leftsidebar';
			}
		}else{
			$return = 'full-width';
		}                       
    }else{
		if( is_active_sidebar( 'sidebar-1' ) ){            
			$return = 'rightsidebar';             
		}else{
			$return = 'full-width';
		} 
	}

	return $return;
}
endif;

if ( ! function_exists( 'best_shop_author_box' ) ) :
    /**
     * Author Box for Single Post and Archive Page
     */
    function best_shop_author_box(){
        if ( is_single() && get_the_author_meta( 'description' ) ) { ?>
            <div class="author-section">
                <div class="author-wrapper">
                    <figure class="author-img">
                        <?php echo get_avatar( get_the_author_meta( 'ID' ), 95, '', 'author' ); ?>
                    </figure>
                    <div class="author-wrap">
                        <h3 class="author-name">
                            <?php echo esc_html( get_the_author_meta( 'display_name' ) ); ?>
                        </h3>
                        <div class="author-content">
                            <p><?php echo wp_kses_post( get_the_author_meta( 'description' ) ); ?></p>
                        </div>                    
                    </div>
                </div>
            </div>
        <?php } elseif( is_author() ) { ?>
            <div class="author-section">
                <div class="author-wrapper">
                    <figure class="author-img">
                        <?php echo get_avatar( get_the_author_meta( 'ID' ), 95, '', 'author' ); ?>
                    </figure>
                    <?php if ( get_the_author_meta( 'description' ) ) { ?>
                        <div class="author-wrap">
                            <h3 class="author-name">
                                <?php echo esc_html( get_the_author_meta( 'display_name' ) ); ?>
                            </h3>
                            <div class="author-content">
                                <p><?php echo wp_kses_post( get_the_author_meta( 'description' ) ); ?></p>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        <?php }
    }
endif;

if( ! function_exists( 'best_shop_mobile_navigation' ) ) :
/**
 * Mobile Navigation
*/
function best_shop_mobile_navigation(){ 
    ?>
    <div class="mobile-header">
        <div class="header-main">
            <div class="container">
                <div class="mob-nav-site-branding-wrap">
                    <div class="header-center">
                        <?php best_shop_site_branding(); ?>
                    </div>
                    <button id="menu-opener" data-toggle-target=".main-menu-modal" data-toggle-body-class="showing-main-menu-modal" aria-expanded="false" data-set-focus=".close-main-nav-toggle">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                </div>
            </div>
        </div>
        <div class="mobile-header-wrap">
            <div class="mobile-menu-wrapper">
                <nav id="mobile-site-navigation" class="main-navigation mobile-navigation">        
                    <div class="primary-menu-list main-menu-modal cover-modal" data-modal-target-string=".main-menu-modal">                  
                        <button class="close close-main-nav-toggle" data-toggle-target=".main-menu-modal" data-toggle-body-class="showing-main-menu-modal" aria-expanded="false" data-set-focus=".main-menu-modal"></button>
                        <div class="mobile-social-wrap">
                            <?php if( best_shop_social_links( false ) ){
                                echo '<div class="header-left"><div class="header-social">';
                                best_shop_social_links();
                                echo '</div></div>';
                            } ?>  
                        </div>
                        <div class="mobile-menu" aria-label="<?php esc_attr_e( 'Mobile', 'best-shop' ); ?>">
                            <?php
                                best_shop_primary_navigation( false );
                            ?>
                        </div>
                    </div>
                    <?php
                      if (best_shop_get_setting('enable_mobile_search')){
                            best_shop_header_search(); 
                      }                    
                    ?>
                </nav><!-- #mobile-site-navigation -->
            </div>
        </div>  
    </div>
<?php   
}
endif;

if( ! function_exists( 'best_shop_comment' ) ) :
	/**
	 * Callback function for Comment List *
	 * 
	 * @link https://codex.wordpress.org/Function_Reference/wp_list_comments 
	 */
	function best_shop_comment( $comment, $args, $depth ){
		if ( 'div' == $args['style'] ) {
			$tag = 'div';
			$add_below = 'comment';
		} else {
			$tag = 'li';
			$add_below = 'div-comment';
		}?>
		<<?php echo $tag ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>">
		
		<?php if ( 'div' != $args['style'] ) : ?>
		<article id="div-comment-<?php comment_ID() ?>" class="comment-body" itemscope itemtype="http://schema.org/UserComments">
		<?php endif; ?>
			
			<footer class="comment-meta">
				<div class="comment-author vcard">
                    <div class="comment-author-image">
				        <?php if ( $args['avatar_size'] != 0 ) echo get_avatar( $comment, $args['avatar_size'], '', 'avatar' ); ?>
                    </div>
				</div>
                <div class="author-details-wrap"><!-- .comment-author vcard -->
                    <?php printf( __( '<b class="fn" itemprop="creator" itemscope itemtype="http://schema.org/Person">%s <span class="says">says:</span></b>', 'best-shop' ), get_comment_author_link() ); ?>
                    <div class="comment-meta-data">
                        <a href="<?php echo esc_url( htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ); ?>">
                            <time itemprop="commentTime" datetime="<?php echo esc_attr( get_gmt_from_date( get_comment_date() . get_comment_time(), 'Y-m-d H:i:s' ) ); ?>"><?php printf( esc_html__( '%1$s at %2$s', 'best-shop' ), get_comment_date(),  get_comment_time() ); ?></time>
                        </a>
                    </div>
                    <?php if ( $comment->comment_approved == '0' ) : ?>
                        <em class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'best-shop' ); ?></em>
                        <br />
                    <?php endif; ?>
                    <div class="comment-content" itemprop="commentText">                     
                        <?php comment_text(); ?>                      
			        </div>    
                    <div class="reply">
                        <?php comment_reply_link( array_merge( $args, array( 'reply_text' => __('Reply', 'best-shop'), 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
                    </div>
                </div>
			</footer> 
		<?php if ( 'div' != $args['style'] ) : ?>
		</article><!-- .comment-body -->
		<?php endif;
	}
endif;


if( ! function_exists( 'best_shop_single_reading_calc' ) ) :
    /**
     * Reading calculation
     */
    function best_shop_single_reading_calc( $content ){ 
        $en_read       = best_shop_get_setting( 'enable_post_read_calc' );
        $read_calc     = best_shop_get_setting( 'read_words_per_minute' );
   $total_word = str_word_count(strip_tags($content));
    $m = floor($total_word / $read_calc);
    $s = floor($total_word % $read_calc / ($read_calc / 60));
    $estimateTime = $m . esc_html__(' minute', 'best-shop') . ($m == 1 ? '' : 's') . ', ' . $s . esc_html__(' second','best-shop') . ($s == 1 ? '' : 's');

        if ( ! $en_read ) { ?>
            <div class="time">
                <?php echo wp_kses_post( $estimateTime ).esc_html__(' Read', 'best-shop'); ?>
            </div>
        <?php }
    }
endif;
    

if( ! function_exists( 'best_shop_footer_site_info' ) ) :
/**
 * Footer site info
*/
function best_shop_footer_site_info(){ 
	echo '<div class="site-info">';
		best_shop_get_footer_copyright();
	echo '</div>';
}
endif;


if( ! function_exists( 'best_shop_get_related_posts' ) ) :
    /**
     * Related post
    */
    function best_shop_get_related_posts(){ ?>
        <div class="additional-post">
            <?php best_shop_get_posts_list( 'related' ); ?>
        </div>
        <?php 
    }
endif;

if( ! function_exists( 'best_shop_get_comments' ) ) :
    /**
     * Comments
    */
    function best_shop_get_comments(){ 
    // If comments are open or we have at least one comment, load up the comment template.
        if ( comments_open() || get_comments_number() ) :
            comments_template();
        endif;      
    }
endif;


if( ! function_exists( 'best_shop_kses_extended_ruleset' ) ) :

function best_shop_kses_extended_ruleset() {
    $kses_defaults = wp_kses_allowed_html( 'post' );

    $svg_args = array(
        'svg'   => array(
            'class'           => true,
            'aria-hidden'     => true,
            'aria-labelledby' => true,
            'role'            => true,
            'xmlns'           => true,
            'width'           => true,
            'height'          => true,
            'viewbox'         => true, // <= Must be lower case!
        ),
        'g'     => array( 'fill' => true ),
        'title' => array( 'title' => true ),
        'path'  => array(
            'd'    => true,
            'fill' => true,
        ),
    );
    return array_merge( $kses_defaults, $svg_args );
}
endif;

if ( ! function_exists( 'best_shop_social_icons_svg_list' ) ) :    
	/**
	 * Get SVG Image
	*/
	function best_shop_social_icons_svg_list( $social ){

		if( !$social ){
			return;
		}
		switch ( $social ) {
			case 'facebook':
				return '<svg
				class="st-icon"
				width="20px"
				height="20px"
				viewBox="0 0 20 20"
				aria-label="Facebook Icon">
					<path d="M20,10.1c0-5.5-4.5-10-10-10S0,4.5,0,10.1c0,5,3.7,9.1,8.4,9.9v-7H5.9v-2.9h2.5V7.9C8.4,5.4,9.9,4,12.2,4c1.1,0,2.2,0.2,2.2,0.2v2.5h-1.3c-1.2,0-1.6,0.8-1.6,1.6v1.9h2.8L13.9,13h-2.3v7C16.3,19.2,20,15.1,20,10.1z"/>
				</svg>';
			break;

			case 'twitter':
				return '<svg
				class="st-icon"
				width="20px"
				height="20px"
				viewBox="0 0 20 20"
				aria-label="Twitter Icon">
					<path d="M20,3.8c-0.7,0.3-1.5,0.5-2.4,0.6c0.8-0.5,1.5-1.3,1.8-2.3c-0.8,0.5-1.7,0.8-2.6,1c-0.7-0.8-1.8-1.3-3-1.3c-2.3,0-4.1,1.8-4.1,4.1c0,0.3,0,0.6,0.1,0.9C6.4,6.7,3.4,5.1,1.4,2.6C1,3.2,0.8,3.9,0.8,4.7c0,1.4,0.7,2.7,1.8,3.4C2,8.1,1.4,7.9,0.8,7.6c0,0,0,0,0,0.1c0,2,1.4,3.6,3.3,4c-0.3,0.1-0.7,0.1-1.1,0.1c-0.3,0-0.5,0-0.8-0.1c0.5,1.6,2,2.8,3.8,2.8c-1.4,1.1-3.2,1.8-5.1,1.8c-0.3,0-0.7,0-1-0.1c1.8,1.2,4,1.8,6.3,1.8c7.5,0,11.7-6.3,11.7-11.7c0-0.2,0-0.4,0-0.5C18.8,5.3,19.4,4.6,20,3.8z"/>
				</svg>';
			break;

			case 'instagram':
				return '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-instagram" viewBox="0 0 16 16">
  <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z"/>
</svg>';
                    break;

			case 'pinterest':
				return '<svg
				class="st-icon"
				width="20px"
				height="20px"
				viewBox="0 0 20 20"
				aria-label="Pinterest Icon">
					<path d="M10,0C4.5,0,0,4.5,0,10c0,4.1,2.5,7.6,6,9.2c0-0.7,0-1.5,0.2-2.3c0.2-0.8,1.3-5.4,1.3-5.4s-0.3-0.6-0.3-1.6c0-1.5,0.9-2.6,1.9-2.6c0.9,0,1.3,0.7,1.3,1.5c0,0.9-0.6,2.3-0.9,3.5c-0.3,1.1,0.5,1.9,1.6,1.9c1.9,0,3.2-2.4,3.2-5.3c0-2.2-1.5-3.8-4.2-3.8c-3,0-4.9,2.3-4.9,4.8c0,0.9,0.3,1.5,0.7,2C6,12,6.1,12.1,6,12.4c0,0.2-0.2,0.6-0.2,0.8c-0.1,0.3-0.3,0.3-0.5,0.3c-1.4-0.6-2-2.1-2-3.8c0-2.8,2.4-6.2,7.1-6.2c3.8,0,6.3,2.8,6.3,5.7c0,3.9-2.2,6.9-5.4,6.9c-1.1,0-2.1-0.6-2.4-1.2c0,0-0.6,2.3-0.7,2.7c-0.2,0.8-0.6,1.5-1,2.1C8.1,19.9,9,20,10,20c5.5,0,10-4.5,10-10C20,4.5,15.5,0,10,0z"/>
				</svg>';
			break;

			case 'digg':
				return '<svg 
				class="st-icon" 
				width="20px" 
				height="20px"
				aria-label="Digg Icon"
				viewBox="0 0 512 512" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M81.7 172.3H0V346.7H132.7V96H81.7V172.3V172.3ZM81.7 305.7H50.9V213.4H81.7V305.7ZM378.9 172.3V346.7H460.7V375.2H378.9V416H512V172.3H378.9V172.3ZM460.7 305.7H429.9V213.4H460.7V305.7ZM225.1 346.7H307.2V375.2H225.1V416H358.4V172.3H225.1V346.7ZM276.3 213.4H307.1V305.7H276.3V213.4ZM153.3 96H204.6V147H153.3V96ZM153.3 172.3H204.6V346.7H153.3V172.3Z" fill="black"/>
				</svg>';
			break;

			case 'telegram':
				return '<svg 
				width="20px" 
				height="20px"
				aria-label="Telegram Icon"
				viewBox="0 0 448 512" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M446.7 98.6L379.1 417.4C374 439.9 360.7 445.5 341.8 434.9L238.8 359L189.1 406.8C183.6 412.3 179 416.9 168.4 416.9L175.8 312L366.7 139.5C375 132.1 364.9 128 353.8 135.4L117.8 284L16.1998 252.2C-5.90022 245.3 -6.30022 230.1 20.7998 219.5L418.2 66.4C436.6 59.5 452.7 70.5 446.7 98.6V98.6Z" fill="black"/>
				</svg>';
			break;

			case 'getpocket':
				return '<svg 
				width="20px" 
				height="20px"
				aria-label="GetPocket Icon"
				viewBox="0 0 448 512" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M407.6 64H40.6C18.5 64 0 82.5 0 104.6V239.8C0 364.5 99.7 464 224.2 464C348.2 464 448 364.5 448 239.8V104.6C448 82.2 430.3 64 407.6 64V64ZM245.6 332.5C233.2 344.3 214.2 343.6 203.2 332.5C89.5 223.6 88.3 227.4 88.3 209.3C88.3 192.4 102.1 178.6 119 178.6C136 178.6 135.1 182.4 224.2 267.9C314.8 181 312.8 178.6 329.7 178.6C346.6 178.6 360.4 192.4 360.4 209.3C360.4 227.1 357.5 225 245.6 332.5V332.5Z" fill="black"/>
				</svg>';
			break;

			case 'dribbble':
				return '<svg
				class="st-icon"
				width="20"
				height="20"
				viewBox="0 0 20 20"
				aria-label="Dribbble Icon">
					<path d="M10,0C4.5,0,0,4.5,0,10c0,5.5,4.5,10,10,10c5.5,0,10-4.5,10-10C20,4.5,15.5,0,10,0 M16.1,5.2c1,1.2,1.6,2.8,1.7,4.4c-1.1-0.2-2.2-0.4-3.2-0.4v0h0c-0.8,0-1.6,0.1-2.3,0.2c-0.2-0.4-0.3-0.8-0.5-1.2C13.4,7.6,14.9,6.6,16.1,5.2 M10,2.2c1.8,0,3.5,0.6,4.9,1.7c-1,1.2-2.4,2.1-3.8,2.7c-1-2-2-3.4-2.7-4.3C8.9,2.3,9.4,2.2,10,2.2 M6.6,3c0.5,0.6,1.6,2,2.8,4.2C7,8,4.6,8.1,3.2,8.1c0,0-0.1,0-0.1,0h0c-0.2,0-0.4,0-0.6,0C3,5.9,4.5,4,6.6,3 M2.2,10c0,0,0-0.1,0-0.1c0.2,0,0.5,0,0.9,0h0c1.6,0,4.3-0.1,7.1-1c0.2,0.3,0.3,0.7,0.4,1c-1.9,0.6-3.3,1.6-4.4,2.6c-1,0.9-1.7,1.9-2.2,2.5C2.9,13.7,2.2,11.9,2.2,10 M10,17.8c-1.7,0-3.3-0.6-4.6-1.5c0.3-0.5,0.9-1.3,1.8-2.2c1-0.9,2.3-1.9,4.1-2.5c0.6,1.7,1.1,3.6,1.5,5.7C11.9,17.6,11,17.8,10,17.8M14.4,16.4c-0.4-1.9-0.9-3.7-1.4-5.2c0.5-0.1,1-0.1,1.6-0.1h0h0h0c0.9,0,2,0.1,3.1,0.4C17.3,13.5,16.1,15.3,14.4,16.4"/>
				</svg>';
			break;

			case 'behance':
				return '<svg
				class="st-icon"
				width="20"
				height="20"
				viewBox="0 0 20 20"
				aria-label="Behance Icon">
					<path d="M15.2,10.3h-2.7c0,0,0.2-1.3,1.5-1.3C15.2,9,15.2,10.3,15.2,10.3z M7.7,10.3H5.3v2.2h2.2c0,0,0.1,0,0.2,0c0.3,0,1-0.1,1-1.1C8.6,10.3,7.7,10.3,7.7,10.3zM20,10c0,5.5-4.5,10-10,10C4.5,20,0,15.5,0,10S4.5,0,10,0C15.5,0,20,4.5,20,10zM12.1,7.2h3.4v-1h-3.4V7.2z M8.8,9.5c0,0,1.3-0.1,1.3-1.6S9,5.7,7.7,5.7H5.3H5.2H3.4V14h1.8h0.1h2.4c0,0,2.6,0.1,2.6-2.5C10.4,11.5,10.5,9.5,8.8,9.5zM13.9,7.8c-3.2,0-3.2,3.2-3.2,3.2s-0.2,3.2,3.2,3.2c0,0,2.9,0.2,2.9-2.2h-1.5c0,0,0,0.9-1.3,0.9c0,0-1.5,0.1-1.5-1.5h4.3C16.8,11.4,17.3,7.8,13.9,7.8z M8.3,8c0-0.9-0.6-0.9-0.6-0.9H7.4H5.3V9h2.3C8,9,8.3,8.9,8.3,8z"/>
				</svg>';
			break;

			case 'unsplash':
				return '<svg
				class="st-icon"
				width="20"
				height="20"
				viewBox="0 0 20 20"
				aria-label="Unsplash Icon">
					<path d="M6.2 5.6V0h7.5v5.6H6.2zm7.6 3.2H20V20H0V8.8h6.2v5.6h7.5V8.8z"/>
				</svg>';
			break;

			case 'five-hundred-px':
				return '<svg
				class="st-icon"
				width="20"
				height="20"
				viewBox="0 0 20 20"
				aria-label="500PX Icon">
					<path d="M17.7 17.3c-.9.9-1.9 1.6-3 2-1.1.5-2.3.7-3.5.7-1.2 0-2.4-.2-3.5-.7-1.1-.5-2.1-1.1-2.9-2-.8-.8-1.5-1.8-2-2.9-.3-.8-.5-1.5-.6-2.1 0-.2.1-.3.5-.4.4-.1.6 0 .6.2.1.7.3 1.3.5 1.8.4.9.9 1.8 1.7 2.5.7.7 1.6 1.3 2.5 1.7 1 .4 2 .6 3.1.6s2.1-.2 3.1-.6c1-.4 1.8-1 2.5-1.7l.1-.1c.1-.1.2-.1.3-.1.1 0 .2.1.4.2.3.5.3.7.2.9zm-5.3-6.9l-.7.7.7.7c.2.2.1.3-.1.5-.1.1-.2.2-.4.2-.1 0-.1 0-.2-.1l-.7-.7-.7.7s-.1.1-.2.1-.2-.1-.3-.2c-.1-.1-.2-.2-.2-.3 0-.1 0-.1.1-.2l.7-.7-.7-.7c-.1-.1-.1-.3.2-.5.1-.1.2-.2.3-.2 0 0 .1 0 .1.1l.7.7.7-.7c.1-.1.3-.1.5.1.3.2.4.4.2.5zm5.3.6c0 .9-.2 1.7-.5 2.5s-.8 1.5-1.4 2.1c-.6.6-1.3 1.1-2.1 1.4-.8.3-1.6.5-2.5.5-.9 0-1.7-.2-2.5-.5s-1.5-.8-2.1-1.4c-.6-.6-1.1-1.3-1.4-2.1l-.2-.4c-.1-.2.1-.4.5-.5.4-.1.6-.1.7.1.3.7.6 1.4 1.1 1.9v-3.8c0-1 .4-1.9 1.1-2.6.8-.8 1.7-1.1 2.8-1.1 1.1 0 2 .4 2.8 1.1.8.8 1.2 1.7 1.2 2.8 0 1.1-.4 2-1.2 2.8-.8.8-1.7 1.2-2.8 1.2-.4 0-.8-.1-1.2-.2-.2-.1-.3-.3-.1-.7.1-.4.3-.5.5-.5h.2c.1 0 .2 0 .4.1s.3 0 .3 0c.8 0 1.4-.3 2-.8.5-.5.8-1.2.8-1.9 0-.8-.3-1.4-.8-1.9s-1.2-.8-2-.8-1.5.3-2 .9c-.7.6-.9 1.2-.9 1.8v4.6c.8.5 1.7.7 2.7.7.7 0 1.4-.1 2.1-.4.7-.3 1.2-.7 1.7-1.2s.9-1.1 1.2-1.7c.3-.7.4-1.3.4-2 0-1.5-.5-2.7-1.6-3.8-1-1-2.3-1.6-3.8-1.6s-2.8.5-3.8 1.6c-.4.4-.7.8-.8 1l-.2.2s-.1.1-.2.1h-.4c-.2 0-.3-.1-.4-.2S5 8.1 5 8V.4c0-.1 0-.2.1-.3s.2-.1.4-.1h9.8c.2 0 .3.2.3.6s-.1.6-.3.6H6.2v5.4c.3-.3.7-.6 1.2-.9.4-.3.8-.6 1.2-.7.8-.3 1.7-.5 2.6-.5.9 0 1.7.2 2.5.5s1.5.8 2.1 1.4c.6.6 1.1 1.3 1.4 2.1.3.8.5 1.7.5 2.5zm-.4-6.4c.1.1.1.1.1.2s0 .1-.1.2l-.2.2c-.2.2-.3.3-.4.3-.1 0-.1 0-.2-.1-.8-.7-1.6-1.2-2.3-1.5-1-.4-2-.6-3.1-.6-1 0-2 .2-2.9.5-.1.1-.3 0-.4-.4-.1-.2-.1-.3-.1-.4 0-.1.1-.2.2-.2 1-.4 2.1-.6 3.3-.6 1.2 0 2.4.2 3.5.7 1 .4 1.9 1 2.6 1.7z"/>
				</svg>';
			break;

			case 'linkedin':
				return '<svg
				class="st-icon"
				width="20px"
				height="20px"
				viewBox="0 0 20 20"
				aria-label="LinkedIn Icon">
					<path d="M18.6,0H1.4C0.6,0,0,0.6,0,1.4v17.1C0,19.4,0.6,20,1.4,20h17.1c0.8,0,1.4-0.6,1.4-1.4V1.4C20,0.6,19.4,0,18.6,0z M6,17.1h-3V7.6h3L6,17.1L6,17.1zM4.6,6.3c-1,0-1.7-0.8-1.7-1.7s0.8-1.7,1.7-1.7c0.9,0,1.7,0.8,1.7,1.7C6.3,5.5,5.5,6.3,4.6,6.3z M17.2,17.1h-3v-4.6c0-1.1,0-2.5-1.5-2.5c-1.5,0-1.8,1.2-1.8,2.5v4.7h-3V7.6h2.8v1.3h0c0.4-0.8,1.4-1.5,2.8-1.5c3,0,3.6,2,3.6,4.5V17.1z"/>
				</svg>';
			break;

			case 'WordPress':
				return '<svg
				class="st-icon"
				width="20px"
				height="20px"
				viewBox="0 0 20 20"
				aria-label="WordPress Icon">
					<path d="M1.9 4.1C3.7 1.6 6.7 0 10 0c2.4 0 4.6.9 6.3 2.3-.7.2-1.2 1-1.2 1.7 0 .9.5 1.6 1 2.4.5.7.9 1.6.9 2.9 0 .9-.3 2-.8 3.4l-1 3.5-3.8-11.3c.6 0 1.2-.1 1.2-.1.6 0 .5-.8 0-.8 0 0-1.7.1-2.8.1-1 0-2.7-.1-2.7-.1-.6 0-.7.8-.1.8 0 0 .5.1 1.1.1l1.6 4.4-2.3 6.8L3.7 4.9c.6 0 1.2-.1 1.2-.1.5 0 .4-.8-.1-.8 0 0-1.7.1-2.9.1.1 0 .1 0 0 0zM.8 6.2C.3 7.4 0 8.6 0 10c0 3.9 2.2 7.2 5.4 8.9L.8 6.2zm9.4 4.5l-3 8.9c.9.3 1.8.4 2.8.4 1.2 0 2.3-.2 3.4-.6l-3.2-8.7zm9-4.6c0 1-.2 2.2-.8 3.6l-3 8.8c2.8-1.8 4.6-4.9 4.6-8.4 0-1.5-.3-2.8-.8-4z"/>
				</svg>';
			break;

			case 'parler':
				return '<svg
				class="st-icon"
				width="20px"
				height="20px"
				viewBox="0 0 20 20"
				aria-label="Parler Icon">
					<path d="M11.7,16.7h-5V15c0-0.9,0.7-1.6,1.6-1.6h3.4c2.8,0,5-2.2,5-5s-2.2-5-5-5h0l-1.1,0H0C0,1.5,1.5,0,3.3,0h7.3l1.1,0C16.3,0,20,3.8,20,8.4S16.3,16.7,11.7,16.7z M3.3,20C1.5,20,0,18.5,0,16.7V9.9c0-1.8,1.4-3.2,3.2-3.2h8.4c0.9,0,1.7,0.7,1.7,1.7c0,0.9-0.7,1.7-1.7,1.7H5c-0.9,0-1.6,0.7-1.6,1.6V20z"/>
				</svg>';
			break;

			case 'mastodon':
				return '<svg
				class="st-icon"
				width="20px"
				height="20px"
				viewBox="0 0 20 20"
				aria-label="Mastodon Icon">
					<path d="M19.3 6.6c0-4.3-2.8-5.6-2.8-5.6C13.7-.3 6.3-.3 3.5 1 3.5 1 .7 2.3.7 6.6c0 5.2-.3 11.6 4.7 12.9 1.8.5 3.4.6 4.6.5 2.3-.1 3.5-.8 3.5-.8l-.1-1.6s-1.6.5-3.4.5c-1.8-.1-3.7-.2-4-2.4v-.6c3.8.9 7.1.4 8 .3 2.5-.3 4.7-1.8 5-3.3.4-2.3.3-5.5.3-5.5zM16 12.2h-2.1V7.1c0-2.2-2.9-2.3-2.9.3v2.8H9V7.4c0-2.6-2.9-2.5-2.9-.3v5.1H4c0-5.4-.2-6.6.8-7.8C6 3.1 8.4 3 9.5 4.6l.5.9.5-.9c1.1-1.6 3.5-1.5 4.7-.3 1 1.3.8 2.4.8 7.9z"/>
				</svg>';
			break;

			case 'medium':
				return '<svg
				class="st-icon"
				width="20"
				height="20"
				viewBox="0 0 20 20"
				aria-label="Medium Icon">
					<path d="M2.4,5.3c0-0.2-0.1-0.5-0.3-0.7L0.3,2.4V2.1H6l4.5,9.8l3.9-9.8H20v0.3l-1.6,1.5c-0.1,0.1-0.2,0.3-0.2,0.4v11.2c0,0.2,0,0.3,0.2,0.4l1.6,1.5v0.3h-7.8v-0.3l1.6-1.6c0.2-0.2,0.2-0.2,0.2-0.4V6.5L9.4,17.9H8.8L3.6,6.5v7.6c0,0.3,0.1,0.6,0.3,0.9L6,17.6v0.3H0v-0.3L2.1,15c0.2-0.2,0.3-0.6,0.3-0.9V5.3z"/>
				</svg>';
			break;

			case 'slack':
				return '<svg
				class="st-icon"
				width="20"
				height="20"
				viewBox="0 0 20 20"
				aria-label="Slack Icon">
					<path d="M7.4,0C6.2,0,5.2,1,5.2,2.2s1,2.2,2.2,2.2h2.2V2.2C9.6,1,8.6,0,7.4,0zM12.6,0c-1.2,0-2.2,1-2.2,2.2v5.2c0,1.2,1,2.2,2.2,2.2s2.2-1,2.2-2.2V2.2C14.8,1,13.8,0,12.6,0z M2.2,5.2C1,5.2,0,6.2,0,7.4s1,2.2,2.2,2.2h5.2c1.2,0,2.2-1,2.2-2.2s-1-2.2-2.2-2.2H2.2zM17.8,5.2c-1.2,0-2.2,1-2.2,2.2v2.2h2.2c1.2,0,2.2-1,2.2-2.2S19,5.2,17.8,5.2z M2.2,10.4c-1.2,0-2.2,1-2.2,2.2s1,2.2,2.2,2.2s2.2-1,2.2-2.2v-2.2H2.2zM7.4,10.4c-1.2,0-2.2,1-2.2,2.2v5.2c0,1.2,1,2.2,2.2,2.2s2.2-1,2.2-2.2v-5.2C9.6,11.4,8.6,10.4,7.4,10.4z M12.6,10.4c-1.2,0-2.2,1-2.2,2.2s1,2.2,2.2,2.2h5.2c1.2,0,2.2-1,2.2-2.2s-1-2.2-2.2-2.2H12.6zM10.4,15.7v2.2c0,1.2,1,2.2,2.2,2.2s2.2-1,2.2-2.2c0-1.2-1-2.2-2.2-2.2H10.4z"/>
				</svg>';
			break;

			case 'codepen':
				return '<svg
				class="st-icon"
				width="20"
				height="20"
				viewBox="0 0 20 20"
				aria-label="CodePen Icon">
					<path d="M10,0L0,6.4v7.3L10,20l10-6.4V6.4L10,0z M10,12l-2.8-2L10,8.1l2.8,1.9L10,12z M11,6.5V2.8l6.4,4.1l-2.9,2L11,6.5z M9,6.5L5.5,8.9l-2.9-2L9,2.8V6.5z M3.9,10l-1.9,1.3V8.7L3.9,10z M5.5,11.2L9,13.6v3.5l-6.4-4.1L5.5,11.2z M11,13.6l3.5-2.5l2.8,1.9L11,17.2V13.6z M16.1,10l1.9-1.4v2.7L16.1,10z"/>
				</svg>';
			break;

			case 'reddit':
				return '<svg
				class="st-icon"
				width="20px"
				height="20px"
				viewBox="0 0 20 20"
				aria-label="Reddit Icon">
					<path d="M11.7,0.9c-0.9,0-2,0.7-2.1,3.9c0.1,0,0.3,0,0.4,0c0.2,0,0.3,0,0.5,0c0.1-1.9,0.6-3.1,1.3-3.1c0.3,0,0.5,0.2,0.8,0.5c0.4,0.4,0.9,0.9,1.8,1.1c0-0.1,0-0.2,0-0.4c0-0.2,0-0.4,0.1-0.5c-0.6-0.2-0.9-0.5-1.2-0.8C12.8,1.3,12.4,0.9,11.7,0.9z M16.9,1.3c-1,0-1.7,0.8-1.7,1.7s0.8,1.7,1.7,1.7s1.7-0.8,1.7-1.7S17.9,1.3,16.9,1.3z M10,5.7c-5.3,0-9.5,2.7-9.5,6.5s4.3,6.9,9.5,6.9s9.5-3.1,9.5-6.9S15.3,5.7,10,5.7z M2.4,6.1c-0.6,0-1.2,0.3-1.7,0.7C0,7.5-0.2,8.6,0.2,9.5C0.9,8.2,2,7.1,3.5,6.3C3.1,6.2,2.8,6.1,2.4,6.1z M17.6,6.1c-0.4,0-0.7,0.1-1.1,0.3c1.5,0.8,2.6,1.9,3.2,3.2c0.4-0.9,0.3-2-0.5-2.7C18.8,6.3,18.2,6.1,17.6,6.1z M6.5,9.6c0.7,0,1.3,0.6,1.3,1.3s-0.6,1.3-1.3,1.3s-1.3-0.6-1.3-1.3S5.8,9.6,6.5,9.6z M13.5,9.6c0.7,0,1.3,0.6,1.3,1.3s-0.6,1.3-1.3,1.3s-1.3-0.6-1.3-1.3S12.8,9.6,13.5,9.6z M6.1,14.3c0.1,0,0.2,0.1,0.3,0.2c0,0.1,1.1,1.4,3.6,1.4c2.6,0,3.6-1.4,3.6-1.4c0.1-0.2,0.4-0.2,0.6-0.1c0.2,0.1,0.2,0.4,0.1,0.6c-0.1,0.1-1.3,1.8-4.3,1.8c-3,0-4.2-1.7-4.3-1.8c-0.1-0.2-0.1-0.5,0.1-0.6C5.9,14.4,6,14.3,6.1,14.3z"/>
				</svg>';
			break;

			case 'twitch':
				return '<svg
				class="st-icon"
				width="20px"
				height="20px"
				viewBox="0 0 20 20"
				aria-label="Twitch Icon">
					<path d="M1.5,0L0,4.1v12.8h4.6V20h2.1l3.8-3.1h4.1l5.4-5.8V0H1.5zM3.1,1.5h15.4v8.8l-3.3,3.5H9.5l-3.4,2.9v-2.9H3.1V1.5z M7.7,4.6v6.2h1.5V4.6H7.7z M12.3,4.6v6.2h1.5V4.6H12.3z"/>
				</svg>';
			break;

			case 'tiktok':
				return '<svg
				class="st-icon"
				width="20px"
				height="20px"
				viewBox="0 0 20 20"
				aria-label="TikTok Icon">
					<path d="M18.2 4.5c-2.3-.2-4.1-1.9-4.4-4.2V0h-3.4v13.8c0 1.4-1.2 2.6-2.8 2.6-1.4 0-2.6-1.1-2.6-2.6s1.1-2.6 2.6-2.6h.2l.5.1V7.5h-.7c-3.4 0-6.2 2.8-6.2 6.2S4.2 20 7.7 20s6.2-2.8 6.2-6.2v-7c1.1 1.1 2.4 1.6 3.9 1.6h.8V4.6l-.4-.1z"/>
				</svg>';
			break;

			case 'snapchat':
				return '<svg
				class="st-icon"
				width="20px"
				height="20px"
				viewBox="0 0 20 20"
				aria-label="Snapchat Icon">
					<path d="M10,0.5c-6,0-6,6-6,6v1c0,0,0,0-0.1,0C3.6,7.5,2,7.6,2,8.9c0,1.5,1.7,1.6,2,1.6c0,0,0,0,0,0c0,1-1.7,2.2-2.7,2.4C0.3,13.3,0,14,0,14.5c0,0.3,0.1,0.5,0.1,0.6c0.4,0.9,1.5,1.3,2.6,1.3c0,1.4,1.1,2,1.8,2c0.8,0,1.6-0.4,1.6-0.4c0,0,1.3,1.4,3.9,1.4s3.9-1.4,3.9-1.4c0,0,0.8,0.4,1.6,0.4c0.7,0,1.7-0.6,1.8-2c1.1,0,2.2-0.5,2.6-1.3c0-0.1,0.1-0.3,0.1-0.6c0-0.5-0.3-1.2-1.3-1.6c-1.1-0.3-2.7-1.4-2.7-2.4c0,0,0,0,0,0c0.3,0,2-0.1,2-1.6c0-1.3-1.6-1.4-1.9-1.4c0,0-0.1,0-0.1,0v-1C16,6.5,16,0.5,10,0.5L10,0.5z"/>
				</svg>';
			break;

			case 'spotify':
				return '<svg
				class="st-icon"
				width="20px"
				height="20px"
				viewBox="0 0 20 20"
				aria-label="Spotify Icon">
					<path d="M10,0C4.5,0,0,4.5,0,10s4.5,10,10,10s10-4.5,10-10S15.5,0,10,0z M14.2,14.5c-0.1,0.2-0.3,0.3-0.5,0.3c-0.1,0-0.2,0-0.4-0.1c-1.1-0.7-2.9-1.2-4.4-1.2c-1.6,0-2.8,0.4-2.8,0.4c-0.3,0.1-0.7-0.1-0.8-0.4c-0.1-0.3,0.1-0.7,0.4-0.8c0.1,0,1.4-0.5,3.2-0.5c1.5,0,3.6,0.4,5.1,1.4C14.4,13.8,14.4,14.2,14.2,14.5z M15.5,11.8c-0.1,0.2-0.4,0.4-0.6,0.4c-0.1,0-0.3,0-0.4-0.1c-1.9-1.2-4-1.5-5.7-1.5c-1.9,0-3.5,0.4-3.5,0.4c-0.4,0.1-0.8-0.1-0.9-0.5c-0.1-0.4,0.1-0.8,0.5-0.9c0.1,0,1.7-0.4,3.8-0.4c1.9,0,4.4,0.3,6.6,1.7C15.6,11,15.8,11.5,15.5,11.8z M16.8,8.7c-0.2,0.3-0.5,0.4-0.8,0.4c-0.1,0-0.3,0-0.4-0.1c-2.3-1.3-5-1.6-6.9-1.6c0,0,0,0,0,0c-2.3,0-4.1,0.4-4.1,0.4c-0.5,0.1-0.9-0.2-1-0.6c-0.1-0.5,0.2-0.9,0.6-1c0.1,0,2-0.5,4.5-0.5c0,0,0,0,0,0c2.1,0,5.2,0.3,7.8,1.9C16.9,7.8,17.1,8.3,16.8,8.7z"/>
				</svg>';
			break;

			case 'soundcloud':
				return '<svg
				class="st-icon"
				width="20px"
				height="20px"
				viewBox="0 0 20 20"
				aria-label="SoundCloud Icon">
					<path d="M20 12.7c0 1.5-1.2 2.7-2.7 2.7h-6c-.4 0-.7-.3-.7-.7V5.3c0-.4.3-.7.7-.7h.7c3.3 0 6 2.7 4.7 5.3h.7c1.4.1 2.6 1.3 2.6 2.8zM.7 9.9c-.4 0-.7.3-.7.7v4.1c0 .4.3.7.7.7.4 0 .7-.3.7-.7v-4.1c-.1-.4-.4-.7-.7-.7zM6 5.3c-.4 0-.7.3-.7.7v8.7c0 .4.3.7.7.7s.7-.3.7-.7V6c0-.4-.3-.7-.7-.7zm2.7 2c-.4 0-.7.3-.7.7v6.7c0 .4.3.7.7.7.4 0 .7-.3.7-.7V8c-.1-.4-.4-.7-.7-.7zM3.3 8c-.3 0-.6.3-.6.7v6c0 .4.3.7.7.7.3-.1.6-.4.6-.7v-6c0-.4-.3-.7-.7-.7z"/>
				</svg>';
			break;

			case 'apple_podcast':
				return '<svg
				class="st-icon"
				width="20px"
				height="20px"
				viewBox="0 0 20 20"
				aria-label="Apple Podcasts Icon">
					<path d="M10 0C5.1 0 1.1 4 1.1 8.9c0 2.9 1.4 5.5 3.6 7.1.3.2.5.4.8.5.3.2.8.1 1-.2.2-.3.1-.8-.2-1-.2-.1-.5-.3-.7-.5-1.8-1.4-3-3.6-3-6 0-4.2 3.4-7.5 7.5-7.5s7.5 3.4 7.5 7.5c0 2.5-1.2 4.7-3 6-.2.2-.5.3-.7.5-.3.2-.5.6-.3 1 .2.3.6.5 1 .3.3-.2.6-.4.8-.6 2.2-1.6 3.6-4.2 3.6-7.2C18.9 4 14.9 0 10 0zm0 2.8c-3.4 0-6.1 2.7-6.1 6.1 0 1.7.7 3.2 1.8 4.3.3.3.7.3 1 0s.3-.7 0-1c-.9-.9-1.4-2-1.4-3.3 0-2.6 2.1-4.7 4.7-4.7s4.7 2.1 4.7 4.7c0 1.3-.5 2.5-1.4 3.3-.3.3-.3.7 0 1 .3.3.7.3 1 0 1.1-1.1 1.8-2.6 1.8-4.3 0-3.3-2.7-6.1-6.1-6.1zm0 3.8C8.7 6.6 7.6 7.7 7.6 9s1.1 2.4 2.4 2.4 2.4-1.1 2.4-2.4-1.1-2.4-2.4-2.4zm0 5.6c-1.3 0-2.4 1.1-2.4 2.4v.5l.9 3.7c.2.7.8 1.2 1.5 1.2s1.3-.5 1.4-1.1l.9-3.7v-.1-.4c.1-1.4-1-2.5-2.3-2.5z"/>
				</svg>';
			break;


			case 'patreon':
				return '<svg
				class="st-icon"
				width="20"
				height="20"
				viewBox="0 0 20 20"
				aria-label="Patreon Icon">
					<path d="M20,7.6c0,4-3.2,7.2-7.2,7.2c-4,0-7.2-3.2-7.2-7.2c0-4,3.2-7.2,7.2-7.2C16.8,0.4,20,3.6,20,7.6z M0,19.6h3.5V0.4H0V19.6z"/>
				</svg>';
			break;

			case 'alignable':
				return '<svg
				class="st-icon"
				width="20"
				height="20"
				viewBox="0 0 20 20"
				aria-label="Alignable Icon">
					<path d="M19.5 6.7C18.1 2.8 14.3 0 9.9 0c-.7 0-1.4.1-2.1.3L6.6.6c.1.1.1.3.2.4.2.8.5 1.6.7 2.4.2.4.4.9.5 1.4.5 1.5 1.1 2.8 1.7 3.8.2.4.5.8.8 1.1.4.4.8.7 1.3.7.7 0 1.3-.6 1.9-1.4.5 1 1.1 2.3 1.5 3.5-.9.8-2 1.3-3.3 1.3-1 0-1.8-.3-2.6-.8-.3-.2-.7-.5-1-.8-1-.9-1.7-2.2-2.4-3.6-.3-.5-.5-1-.7-1.6C4.5 5.5 4 3.9 3.6 2.3c-.4.2-.7.6-1 .9C1 5 0 7.4 0 10c0 2.3.7 4.4 2 6.1.2.4.6.8.9 1.1.3-1.1.7-2.1 1-3.1.4-1.3.8-2.6 1.3-3.9.7 1.3 1.5 2.5 2.5 3.3-.2.6-.4 1.2-.6 1.7-.5 1.3-.9 2.7-1.4 4 .4.1.8.3 1.2.4 1 .3 2 .4 3 .4 2.7 0 5.2-1.1 7-2.8.4-.4.7-.7 1-1.1-.1-.3-.2-.7-.3-1-.3-.7-.5-1.5-.8-2.3-.2-.5-.3-.9-.5-1.4-.5-1.5-1.1-2.8-1.7-3.8-.2-.4-.5-.8-.8-1.1l-.3-.3c-.3-.3-.7-.4-1-.4-.7 0-1.3.6-1.9 1.4-.6-1-1.2-2.3-1.6-3.5.1-.1.2-.2.4-.3.9-.6 1.9-1 3-1 1 0 1.8.3 2.6.8.3.2.7.5 1 .8.9.9 1.7 2.2 2.3 3.5.3.5.5 1.1.7 1.6.3.7.6 1.4.8 2.1.2-.4.2-.8.2-1.2 0-1.1-.2-2.2-.5-3.3z"/>
				</svg>';
			break;


			case 'skype':
				return '<svg
				class="st-icon"
				width="20"
				height="20"
				viewBox="0 0 20 20"
				aria-label="Skype Icon">
					<path d="M5.7 0C2.6 0 0 2.5 0 5.6c0 1 .2 1.9.7 2.7-.1.6-.2 1.2-.2 1.8 0 5.2 4.3 9.4 9.6 9.4.5 0 1.1 0 1.6-.1.8.4 1.7.6 2.6.6 3.1 0 5.7-2.5 5.7-5.6 0-.8-.2-1.6-.5-2.4.1-.6.2-1.2.2-1.9 0-5.2-4.3-9.4-9.6-9.4-.5 0-1 0-1.5.1C7.7.3 6.7 0 5.7 0zM10 3.8c.8 0 1.5.1 2.1.3.6.2 1.1.4 1.5.7.4.3.7.6.9 1 .2.3.3.7.3 1 0 .3-.1.6-.4.9s-.5.3-.8.3c-.3 0-.6-.1-.8-.2-.2-.2-.4-.4-.6-.7-.2-.4-.5-.8-.8-1-.3-.2-.8-.3-1.5-.3s-1.2.1-1.6.4c-.4.2-.6.5-.6.8 0 .2.1.4.2.5.1.2.3.3.5.4.3.1.5.2.8.3.3.1.7.2 1.3.3.7.2 1.4.3 2 .5.6.2 1.1.4 1.6.7.4.3.8.6 1 1.1s.4 1 .4 1.6c0 .7-.2 1.4-.6 2-.4.6-1.1 1.1-1.9 1.4-.8.3-1.8.5-2.9.5-1.3 0-2.4-.2-3.3-.7-.6-.3-1.1-.8-1.5-1.3-.4-.6-.6-1.1-.6-1.6 0-.3.1-.6.4-.9.3-.2.6-.3.9-.3.3 0 .6.1.8.3.2.2.4.4.5.8.2.4.3.7.5.9.2.2.4.4.8.6.3.2.8.2 1.3.2.8 0 1.4-.2 1.8-.5.5-.3.7-.7.7-1.1 0-.4-.1-.6-.4-.9-.2-.2-.6-.4-1-.5-.4-.1-1-.3-1.7-.4-.9-.2-1.8-.4-2.4-.7-.4-.3-1-.7-1.3-1.2-.4-.5-.7-1.1-.7-1.8s.2-1.3.6-1.8c.4-.5 1-.9 1.8-1.2.8-.3 1.7-.4 2.7-.4z"/>
				</svg>';
			break;

			case 'github':
				return '<svg
				class="st-icon"
				width="20"
				height="20"
				viewBox="0 0 20 20"
				aria-label="GitHub Icon">
					<path d="M8.9,0.4C4.3,0.9,0.6,4.6,0.1,9.1c-0.5,4.7,2.2,8.9,6.3,10.5C6.7,19.7,7,19.5,7,19.1v-1.6c0,0-0.4,0.1-0.9,0.1c-1.4,0-2-1.2-2.1-1.9c-0.1-0.4-0.3-0.7-0.6-1C3.1,14.6,3,14.6,3,14.5c0-0.2,0.3-0.2,0.4-0.2c0.6,0,1.1,0.7,1.3,1c0.5,0.8,1.1,1,1.4,1c0.4,0,0.7-0.1,0.9-0.2c0.1-0.7,0.4-1.4,1-1.8c-2.3-0.5-4-1.8-4-4c0-1.1,0.5-2.2,1.2-3C5.1,7.1,5,6.6,5,5.9c0-0.4,0-1,0.3-1.6c0,0,1.4,0,2.8,1.3C8.6,5.4,9.3,5.3,10,5.3s1.4,0.1,2,0.3c1.3-1.3,2.8-1.3,2.8-1.3C15,4.9,15,5.5,15,5.9c0,0.8-0.1,1.2-0.2,1.4c0.7,0.8,1.2,1.8,1.2,3c0,2.2-1.7,3.5-4,4c0.6,0.5,1,1.4,1,2.3v2.6c0,0.3,0.3,0.6,0.7,0.5c3.7-1.5,6.3-5.1,6.3-9.3C20,4.4,14.9-0.3,8.9,0.4z"/>
				</svg>';
			break;

			case 'gitlab':
				return '<svg
				class="st-icon"
				width="20"
				height="20"
				viewBox="0 0 20 20"
				aria-label="GitLab Icon">
					<path d="M15.7.9c-.2 0-.4.1-.4.3l-2.2 6.7H6.9L4.8 1.2C4.7 1 4.5.9 4.4.9c-.2 0-.4.1-.5.3l-2.6 7L0 11.6c0 .2 0 .4.2.5l9.6 7h.1l9.6-7c.5-.1.5-.3.5-.5l-1.3-3.5-2.6-7c-.1-.1-.3-.2-.4-.2zM2.6 8.7h3.7l2.5 7.8-6.2-7.8zm11.1 0h3.7l-6.2 7.8 2.5-7.8zm-11.8.4l5.8 7.3L1 11.6l.9-2.5zm16.2 0l.9 2.4-6.7 4.9 5.8-7.3z"/>
				</svg>';
			break;


			case 'youtube':
				return '<svg
				class="st-icon"
				width="20"
				height="20"
				viewbox="0 0 20 20"
				aria-label="YouTube Icon">
					<path d="M15,0H5C2.2,0,0,2.2,0,5v10c0,2.8,2.2,5,5,5h10c2.8,0,5-2.2,5-5V5C20,2.2,17.8,0,15,0z M14.5,10.9l-6.8,3.8c-0.1,0.1-0.3,0.1-0.5,0.1c-0.5,0-1-0.4-1-1l0,0V6.2c0-0.5,0.4-1,1-1c0.2,0,0.3,0,0.5,0.1l6.8,3.8c0.5,0.3,0.7,0.8,0.4,1.3C14.8,10.6,14.6,10.8,14.5,10.9z"/>
				</svg>';
			break;

			case 'vimeo':
				return '<svg
				class="st-icon"
				width="20"
				height="20"
				viewBox="0 0 20 20"
				aria-label="Vimeo Icon">
					<path d="M20,5.3c-0.1,1.9-1.4,4.6-4.1,8c-2.7,3.5-5,5.3-6.9,5.3c-1.2,0-2.2-1.1-3-3.2C4.5,9.7,3.8,6.3,2.5,6.3c-0.2,0-0.7,0.3-1.6,0.9L0,6c2.3-2,4.5-4.3,5.9-4.4c1.6-0.2,2.5,0.9,2.9,3.2c1.3,8.1,1.8,9.3,4.2,5.7c0.8-1.3,1.3-2.3,1.3-3c0.2-2-1.6-1.9-2.8-1.4c1-3.2,2.9-4.8,5.6-4.7C19.1,1.4,20.1,2.7,20,5.3L20,5.3z"/>
				</svg>';
			break;

			case 'dtube':
				return '<svg
				class="st-icon"
				width="20"
				height="20"
				viewBox="0 0 20 20"
				aria-label="DTube Icon">
					<path d="M18.2,6c-0.4-1.2-1.1-2.3-1.9-3.2c-0.8-0.9-1.8-1.6-2.9-2C12.3,0.2,11,0,9.6,0H1.1v20h8.2c1.3,0,2.4-0.2,3.4-0.5c1-0.3,1.9-0.8,2.7-1.4c1.1-0.9,2-2,2.6-3.3c0.6-1.4,0.9-2.9,0.9-4.7C18.9,8.6,18.7,7.2,18.2,6z M6.1,14.5v-9l7.8,4.5L6.1,14.5z"/>
				</svg>';
			break;

			case 'vk':
				return '<svg
				class="st-icon"
				width="20px"
				height="20px"
				viewBox="0 0 20 20"
				aria-label="VKontakte Icon">
					<path d="M19.2,4.8H16c-0.3,0-0.5,0.1-0.6,0.4c0,0-1.3,2.4-1.7,3.2c-1.1,2.2-1.8,1.5-1.8,0.5V5.4c0-0.6-0.5-1.1-1.1-1.1H8.2C7.6,4.3,6.9,4.6,6.5,5.1c0,0,1.2-0.2,1.2,1.5c0,0.4,0,1.6,0,2.6c0,0.4-0.3,0.7-0.7,0.7c-0.2,0-0.4-0.1-0.6-0.2c-1-1.4-1.8-2.9-2.5-4.5C4,5,3.7,4.8,3.5,4.8c-0.7,0-2.1,0-2.9,0C0.2,4.8,0,5,0,5.3c0,0.1,0,0.1,0,0.2C0.9,8,4.8,15.7,9.2,15.7H11c0.4,0,0.7-0.3,0.7-0.7v-1.1c0-0.4,0.3-0.7,0.7-0.7c0.2,0,0.4,0.1,0.5,0.2l2.2,2.1c0.2,0.2,0.5,0.3,0.7,0.3h2.9c1.4,0,1.4-1,0.6-1.7c-0.5-0.5-2.5-2.6-2.5-2.6c-0.3-0.4-0.4-0.9-0.1-1.3c0.6-0.8,1.7-2.2,2.1-2.8C19.6,6.5,20.7,4.8,19.2,4.8z"/>
				</svg>';
			break;

			case 'ok':
				return '<svg
				class="st-icon"
				width="20px"
				height="20px"
				viewBox="0 0 20 20"
				aria-label="Odnoklassniki Icon">
					<path d="M8.2,6.5c0-1,0.8-1.8,1.8-1.8s1.8,0.8,1.8,1.8c0,1-0.8,1.8-1.8,1.8S8.2,7.5,8.2,6.5L8.2,6.5z M20,2.1v15.7c0,1.2-1,2.1-2.1,2.1H2.1C1,20,0,19,0,17.9V2.1C0,1,1,0,2.1,0h15.7C19,0,20,1,20,2.1z M6.4,6.5c0,2,1.6,3.6,3.6,3.6s3.6-1.6,3.6-3.6c0-2-1.6-3.6-3.6-3.6S6.4,4.5,6.4,6.5z M14.2,10.5c-0.2-0.4-0.8-0.8-1.5-0.2c0,0-1,0.8-2.6,0.8s-2.6-0.8-2.6-0.8C6.6,9.8,6,10.1,5.8,10.5c-0.4,0.7,0,1.1,1,1.7c0.8,0.5,1.8,0.7,2.5,0.8l-0.6,0.6c-0.8,0.8-1.6,1.6-2.1,2.1c-0.8,0.8,0.5,2,1.3,1.3l2.1-2.1c0.8,0.8,1.6,1.6,2.1,2.1c0.8,0.8,2.1-0.5,1.3-1.3l-2.1-2.1l-0.6-0.6c0.7-0.1,1.7-0.3,2.5-0.8C14.1,11.6,14.5,11.2,14.2,10.5z"/>
				</svg>';
			break;

			case 'rss':
				return '<svg
				class="st-icon"
				width="20"
				height="20"
				viewBox="0 0 20 20"
				aria-label="RSS Icon">
					<path d="M17.9,0H2.1C1,0,0,1,0,2.1v15.7C0,19,1,20,2.1,20h15.7c1.2,0,2.1-1,2.1-2.1V2.1C20,1,19,0,17.9,0z M5,17.1c-1.2,0-2.1-1-2.1-2.1s1-2.1,2.1-2.1s2.1,1,2.1,2.1S6.2,17.1,5,17.1z M12,17.1h-1.5c-0.3,0-0.5-0.2-0.5-0.5c-0.2-3.6-3.1-6.4-6.7-6.7c-0.3,0-0.5-0.2-0.5-0.5V8c0-0.3,0.2-0.5,0.5-0.5c4.9,0.3,8.9,4.2,9.2,9.2C12.6,16.9,12.3,17.1,12,17.1L12,17.1z M16.6,17.1h-1.5c-0.3,0-0.5-0.2-0.5-0.5c-0.2-6.1-5.1-11-11.2-11.2c-0.3,0-0.5-0.2-0.5-0.5V3.4c0-0.3,0.2-0.5,0.5-0.5c7.5,0.3,13.5,6.3,13.8,13.8C17.2,16.9,16.9,17.1,16.6,17.1L16.6,17.1z"/>
				</svg>';
			break;

			case 'facebook_group':
				return '<svg
				class="st-icon"
				width="20px"
				height="20px"
				viewBox="0 0 20 20"
				aria-label="Facebook Group Icon">
					<path d="M3.3,18.4c-0.2-0.5,0.3-2.8,0.7-3.7c0.5-1.1,1.6-2,2.5-2.3c0.6-0.2,0.7-0.2,2.1,0.5l1.4,0.7l1.4-0.7c0.8-0.4,1.5-0.7,1.8-0.7c0.5,0,1.8,0.9,2.4,1.6c0.6,0.9,1.1,2.3,1.2,3.7l0,1.1l-6.7,0C4,18.7,3.4,18.6,3.3,18.4z M0.1,12.8c-0.4-0.9,0.6-3.4,1.6-4.1c0.8-0.5,1.5-0.5,2.5,0.1c0.6,0.4,0.9,0.5,1.1,0.3C5.6,9,5.7,9,5.9,9.3c0.2,0.2,0.6,0.6,0.9,1c0.6,0.6,0.6,0.7-0.4,1.1c-0.4,0.1-1.1,0.5-1.6,1l-0.9,0.7H2.1C0.5,13.1,0.2,13,0.1,12.8z M15.3,12.4c-0.4-0.4-1.1-0.8-1.5-1c-1.1-0.4-1.1-0.5-0.5-1.1c0.3-0.3,0.7-0.7,0.9-1C14.4,9,14.5,9,14.8,9.1c0.2,0.1,0.5,0,1.1-0.3c0.5-0.3,1.1-0.5,1.4-0.5c1.3,0,2.6,1.8,2.7,3.7l0,1l-2,0l-2,0L15.3,12.4z M8.4,10.6C7,9.9,6,8.4,6,6.9c0-2.1,2-4.1,4.1-4.1s4.1,2,4.1,4.1S12.1,11,10,11C9.6,11,8.9,10.8,8.4,10.6z M3.5,6.8c-1.7-1-1.9-3.5-0.4-4.7c1.1-0.9,2.5-1,3.6-0.2c1,0.7,1,0.9,0.2,1.6c-0.8,0.7-1.4,1.8-1.5,3C5.2,7.2,5.2,7.3,4.7,7.3C4.4,7.3,3.9,7.1,3.5,6.8z M14.8,6.5c-0.2-1.2-0.7-2.3-1.5-3c-0.8-0.7-0.8-0.9,0.2-1.6C15.4,0.6,18,2,18,4.3c0,1.5-1.4,3-2.7,3C14.9,7.3,14.9,7.2,14.8,6.5z"/>
				</svg>';
			break;

			case 'discord':
				return '<svg
				class="st-icon"
				width="20px"
				height="20px"
				viewBox="0 0 20 20"
				aria-label="Discord Icon">
					<path d="M17.2,4.2c-1.7-1.4-4.5-1.6-4.6-1.6c-0.2,0-0.4,0.1-0.4,0.3c0,0-0.1,0.1-0.1,0.4c1.1,0.2,2.6,0.6,3.8,1.4C16.1,4.7,16.2,5,16,5.2c-0.1,0.1-0.2,0.2-0.4,0.2c-0.1,0-0.2,0-0.2-0.1C13.3,4,10.5,3.9,10,3.9S6.7,4,4.6,5.3C4.4,5.5,4.1,5.4,4,5.2C3.8,5,3.9,4.7,4.1,4.6c1.3-0.8,2.7-1.2,3.8-1.4C7.9,3,7.8,2.9,7.8,2.9C7.7,2.7,7.5,2.6,7.4,2.6c-0.1,0-2.9,0.2-4.6,1.7C1.8,5.1,0,10.1,0,14.3c0,0.1,0,0.2,0.1,0.2c1.3,2.2,4.7,2.8,5.5,2.8c0,0,0,0,0,0c0.1,0,0.3-0.1,0.4-0.2l0.8-1.1c-2.1-0.6-3.2-1.5-3.3-1.6c-0.2-0.2-0.2-0.4,0-0.6c0.2-0.2,0.4-0.2,0.6,0c0,0,2,1.7,6,1.7c4,0,6-1.7,6-1.7c0.2-0.2,0.5-0.1,0.6,0c0.2,0.2,0.1,0.5,0,0.6c-0.1,0.1-1.2,1-3.3,1.6l0.8,1.1c0.1,0.1,0.2,0.2,0.4,0.2c0,0,0,0,0,0c0.8,0,4.2-0.6,5.5-2.8c0-0.1,0.1-0.1,0.1-0.2C20,10.1,18.2,5.1,17.2,4.2z M7.2,12.6c-0.8,0-1.5-0.8-1.5-1.7s0.7-1.7,1.5-1.7c0.8,0,1.5,0.8,1.5,1.7S8,12.6,7.2,12.6z M12.8,12.6c-0.8,0-1.5-0.8-1.5-1.7s0.7-1.7,1.5-1.7c0.8,0,1.5,0.8,1.5,1.7S13.7,12.6,12.8,12.6z"/>
				</svg>';
			break;

			case 'tripadvisor':
				return '<svg
				class="st-icon"
				width="20px"
				height="20px"
				viewBox="0 0 20 20"
				aria-label="TripAdvisor Icon">
					<path d="M5.9 10.7c0 .4-.4.8-.8.8s-.8-.4-.8-.8.4-.8.8-.8.8.3.8.8zm1.7 0c0 1.3-1.1 2.4-2.4 2.4S2.7 12 2.7 10.7c0-1.3 1.1-2.4 2.4-2.4s2.5 1 2.5 2.4zm-.9 0c0-.9-.7-1.6-1.6-1.6-.9 0-1.6.7-1.6 1.6 0 .9.7 1.6 1.6 1.6.9 0 1.6-.7 1.6-1.6zm8.2-.8c-.4 0-.8.4-.8.8s.4.8.8.8.8-.4.8-.8c0-.5-.4-.8-.8-.8zm2.4.8c0 1.3-1.1 2.4-2.4 2.4s-2.4-1.1-2.4-2.4c0-1.3 1.1-2.4 2.4-2.4s2.4 1 2.4 2.4zm-.8 0c0-.9-.7-1.6-1.6-1.6-.9 0-1.6.7-1.6 1.6 0 .9.7 1.6 1.6 1.6.9 0 1.6-.7 1.6-1.6zm1.6 4.1c-2.1 1.7-5.2 1.3-6.9-.8l-.9 1.5c0 .1-.1.1-.1.1-.2.1-.4.1-.6-.1L8.7 14c-1.7 2.1-4.7 2.5-6.9.8-2-1.7-2.4-4.8-.8-6.9-.1-.5-.4-1-.7-1.4 0-.1-.1-.2-.1-.3 0-.2.2-.4.4-.4h3.1c3.9-2.2 8.7-2.2 12.6 0h3.1c.1 0 .2 0 .3.1.2.1.2.4 0 .6-.3.4-.6.9-.8 1.4 1.7 2.1 1.3 5.2-.8 6.9zm-8.9-4.1c0-2.2-1.8-4.1-4.1-4.1h-1C2.3 7.1 1 8.8 1 10.7c0 2.2 1.9 4 4.1 4 2.3.1 4.1-1.8 4.1-4zm6.6-4h-.2c-.2 0-.5-.1-.7-.1-2.2 0-4 1.7-4.1 3.9 0 .7.2 1.4.5 2.1.1.1.1.2.2.3.8 1.1 2 1.8 3.4 1.8 1.9 0 3.5-1.3 3.9-3.1.5-2.1-.8-4.3-3-4.9z"/>
				</svg>';
			break;

			case 'foursquare':
				return '<svg
				class="st-icon"
				width="20px"
				height="20px"
				viewBox="0 0 20 20"
				aria-label="Foursquare Icon">
					<path d="M14.8 2.9l-.4 2.3c-.1.3-.4.5-.7.5H9.5c-.5 0-.8.4-.8.8V7c0 .5.3.8.8.8H13c.3 0 .7.4.6.7l-.4 2.3c0 .2-.3.5-.7.5H9.6c-.5 0-.7.1-1 .5-.3.4-3.5 4.2-3.5 4.2H5V2.8c0-.3.3-.6.6-.6h8.6c.4 0 .7.3.6.7zm.3 9.1c.1-.5 1.5-7.3 1.9-9.5M15.4 0H4.7C3.3 0 2.8 1.1 2.8 1.8v16.9c0 .8.4 1.1.7 1.2.2.1.9.2 1.3-.3 0 0 5-5.8 5.1-5.9.1-.1.1-.1.3-.1h3.3c1.4 0 1.6-1 1.7-1.5.1-.5 1.5-7.3 1.9-9.5C17.4.9 17 0 15.4 0z"/>
				</svg>';
			break;

			case 'yelp':
				return '<svg
				class="st-icon"
				width="20px"
				height="20px"
				viewBox="0 0 20 20"
				aria-label="Yelp Icon">
					<path d="M18.8 14.4c0 .4-.3.8-.3.9l-2.1 2.9-.1.1c-.1 0-.5.3-1 .3s-1-.6-1.1-.7l-2.7-4.2c-.3-.3-.3-1 .1-1.5.3-.3.5-.3.9-.3h.3l5 1.5c.3.1 1 .3 1 1zm-6.1-3.3l5-1.4c.2-.1.9-.3 1-.9.2-.5-.1-1-.2-1 0 0 0-.1-.1-.1L16 5.2c0-.1-.3-.5-1-.5s-1 .6-1 .7l-2.8 4.2c-.2.3-.3.8 0 1.2.3.2.6.3 1.1.3h.4zM9.9.2C9.3 0 8.9 0 8.6.1L4.4 1.4c-.1 0-.5.2-.9.6-.4.8.4 1.6.4 1.6l4.4 5.5c.1.1.4.4 1 .4h.3c.7-.2 1-.9 1-1.3V1.6c-.1-.2-.2-1.1-.7-1.4zM8 12.6c.3-.1.7-.3.7-1.1s-.8-1.1-.9-1.2L3.4 8.2c-.1 0-1-.3-1.3-.1-.2.1-.7.5-.7.9l-.3 3.3c0 .2 0 .7.2 1 .1.2.3.4.8.4.3 0 .6-.1.6-.1l5.1-1c.2.1.2 0 .2 0zm1.8.3c-.2-.1-.3-.1-.4-.1-.5 0-1 .3-1 .4l-3.5 3.6c-.1.2-.5.8-.3 1.3.2.4.3.7.8.9l3.5 1h.4c.2 0 .3 0 .4-.1.5-.2.7-.8.7-1.2l.1-4.9c0-.2-.2-.7-.7-.9z"/>
				</svg>';
			break;

			case 'hacker_news':
				return '<svg
				class="st-icon"
				width="20px"
				height="20px"
				viewBox="0 0 20 20"
				aria-label="Hacker News Icon">
					<path d="M0,0v20h20V0H0z M11.2,11.8v4.7H8.8v-4.7L4.7,4.1h1.9l3.4,6l3.4-6h1.9L11.2,11.8z"/>
				</svg>';
			break;

			case 'xing':
				return '<svg
				class="st-icon"
				width="20"
				height="20"
				viewBox="0 0 20 20"
				aria-label="Xing Icon">
					<path d="M16.8,0H3.2C1.4,0,0,1.4,0,3.2v13.6C0,18.6,1.4,20,3.2,20h13.6c1.8,0,3.2-1.4,3.2-3.2V3.2C20,1.4,18.6,0,16.8,0z M6.2,13.3H3.8c-0.2,0-0.3-0.3-0.3-0.4L6,8.4c0.1-0.1,0.1-0.2,0-0.3L4.5,5.4C4.4,5.3,4.5,5,4.7,5H7c0.1,0,0.2,0.1,0.3,0.2L9,8.2c0.1,0.1,0.1,0.2,0,0.3l-2.6,4.7C6.4,13.2,6.2,13.3,6.2,13.3z M16.3,2.9l-4.7,8.6c-0.1,0.1-0.1,0.2,0,0.3l3,5.3c0.1,0.2,0,0.4-0.3,0.4h-2.3c-0.1,0-0.2-0.1-0.3-0.2l-3.2-5.6c-0.1-0.1-0.1-0.2,0-0.3l4.8-8.9c0.1,0,0.3-0.1,0.3-0.1h2.3C16.3,2.5,16.4,2.8,16.3,2.9z"/>
				</svg>';
			break;

			case 'whatsapp':
				return '<svg
				class="st-icon"
				width="20px"
				height="20px"
				viewBox="0 0 20 20"
				aria-label="WhatsApp Icon">
					<path d="M10,0C4.5,0,0,4.5,0,10c0,1.9,0.5,3.6,1.4,5.1L0.1,20l5-1.3C6.5,19.5,8.2,20,10,20c5.5,0,10-4.5,10-10S15.5,0,10,0zM6.6,5.3c0.2,0,0.3,0,0.5,0c0.2,0,0.4,0,0.6,0.4c0.2,0.5,0.7,1.7,0.8,1.8c0.1,0.1,0.1,0.3,0,0.4C8.3,8.2,8.3,8.3,8.1,8.5C8,8.6,7.9,8.8,7.8,8.9C7.7,9,7.5,9.1,7.7,9.4c0.1,0.2,0.6,1.1,1.4,1.7c0.9,0.8,1.7,1.1,2,1.2c0.2,0.1,0.4,0.1,0.5-0.1c0.1-0.2,0.6-0.7,0.8-1c0.2-0.2,0.3-0.2,0.6-0.1c0.2,0.1,1.4,0.7,1.7,0.8s0.4,0.2,0.5,0.3c0.1,0.1,0.1,0.6-0.1,1.2c-0.2,0.6-1.2,1.1-1.7,1.2c-0.5,0-0.9,0.2-3-0.6c-2.5-1-4.1-3.6-4.2-3.7c-0.1-0.2-1-1.3-1-2.6c0-1.2,0.6-1.8,0.9-2.1C6.1,5.4,6.4,5.3,6.6,5.3z"/>
				</svg>';
			break;

			case 'flipboard':
				return '<svg
				class="st-icon"
				width="20px"
				height="20px"
				viewBox="0 0 20 20"
				aria-label="Flipboard Icon">
					<path d="M0 0v20h20V0H0zm16 8h-4v4H8v4H4V4h12v4z"/>
				</svg>';
			break;

			case 'viber':
				return '<svg
				class="st-icon"
				width="20px"
				height="20px"
				viewBox="0 0 20 20"
				aria-label="Viber Icon">
					<path d="M18.6,4.4c-0.3-1.2-1-2.2-2-2.9c-1.2-0.9-2.7-1.2-3.9-1.4C11,0,9.4-0.1,8,0.1C6.6,0.3,5.5,0.6,4.6,1c-1.9,0.9-3,2.2-3.3,4.1C1.1,6,1,6.9,0.9,7.6c-0.2,1.8,0,3.4,0.4,4.9c0.4,1.5,1.2,2.5,2.2,3.2c0.3,0.2,0.6,0.3,1,0.4c0.2,0.1,0.3,0.1,0.5,0.2v2.9C5,19.7,5.3,20,5.7,20l0,0c0.2,0,0.4-0.1,0.5-0.2l2.7-2.6C9,17,9,17,9.1,17c0.9,0,1.9-0.1,2.8-0.1c1.1-0.1,2.5-0.2,3.7-0.7c1.1-0.5,2-1.2,2.5-2.2c0.5-1.1,0.8-2.2,0.9-3.5C19.3,8.2,19.1,6.2,18.6,4.4z M13.9,13.1c-0.3,0.4-0.7,0.8-1.2,1c-0.4,0.1-0.7,0.1-1.1,0C8.8,12.8,6.5,10.9,5,8.1C4.7,7.5,4.5,6.9,4.2,6.3C4.2,6.2,4.2,6,4.2,5.9c0-1,0.8-1.5,1.5-1.7c0.3-0.1,0.5,0,0.8,0.2c0.6,0.6,1.1,1.2,1.4,2C8,6.7,8,7,7.7,7.2C7.6,7.3,7.6,7.3,7.5,7.4C6.9,7.8,6.8,8.2,7.2,8.9c0.5,1.2,1.5,1.9,2.6,2.4c0.3,0.1,0.6,0.1,0.8-0.2c0,0,0.1-0.1,0.1-0.1c0.5-0.8,1.1-0.7,1.8-0.3c0.4,0.3,0.8,0.6,1.2,0.9C14.3,12.1,14.3,12.5,13.9,13.1z M10.4,5.1c-0.2,0-0.3,0-0.5,0C9.7,5.2,9.5,5,9.4,4.8c0-0.3,0.1-0.5,0.4-0.5c0.2,0,0.4-0.1,0.6-0.1c2.1,0,3.7,1.7,3.7,3.7c0,0.2,0,0.4-0.1,0.6c0,0.2-0.2,0.4-0.5,0.4c0,0-0.1,0-0.1,0c-0.3,0-0.4-0.3-0.4-0.5c0-0.2,0-0.3,0-0.5C13.2,6.4,12,5.1,10.4,5.1z M12.5,8.2c0,0.3-0.2,0.5-0.5,0.5s-0.5-0.2-0.5-0.5c0-0.8-0.6-1.4-1.4-1.4c-0.3,0-0.5-0.2-0.5-0.5c0-0.3,0.2-0.5,0.5-0.5C11.4,5.8,12.5,6.9,12.5,8.2zM15.7,8.8c-0.1,0.2-0.2,0.4-0.5,0.4c0,0-0.1,0-0.1,0c-0.3-0.1-0.4-0.3-0.4-0.6c0.1-0.3,0.1-0.6,0.1-0.9c0-2.3-1.9-4.2-4.2-4.2c-0.3,0-0.6,0-0.9,0.1C9.5,3.6,9.2,3.5,9.2,3.2C9.1,2.9,9.3,2.7,9.5,2.6c0.4-0.1,0.8-0.1,1.1-0.1c2.8,0,5.2,2.3,5.2,5.2C15.8,8,15.8,8.4,15.7,8.8z"/>
				</svg>';
			break;

			case 'line':
				return '<svg
				class="st-icon"
				width="20px"
				height="20px"
				viewBox="0 0 20 20"
				aria-label="Line Icon">
					<path d="M16.1 8.2c.3 0 .5.2.5.5s-.2.5-.5.5h-1.5v.9h1.5c.3 0 .5.2.5.5s-.2.5-.5.5h-2c-.3 0-.5-.2-.5-.5v-4c0-.3.2-.5.5-.5h2c.3 0 .5.2.5.5s-.2.5-.5.5h-1.5V8h1.5zm-3.2 2.5c0 .2-.1.4-.4.5h-.2c-.2 0-.3-.1-.4-.2l-2-2.8v2.5c0 .3-.2.5-.5.5s-.5-.2-.5-.5v-4c0-.2.1-.4.4-.5h.2c.2 0 .3.1.4.2L12 9.2V6.8c0-.3.2-.5.5-.5s.5.2.5.5v3.9zm-4.8 0c0 .3-.2.5-.5.5s-.5-.2-.5-.5v-4c0-.3.2-.5.5-.5s.5.2.5.5v4zm-2 .6h-2c-.3 0-.5-.2-.5-.5v-4c0-.3.2-.5.5-.5s.5.2.5.5v3.5h1.5c.3 0 .5.2.5.5 0 .2-.2.5-.5.5M20 8.6C20 4.1 15.5.5 10 .5S0 4.1 0 8.6c0 4 3.6 7.4 8.4 8 .3.1.8.2.9.5.1.3.1.6 0 .9l-.1.9c0 .3-.2 1 .9.5 1.1-.4 5.8-3.4 7.9-5.8 1.3-1.6 2-3.2 2-5"/>
				</svg>';
			break;

			case 'weibo':
				return '<svg
				class="st-icon"
				width="20"
				height="20"
				viewBox="0 0 20 20"
				aria-label="Weibo Icon">
					<path d="M15.9,7.6c0.3-0.9-0.5-1.8-1.5-1.6c-0.9,0.2-1.1-1.1-0.3-1.3c2-0.4,3.6,1.4,3,3.3C16.9,8.8,15.6,8.4,15.9,7.6z M8.4,18.1c-4.2,0-8.4-2-8.4-5.3C0,11,1.1,9,3,7.2c3.9-3.9,7.9-3.9,6.8-0.2c-0.2,0.5,0.5,0.2,0.5,0.2c3.1-1.3,5.5-0.7,4.5,2c-0.1,0.4,0,0.4,0.3,0.5C20.3,11.3,16.4,18.1,8.4,18.1L8.4,18.1zM14,12.4c-0.2-2.2-3.1-3.7-6.4-3.3C4.3,9.4,1.8,11.4,2,13.6s3.1,3.7,6.4,3.3C11.7,16.6,14.2,14.6,14,12.4zM13.6,2c-1,0.2-0.7,1.7,0.3,1.5c2.8-0.6,5.3,2.1,4.4,4.8c-0.3,0.9,1.1,1.4,1.5,0.5C21,4.9,17.6,1.2,13.6,2L13.6,2z M10.5,14.2c-0.7,1.5-2.6,2.3-4.3,1.8c-1.6-0.5-2.3-2.1-1.6-3.5c0.7-1.4,2.5-2.2,4-1.8C10.4,11.1,11.2,12.7,10.5,14.2zM7.2,13c-0.5-0.2-1.2,0-1.5,0.5C5.3,14,5.5,14.6,6,14.8c0.5,0.2,1.2,0,1.5-0.5C7.8,13.8,7.7,13.2,7.2,13zM8.4,12.5c-0.2-0.1-0.4,0-0.6,0.2c-0.1,0.2-0.1,0.4,0.1,0.5c0.2,0.1,0.5,0,0.6-0.2C8.7,12.8,8.6,12.6,8.4,12.5z"/>
				</svg>';
			break;

			case 'tumblr':
				return '<svg
				class="st-icon"
				width="20"
				height="20"
				viewBox="0 0 20 20"
				aria-label="Tumblr Icon">
					<path d="M18,0H2C0.9,0,0,0.9,0,2v16c0,1.1,0.9,2,2,2h16c1.1,0,2-0.9,2-2V2C20,0.9,19.1,0,18,0z M15,15.9c0,0,0,0.1-0.1,0.1c0,0-1.4,1-3.9,1c-3,0-3-3.6-3-4V9H6.2C6.1,9,6,8.9,6,8.8V7.2C6,7.1,6,7,6.1,7C6.1,7,9,5.7,9,3.2C9,3.1,9.1,3,9.2,3h1.7C10.9,3,11,3.1,11,3.2V7h2.8C13.9,7,14,7.1,14,7.2v1.7C14,8.9,13.9,9,13.8,9H11v4c0,0.1-0.1,1.3,1.2,1.3c1.1,0,2.5-0.3,2.5-0.3c0.1,0,0.1,0,0.2,0c0.1,0,0.1,0.1,0.1,0.2V15.9z"/>
				</svg>';
			break;

			case 'qq':
				return '<svg
				class="st-icon"
				width="20"
				height="20"
				viewBox="0 0 20 20"
				aria-label="QQ Icon">
					<path d="M18.2,16.4c-0.5,0.1-1.8-2.1-1.8-2.1c0,1.2-0.6,2.8-2,4c0.7,0.2,2.1,0.7,1.8,1.3C16,20.2,11.3,20,10,19.8c-1.3,0.2-5.9,0.3-6.2-0.2c-0.4-0.6,1.1-1.1,1.8-1.3c-1.4-1.2-2-2.8-2-4c0,0-1.3,2.1-1.8,2.1c-0.2,0-0.5-1.2,0.4-3.9c0.4-1.3,0.9-2.4,1.6-4.1C3.6,3.8,5.5,0,10,0c4.4,0,6.4,3.8,6.3,8.4c0.7,1.8,1.2,2.8,1.6,4.1C18.7,15.3,18.4,16.4,18.2,16.4L18.2,16.4z"/>
				</svg>';
			break;

			case 'wechat':
				return '<svg
				class="st-icon"
				width="20"
				height="20"
				viewBox="0 0 20 20"
				aria-label="WeChat Icon">
					<path d="M13.5,6.8c0.2,0,0.5,0,0.7,0c-0.6-2.9-3.7-5-7.1-5C3.2,1.9,0,4.5,0,7.9c0,1.9,1.1,3.5,2.8,4.8l-0.7,2.1l2.5-1.2c0.9,0.2,1.6,0.4,2.5,0.4c0.2,0,0.4,0,0.7,0c-0.1-0.5-0.2-1-0.2-1.5C7.5,9.3,10.2,6.8,13.5,6.8L13.5,6.8zM9.7,4.9c0.5,0,0.9,0.4,0.9,0.9c0,0.5-0.4,0.9-0.9,0.9c-0.5,0-1.1-0.4-1.1-0.9C8.7,5.2,9.2,4.9,9.7,4.9zM4.8,6.6c-0.5,0-1.1-0.4-1.1-0.9c0-0.5,0.5-0.9,1.1-0.9c0.5,0,0.9,0.4,0.9,0.9C5.7,6.3,5.3,6.6,4.8,6.6z M20,12.3c0-2.8-2.8-5.1-6-5.1c-3.4,0-6,2.3-6,5.1s2.6,5.1,6,5.1c0.7,0,1.4-0.2,2.1-0.4l1.9,1.1l-0.5-1.8C18.9,15.3,20,13.9,20,12.3zM12,11.4c-0.4,0-0.7-0.4-0.7-0.7c0-0.4,0.4-0.7,0.7-0.7c0.5,0,0.9,0.4,0.9,0.7C12.9,11.1,12.6,11.4,12,11.4zM15.9,11.4c-0.4,0-0.7-0.4-0.7-0.7c0-0.4,0.4-0.7,0.7-0.7c0.5,0,0.9,0.4,0.9,0.7C16.8,11.1,16.5,11.4,15.9,11.4z"/>
				</svg>';
			break;

			case 'strava':
				return '<svg
				class="st-icon"
				width="20"
				height="20"
				viewBox="0 0 20 20"
				aria-label="Strava Icon">
					<path d="M12.3,13.9l-1.4-2.7h2.8L12.3,13.9z M20,3v14c0,1.7-1.3,3-3,3H3c-1.7,0-3-1.3-3-3V3c0-1.7,1.3-3,3-3h14C18.7,0,20,1.3,20,3zM15.8,11.1h-2.1L9,2l-4.7,9.1H7L9,7.5l1.9,3.6H8.8l3.5,6.9L15.8,11.1z"/>
				</svg>';
			break;

			case 'flickr':
				return '<svg
				class="st-icon"
				width="20"
				height="20"
				viewBox="0 0 20 20"
				aria-label="Flickr Icon">
					<path d="M4.7 14.7C2.1 14.8 0 12.6 0 10c0-2.5 2.1-4.7 4.8-4.7 2.6 0 4.7 2.1 4.7 4.8 0 2.6-2.2 4.7-4.8 4.6z"/>
					<path d="M15.3 5.3C18 5.3 20 7.5 20 10c0 2.6-2.1 4.7-4.7 4.7-2.5 0-4.7-2-4.7-4.7-.1-2.6 2-4.7 4.7-4.7z"/>
				</svg>';
			break;
                
			case 'wordpress':
				return '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M2.597 7.81l4.911 13.454c-3.434-1.668-5.802-5.19-5.802-9.264 0-1.493.32-2.91.891-4.19zm16.352 3.67c0-1.272-.457-2.153-.849-2.839-.521-.849-1.011-1.566-1.011-2.415 0-.978.747-1.88 1.862-1.819-1.831-1.677-4.271-2.701-6.951-2.701-3.596 0-6.76 1.845-8.601 4.64.625.02 1.489.032 3.406-.118.555-.034.62.782.066.847 0 0-.558.065-1.178.098l3.749 11.15 2.253-6.756-1.604-4.394c-.555-.033-1.08-.098-1.08-.098-.555-.033-.49-.881.065-.848 2.212.17 3.271.171 5.455 0 .555-.033.621.783.066.848 0 0-.559.065-1.178.098l3.72 11.065 1.027-3.431c.444-1.423.783-2.446.783-3.327zm-6.768 1.42l-3.089 8.975c.922.271 1.898.419 2.908.419 1.199 0 2.349-.207 3.418-.583-.086-.139-3.181-8.657-3.237-8.811zm8.852-5.839c.224 1.651-.099 3.208-.713 4.746l-3.145 9.091c3.061-1.784 5.119-5.1 5.119-8.898 0-1.79-.457-3.473-1.261-4.939zm2.967 4.939c0 6.617-5.384 12-12 12s-12-5.383-12-12 5.383-12 12-12 12 5.383 12 12zm-.55 0c0-6.313-5.137-11.45-11.45-11.45s-11.45 5.137-11.45 11.45 5.137 11.45 11.45 11.45 11.45-5.137 11.45-11.45z"/></svg>';
			break;
                
			case 'phone':
				return '<svg
				class="st-icon"
				width="20"
				height="20"
				viewBox="0 0 20 20"
				aria-label="Phone Icon">
					<path d="M4.8,0C2.1,0,0,2.1,0,4.8v10.5C0,17.9,2.1,20,4.8,20h10.5c2.6,0,4.8-2.1,4.8-4.8V4.8C20,2.1,17.9,0,15.2,0H4.8z M6.7,3.8C7,3.8,7.2,4,7.4,4.3C7.6,4.6,7.9,5,8.3,5.6c0.3,0.5,0.4,1.2,0.1,1.8l-0.7,1C7.4,8.7,7.4,9,7.5,9.3c0.2,0.5,0.6,1.2,1.3,1.9c0.7,0.7,1.4,1.1,1.9,1.3c0.3,0.1,0.6,0.1,0.9-0.1l1-0.7c0.6-0.3,1.3-0.3,1.8,0.1c0.6,0.4,1.1,0.7,1.3,0.9c0.3,0.2,0.4,0.4,0.4,0.7c0.1,1.7-1.2,2.4-1.6,2.4c-0.3,0-3.4,0.4-7-3.2s-3.2-6.8-3.2-7C4.3,5.1,5,3.8,6.7,3.8z"/>
				</svg>';
			break;
                
			case 'email':
				return '<svg
				class="st-icon"
				width="20"
				height="20"
				viewBox="0 0 20 20"
				aria-label="Email Icon">
					<path d="M10,10.1L0,4.7C0.1,3.2,1.4,2,3,2h14c1.6,0,2.9,1.2,3,2.8L10,10.1z M10,11.8c-0.1,0-0.2,0-0.4-0.1L0,6.4V15c0,1.7,1.3,3,3,3h4.9h4.3H17c1.7,0,3-1.3,3-3V6.4l-9.6,5.2C10.2,11.7,10.1,11.7,10,11.8z"/>
				</svg>';
			break;

            case 'location':
				return '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" viewBox="Location Icon">
                            <path d="M12 0c-4.198 0-8 3.403-8 7.602 0 4.198 3.469 9.21 8 16.398 4.531-7.188 8-12.2 8-16.398 0-4.199-3.801-7.602-8-7.602zm0 11c-1.657 0-3-1.343-3-3s1.343-3 3-3 3 1.343 3 3-1.343 3-3 3z"/>
                        </svg>';
			break;
                
                
            case 'cart':
				return '<svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24"><path d="M20 7h-4v-3c0-2.209-1.791-4-4-4s-4 1.791-4 4v3h-4l-2 17h20l-2-17zm-11-3c0-1.654 1.346-3 3-3s3 1.346 3 3v3h-6v-3zm-4.751 18l1.529-13h2.222v1.5c0 .276.224.5.5.5s.5-.224.5-.5v-1.5h6v1.5c0 .276.224.5.5.5s.5-.224.5-.5v-1.5h2.222l1.529 13h-15.502z"/></svg>';
			break;
                
            case 'wishlist':
				return '<svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 24 24"><path d="M12 9.229c.234-1.12 1.547-6.229 5.382-6.229 2.22 0 4.618 1.551 4.618 5.003 0 3.907-3.627 8.47-10 12.629-6.373-4.159-10-8.722-10-12.629 0-3.484 2.369-5.005 4.577-5.005 3.923 0 5.145 5.126 5.423 6.231zm-12-1.226c0 4.068 3.06 9.481 12 14.997 8.94-5.516 12-10.929 12-14.997 0-7.962-9.648-9.028-12-3.737-2.338-5.262-12-4.27-12 3.737z"/></svg>';
			break;
                
            case 'list':
				return '<svg width="21" height="21" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M9 21h-9v-2h9v2zm6.695-2.88l-3.314-3.13-1.381 1.47 4.699 4.54 8.301-8.441-1.384-1.439-6.921 7zm-6.695-1.144h-9v-2h9v2zm8-3.976h-17v-2h17v2zm7-4h-24v-2h24v2zm0-4h-24v-2h24v2z"/></svg>';
			break;                
                
            case 'sync':
				return '<svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 24 24"><path d="M23 12c0 1.042-.154 2.045-.425 3h-2.101c.335-.94.526-1.947.526-3 0-4.962-4.037-9-9-9-1.706 0-3.296.484-4.655 1.314l1.858 2.686h-6.994l2.152-7 1.849 2.673c1.684-1.049 3.659-1.673 5.79-1.673 6.074 0 11 4.925 11 11zm-6.354 7.692c-1.357.826-2.944 1.308-4.646 1.308-4.962 0-9-4.038-9-9 0-1.053.191-2.06.525-3h-2.1c-.271.955-.425 1.958-.425 3 0 6.075 4.925 11 11 11 2.127 0 4.099-.621 5.78-1.667l1.853 2.667 2.152-6.989h-6.994l1.855 2.681z"/></svg>';
			break;
                
            case 'my-account':
				return '<svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 24 24"><path d="M12 2c2.757 0 5 2.243 5 5.001 0 2.756-2.243 5-5 5s-5-2.244-5-5c0-2.758 2.243-5.001 5-5.001zm0-2c-3.866 0-7 3.134-7 7.001 0 3.865 3.134 7 7 7s7-3.135 7-7c0-3.867-3.134-7.001-7-7.001zm6.369 13.353c-.497.498-1.057.931-1.658 1.302 2.872 1.874 4.378 5.083 4.972 7.346h-19.387c.572-2.29 2.058-5.503 4.973-7.358-.603-.374-1.162-.811-1.658-1.312-4.258 3.072-5.611 8.506-5.611 10.669h24c0-2.142-1.44-7.557-5.631-10.647z"/></svg>';
			break;
                
            case 'arrow-left':
				return '<svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M20 .755l-14.374 11.245 14.374 11.219-.619.781-15.381-12 15.391-12 .609.755z"/></svg>';
            break;            
                
            case 'arrow-right':
				return '<svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M4 .755l14.374 11.245-14.374 11.219.619.781 15.381-12-15.391-12-.609.755z"/></svg>';
            break;
                
			default:
            # code...
            break;
		}
	}
endif;



if( ! function_exists( 'best_shop_is_woocommerce_activated' ) ) :
	/**
	 * Query WooCommerce activation
	 */
	function best_shop_is_woocommerce_activated() {
		return class_exists( 'woocommerce' ) ? true : false;
	}
endif;

if( ! function_exists( 'best_shop_is_btnw_activated' ) ) :
	/**
	 * Is gradientthemes Email Newsletters active or not
	*/
	function best_shop_is_btnw_activated(){
		return class_exists( 'gradientthemes_Email_Newsletter' ) ? true : false;        
	}
endif;


/*
 * News widget functions
 */

function best_shop_post_grid( $loop, $max_height, $title, $layout, $excerpt, $colums ){

		global $post;
		$i = 1;
		
		while( $loop->have_posts() ) : $loop->the_post();
			$post_id = get_the_ID();		  
			$thumb_id = get_post_thumbnail_id($post_id);
			$url = get_the_post_thumbnail_url($post_id, 'full');
			
			if(!$url) {
				$url = get_template_directory_uri().'/images/empty.png';
			}
						
			$alt = get_post_meta($thumb_id, '_wp_attachment_image_alt', true);
			$title = get_the_title();
			$content = get_the_excerpt();
			$date = get_the_time('M d, Y', $post_id );
			$author = get_the_author();
			$author_id = $post->post_author ;
			//compact
			if($layout == 1) {
			?>
			<div class="<?php echo esc_attr($colums); ?> post-compact" >
		  		<div class="background-img" >
					<a  href="<?php the_permalink(); ?>"><?php the_post_thumbnail('best-shop-medium'); ?></a>
                    <div class="post-compact-container" >
						<div class="portfolio-content" >
							<h3><a href="<?php the_permalink(); ?>" ><?php echo esc_html($title); ?></a></h3>
							<div class="item-metadata ">
                                <span><?php echo get_avatar(get_the_author_meta('user_email', $author_id), 16); ?></span>
								<span class="author"><i class="fa fa-user-o"></i><?php echo ' '.esc_html($author); ?></span>
								<span class="posts-date">
								<i class="fa fa-clock-o" aria-hidden="true"></i><?php echo ' '.esc_html($date); ?>
								</span>	
							</div>
							<?php best_shop_print_post_cat($post_id); ?>												
						</div>
						
					</div>
				</div>
			</div>
			<?php
			
			//List
			} else if ($layout == 2){
			
			?>
			<div class="<?php echo esc_attr($colums); ?> post-grid" >
			 <div class="post-content" >
		  		<div class="post-compact-container">                    
					<a  href="<?php the_permalink(); ?>"><?php the_post_thumbnail('best-shop-medium'); ?></a>
					<?php best_shop_print_post_cat($post_id); ?>
				</div>
					<div class="layout-list portfolio-content" >
						<h3><a  href="<?php the_permalink(); ?>"><?php echo $title; ?></a></h3>		
						
						<div class="item-metadata ">
                            <span><?php echo get_avatar(get_the_author_meta('user_email', $author_id), 16); ?></span>
							<span class="author"><i class="fa fa-user-o"></i><?php echo ' '.esc_html($author); ?></span>
							<span class="posts-date">
							<i class="fa fa-clock-o" aria-hidden="true"></i><?php echo ' '.esc_html($date); ?>
							</span>	
						</div>											
						
						<?php if($excerpt > 0 && $excerpt !==''): ?>
						<p><?php echo wp_kses_post( best_shop_trim_content($excerpt , $post) ); ?></p>
						<?php endif; ?>
						
						<a class="more-link" href="<?php the_permalink(); ?>"><?php echo esc_html__("Read More", "best-shop"); ?></a>
					</div>
				</div>				
			</div>
			<?php
			
			//grid
			} else if ($layout == 3 || $layout == 4) {
			
			?>
			<div class="<?php echo esc_attr($colums); ?>  post-list">
			 <div class="post-content vertical-center">		  
		  		<div class="<?php if($layout == 4) echo 'small-list'; ?> post-img" >
					<div style="position:relative">
					<a  href="<?php the_permalink(); ?>"><?php the_post_thumbnail('best-shop-medium-square'); ?></a>
					<?php best_shop_print_post_cat($post_id); ?>
					</div>
				</div>

				<div class="layout-grid <?php if($layout == 4) echo 'small-list'; ?> portfolio-content " >
					 <div>
						<h4><a  href="<?php the_permalink(); ?>"><?php echo esc_html($title); ?></a></h4>
						<div class="item-metadata ">
                            <span><?php echo get_avatar(get_the_author_meta('user_email', $author_id), 16); ?></span>
							<span class="author"><i class="fa fa-user-o"></i><?php echo ' '.esc_html($author); ?></span>
							<span class="posts-date">
							<i class="fa fa-clock-o" aria-hidden="true"></i><?php echo ' '.esc_html($date); ?>
							</span>	
						</div>
						
						<?php if($excerpt > 0 && $excerpt !=='' && $layout != 4): ?>									
						<p><?php echo wp_kses_post( best_shop_trim_content($excerpt , $post) ); ?></p>
						<?php endif; ?>
						
						<a class="more-link" href="<?php the_permalink(); ?>"><?php echo esc_html__("Read More", "best-shop"); ?></a>
					 </div>					
				</div>
			 </div>		
			</div>
						
			<?php
			// Post summery
			} else if ($layout == 5) {
			?>
			
			<div class="<?php echo esc_attr($colums); ?> post-summery">
			
			 <div class="post-content">		  
		  		<div class="post-img" >
					<a  href="<?php the_permalink(); ?>"><?php the_post_thumbnail('best-shop-medium-square'); ?></a>
				</div>

				<div class="layout-summery portfolio-content vertical-center" >
					 <div>
					 	<?php best_shop_print_post_cat($post_id); ?>
						<div class="portfolio-content-inner">
							<h4><a  href="<?php the_permalink(); ?>"><?php echo esc_html($title); ?></a></h4>
					 	</div>
					 </div>					
				</div>
			 </div>	
				
			</div>
							
			<?php			
			}

			$i++; 
		endwhile;
		wp_reset_postdata();
		
}		

/*
 * 
 */
function best_shop_print_post_cat ( $post_id ){

$category_object = get_the_category($post_id);
    
	echo '<div class="post-widget-categories">';
	foreach($category_object as $c){
		$cat = get_category( $c );
		echo '<a>'.esc_html($cat->name).' </a>';
		break;
	}
	echo '</div>';

}

class best_shop_cat	{
	public $term_id = '';
	public $name = '';
}

if ( ! function_exists( 'best_shop_trim_content' ) ) :
	/**
	 * custom excerpt function
	 * 
	 * @since 1.0.0
	 * @return  no of words to display
	 */
	function best_shop_trim_content( $length = 40, $post_obj = null ) {
		global $post;
		if ( is_null( $post_obj ) ) {
			$post_obj = $post;
		}

		$length = absint( $length );
		if ( $length < 1 ) {
			$length = 40;
		}

		$source_content = $post_obj->post_content;
		if ( ! empty( $post_obj->post_excerpt ) ) {
			$source_content = $post_obj->post_excerpt;
		}

		$source_content = preg_replace( '`\[[^\]]*\]`', '', $source_content );
		$trimmed_content = wp_trim_words( $source_content, $length, '...' );

	   return apply_filters( 'best_shop_trim_content', $trimmed_content );
	}
endif;

/*
 * Get Popular taxinomies
 */

function best_shop_list_popular_taxonomies($taxonomy, $title, $number = 5)
{
    $popular_taxonomies = get_terms(array(
        'taxonomy' => $taxonomy,
        'number' => absint($number),
        'orderby' => 'count',
        'order' => 'DESC',
        'hide_empty' => true,
    ));

    $html = '';

    if (isset($popular_taxonomies) && !empty($popular_taxonomies)):
        $html .= '<div class="aft-popular-taxonomies-lists clearfix">';
        if (!empty($title)):
            $html .= '<strong>';
            $html .= esc_html($title);
            $html .= '</strong>';
        endif;
        $html .= '<ul>';
        foreach ($popular_taxonomies as $tax_term):
            $html .= '<li>';
            $html .= '<a href="' . esc_url(get_term_link($tax_term)) . '">';
            $html .= $tax_term->name;
            $html .= '</a>';
            $html .= '</li>';
        endforeach;
        $html .= '</ul>';
        $html .= '</div>';
    endif;

    echo wp_kses_post($html);
}
