<?php 

class Product_Share_Front{

	protected static $_instance = null;

	public $display_position;

    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public function __construct(){

        $this->includes();
        $this->init();
        do_action( 'product_share_frontend_loaded', $this );
    	
    }

    /*
     * Bootstraps the class and hooks required actions & filters.
     *
     */
    public function init() {

        $this->get_icons();

        // Asset Load

        add_action( 'wp_enqueue_scripts', array( $this, 'front_asset' ) );

        // Display Conditions of Social Icons

        $this->display_position = Product_Share::get_options()->display_position;

        if( 'after_product_price' === $this->display_position ){
            add_action( 'woocommerce_single_product_summary', array( $this, 'display_share_link' ), 11 );
        }
        elseif( 'after_product_title' === $this->display_position ){
            add_action( 'woocommerce_single_product_summary', array( $this, 'display_share_link' ), 6 );
        }
        else{
            add_action( 'woocommerce_share', array( $this, 'display_share_link' ) );
        }

        // Shortcode
        add_shortcode( 'psfw_basic_share', array( $this, 'shortcode_share_link' ) );

        // Display only shortcode
        add_filter( 'psfw_display_default_icon', array( $this, 'display_only_shortcode' ) );

        // All Icons Popup
        if ( has_action( 'wp_footer' ) ){
            add_action('wp_footer', array( $this, 'all_icons_popup' ) );
        }
    } 

    public function front_asset(){

    	// @Note: Checking if `SCRIPT_DEBUG` is defined and `true`
        $suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

    	if( is_product() || is_shop() ){

    		wp_enqueue_style('psfw-public', plugins_url('public/css/public'. $suffix .'.css', PRODUCT_SHARE_PLUGIN_FILE), array(), product_share()->version(), 'all');
    		wp_style_add_data( 'psfw-public', 'rtl', 'replace' );

    		/**
             * Fontawesome 6.4.2 added by replacing 6.1.1
             * 
             * @since 1.2.6 
             * 
             */
            wp_enqueue_style('psfw-fontawesome-6.4.2', plugins_url('fonts/fontawesome/css/all.css', PRODUCT_SHARE_PLUGIN_FILE), array(), product_share()->version(), 'all');

    		wp_enqueue_script('psfw-public', plugins_url('public/js/public'. $suffix .'.js', PRODUCT_SHARE_PLUGIN_FILE), array('jquery'), product_share()->version(), true);

    		wp_localize_script( 'psfw-public', 'public_js_object',
		        array( 
		            'copy_to_clipboard_text' => apply_filters( 'psfw_copy_to_clipboard_text', __('Copy to Clipboard', 'product-share') ),
		            'copied_to_clipboard_text' => apply_filters( 'psfw_copied_to_clipboard_text', __('Copied to Clipboard', 'product-share') ),
		        )
		    );

    	}

    	
    }


    /*
     * Includes files.
     *
     */

    public function includes() {
        require_once dirname( __FILE__ ) . '/class-product-share-icons.php';
    }

    /**
     *
     * Frontend 
     *
     */

    public function get_icons(){
        return Product_Share_Icons::instance();
    }

    public function shortcode_share_link(){

        ob_start();

        if( 'hide_icon' === Product_Share::get_options()->display_position ){
            return;
        }

        $this->main_markup();

        return ob_get_clean();

    }

    public function display_share_link( ){

        if( apply_filters( 'psfw_display_default_icon', false ) ){
            return;
        }

        $this->main_markup();

    }

    public function main_markup(){
        // Preparing Icon Title 
        $title = sprintf(
            '<span class="psfw-icon-title">%s</span>',
            apply_filters('psfw_icon_title', __('Share On:', 'product-share'))
        );

        echo sprintf(
            '<div class="psfw-social-wrap">
            %1$s<ul class="psfw-social-icons %2$s %3$s %4$s">',
            ( Product_Share::get_options()->icon_title === 'yes' ) ? $title : "",
            esc_attr( Product_Share::get_options()->button_shape ),
            esc_attr( Product_Share::get_options()->icon_appearance ),
            apply_filters('psfw_ul_class', '')
        );

        $icon_appearance = Product_Share::get_options()->icon_appearance;
        $selected_labels = Product_Share::get_options()->selected_lables;

        // Social Icons Only [foreach loop is working inside the `prepare_icons`]
        $this->prepare_icons( $selected_labels, $icon_appearance );

        // Additional Icons [icons those are not social icon like- copy to clipboard]
        $this->additional_icons( false );

        echo '</ul></div>';
    }


    public function prepare_icons( $selected_labels, $icon_appearance ){

        foreach ($selected_labels as $key => $label) {

            // Font Awesome Icon Family
            $font_type = 'brands';
            if( $key == 'envelope' ){
                $font_type = 'solid';
            }

            // Text Appearance 
            if( $key == 'whatsapp' ){
                $text = 'WhatsApp';
            }

            elseif( $key == 'linkedin' ){
                $text = 'LinkedIn';
            }

            elseif( $key == 'envelope' ){
                $text = __( 'Email', 'product-share' );
            }

            else{
                $text = ucfirst($key);
            }

            // Icon Appearance
            if( 'only_icon' == $icon_appearance ){
                /**
                 * @since 1.2.6 
                 * `psfw_icon_key` added to remove the email address 
                 * 
                 */
                $btn_format = sprintf('<i class="fa-%s fa-%s"></i>',$font_type, apply_filters( 'psfw_icon_key', $key ) );
            }
            elseif( 'only_text' == $icon_appearance ){
                
                $btn_format = $text;
                
            }
            else{
                /**
                 * @since 1.2.6 
                 * `psfw_icon_key` added to remove the email address 
                 * 
                 */
                $btn_format = sprintf('<i class="fa-%s fa-%s"></i>',$font_type, apply_filters( 'psfw_icon_key', $key )).$text;
            }

            switch ($key) {

                case "facebook":
                     product_share()->get_frontend()->get_icons()->get_facebook($icon_appearance, $btn_format, $text);
                break;

                case "twitter":
                     product_share()->get_frontend()->get_icons()->get_twitter($icon_appearance, $btn_format, $text);
                break;

                case "linkedin":
                     product_share()->get_frontend()->get_icons()->get_linkedin($icon_appearance, $btn_format, $text);
                break;

                case "viber":
                     product_share()->get_frontend()->get_icons()->get_viber($icon_appearance, $btn_format, $text);
                break;

                case "telegram":
                     product_share()->get_frontend()->get_icons()->get_telegram($icon_appearance, $btn_format, $text);
                break;

                case "whatsapp":
                     product_share()->get_frontend()->get_icons()->get_whatsapp($icon_appearance, $btn_format, $text);
                break;

                case "pinterest":
                     product_share()->get_frontend()->get_icons()->get_pinterest($icon_appearance, $btn_format, $text);
                break;

                case "tumblr":
                     product_share()->get_frontend()->get_icons()->get_tumblr($icon_appearance, $btn_format, $text);
                break;

                case "vk":
                     product_share()->get_frontend()->get_icons()->get_vk($icon_appearance, $btn_format, $text);
                break;

                case "reddit":
                     product_share()->get_frontend()->get_icons()->get_reddit($icon_appearance, $btn_format, $text);
                break;

                case "xing":
                     product_share()->get_frontend()->get_icons()->get_xing($icon_appearance, $btn_format, $text);
                break;

                case "yahoo":
                     product_share()->get_frontend()->get_icons()->get_yahoo($icon_appearance, $btn_format, $text);
                break;

                case "pocket":
                     product_share()->get_frontend()->get_icons()->get_pocket($icon_appearance, $btn_format, $text);
                break;

                case "weibo":
                     product_share()->get_frontend()->get_icons()->get_weibo($icon_appearance, $btn_format, $text);
                break;


                case "envelope":
                     product_share()->get_frontend()->get_icons()->get_email($icon_appearance, $btn_format, $text);
                break;

                default:
                    echo  "";
            }

        }

    }

    public function additional_icons( $popup ){

        // Clipboard Button
        if( 'yes' === Product_Share::get_options()->copy_to_clipboard && false === $popup ){
            $text = __('Copy Link', 'product-share');
            product_share()->get_frontend()->get_icons()->get_copy_to_clipboard(Product_Share::get_options()->icon_appearance, $text);
        }

        // All Icon Button
        if( 'yes' === Product_Share::get_options()->all_icon && false === $popup ){
            $text = __('All Icon', 'product-share');
            product_share()->get_frontend()->get_icons()->get_all_icon(Product_Share::get_options()->icon_appearance, $text);
        }

    }

    public function all_icons_popup(){

        if( 'no' === Product_Share::get_options()->all_icon ){
            return;
        }

        // @Note: Push the popup markup where script exists 
        if( is_product() || is_shop() ){

            $icon_appearance = 'icon_with_text';
            $selected_labels = product_share()->all_icons();

            echo sprintf(
                "<div class='%s'><div class='%s'><h3 class='psfw-popup-title'>%s</h3><ul class='%s'>",
                apply_filters('psfw_popup_class', 'psfw-popup-container'),
                apply_filters('psfw_popup_inner_class', 'psfw-popup-inner-container'),
                apply_filters('psfw_icon_title', __('Share On:', 'product-share')),
                apply_filters('psfw_popup_ul_class', 'psfw-popup-ul-container')
            );
            $this->prepare_icons( $selected_labels, $icon_appearance );
            echo "</ul></div></div>";

        }

    }

    // Display only shortcode
    public function display_only_shortcode(){
        if( 'hide_icon' === Product_Share::get_options()->display_position ){
            return true;
        }
    }


}