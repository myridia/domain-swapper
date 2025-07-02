<?php

namespace WP\DS\Main;

class ClassAjax
{
    private $domains;
    private $siteurl;
    private $new_siteurl;
    private $new_domain;
    private $old_domain;

    public function __construct()
    {
        error_log('...swap ajax calls');

        $o = get_option(WPDS_OPTION);
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

        if (isset($o['activate'])) {
            if ($this->new_siteurl != $this->siteurl) {
                add_filter('woocommerce_cart_item_thumbnail', [$this, 'swap_woocommerce_cart_item_thumbnail'], 10, 3);
                add_filter('woocommerce_get_cart_url', [$this, 'swap_woocommerce_get_cart_url'], 10, 3);
                add_filter('woocommerce_get_checkout_url', [$this, 'swap_woocommerce_get_checkout_url'], 10, 3);
                add_filter('woocommerce_cart_item_permalink', [$this, 'swap_woocommerce_cart_item_permalink'], 10, 2);
            }
        }
    }

    public function swap_woocommerce_cart_item_permalink($permalink, $product)
    {
        $permalink = str_replace($this->siteurl, $this->new_siteurl, $permalink);

        return $permalink;
    }

    public function swap_woocommerce_get_checkout_url($url)
    {
        $url = str_replace($this->siteurl, $this->new_siteurl, $url);

        return $url;
    }

    public function swap_woocommerce_get_cart_url($url)
    {
        $url = str_replace($this->siteurl, $this->new_siteurl, $url);

        return $url;
    }

    public function swap_woocommerce_cart_item_thumbnail($thumbnail, $cart_item, $cart_item_key)
    {
        $thumbnail = str_replace($this->siteurl, $this->new_siteurl, $thumbnail);

        return $thumbnail;
    }
}
