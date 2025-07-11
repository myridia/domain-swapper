<?php

namespace Automattic\WooCommerce\Blocks\BlockTypes;

/**
 * CheckoutOrderSummaryBlock class.
 */
class CheckoutOrderSummaryBlock extends AbstractInnerBlock
{
    /**
     * Block name.
     *
     * @var string
     */
    protected $block_name = 'checkout-order-summary-block';

    /**
     * Get the contents of the given inner block.
     *
     * @param string $block_name name of the order summary inner block
     * @param string $content    the content to search
     *
     * @return array|bool
     */
    private function get_inner_block_content($block_name, $content)
    {
        if (preg_match($this->inner_block_regex($block_name), $content, $matches)) {
            return $matches[0];
        }

        return false;
    }

    /**
     * Get the regex that will return an inner block.
     *
     * @param string $block_name name of the order summary inner block
     *
     * @return string regex pattern
     */
    private function inner_block_regex($block_name)
    {
        return '/<div data-block-name="woocommerce\/checkout-order-summary-'.$block_name.'-block"(.+?)>(.*?)<\/div>/si';
    }

    /**
     * Render the Checkout Order Summary block.
     *
     * @param array  $attributes block attributes
     * @param string $content    block content
     * @param object $block      block object
     *
     * @return string rendered block
     */
    protected function render($attributes, $content, $block)
    {
        // The order-summary-totals block was introduced as a new parent block for the totals
        // (subtotal, discount, fees, shipping and taxes) blocks.
        $regex_for_checkout_order_summary_totals = '/<div data-block-name="woocommerce\/checkout-order-summary-totals-block"(.+?)>/';
        $order_summary_totals_content = '<div data-block-name="woocommerce/checkout-order-summary-totals-block" class="wp-block-woocommerce-checkout-order-summary-totals-block">';

        // We want to move these blocks inside a parent 'totals' block.
        $totals_inner_blocks = ['subtotal', 'discount', 'fee', 'shipping', 'taxes'];

        if (preg_match($regex_for_checkout_order_summary_totals, $content)) {
            return $content;
        }

        foreach ($totals_inner_blocks as $key => $block_name) {
            $inner_block_content = $this->get_inner_block_content($block_name, $content);

            if ($inner_block_content) {
                $order_summary_totals_content .= "\n".$inner_block_content;

                // The last block is replaced with the totals block.
                if (count($totals_inner_blocks) - 1 === $key) {
                    $order_summary_totals_content .= '</div>';
                    $content = preg_replace($this->inner_block_regex($block_name), $order_summary_totals_content, $content);
                } else {
                    // Otherwise, remove the block.
                    $content = preg_replace($this->inner_block_regex($block_name), '', $content);
                }
            }
        }

        // Remove empty lines.

        return preg_replace('/\n\n( *?)/i', '', $content);
    }
}
