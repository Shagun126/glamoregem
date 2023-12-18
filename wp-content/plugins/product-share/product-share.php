<?php
/**
 * Plugin Name: Social Share for WooCommerce
 * Plugin URI: https://wordpress.org/product-share
 * Description: Display social icons on the different spots of product pages to share your WooCommerce product on social media.
 * Author: WPXtension
 * Version: 1.2.7
 * Domain Path: /languages
 * Requires at least: 5.5
 * Tested up to: 6.4
 * Requires PHP: 7.3
 * WC requires at least: 5.5
 * WC tested up to: 8.2.2
 * Text Domain: product-share
 * Author URI: https://wpxtension.com
 */

defined( 'ABSPATH' ) or die( 'Keep Silent' );

if ( ! defined( 'PRODUCT_SHARE_PLUGIN_FILE' ) ) {
    define( 'PRODUCT_SHARE_PLUGIN_FILE', __FILE__ );
}

// Include the main class.
if ( ! class_exists( 'Product_Share', false ) ) {
    require_once dirname( __FILE__ ) . '/includes/class-product-share.php';
}

// Require woocommerce admin message
function product_share_wc_requirement_notice() {

    if ( ! class_exists( 'WooCommerce' ) ) {
        $text    = esc_html__( 'WooCommerce', 'product-share' );
        $link    = esc_url( add_query_arg( array(
            'tab'       => 'plugin-information',
            'plugin'    => 'woocommerce',
            'TB_iframe' => 'true',
            'width'     => '640',
            'height'    => '500',
        ), admin_url( 'plugin-install.php' ) ) );
        $message = wp_kses( __( "<strong>Social Share for WooCommerce</strong> is an add-on of ", 'product-share' ), array( 'strong' => array() ) );

        printf( '<div class="%1$s"><p>%2$s <a class="thickbox open-plugin-details-modal" href="%3$s"><strong>%4$s</strong></a></p></div>', 'notice notice-error', $message, $link, $text );
    }
}

add_action( 'admin_notices', 'product_share_wc_requirement_notice' );


/**
 * Returns the main instance.
 */

function product_share() { // phpcs:ignore WordPress.NamingConventions.ValidFunctionName.FunctionNameInvalid

    if ( ! class_exists( 'WooCommerce', false ) ) {
        return false;
    }

    if ( function_exists( 'product_share_pro' ) ) {
        return product_share_pro();
    }

    return Product_Share::instance();
}

add_action( 'plugins_loaded', 'product_share' );

// HPOS compatibility for Product Share
function product_share_hpos_compatibility() {
    if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
        \Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', __FILE__, true );
    }
}

add_action( 'before_woocommerce_init', 'product_share_hpos_compatibility' );