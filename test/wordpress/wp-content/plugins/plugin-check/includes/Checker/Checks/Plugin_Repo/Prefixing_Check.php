<?php
/**
 * Class Prefixing_Check.
 *
 * @package plugin-check
 */

namespace WordPress\Plugin_Check\Checker\Checks\Plugin_Repo;

use WordPress\Plugin_Check\Checker\Check_Categories;
use WordPress\Plugin_Check\Checker\Check_Result;
use WordPress\Plugin_Check\Checker\Checks\Abstract_PHP_CodeSniffer_Check;
use WordPress\Plugin_Check\Traits\Amend_Check_Result;
use WordPress\Plugin_Check\Traits\Prefix_Utils;
use WordPress\Plugin_Check\Traits\Stable_Check;

/**
 * Check for prefixing.
 *
 * @since 1.7.0
 */
class Prefixing_Check extends Abstract_PHP_CodeSniffer_Check {

	use Amend_Check_Result;
	use Prefix_Utils;
	use Stable_Check;

	/**
	 * Gets the categories for the check.
	 *
	 * Every check must have at least one category.
	 *
	 * @since 1.7.0
	 *
	 * @return array The categories for the check.
	 */
	public function get_categories() {
		return array( Check_Categories::CATEGORY_PLUGIN_REPO );
	}

	/**
	 * Returns an associative array of arguments to pass to PHPCS.
	 *
	 * @since 1.7.0
	 *
	 * @param Check_Result $result The check result to amend, including the plugin context to check.
	 * @return array An associative array of PHPCS CLI arguments.
	 */
	protected function get_args( Check_Result $result ) {
		$args = array(
			'extensions' => 'php',
			'standard'   => 'WordPress',
			'sniffs'     => 'WordPress.NamingConventions.PrefixAllGlobals',
		);

		$prefixes = $this->get_potential_prefixes( $result );

		if ( ! empty( $prefixes ) ) {
			$args['runtime-set'] = array(
				'prefixes' => implode( ',', $prefixes ),
			);
		}

		return $args;
	}

	/**
	 * Gets the description for the check.
	 *
	 * Every check must have a short description explaining what the check does.
	 *
	 * @since 1.7.0
	 *
	 * @return string Description.
	 */
	public function get_description(): string {
		return __( 'Checks plugin for unique prefixing for everything the plugin defines in the public namespace.', 'plugin-check' );
	}

	/**
	 * Gets the documentation URL for the check.
	 *
	 * Every check must have a URL with further information about the check.
	 *
	 * @since 1.7.0
	 *
	 * @return string The documentation URL.
	 */
	public function get_documentation_url(): string {
		return __( 'https://make.wordpress.org/plugins/handbook/performing-reviews/review-checklist/#code', 'plugin-check' );
	}
}
