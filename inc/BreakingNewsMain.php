<?php
/**
* BreakingNewsMain
* @since 1.0
**/

defined( 'ABSPATH' ) or die ( 'Not Allowed');

class BreakingNewsMain {

    public  function __construct(){
        
        add_action( 'admin_menu', array( $this,'breaking_news_menu') );
        add_action( 'admin_init',  array( $this,'breaking_news_register_setting') );
        add_shortcode('breaking-news', array($this, 'breaking_news_show') ); 
        add_action( 'wp_body_open', array($this, 'breaking_news_top' ) );
        add_action('wp_enqueue_scripts', array($this, 'breaking_news_register_script'));

        // For admin only
        if( is_admin() ) {
            //No code yet
        }
    }

    /**
    ** Shortcode To show News
    */
    public function breaking_news_show() { 
 
        // Things that you want to do. 
        $newsModalHtml ='
        <div id="nw-news-box" class="nw-box">
            <div class="nw-news-content">
                <span id="nw-close" class="nw-box-close">&times;</span>
                <p class="nw-msg" id="nw-content-message"><a id="nw-msg-link"><a></p>
            </div>
        </div>
        ';
        // echo '<h1>this</h1>'; 
         
        return $newsModalHtml;
    }

    /**
    ** Getting Shortcode on the top
    */
    public function breaking_news_top() {
        echo do_shortcode("[breaking-news]");
    }

    /**
    ** Register and Enqueue News Style And Scripts
    */
    public function breaking_news_register_script() {
        wp_register_script( 'api_script', BREAKINGNEWS_URL .'assets/admin/js/api-script.js', array('jquery'));

        /* News Settings data*/
        $NwControl     = get_option( 'news_control' );
        $NwMessage     = get_option( 'news_message' );
        $NwTextColor   = get_option( 'nw_text_color' );
        $NwBackground  = get_option( 'nw_bg_color' );
        $NwMessageLink = get_option( 'nw_text_link' );

        $nwOptions = array(
            'NwControl'    => $NwControl,
            'NwMessage'    => $NwMessage,
            'NwTextColor'  => $NwTextColor,
            'NwBackground' => $NwBackground,
            'NwMessageLink'=> $NwMessageLink
        );

        wp_register_style( 'news_style', BREAKINGNEWS_URL .'assets/css/news-style.css');
        wp_register_script( 'news_script', BREAKINGNEWS_URL .'assets/js/news-ui.js', array('jquery'), false, true);
        wp_register_script( 'jsCookies','https://cdn.jsdelivr.net/npm/js-cookie@rc/dist/js.cookie.min.js');
        wp_localize_script( 'news_script', 'newsSettingsData', $nwOptions );

        wp_enqueue_style( 'news_style' );
        wp_enqueue_script('news_script');
        wp_enqueue_script('jsCookies');
    }

    /**
    * Register menu page.
    **/
    public function breaking_news_menu(){
        
        add_menu_page( 
            __( 'Dashboard', 'breakingnews' ),
            'Breaking News',
            'manage_options',
            'breaking_news',
            array( $this, 'breaking_news_page'),
            'dashicons-layout',
            NUll
        );
        remove_submenu_page('breakingnews','breakingnews');
    }

    /**
    * Register News Settings page.
    **/
    public function breaking_news_page(){
        echo '<div class="wrap">
        <h1>Breaking News Settings</h1>
        <form method="post" action="options.php">';
     
            settings_fields( 'breaking_news_settings' ); 
            do_settings_sections( 'breaking_news' );
            submit_button('Save Data');
     
        echo '</form></div>';
    }

    /**
    * Register News Settings.
    **/
    public function breaking_news_register_setting(){
        
                register_setting(
                        'breaking_news_settings', 
                        'news_control',
                        'sanitize_text_field'
                );        
                register_setting(
                        'breaking_news_settings', 
                        'news_message',
                        'sanitize_text_field'
                );
                register_setting(
                        'breaking_news_settings', 
                        'nw_text_color',
                        'sanitize_text_field'
                );
                register_setting(
                        'breaking_news_settings', 
                        'nw_bg_color',
                        'sanitize_text_field'
                );
                register_setting(
                        'breaking_news_settings', 
                        'nw_text_link',
                        'sanitize_text_field'
                );

                add_settings_section(
                        'breaking_news_settings_section',
                        '',
                        '',
                        'breaking_news'
                );
                
                
                add_settings_field(
                        'news_control',
                        'Display News Message?',
                        array($this,'breaking_news_control_field_html'), 
                        'breaking_news', 
                        'breaking_news_settings_section', 
                        array( 
                                'label_for' => 'news_control', 
                        )
                );
                add_settings_field(
                        'news_message',
                        'News Message',
                        array($this,'breaking_news_message_field_html'), 
                        'breaking_news', 
                        'breaking_news_settings_section', 
                        array( 
                                'label_for' => 'news_message', 
                        )
                );
                add_settings_field(
                        'nw_text_color',
                        'News Text Color',
                        array($this,'breaking_news_text_color_field_html'), 
                        'breaking_news', 
                        'breaking_news_settings_section', 
                        array( 
                                'label_for' => 'nw_text_color', 
                        )
                );
                add_settings_field(
                        'nw_bg_color',
                        'News Background Color',
                        array($this,'breaking_news_background_field_html'), 
                        'breaking_news', 
                        'breaking_news_settings_section', 
                        array( 
                                'label_for' => 'nw_bg_color', 
                        )
                );
                add_settings_field(
                        'nw_text_link',
                        'News Text Link',
                        array($this,'breaking_news_link_field_html'), 
                        'breaking_news', 
                        'breaking_news_settings_section', 
                        array( 
                                'label_for' => 'nw_text_link', 
                        )
                );
     
        }
        
        function breaking_news_control_field_html(){

                $text = get_option( 'news_control' );

                echo'<select id="news_control" name="news_control" value="%s" >
                                <option value="show" >show</option>
                                <option value="hide" selected>Hide</option>
                        </select>
                        <script>
                                jQuery(`#news_control option[value="'.esc_attr($text).'"]`).attr("selected", "selected");
                        </script>';

        }
        
        function breaking_news_message_field_html(){

                $text = get_option( 'news_message' );

                printf(
                        '<textarea type="text" placeholder="Message" id="news_message" name="news_message"  >%s</textarea>',
                        esc_attr( $text )
                );

        }
     
        function breaking_news_text_color_field_html(){
        
                $text = get_option( 'nw_text_color' );
        
                printf(
                        '<input type="text" placeholder="Text Color e.g(#fff)" id="nw_text_color" name="nw_text_color" value="%s" />',
                        esc_attr( $text )
                );
        
        }
        function breaking_news_background_field_html(){
        
                $text = get_option( 'nw_bg_color' );
        
                printf(
                        '<input type="text" placeholder="Background Color e.g(#000) id="nw_bg_color" name="nw_bg_color" value="%s" />',
                        esc_attr( $text )
                );
        
        }
        function breaking_news_link_field_html(){
        
                $text = get_option( 'nw_text_link' );
        
                printf(
                        '<input type="text" placeholder="https://example.com" id="nw_text_link" name="nw_text_link" value="%s" />',
                        esc_attr( $text )
                );
        
        }
}
new BreakingNewsMain();
