<?php 
if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if( ! class_exists('Ultimate_TOC_Setting') ) :
    /**
     * Class Ultimate_TOC_Setting
     *
     * @date 4/6/2023
     * @since 1.0.0
     */

    class Ultimate_TOC_Setting{

        /**
         * @var array Get the options get_option()
         * 
         * @date 4/6/2023
         * @since 1.0.0
         * 
         * Holds the values to be used in the fields callbacks
         */

        private $options;

        /**
         * __construct
         * 
         * @date 12/24/22
         * @since 1.0.0
         * 
         * @param N/A 
         * @return N/A
         * 
         */
        public function __construct()
        {
            add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
            add_action( 'admin_init', array( $this, 'page_init' ) );
        }

        /**
         * add_plugin_page
         * 
         * Description
         * Register option page
         * 
         * @type function
         * @date 4/6/2023
         * @since 1.0.0
         * 
         * @param N/A 
         * @return N/A
         */
        public function add_plugin_page()
        {
            // This page will be under "Settings"
            add_options_page(
                'Settings Admin', 
                'Table of Contents Settings', 
                'manage_options', 
                'toc-setting-admin', 
                array( $this, 'create_admin_page' )
            );
        }

        /**
         * create_admin_page
         * Description
         * Show setting form
         * 
         * @date 4/6/2023
         * @since 1.0.0
         * 
         * @param N/A 
         * @return form
         */
        public function create_admin_page()
        {
            // Set class property
            $this->options = get_option( 'toc_option' );
            ?>
            <div class="wrap">
                <h1><?php esc_html_e( 'TOC Settings', 'ultimate_toc' ) ?></h1>
                <form method="post" action="options.php">
                <?php
                    // This prints out all hidden setting fields
                    settings_fields( 'my_option_group' );
                    do_settings_sections( 'toc-setting-admin' );
                    submit_button();
                ?>
                </form>
            </div>
            <?php
        }

        /**
         * page_init
         * Description
         * Register Setting and Add Setting Section with call back function
         * 
         * @date 4/6/2023
         * @since 1.0.0
         * 
         * @param N/A 
         * @return HTML Fields
         */
        public function page_init()
        {        
            register_setting(
                'my_option_group', // Option group
                'toc_option', // Option name
                //array( $this, 'sanitize' ) // Sanitize
            );

            add_settings_section(
                'setting_section_id', // ID
                '', // Title
                array( $this, 'print_section_info' ), // Callback
                'toc-setting-admin' // Page
            );
            
            add_settings_field(
                'toc_autoshowpost', 
                'Auto Show', 
                array( $this, 'toc_autoshowpost_callback' ), 
                'toc-setting-admin', 
                'setting_section_id'
            );

            add_settings_field(
                'select_headings', // ID
                'Select Headings', // Title 
                array( $this, 'select_headings_callback' ), // Callback
                'toc-setting-admin', // Page
                'setting_section_id' // Section           
            );

            add_settings_field(
                'toc_style', // ID
                'TOC Style', // Title 
                array( $this, 'toc_style_callback' ), // Callback
                'toc-setting-admin', // Page
                'setting_section_id' // Section           
            );

            add_settings_field(
                'toc_postheading', 
                'Heading', 
                array( $this, 'toc_postheading_callback' ), 
                'toc-setting-admin', 
                'setting_section_id'
            );
        }

        /**
         * sanitize
         * Descrption
         * Senitize input fields 
         * 
         * @date 4/6/2023
         * @since 1.0.0
         * 
         * @param array $input Contains all settings fields as array keys
         * @return new_inputs
         */
        public function sanitize( $input )
        {
            $new_input = array();
            if( isset( $input['toc_postheading'] ) )
                $new_input['toc_postheading'] = sanitize_text_field( $input['toc_postheading'] );

            if( isset( $input['select_headings'] ) )
                $new_input['select_headings'] = sanitize_text_field( $input['select_headings'] );
            
            return $new_input;
        }

        /**
         * print_seciton_info
         * Description
         * Show the text
         * 
         * @date 4/6/2023
         * @since 1.0.0
         * 
         * @param N/A 
         * @return content
         */
        public function print_section_info()
        {
            esc_html_e( 'Enter your settings below:', 'ultimate_toc' );
        }

        /**
         * toc_autoshowpost_callback
         * Description
         * show shortcode on post single page before content
         * 
         * @date 5/20/2023
         * @since 1.0.1
         * 
         * @param N/A 
         * @return checkbox field
         */

         public function toc_autoshowpost_callback(){
            ?>
            <label for="yes">
                <input id="yes" type="radio" name="toc_option[toc_autoshowpost]" value="1" 
                <?php echo isset( $this->options['toc_autoshowpost'] ) ? ( $this->options['toc_autoshowpost'] == '1' ? 'checked="checked"':'') : ''; ?> >
                <?php esc_html_e( 'Yes', 'ultimate_toc' ); ?>
            </label>
            <br/>
            <label for="no">
                <input id="yes" type="radio" name="toc_option[toc_autoshowpost]" value="0" 
                <?php echo isset( $this->options['toc_autoshowpost'] ) ? ( $this->options['toc_autoshowpost'] == '0' ? 'checked="checked"':'') : ''; ?> >
                <?php echo sprintf( esc_html__( 'No %s', 'ultimate_toc' ), '<small>' . esc_html__( '(Manually Add Shortcode [ultimate_toc])','ultimate_toc').'</small>'); ?>
            </label>
            <br/>
            <small><?php esc_html_e( 'Shortcode auto show post page', 'ultimate_toc' ); ?></small>
            <?php 
        }

        /**
         * select_headings_callback
         * Description
         * show all H tags
         * 
         * @date 4/6/2023
         * @since 1.0.0
         * 
         * @param N/A 
         * @return checkbox field
         */

        public function select_headings_callback(){
            if(isset( $this->options['select_headings'] ))
            $field = isset( $this->options['select_headings'] ) ? $this->options['select_headings'] : '';
            $checked = array( );
            if ( ! empty( $field ) && $field != null ) {
                foreach(  $field as $val ) {
                    $checked[ $val ] = 'checked="checked"';
                }
            }
            $hs  = ['1'=>'h1','2'=>'h2','3'=>'h3','4'=>'h4','5'=>'h5','6'=>'h6'];
            echo '<ul>';
            foreach($hs as $k => $h){ ?>
                <li>
                    <label>
                        <input 
                        type="checkbox" 
                        class="checkbox-class" 
                        <?php if(isset($field)) { echo ( isset( $checked[ $h ] ) ) ? $checked[ $h ] : null; } ?>
                        name="toc_option[select_headings][]" 
                        value="<?php echo sanitize_text_field($h); ?>">
                        <?php echo sanitize_text_field($h);?>
                    </label>
                </li>
            <?php 
            }
            echo '</ul>';
        }

        /** 
         * toc_style
         * Description
         * If you select yes toggle function enable
         * 
         * @date 4/6/2023
         * @since 1.0.0
         * 
         * @param N/A 
         * @return Checkbox HTML
         */
        public function toc_style_callback()
        {
            ?>
            <label for="no-style">
                <input id="no-style" type="radio" name="toc_option[toc_style]" value="liststyle" 
                <?php echo isset( $this->options['toc_style'] ) ? ( $this->options['toc_style'] == 'liststyle' ? 'checked="checked"':'') : ''; ?> >
                <?php esc_html_e( 'List Style', 'ultimate_toc' ); ?>
            </label>
            <br/>
            <label for="collapse">
                <input id="collapse" type="radio" name="toc_option[toc_style]" value="collapse" 
                <?php echo isset( $this->options['toc_style'] ) ? ( $this->options['toc_style'] == 'collapse' ? 'checked="checked"':'') : ''; ?> >
                <?php esc_html_e( 'Collapse', 'ultimate_toc' ); ?>
            </label>
            <br/>
            <label for="table">
                <input id="table" type="radio" name="toc_option[toc_style]" value="table" 
                <?php echo isset( $this->options['toc_style'] ) ? ( $this->options['toc_style'] == 'table' ? 'checked="checked"':'') : ''; ?> >
                <?php esc_html_e( 'Table', 'ultimate_toc' ); ?>
            </label>
            <br/>
            <label for="table">
                <input id="table" type="radio" name="toc_option[toc_style]" value="fixed" 
                <?php echo isset( $this->options['toc_style'] ) ? ( $this->options['toc_style'] == 'fixed' ? 'checked="checked"':'') : ''; ?> >
                <?php esc_html_e( 'Fixed', 'ultimate_toc' ); ?>
            </label>
            <?php 
        }

        /**
         * toc_postheading_callback
         * Description
         * show heading before the shortcode only single page
         * 
         * @date 4/6/2023
         * @since 1.0.0
         * 
         * @param N/A 
         * @return text field
         */

        public function toc_postheading_callback(){
            printf(
                '<input type="text" id="toc_postheading" name="toc_option[toc_postheading]" value="%s" /><p>%s</p>',
                isset( $this->options['toc_postheading'] ) ? esc_attr( $this->options['toc_postheading']) : '', __('e.g, Add headings before shortcode only post detail page.','ultimate_toc')
            );
        }
    }
endif; 