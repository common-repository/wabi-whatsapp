<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://www.wabi-app.com/
 * @since      1.0.0
 *
 * @package    WabiWidget
 * @subpackage WabiWidget/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    WabiWidget
 * @subpackage WabiWidget/public
 * @author     Wabi
 */
class WabiWidget_Public
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $plugin_name The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $version The current version of this plugin.
     */
    private $version;

    /**
     * The options name to be used in this plugin
     *
     * @since    1.0.0
     * @access    private
     * @var    string $option_name Option name of this plugin
     */
    private $option_name = 'WabiWidget';

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string $plugin_name The name of the plugin.
     * @param      string $version The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in WabiWidget_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The WabiWidget_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/WabiWidget-public.css', array(), $this->version, 'all');
    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in WabiWidget_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The WabiWidget_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        $src = 'https://app.wabi-app.com/widget/js/wabi.js?src=wpp-' . $this->version;

        $phoneNumber = get_option($this->option_name . '_phoneNumber', "");
        if (trim($phoneNumber) != false) {
            $phoneNumber = str_replace('+', '', $phoneNumber);
            $src .= '&phone_number=' . $phoneNumber;
            $language = get_option($this->option_name . '_language', "auto");
            if ($language != false) {
                if ($language == "auto") {
                    $language = substr(get_locale(), 0, 2);
                }
                $src .= '&lang=' . $language;
            }
            $position = get_option($this->option_name . '_position', "right");
            if ($position != false) {
                $src .= '&position=' . $position;
            }
            wp_enqueue_script($this->plugin_name, $src, array(), null, true);
        }
    }

}
