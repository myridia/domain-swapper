<?php

namespace WP\Ds\Main;

/**
 * Main Admin Class.
 *
 * Register and un-register the plugin. Setting Page render.
 *
 * @since 1.0.0
 */
class ClassAdmin
{
    private $options;

    public function __construct()
    {
        $this->options = [
            'include' => ['ww1.app.local', 'ww2.app.local', 'ww3.app.local', 'foo.bar.local'],
        ];
    }

    /**
     *  Default Activate.
     *
     * @since 1.0.0
     */
    public static function activate()
    {
        $options = [
            'include' => ['ww1.app.local', 'ww2.app.local', 'ww3.app.local', 'foo.bar.local'],
        ];
        if (false == get_option(WPDS_OPTION)) {
            update_option(WPDS_OPTION, $options);
        }
    }

    /**
     * Default Deacativation.
     *
     * @since 1.0.0
     */
    public static function deactivate()
    {
        delete_option(WPDS_OPTION);
    }

    /**
     * Pro Key test.
     *
     *  Generate a list of message_signed and save them to the plugin. As well save the sign_public key to the plugin.
     *  But keep the sign_secrete and the messages/serial keys secret.
     *  Let the Customer enter his key, it will be signed and the result must be in your saved list to confirm it. 
     *  https://www.php.net/manual/en/function.sodium-crypto-sign.php
     *
     * @since 1.0.0
     */
    public static function key()
    {
        $sign_pair = sodium_crypto_sign_keypair();
        $sign_secret = sodium_crypto_sign_secretkey($sign_pair);
        $sign_public = sodium_crypto_sign_publickey($sign_pair);
        $message = '675234';
        $message_signed = sodium_crypto_sign($message, $sign_secret);
        $smessage = sodium_crypto_sign_open($message_signed, $sign_public);
        // echo $smessage.'<br>';
        // echo $message_signed.'<br>';
    }

    /**
     * Add Menu Setting.
     *
     * The Menu will appear under Settings
     *
     * @since 1.0.0
     */
    public function add_menu_setting()
    {
        add_submenu_page(
            'options-general.php',
            esc_html__('Domain Swapper', 'domain_swapper'),
            esc_html__('Domain Swapper', 'domain_swapper'),
            'manage_options',
            'domain-swapper',
            [$this, 'wporg_options_page_html'],
            99
        );
    }

    /**
     * Add an API based Setting Page
     * doc: https://developer.wordpress.org/plugins/settings/custom-settings-page/.
     *
     * @since 1.0.0
     */
    public function register_settings()
    {
        register_setting(WPDS_OPTION, WPDS_OPTION, [$this, 'validate']);

        // https://developer.wordpress.org/reference/functions/add_settings_section/
        add_settings_section(
            'section1',
            __('Settings', WPDS_TEXT),
            [$this, 'callback'],
            WPDS_OPTION
        );
        // https://developer.wordpress.org/reference/functions/add_settings_field/
        add_settings_field(
            'key',
            __('Pro Key:', WPDS_TEXT),
            [$this, 'field_key'],
            WPDS_OPTION,
            'section1',
            [
                'label_for' => 'plugin_domain_swapper[key]',
            ]
        );

        add_settings_field(
            'activate',
            __('Activate:', WPDS_TEXT),
            [$this, 'field_activate'],
            WPDS_OPTION,
            'section1',
            [
                'label_for' => 'plugin_domain_swapper[activate]',
            ]
        );

        add_settings_field(
            'include',
            __('Included Domains: ', WPDS_TEXT),
            [$this, 'field_include'],
            WPDS_OPTION,
            'section1',
            [
                'label_for' => 'plugin_domain_swapper[include][]',
            ]
        );
    }

    /**
     * Check for valid Domain.
     *
     * @since 1.0.0
     *
     * @param string $domain_name
     *
     * @return bool $ok
     */
    public function is_valid_domain_name($domain_name)
    {
        $ok = preg_match("/^([a-z\d](-*[a-z\d])*)(\.([a-z\d](-*[a-z\d])*))*$/i", $domain_name) // valid chars check
                && preg_match('/^.{1,253}$/', $domain_name) // overall length check
                && preg_match("/^[^\.]{1,63}(\.[^\.]{1,63})*$/", $domain_name); // length of each label
        if ('localhost' != $domain_name) {
            if (false == strpos($domain_name, '.')) {
                $ok = false;
            }
        }

        return $ok;
    }

    /**
     * Validate input.
     *
     * @since 1.0.0
     *
     * @param string $input
     *
     * @return string $input
     */
    public function validate($input)
    {
        $newinput = $input;
        $newinput['include'] = [];
        if (isset($input['include'])) {
            if ('array' == gettype($input['include'])) {
                foreach ($input['include'] as $i) {
                    if (true == $this->is_valid_domain_name($i)) {
                        $newinput['include'][] = $i;
                    } else {
                        $newinput['include'][] = '';
                    }
                }
            }
        }

        return $newinput;
    }

    /**
     * Callback after Save Settings.
     *
     * @since 1.0.0
     */
    public function callback()
    {
        esc_html_e('Settings Saved to ', WPDS_TEXT);
    }

    /**
     * Field Activate HTML output.
     *
     * Generate a text checkbox field for the Plugin activation
     *
     * @since 1.0.0
     *
     * @param array $args {
     *                    Field array
     *
     * @var string label_for
     *             }
     *
     * @return string $input
     */
    public function field_activate($args)
    {
        $o = get_option(WPDS_OPTION);
        $checked = '';
        if (isset($o['activate'])) {
            if ('on' == $o['activate']) {
                $checked = 'checked=checked';
            }
        }
        echo "<input type='checkbox' id='key' name='{$args['label_for']}'  {$checked} />";
    }

    /**
     * Field Pro Key HTML output.
     *
     * Generate a text input field for the Plugin activation key
     *
     * @since 1.0.0
     *
     * @param array $args {
     *                    Field array
     *
     * @var string label_for
     *             }
     *
     * @return string $input
     */
    public function field_key($args)
    {
        $o = get_option(WPDS_OPTION);
        $key = '';
        if (isset($o['key'])) {
            $key = $o['key'];
        }
        echo "<input id='key' name='{$args['label_for']}' type='text' value='{$key}' />";
    }

    /**
     * Field Doomain HTML outputs.
     *
     * Generate a text input fields for the Domain names
     *
     * @since 1.0.0
     *
     * @param array $args {
     *                    Field array
     *
     * @var string label_for
     *             }
     *
     * @return string $input
     */
    public function field_include($args)
    {
        $o = get_option(WPDS_OPTION);
        if (isset($o['include'])) {
            foreach ($o['include'] as $i) {
                echo "<input id='key' name='{$args['label_for']}' type='text' value='{$i}'  /><br>";
            }
        } else {
            /* example 1 */

            for ($i = 1; $i <= 5; ++$i) {
                echo "<input id='key' name='{$args['label_for']}' type='text'  /><br>";
            }
        }
    }

    /**
     * Generate Setting Page.
     *
     * Generate a text input fields for the Domain names
     *
     * @since 1.0.0
     */
    public function wporg_options_page_html()
    {
        if (!current_user_can('manage_options')) {
            return;
        }
        if (isset($_GET['settings-updated'])) {
            add_settings_error('wporg_messages', 'wporg_message', __('Settings saved successfully to the database option settings:  '.WPDS_OPTION, WPDS_TEXT), 'updated');
        }
        settings_errors('wporg_messages');
        ?>
	<div class="wrap">
		<h1><?php echo esc_html(get_admin_page_title()); ?></h1>
		<form action="options.php" method="post">
			<?php

        settings_fields(WPDS_OPTION);
        do_settings_sections(WPDS_OPTION);
        submit_button('Save Settings');
        ?>
		</form>
	</div>
	<?php
    }
}
