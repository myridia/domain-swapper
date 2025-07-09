<?php

namespace WP\DS\Main;

/**
 * Class Ajax.
 *
 * Handle Ajax requests
 *
 * @since 1.0.0
 */
class ClassAjax
{
    private $domains;
    private $siteurl;
    private $new_siteurl;
    private $new_domain;
    private $old_domain;
    private $activate;

    /**
     * Init the Ajax Filter Hooks.
     *
     * If Plugin is activated and if the new_siteurl is different to the base stieurl, then init the ajax filter hooks
     *
     * @since 1.0.0
     */
    public function __construct()
    {
        error_log('...swap ajax calls');
        $this->set_domain_data();

        if ($this->activate) {
            if ($this->new_siteurl != $this->siteurl) {
                add_filter('woocommerce_cart_item_thumbnail', [$this, 'swap_woocommerce_cart_item_thumbnail'], 10, 3);
                add_filter('woocommerce_get_cart_url', [$this, 'swap_woocommerce_get_cart_url'], 10, 3);
                add_filter('woocommerce_get_checkout_url', [$this, 'swap_woocommerce_get_checkout_url'], 10, 3);
                add_filter('woocommerce_cart_item_permalink', [$this, 'swap_woocommerce_cart_item_permalink'], 10, 2);
            }
        }
    }

    /**
     * Set Urls.
     *
     * Set the new_domain and and old domain and other data
     *
     * Register and un-register the plugin. Setting Page render.
     *
     * @since 1.0.0
     */
    public function set_domain_data()
    {
        $o = get_option(WPDS_OPTION);
        if ($o['activate']) {
            $this->activate = 1;
        } else {
            $this->activate = 0;

            return;
        }

        $this->domains = $o['include'];
        $this->siteurl = get_option('siteurl');
        $this->new_siteurl = $this->siteurl;

        $this->old_domain = str_replace('https://', '', get_option('siteurl'));
        $this->old_domain = str_replace('http://', '', $this->old_domain);

        $new_domain = str_replace('https://', '', $this->new_siteurl);
        $new_domain = str_replace('http://', '', $new_domain);

        if (isset($_SERVER['HTTP_HOST'])) {
            if ('' != $_SERVER['HTTP_HOST']) {
                $new_domain = $_SERVER['HTTP_HOST'];
            }
        } elseif (isset($_SERVER['SERVER_NAME'])) {
            if ('' != $_SERVER['SERVER_NAME']) {
                $new_domain = $_SERVER['SERVER_NAME'];
            }
        }

        if (in_array($new_domain, $this->domains)) {
            $this->new_siteurl = 'https://'.$new_domain;
            $this->new_domain = $new_domain;
        }
    }

    /**
     * Overwrite filter hook woocommerce_cart_item_permalink.
     *
     * https://developer.wordpress.org/reference/hooks/hook woocommerce_cart_item_permalink
     *
     * @since 1.0.0
     *
     * @param string $permalink
     * @param object $product
     *
     * @return string $permalink
     */
    public function swap_woocommerce_cart_item_permalink($permalink, $product)
    {
        $permalink = str_replace($this->siteurl, $this->new_siteurl, $permalink);

        return $permalink;
    }

    /**
     * Overwrite filter hook woocommerce_get_checkout_url.
     *
     * https://developer.wordpress.org/reference/hooks/woocommerce_get_checkout_url
     *
     * @since 1.0.0
     *
     * @param string $url
     *
     * @return string $url
     */
    public function swap_woocommerce_get_checkout_url($url)
    {
        $url = str_replace($this->siteurl, $this->new_siteurl, $url);

        return $url;
    }

    /**
     * Overwrite filter hook woocommerce_get_cart_url.
     *
     * https://developer.wordpress.org/reference/hooks/woocommerce_get_cart_url
     *
     * @since 1.0.0
     *
     * @param string $url
     *
     * @return string $url
     */
    public function swap_woocommerce_get_cart_url($url)
    {
        $url = str_replace($this->siteurl, $this->new_siteurl, $url);

        return $url;
    }

    /**
     * Overwrite filter hook woocommerce_cart_item_thumbnail.
     *
     * https://developer.wordpress.org/reference/hooks/woocommerce_cart_item_thumbnail
     *
     * @since 1.0.0
     *
     * @param string $thumbnail
     * @param string $cart_item
     * @param string $cart_item_key
     *
     * @return string $thumbnail
     */
    public function swap_woocommerce_cart_item_thumbnail($thumbnail, $cart_item, $cart_item_key)
    {
        $thumbnail = str_replace($this->siteurl, $this->new_siteurl, $thumbnail);

        return $thumbnail;
    }
}
