<?php

class Product_Share_Admin_Settings{
	
	protected static $_instance = null;

    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public function __construct(){
        add_action( 'admin_menu', array( __CLASS__, 'product_share_submenu' ), 99 );
        add_action( 'admin_init', array( __CLASS__, 'register_psfw_setting' ) );
        add_action( 'admin_enqueue_scripts', array( __CLASS__, 'admin_assets' ) );
        // Tab Sections
        add_action('psfw_setting_tab_content', array( __CLASS__, 'tab_contents' ), 10, 2);
        // Settings Link
        add_filter( 'plugin_action_links_'. plugin_basename( PRODUCT_SHARE_PLUGIN_FILE ), array( $this, 'settings_link') );
        // Plugin row meta link
        add_filter( 'plugin_row_meta', array( $this, 'plugin_row_meta' ), 10, 4 );
        // Clear Settings
        add_action('psfw_layout_start', array( $this, 'reset_setting' ) );

        // Upate option
        add_action('admin_init', array( $this, 'upate_option' ) );
    }

    public static function product_share_submenu( ){

    	add_submenu_page('wpxtension', 'Social Share', 'Social Share', 'manage_options', 'product-share', array( __CLASS__, 'menu_page' ) );
    }

    public static function menu_page(){
        if ( is_file( plugin_dir_path( PRODUCT_SHARE_PLUGIN_FILE ) . 'includes/wpxtension/wpx-sidebar.php' ) ) {
            include_once plugin_dir_path( PRODUCT_SHARE_PLUGIN_FILE ) . 'includes/wpxtension/wpx-sidebar.php';
        }
        if ( is_file( plugin_dir_path( PRODUCT_SHARE_PLUGIN_FILE ) . 'includes/layout.php' ) ) {
            include_once plugin_dir_path( PRODUCT_SHARE_PLUGIN_FILE ) . 'includes/layout.php';
        }
    }

    public static function get_setting(){
    	return get_option( 'product_share_option' );
    }

    public static function tab_contents( $plugin_name, $curTab ){

        if( 'product-share' !==  $plugin_name ){
            return;
        }

        if( 'advanced' === $curTab ){
            settings_fields( 'product-share-group_adavanced' );
            do_settings_sections( 'product-share-group_adavanced' );
            require_once dirname( __FILE__ ) . '/setting-tab/advanced.php';
        }
        if( '' === $curTab || null === $curTab ){
            settings_fields( 'product-share-group' );
            do_settings_sections( 'product-share-group' );
            require_once dirname( __FILE__ ) . '/setting-tab/general.php';
        }
    }

    public static function register_psfw_setting(){
    	register_setting( 'product-share-group', 'product_share_option' );
        register_setting( 'product-share-group_adavanced', 'product_share_option_advanced' );
        register_setting( 'product-share-group_license', 'product_share_license' );
    }

    public static function admin_assets() {

        // @Note: Checking if `SCRIPT_DEBUG` is defined and `true`
        $suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

        if ( isset( $_GET['page'] ) && ! empty( $_GET['page'] ) && 'product-share' === $_GET['page'] ) {
            
            // Style Start
            wp_enqueue_style('psfw-admin', plugins_url('admin/css/backend.css', PRODUCT_SHARE_PLUGIN_FILE), array(), product_share()->version(), 'all');
            wp_style_add_data( 'psfw-admin', 'rtl', 'replace' );

            wp_enqueue_style('wpxtension-admin', plugins_url('includes/wpxtension/wpxtension-admin'. $suffix .'.css', PRODUCT_SHARE_PLUGIN_FILE), array(), product_share()->version(), 'all');
            wp_style_add_data( 'wpxtension-admin', 'rtl', 'replace' );

            wp_enqueue_style('psfw-fontawesome-6.1.1', plugins_url('fonts/fontawesome/css/all.css', PRODUCT_SHARE_PLUGIN_FILE), array(), product_share()->version(), 'all');
            wp_enqueue_style( 'wp-color-picker' ); 

            // Scripts Start

            wp_enqueue_script('jquery-ui-sortable');
            wp_enqueue_script('psfw-admin', plugins_url('admin/js/backend.js', PRODUCT_SHARE_PLUGIN_FILE), array('jquery','wp-color-picker'), product_share()->version(), true);
        }
    }

    public function settings_link($links) { 
        // Build and escape the URL.
        $url = esc_url( add_query_arg(
            'page',
            'product-share',
            get_admin_url() . 'admin.php'
        ) );
        // Create the link.
        $settings_link = "<a href='$url'>" . __( 'Settings', 'product-share' ) . '</a>';
        
        // Adds the link to the begining of the array.
        array_unshift( $links, $settings_link );

        if( !Product_Share::check_plugin_state('product-share-pro') ){
            $pro_link = "<a style='font-weight: bold; color: #8012f9;' href='https://wpxtension.com/product/social-share-for-woocommerce/' target='_blank'>" . __( 'Go Premium' ) . '</a>';
            array_push( $links, $pro_link );
        }
        return $links; 
    }

    /**
    * ====================================================
    * Plugin row link for plugin listing page
    * ====================================================
    **/

    public function plugin_row_meta( $plugin_meta, $plugin_file, $plugin_data, $status ) {

        if ( strpos( $plugin_file, 'product-share.php' ) !== false ) {

            $new_links = array(
                'ticket' => '<a href="https://wpxtension.com/submit-a-ticket/" target="_blank" style="font-weight: bold; color: #8012f9;">Help & Support</a>',
                'doc' => '<a href="https://wpxtension.com/doc-category/social-share-for-woocommerce/" target="_blank">Documentation</a>'
            );
             
            $plugin_meta = array_merge( $plugin_meta, $new_links );

        }
         
        return $plugin_meta;
    }

    /**
    * ====================================================
    * Reset Conditions for settings
    * ====================================================
    **/
    public function reset_setting(){

        // Condition starts from here

        if( isset( $_GET['action'] ) && 'reset' === $_GET['action'] ){

            //In our file that handles the request, verify the nonce.
            $nonce = $_REQUEST['_wpnonce'];
            if ( ! wp_verify_nonce( $nonce, 'psfw-settings' ) ) {
                die( __( 'Security check', 'product-share' ) ); 
            } else {
                
                if( isset( $_GET['tab'] ) && 'advanced' === $_GET['tab'] ){
                    delete_option('product_share_option_advanced');
                    wp_safe_redirect( admin_url( 'admin.php?page=product-share&tab=' . $_GET['tab'] ) );
                    exit();
                }
                elseif( isset( $_GET['tab'] ) && 'license' === $_GET['tab'] ){
                    delete_option('product_share_license');
                    wp_safe_redirect( admin_url( 'admin.php?page=product-share&tab=' . $_GET['tab'] ) );
                    exit();
                }
                else{
                    delete_option('product_share_option');
                    wp_safe_redirect( admin_url( 'admin.php?page=product-share' ) );
                    exit();
                }

            }

        }
        
    }


    /**
    * ====================================================
    * Update Option value 1 to `yes` and 0 to `no`
    * ====================================================
    **/

    public function upate_option(){

        $get_option = get_option('product_share_option');
        // print_r(get_option('product_share_option'));

        if(  !empty( $get_option['copy_to_clipboard'] ) && $get_option['copy_to_clipboard'] == 1 ){
            $get_option['copy_to_clipboard'] = "yes";
            update_option('product_share_option', $get_option);
        }

        
        if( !empty( $get_option['float_icon'] ) && $get_option['float_icon'] == 1 ){
            $get_option['float_icon'] = "yes";
            update_option('product_share_option', $get_option);
        }
    }

}