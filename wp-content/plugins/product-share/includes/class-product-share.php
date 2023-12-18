<?php 

defined( 'ABSPATH' ) or die( 'Keep Quit' );

class Product_Share{

    /*
     * Version of Plugin.
     *
     */

    protected $_plugin = 'product-share';
    
    protected $_version = '1.2.7';

    protected static $_instance = null;


    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }


    /*
     * Construct of the Class.
     *
     */

    public function __construct(){

        $this->includes();
        $this->init();
        $this->get_wpx_menu();
        $this->get_wpx_setting_fields();

    }


    /*
     * Version function.
     *
     */
    public function version() {
        return esc_attr( $this->_version );
    }

    /*
     * Name function.
     *
     */
    public function plugin() {
        return esc_attr( $this->_plugin.'-pro' );
    }

    /*
     * Bootstraps the class and hooks required actions & filters.
     *
     */
    public function init() {

        // Load TextDomain
        add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) );
        // Disable Field for Pro Feature
        // add_filter('psfw_need_pro', array( $this, 'disable_for_pro' ), 10, 2 );

        $this->get_backend();
        $this->get_frontend();
    } 


    /**
     *
     * Load Text Domain Folder
     *
     */
    public function load_textdomain() {
        load_plugin_textdomain( "product-share", false, basename( dirname( PRODUCT_SHARE_PLUGIN_FILE ) )."/languages" );
    }

    /*
     * Includes files.
     *
     */

    public function includes() {
        require_once dirname( __FILE__ ) . '/wpxtension/wpx-menu.php';
        require_once dirname( __FILE__ ) . '/wpxtension/wpx-setting-fields.php';
        require_once dirname( __FILE__ ) . '/class-product-share-admin-settings.php';
        require_once dirname( __FILE__ ) . '/class-product-share-front.php';
    }

    /**
     *
     * WPX Menu
     *
     */

    public function get_wpx_menu(){
        return WPXtension_Menu::instance();
    }


    /**
     *
     * WPX Setting Fields
     *
     */

    public function get_wpx_setting_fields(){
        return new WPXtension_Setting_Fields(self::check_plugin_state($this->plugin()));
    }

    /**
     *
     * Admin Settings
     *
     */

    public function get_backend(){
        return Product_Share_Admin_Settings::instance();
    }


    /**
     *
     * Frontend 
     *
     */

    public function get_frontend(){
        return Product_Share_Front::instance();
    }


    /**
     *
     * Return all options of Product Share Plugin
     *
     */
    public static function get_options(){

        $get_option = array_merge( (array) get_option('product_share_option'), (array) get_option('product_share_option_advanced') );

        $options = array(

            'display_position' => ( !empty( $get_option['display_position'] ) ) ? $get_option['display_position'] : 'with_category',

            'selected_lables' => ( !empty( $get_option['buttons'] ) ) ? $get_option['buttons'] : apply_filters('selected_lables',array(
                    'facebook' => 'Facebook',
                    'twitter' => 'Twitter',
                    'linkedin' => 'LinkedIn'
                )
            ),

            'labels' => ( !empty( $get_option['all_buttons'] ) ) ? $get_option['all_buttons'] : apply_filters('psfw_labels', array(
                    'facebook' => 'Facebook',
                    'twitter' => 'Twitter',
                    'linkedin' => 'LinkedIn'
                )),

            'icon_appearance' => ( !empty( $get_option['icon_appearance'] ) ) ? $get_option['icon_appearance'] : 'only_icon',

            'button_shape' => ( !empty( $get_option['button_shape'] ) ) ? $get_option['button_shape'] : 'round',

            'copy_to_clipboard' => ( empty( $get_option['copy_to_clipboard'] ) ) ? 'no' : $get_option['copy_to_clipboard'],

            'all_icon' => ( empty( $get_option['all_icon'] ) ) ? 'no' : $get_option['all_icon'],


            'icon_title' => ( empty( $get_option['icon_title'] ) ) ? 'no' : $get_option['icon_title'],

            'encode_url' => ( empty( $get_option['encode_url'] ) ) ? 'no' : $get_option['encode_url'],

            'tooltip' => ( empty( $get_option['tooltip'] ) ) ? 'no' : $get_option['tooltip'],

            'variation_link' => ( empty( $get_option['variation_link'] ) ) ? 'no' : $get_option['variation_link'],


            // ### Advanced Settings
            

            // Tooltip Settings

            'tooltip_color' => ( empty( $get_option['tooltip_color'] ) ) ? '#ffffff' : $get_option['tooltip_color'],

            'tooltip_bg_color' => ( empty( $get_option['tooltip_bg_color'] ) ) ? '#000000' : $get_option['tooltip_bg_color'],


            // Title Settings

            'title_text' => ( empty( $get_option['title_text'] ) ) ? __('Share On:', 'product-share') : $get_option['title_text'],

            'title_color' => ( empty( $get_option['title_color'] ) ) ? '#000000' : $get_option['title_color'],

            'title_weight' => ( !empty( $get_option['title_weight'] ) ) ? $get_option['title_weight'] : 'normal',

            'title_font_size' => ( empty( $get_option['title_font_size'] ) ) ? '18' : $get_option['title_font_size'],

            
            // Button Settings

            'btn_background_color' => ( empty( $get_option['btn_background_color'] ) ) ? '#ffffff' : $get_option['btn_background_color'],

            'btn_border_color' => ( empty( $get_option['btn_border_color'] ) ) ? '#000000' : $get_option['btn_border_color'],

            'btn_text_color' => ( empty( $get_option['btn_text_color'] ) ) ? '#000000' : $get_option['btn_text_color'],

            'btn_font_size' => ( empty( $get_option['btn_font_size'] ) ) ? '18' : $get_option['btn_font_size'],

            'btn_width' => ( empty( $get_option['btn_width'] ) ) ? '30' : $get_option['btn_width'],

            'btn_height' => ( empty( $get_option['btn_height'] ) ) ? '30' : $get_option['btn_height'],

            // ### Hover Settings

            'btn_hover_background_color' => ( empty( $get_option['btn_hover_background_color'] ) ) ? '#ffffff' : $get_option['btn_hover_background_color'],

            'btn_hover_border_color' => ( empty( $get_option['btn_hover_border_color'] ) ) ? '#000000' : $get_option['btn_hover_border_color'],

            'btn_hover_text_color' => ( empty( $get_option['btn_hover_text_color'] ) ) ? '#000000' : $get_option['btn_hover_text_color'],

            // ### Floating Icon Settings

            'float_icon' => ( empty( $get_option['float_icon'] ) ) ? 0 : $get_option['float_icon'],

            'float_icon_position' => ( !empty( $get_option['float_icon_position'] ) ) ? $get_option['float_icon_position'] : 'right_side',
            'float_icon_color' => ( empty( $get_option['float_icon_color'] ) ) ? '#000000' : $get_option['float_icon_color'],

        );

        return (object) apply_filters( 'psfw_options', $options );
    }

    /**
     *
     * Check plugin exits or not
     *
     */

    public static function check_plugin_state( $plugin_name ){

        include_once ABSPATH . 'wp-admin/includes/plugin.php';

        if (is_plugin_active( $plugin_name.'/'.$plugin_name.'.php' ) ){

            return true;

        }
        else{

            return false;

        }

    }

    /**
     *
     * All icons list
     *
     */

    public static function all_icons(){

        $all_icons = array(
            'facebook' => 'Facebook',
            'twitter' => 'Twitter',
            'linkedin' => 'LinkedIn',
            'viber' => 'Viber',
            'telegram' => 'Telegram',
            'whatsapp' => 'WhatsApp',
            'pinterest' => 'Pinterest',
            'tumblr' => 'Tumblr',
            'vk' => 'VK',
            'reddit' => 'Reddit',
            'xing' => 'Xing',
            'yahoo' => 'Yahoo',
            'pocket' => 'Pocket',
            'weibo' => 'Weibo',
            'envelope' => 'Email'
        );
        
        return apply_filters('psfw_available_social_icons', $all_icons);

    }


}