<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @since      1.0.0
 *
 * @package    Woocommerce_Product_Tabs
 */

/**
 * The public-facing functionality of the plugin.
 *
 * @package    Woocommerce_Product_Tabs
 */
class Woocommerce_Product_Tabs_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @var      string    $plugin_name       The name of the plugin.
	 * @var      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		if ( $this->enable_the_content_filter() ) {
			add_filter( 'wpt_use_the_content_filter', '__return_false' );
			add_filter( 'wpt_filter_tab_content', array( $this, 'product_tabs_filter_content' ), 10, 1 );
		}
	}

	public function custom_woocommerce_product_tabs( $tabs ){
		global $product;

		$this->product_tabs_list = get_posts(
			array(
				'post_type'      => WOOCOMMERCE_PRODUCT_TABS_POST_TYPE_TAB,
				'posts_per_page' => -1,
				'orderby'        => 'menu_order',
				'order'          => 'asc',
				)
			);
		if ( ! empty( $this->product_tabs_list ) ) {
			foreach ($this->product_tabs_list as $key => $t) {
				$this->product_tabs_list[$key]->post_meta = get_post_meta($this->product_tabs_list[$key]->ID);
			}
		}

		if ( empty( $this->product_tabs_list ) ) {
			return $tabs;
		}

		$wpt_tabs = array();
		foreach ($this->product_tabs_list as $key => $prd) {

			$wpt_tabs[$key]['id'] = $prd->post_name;
			$wpt_tabs[$key]['title'] = esc_attr( $prd->post_title );
      $wpt_tabs[$key]['priority'] = esc_attr( $prd->menu_order );
      $wpt_tabs[$key]['conditions_category'] = get_post_meta( $prd->ID, '_wpt_conditions_category', true );
			$wpt_tabs[$key]['use_default_for_all'] = esc_attr( get_post_meta( $prd->ID, '_wpt_option_use_default_for_all', true ) );

		}

    $wpt_tabs = apply_filters( 'wpt_filter_product_tabs', $wpt_tabs );

		if ( ! empty( $wpt_tabs ) ) {

			foreach ($wpt_tabs as $key => $tab) {

				$tab_temp             = array();
				$tab_temp['title']    = $tab['title'];
				$tab_temp['priority'] = $tab['priority'];
				$tab_temp['callback'] = array( $this, 'wpt_callback' );
				$tabs[$tab['id']]     = $tab_temp;
			}

		}

		return $tabs;

	}

  public function tab_status_check( $tabs ){

    global $product;

    if ( ! empty( $tabs ) && is_array( $tabs ) ) {

      foreach ($tabs as $tab_key => $tab) {
        $key = $tab['id'];

        $tab_post = get_page_by_path( $key, OBJECT, WOOCOMMERCE_PRODUCT_TABS_POST_TYPE_TAB );

        if ( ! empty( $tab_post ) ) {
          //
          $tab_default_value = $tab_post->post_content ;

          $content_to_show = $tab_default_value;

          if ( 'yes' != $tab['use_default_for_all'] ) {
            $tab_value = get_post_meta( $product->get_id(), '_wpt_field_'.$key, true );
            if ( ! empty( $tab_value ) ) {
              $content_to_show = $tab_value;
            }
          }

          if ( empty( $content_to_show ) ) {
            unset( $tabs[ $tab_key ] );
          }

          if ( ! empty( $tab['conditions_category'] ) && isset( $tabs[ $tab_key ] ) ) {
            // check category condition
            $cat_list = wp_get_post_terms( $product->get_id(), 'product_cat', array( 'fields' => 'ids' ) );

            if ( ! array_intersect( $cat_list, $tab['conditions_category'] ) ) {
              unset( $tabs[ $tab_key ] );
            }

          }
        }

      } // end foreach

    }
    return $tabs;

  }

	public function wpt_callback( $key, $tab ){

		global $product;

		$tab_post = get_page_by_path( $key, OBJECT, WOOCOMMERCE_PRODUCT_TABS_POST_TYPE_TAB );
		if (empty($tab_post)) {
			return;
		}
		$flag_wpt_option_use_default_for_all = get_post_meta( $tab_post->ID, '_wpt_option_use_default_for_all', true );
		if ( 'yes' == $flag_wpt_option_use_default_for_all ) {
			// Default content for all
			echo $this->get_filter_content( $tab_post->post_content );
		}
		else{
			// no default
			$tab_value = get_post_meta( $product->get_id(), '_wpt_field_'.$key, true );
			if ( ! empty( $tab_value ) ) {
				// Value is set for Product
				echo $this->get_filter_content( $tab_value );
			}
			else{
				// Value is empty; show default
				echo $this->get_filter_content( $tab_post->post_content );

			}

		}
		return;

	}

	public function custom_post_types(){

		$labels = array(
				'name'               => _x( 'Tabs', 'post type general name', 'woocommerce-product-tabs' ),
				'singular_name'      => _x( 'Tab', 'post type singular name', 'woocommerce-product-tabs' ),
				'menu_name'          => _x( 'WooCommerce Product Tabs', 'admin menu', 'woocommerce-product-tabs' ),
				'name_admin_bar'     => _x( 'Tab', 'add new on admin bar', 'woocommerce-product-tabs' ),
				'add_new'            => _x( 'Add New', WOOCOMMERCE_PRODUCT_TABS_POST_TYPE_TAB, 'woocommerce-product-tabs' ),
				'add_new_item'       => __( 'Add New Tab', 'woocommerce-product-tabs' ),
				'new_item'           => __( 'New Tab', 'woocommerce-product-tabs' ),
				'edit_item'          => __( 'Edit Tab', 'woocommerce-product-tabs' ),
				'view_item'          => __( 'View Tab', 'woocommerce-product-tabs' ),
				'all_items'          => __( 'Product Tabs', 'woocommerce-product-tabs' ),
				'search_items'       => __( 'Search Tabs', 'woocommerce-product-tabs' ),
				'parent_item_colon'  => __( 'Parent Tabs:', 'woocommerce-product-tabs' ),
				'not_found'          => __( 'No tabs found.', 'woocommerce-product-tabs' ),
				'not_found_in_trash' => __( 'No tabs found in Trash.', 'woocommerce-product-tabs' )
			);

			$args = array(
				'labels'             => $labels,
				'public'             => false,
				'publicly_queryable' => false,
				'show_ui'            => true,
				'show_in_menu'       => true,
				'query_var'          => false,
				'capability_type'    => 'post',
				'has_archive'        => false,
				'hierarchical'       => false,
				'menu_icon'          => 'dashicons-admin-site-alt3',
				'menu_position'      => 58,
				'supports'           => array( 'title', 'editor' )
			);

			register_post_type( WOOCOMMERCE_PRODUCT_TABS_POST_TYPE_TAB, $args );


	}

	/**
	 * Filter the tab content.
	 *
	 * @since 2.0.2
	 *
	 * @param string $content Content for the current tab.
	 * @return string Tab content.
	 */
	public function product_tabs_filter_content( $content ){
		$content = function_exists( 'capital_P_dangit' ) ? capital_P_dangit( $content ) : $content;
		$content = function_exists( 'wptexturize' ) ? wptexturize( $content ) : $content;
		$content = function_exists( 'convert_smilies' ) ? convert_smilies( $content ) : $content;
		$content = function_exists( 'wpautop' ) ? wpautop( $content ) : $content;
		$content = function_exists( 'shortcode_unautop' ) ? shortcode_unautop( $content ) : $content;
		$content = function_exists( 'prepend_attachment' ) ? prepend_attachment( $content ) : $content;
		$content = function_exists( 'wp_filter_content_tags' ) ? wp_filter_content_tags( $content ) : $content;
		$content = function_exists( 'do_shortcode' ) ? do_shortcode( $content ) : $content;

		if ( class_exists( 'WP_Embed' ) ) {
			$embed = new WP_Embed;
			$content = method_exists( $embed, 'autoembed' ) ? $embed->autoembed( $content ) : $content;
		}

		return $content;
	}

	/**
	 * Get filter for the content.
	 *
	 * @since 2.0.2
	 *
	 * @param string $content Content to apply filter.
	 * @return string $content Tab content.
	 */
	public function get_filter_content( $content ){
		$use_the_content_filter = apply_filters( 'wpt_use_the_content_filter', true );

		if ( $use_the_content_filter === true ) {
			$content = apply_filters( 'the_content', $content );
		} else {
			$content = apply_filters( 'wpt_filter_tab_content', $content );
		}
		return $content;
	}

	/**
	 * Check to enable custom filter for the content.
	 *
	 * @since 2.0.2
	 */
	public function enable_the_content_filter() {
		$disable_the_content_filter = get_option( 'wpt_disable_content_filter' );
		$output = false;

		if ( empty( $disable_the_content_filter ) ){
			$disable_the_content_filter = 'no';
		}

		if ( 'yes' === $disable_the_content_filter ){
			$output = true;
		}

		return $output;
	}

}
