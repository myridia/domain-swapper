<?php
/**
 * Theme Headep
 * DOCTYPE hook.
 *
 * @hooked best_shop_doctype
 */
do_action('best_shop_doctype');
?>
<head itemscope itemtype="https://schema.org/WebSite">
<?php
/**
 * Before wp_head.
 *
 * @hooked best_shop_head
 */
do_action('best_shop_before_wp_head');
wp_head();

?>

<style >
   .domain_swapper_example button a {
       font-weight:bold;

}
</style>
<div class="domain_swapper_example">
    <span>You are on domain:</span> <span style="color:red"><?php echo get_site_url(); ?></span><br>    
     <span>Test Domains:</span>
    <button><a title="test domain www.app.local" class="button" href="https://">www.app.local</a></button>
    <button><a title="test domain ww1.app.local" class="button" href="https://ww1.app.local">ww1.app.local</a></button>
    <button><a title="test domain ww2.app.local" class="button" href="https://ww2.app.local">ww2.app.local</a></button>
    <button><a title="test domain ww3.app.local" class="button" href="https://ww3.app.local">ww3.app.local</a></button>
    <button><a title="test domain foo.app.local" class="button" href="https://foo.app.local">foo.app.local</a></button>

    </div>

</head>

<body <?php body_class(); ?> itemscope itemtype="https://schema.org/WebPage">
<?php
wp_body_open();
/*
 * Before Header
 *
 * @hooked best_shop_page_start
 */
do_action('best_shop_before_header');

/**
 * Header.
 */
$best_shop_header_layout = best_shop_get_header_style();

// if header layout is customizer or empty, get customizer setting
if ('customizer-setting' === $best_shop_header_layout || '' === $best_shop_header_layout) {
    $best_shop_header_layout = best_shop_get_setting('header_layout');
}

// if woocommerce not installed, set layout to default
if (!class_exists('WooCommerce') && 'woocommerce-bar' === $best_shop_header_layout) {
    $best_shop_header_layout = 'default';
}

?>
<header id="masthead" class="site-header style-one 
        <?php if ('transparent-header' === $best_shop_header_layout) {
            echo esc_attr($best_shop_header_layout);
        } if ('woocommerce-bar' === $best_shop_header_layout) {
            echo esc_attr(' header-no-border ');
        }
if ('woocommerce-bar' === $best_shop_header_layout) {
    echo esc_attr(' hide-menu-cart ');
}

?>"
        itemscope itemtype="https://schema.org/WPHeader">
  <?php if (best_shop_get_setting('enable_top_bar')) { ?>
  <div class="top-bar-menu">
    <div class="container">
      <div class="left-menu">
        <?php

if ('menu' === best_shop_get_setting('top_bar_left_content')) {
    wp_nav_menu(['container_class' => 'top-bar-menu',
        'theme_location' => 'top-bar-left-menu',
        'depth' => 1,
    ]);
} elseif ('contacts' === best_shop_get_setting('top_bar_left_content')) {
    ?>
        <ul>
          <?php if ('' != best_shop_get_setting('phone_number')) { ?>
          <li><?php echo esc_html(best_shop_get_setting('phone_title')).esc_html(best_shop_get_setting('phone_number')); ?></li>
          <?php } ?>
          <?php if ('' != best_shop_get_setting('address')) { ?>
          <li><?php echo esc_html(best_shop_get_setting('address_title')).esc_html(best_shop_get_setting('address')); ?></li>
          <?php } ?>
          <?php if ('' != best_shop_get_setting('mail_description')) { ?>
          <li><?php echo esc_html(best_shop_get_setting('mail_title')).esc_html(best_shop_get_setting('mail_description')); ?></li>
          <?php } ?>
        </ul>
        <?php
} elseif ('text' === best_shop_get_setting('top_bar_left_content')) {
    ?>
        <ul>
          <li><?php echo esc_html(best_shop_get_setting('top_bar_left_text')); ?></li>
        </ul>
        <?php
}

      ?>
      </div>
      <div class="right-menu">
        <?php
      if ('menu' === best_shop_get_setting('top_bar_right_content')) {
          wp_nav_menu(['container_class' => 'top-bar-menu',
              'theme_location' => 'top-bar-right-menu',
              'depth' => 1,
          ]);
      } elseif ('social' === best_shop_get_setting('top_bar_right_content')) {
          best_shop_social_links(true);
      } elseif ('menu_social' === best_shop_get_setting('top_bar_right_content')) {
          wp_nav_menu(['container_class' => 'top-bar-menu',
              'theme_location' => 'top-bar-right-menu',
              'depth' => 1,
          ]);

          best_shop_social_links(true);
      }

      ?>
      </div>
    </div>
  </div>
  <?php } /* end top bar */ ?>
  <div class=" <?php if ('default' === best_shop_get_setting('menu_layout')) {
      echo 'main-menu-wrap';
  } else {
      echo 'burger-banner';
  } ?> ">
    <div class="container">
      <div class="header-wrapper">
        <?php
        /**
         * Site Branding.
         */
        best_shop_site_branding();
?>
        <div class="nav-wrap">
          <?php if ('default' === best_shop_get_setting('menu_layout')) { ?>
          <div class="header-left">
            <?php
    /**
     * Primary navigation.
     */
    best_shop_primary_navigation();
              ?>
          </div>
          <div class="header-right">
            <?php
              /**
               * Header Search.
               */
              best_shop_header_search();
              ?>
          </div>
          <?php } else { ?>
          <div class="banner header-right">
            <?php the_widget('WP_Widget_Media_Image', 'url='.best_shop_get_setting('header_banner_img')); ?>
          </div>
          <?php } ?>
        </div>
        <!-- #site-navigation --> 
      </div>
    </div>
  </div>
  <?php
  if ('full_width' === best_shop_get_setting('menu_layout')) {
      ?>
  
  <!--Burger header-->
  <div class="burger main-menu-wrap">
    <div class="container">
      <div class="header-wrapper">
        <div class="nav-wrap">
          <div class="header-left">
            <?php
              /**
               * Primary navigation.
               */
              best_shop_primary_navigation();
      ?>
          </div>
          <div class="header-right">
            <?php
      /**
       * Header Search.
       */
      best_shop_header_search();
      ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- #site-navigation -->
  
  <?php
  }

/*
 * Mobile navigation
 */
best_shop_mobile_navigation();

if (class_exists('WooCommerce') && 'woocommerce-bar' === $best_shop_header_layout) {
    ?>
  <div class="woocommerce-bar">
    <nav>
      <div class="container">
        <?php
        best_shop_product_category_list();
    best_shop_product_search();
    best_shop_cart_wishlist_myacc();
    ?>
      </div>
    </nav>
  </div>
  <?php

}

?>
</header>
<!-- #masthead -->

<?php

/**
 * * @hooked best_shop_primary_page_header - 10
 */
do_action('best_shop_before_posts_content');

if (best_shop_get_setting('preloader_enabled')) {
    ?>

<div class="preloader-center">
     <div class="preloader-ring"></div>
     <span>loading...</span>
</div>
<?php
}
