<?php

namespace WP\DS\Main;

class Class02
{
    private $domains;
    private $siteurl;
    private $new_siteurl;
    private $new_domain;
    private $old_domain;

    public function __construct()
    {
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
                error_log('....start swapping');
                add_filter('option_siteurl', [$this, 'swap_siteurl']);
                add_filter('style_loader_src', [$this, 'swap_style_loader_src'], 10, 4);
                add_filter('script_loader_src', [$this, 'swap_script_loader_src'], 10, 4);
                add_filter('template_directory_uri', [$this, 'swap_template_directory_uri']);
                add_filter('get_canonical_url', [$this, 'swap_get_canonical_url'], 10, 2);
                add_filter('pre_get_shortlink', [$this, 'swap_pre_get_shortlink'], 10, 4);
                add_filter('the_content', [$this, 'swap_the_content'], 1);
                add_filter('home_url', [$this, 'swap_home_url'], 10, 4);
                add_filter('site_url', [$this, 'swap_site_url'], 10, 4);
                add_filter('wp_setup_nav_menu_item', [$this, 'swap_wp_setup_nav_menu_item']);
                add_filter('plugins_url', [$this, 'swap_plugin_url']);
                add_filter('wp_resource_hints', [$this, 'swap_prefetch_resource'], 10, 2);
                add_filter('wp_get_attachment_image_attributes', [$this, 'swap_attachment_image_attributes'], 10, 3);
                add_filter('woocommerce_gallery_image_html_attachment_image_params', [$this, 'swap_woocommerce_gallery_image_html_attachment_image_params'], 10, 4);
                // add_filter('woocommerce_get_cart_url', [$this, 'swap_woocommerce_get_cart_url'], 10, 3);
                add_filter('wp_script_attributes', [$this, 'swap_wp_script_attributes'], 10, 2);
                add_action('template_redirect', [$this, 'template_redirect']);
                add_filter('woocommerce_cart_item_thumbnail', [$this, 'swap_woocommerce_cart_item_thumbnail'], 10, 3);
            }
        }
    }

    public function swap_woocommerce_cart_item_thumbnail($thumbnail, $cart_item, $cart_item_key)
    {
        $thumbnail = str_replace($this->siteurl, $this->new_siteurl, $thumbnail);

        return $thumbnail;
    }

    public function template_redirect()
    {
        ob_start(function ($html) {
            $html = str_replace($this->siteurl, $this->new_siteurl, $html);
            $html = str_replace($this->old_domain, $this->new_domain, $html);

            return $html;
        });
    }

    public function swap_wp_script_attributes(array $attr)
    {
        $attr['src'] = str_replace($this->siteurl, $this->new_siteurl, $attr['src']);

        return $attr;
    }

    public function swap_woocommerce_gallery_image_html_attachment_image_params($params, $attachment_id, $post_id, $image_class)
    {
        // https://developer.wordpress.org/reference/hooks/swap_woocommerce_gallery_image_html_attachment_image_params
        $params['data-src'] = str_replace($this->siteurl, $this->new_siteurl, $params['data-src']);
        $params['data-large_image'] = str_replace($this->siteurl, $this->new_siteurl, $params['data-large_image']);

        return $params;
    }

    public function swap_attachment_image_attributes($attr, $attachment, $size)
    {
        // https://developer.wordpress.org/reference/hooks/attachment_image_attributes
        $attr['srcset'] = str_replace($this->siteurl, $this->new_siteurl, $attr['srcset']);
        $attr['src'] = str_replace($this->siteurl, $this->new_siteurl, $attr['src']);

        return $attr;
    }

    public function swap_prefetch_resource($urls, $relation_type)
    {
        // https://developer.wordpress.org/reference/hooks/prefetch_resource
        if ('prefetch' === $relation_type) {
            foreach ($urls as $k => $v) {
                $urls[$k]['href'] = str_replace($this->siteurl, $this->new_siteurl, $v['href']);
                // error_log($v['href']);
            }
        }

        return $urls;
    }

    public function swap_style_loader_src($url)
    {
        $new_url = $url;
        $src_parse = parse_url($url);
        if (isset($src_parse['host']) && isset($src_parse['scheme'])) {
            $host = $src_parse['scheme'].'://'.$src_parse['host'];

            if (isset($src_parse['port'])) {
                $host = $host.':'.$src_parse['port'];
            }

            if ($host == $this->siteurl) {
                $new_url = str_replace($this->siteurl, $this->new_siteurl, $url);
            }
        }
        $new_url = str_replace('http://', 'https://', $new_url);
        $new_url = str_replace($this->siteurl, $this->new_siteurl, $new_url);

        // error_log($new_url);

        return $new_url;
    }

    public function swap_script_loader_src($url)
    {
        $new_url = $url;
        $src_parse = parse_url($url);
        if (isset($src_parse['host'])) {
            $host = $src_parse['scheme'].'://'.$src_parse['host'];

            if (isset($src_parse['port'])) {
                $host = $host.':'.$src_parse['port'];
            }

            if ($host == $this->siteurl) {
                $new_url = str_replace($this->siteurl, $this->new_siteurl, $url);
            }
        }
        $new_url = str_replace('http://', 'https://', $new_url);
        $new_url = str_replace($this->siteurl, $this->new_siteurl, $new_url);

        return $new_url;
    }

    public function swap_do_shortcode_tag($output, $tag, $attr, $m)
    {
        return $output;
    }

    public function swap_plugin_url($url)
    {
        // https://developer.wordpress.org/reference/hooks/plugin_url
        $url = str_replace($this->siteurl, $this->new_siteurl, $url);

        return $url;
    }

    public function swap_wp_setup_nav_menu_item($menu_item)
    {
        // https://developer.wordpress.org/reference/hooks/wp_setup_nav_menu_item
        $menu_item->url = str_replace($this->siteurl, $this->new_siteurl, $menu_item->url);

        return $menu_item;
    }

    public function swap_site_url($url, $path, $orig_scheme, $blog_id)
    {
        // https://developer.wordpress.org/reference/hooks/swap_site_url/
        if ($this->siteurl == $url) {
        } else {
            $url = str_replace('http://', 'https://', $url);
        }

        return $url;
    }

    public function swap_home_url($url, $path, $orig_scheme, $blog_id)
    {
        // https://developer.wordpress.org/reference/hooks/home_url/
        if ($this->siteurl == $url) {
        } else {
            $url = str_replace($this->siteurl, $this->new_siteurl, $url);
        }

        return $url;
    }

    public function swap_the_content($content)
    {
        /* https://developer.wordpress.org/reference/hooks/the_content/
          changed /category url
         */
        if (is_singular() && in_the_loop() && is_main_query()) {
            $new_content = str_replace($this->siteurl, $this->new_siteurl, $content);

            return $new_content;
        }

        return $content;
    }

    public function swap_pre_get_shortlink($shortlink, $id, $context, $allow_slugs)
    {
        // https://developer.wordpress.org/reference/hooks/pre_get_shortlink/
        if (0 == strlen($shortlink) && '' != $this->new_siteurl) {
            $shortlink = $this->new_siteurl;
        } elseif ('' != $this->new_siteurl) {
            $shortlink = str_replace($this->siteurl, $this->new_siteurl, $shortlink);
        }

        return $shortlink;
    }

    public function swap_get_canonical_url($url, $post)
    {
        // https://developer.wordpress.org/reference/hooks/get_canonical_url/
        // error_log($url);
        $url = str_replace($this->siteurl, $this->new_siteurl, $url);

        return $url;
    }

    public function swap_template_directory_uri($url)
    {
        // https://developer.wordpress.org/reference/hooks/template_directory_uri/
        $url = str_replace($this->siteurl, $this->new_siteurl, $url);

        return $url;
    }

    public function swap_siteurl($url)
    {
        if ('' != $this->new_siteurl) {
            if (!defined('WPDS_CUSTOM_REQUEST_URL')) {
                define('WPDS_CUSTOM_REQUEST_URL', $this->new_siteurl);
            }

            if (!defined('WP_SITEURL')) {
                define('WP_SITEURL', $this->new_siteurl);
            }

            $url = $this->new_siteurl;
        }
        // error_log($url);

        return $url;
    }

    public function swap_feed_link($output, $feed)
    {
        // error_log($output);

        return $output;
    }

    public function swap_default_scripts_domain($scripts)
    {
        return $scripts;
    }

    public function swap_wo_asset_url($url, $path)
    {
        $new_url = str_replace($this->siteurl, $this->new_siteurl, $url);

        return $new_url;
    }

    public function swap_rest_route_for_post($route, $post)
    {
        return $route;
    }

    public function swap_rest_url($url, $path, $blog_id, $scheme)
    {
        $new_url = str_replace($this->siteurl, $this->new_siteurl, $url);

        // $new_url = str_replace($this->siteurl, 'https://th.shock.se', $url);
        /*
        error_log($this->siteurl);
        error_log($this->new_siteurl);
        error_log($url);
        error_log($new_url);
        error_log('xxxxxxxxxxxxxxxxxxxxxx');
        */
        return $new_url;
    }

    public function update_url_to_https($url)
    {
        return str_replace('http://', 'https://', $url);
    }

    public function swap_start_relative_url()
    {
        ob_start([$this, 'swap_relative_url']);
    }

    public function swap_end_relative_url()
    {
        @ob_end_flush();
    }

    public function swap_relative_url($buffer)
    {
        $url = esc_url(home_url('/'));
        $url_relative = wp_make_link_relative($url);

        $url_escaped = str_replace('/', '\/', $url);
        $url_escaped_relative = str_replace('/', '\/', $url_relative);

        $buffer = str_replace($url, $url_relative, $buffer);
        $buffer = str_replace($url_escaped, $url_escaped_relative, $buffer);

        return $buffer;
    }

    public function swap_attachment_url($url)
    {
        $var = explode('/wp-content', $url);

        $new_url = str_replace($var[0], $this->new_siteurl, $url);

        return $new_url;
    }

    public function swap_featured_img_url($url)
    {
        $new_url = str_replace($this->siteurl, $this->new_siteurl, $url);

        return $new_url;
    }

    public function swap_style_uri($url)
    {
        $new_url = $this->swap_content_url($url);

        return $new_url;
    }
}
