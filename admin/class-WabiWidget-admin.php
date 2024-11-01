<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.wabi-app.com/
 * @since      1.0.0
 *
 * @package    WabiWidget
 * @subpackage WabiWidget/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    WabiWidget
 * @subpackage WabiWidget/admin
 * @author     Wabi
 */
class WabiWidget_Admin
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
    private $option_name = 'wabiwidget';

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string $plugin_name The name of this plugin.
     * @param      string $version The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Add an options page under the Settings submenu
     *
     * @since  1.0.0
     */
    public function add_options_page()
    {
        $this->plugin_screen_hook_suffix = add_options_page(
            __('Wabi Widget Settings', 'wabiwidget'),
            __('Wabi Widget', 'wabiwidget'),
            'manage_options',
            $this->plugin_name,
            array($this, 'display_options_page')
        );
    }

    public function link_settings($links)
    {
        $mylinks = array(
            '<a href="' . admin_url('options-general.php?page=wabiwidget') . '">Setup</a>',
        );
        return array_merge($mylinks, $links);
    }

    /**
     * Render the options page for plugin
     *
     * @since  1.0.0
     */
    public function display_options_page()
    {
        include_once 'partials/WabiWidget-admin-display.php';
    }

    /**
     * Save the settings in admin page
     *
     * @since  1.0.0
     */
    public function register_setting()
    {
        // Add a General section
        add_settings_section(
            $this->option_name . '_wp',
            __('Wabi Widget', 'wabiwidget'),
            array($this, $this->option_name . '_general_cb'),
            $this->plugin_name
        );

        // Phone number
        add_settings_field(
            $this->option_name . '_phoneNumber',
            __('Phone number (international format)', 'wabiwidget'),
            array($this, $this->option_name . '_phoneNumber_cb'),
            $this->plugin_name,
            $this->option_name . '_wp',
            array('label_for' => $this->option_name . '_phoneNumber')
        );

        // Language
        add_settings_field(
            $this->option_name . '_language',
            __('Language', 'wabiwidget'),
            array($this, $this->option_name . '_language_cb'),
            $this->plugin_name,
            $this->option_name . '_wp',
            array('label_for' => $this->option_name . '_language')
        );

        // Language
        add_settings_field(
            $this->option_name . '_position',
            __('Position', 'wabiwidget'),
            array($this, $this->option_name . '_position_cb'),
            $this->plugin_name,
            $this->option_name . '_wp',
            array('label_for' => $this->option_name . '_position')
        );

        register_setting($this->plugin_name, $this->option_name . '_phoneNumber',
            array('sanitize_callback' => array($this, $this->option_name . '_phoneNumber_sanitize_cb')));

        register_setting($this->plugin_name, $this->option_name . '_language');

        register_setting($this->plugin_name, $this->option_name . '_position');
    }

    /**
     * Render the text for the general section
     *
     * @since  1.0.0
     */
    public function wabiwidget_general_cb()
    {
        echo '<p></p>';
    }

    /**
     * Render the input box for phoneNumber
     *
     * @since  1.0.0
     */
    public function wabiwidget_phoneNumber_cb()
    {
        $phoneNumber = get_option($this->option_name . '_phoneNumber');
        echo '<input type="text" name="' . $this->option_name . '_phoneNumber' . '" id="' . $this->option_name . '_phoneNumber' . '" value="' . $phoneNumber . '" style="width:150px" placeholder="e.g. +13025276080"> ';
    }

    /**
     * Render the input box for language
     *
     * @since  1.0.0
     */
    public function wabiwidget_language_cb()
    {
        $langs = array(
            array("auto", "Auto"),
            array("en", "English"),
            array("it", "Italian"),
            array("he", "Hebrew")
        );
        $language = get_option($this->option_name . '_language', 'auto');
        $output = '<select name="' . $this->option_name . '_language' . '" id="' . $this->option_name . '_language' . '" style="width:100px">';
//        $output .= '<option value=""></option>';
        foreach ($langs as $lang) {
            $output .= '<option value="' . $lang[0] . '"';
            if ($language == $lang[0]) {
                $output .= ' selected';
            }
            $output .= '>' . $lang[1] . '</option>';
        }
        $output .= '</select>';
        echo $output;
    }

    public function wabiwidget_position_cb()
    {
        $positions = array(
            array("right", "Right"),
            array("left", "Left"),
        );
        $position = get_option($this->option_name . '_position', 'right');
        $output = '<select name="' . $this->option_name . '_position' . '" id="' . $this->option_name . '_position' . '" style="width:100px">>';
        foreach ($positions as $pos) {
            $output .= '<option value="' . $pos[0] . '"';
            if ($position == $pos[0]) {
                $output .= ' selected';
            }
            $output .= '>' . $pos[1] . '</option>';
        }
        $output .= '</select>';
        echo $output;
    }

//'<option value="it">Italian</option>' .
//'<option value="he">Hebrew</option>';

    function wabiwidget_phoneNumber_sanitize_cb($input)
    {
        $output = preg_replace('/\D/', '', $input);
        $output = '+' . $output;
        return $output;
    }

    /**
     * Register the stylesheets for the admin area.
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

        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/wabiwidget-admin.css', array(), $this->version, 'all');

    }

    /**
     * Register the JavaScript for the admin area.
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

//        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/wabiwidget-admin.js', array(), $this->version, false);

    }

}
