<?php 
if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if( ! class_exists('TOC') ) :

    /**
     * @since 1.0.0
     * 
     * TOC Main class
     */

    class TOC {

        /** @var string The plugin version number. */
	    var $version = '1.0.0';

        /** Get the h tags with attrs and inside the anchor tag supported
         * @var string #<(h\d*)(.*?)>(.*?)</h\d*>#i */
        
        var $preg_heading = '#<(h\d*)(.*?)>(.*?)</h\d*>#i';

        private static $_instance = null;
        
        public $toc;

        public function __construct(){
            add_filter( 'rank_math/researches/toc_plugins', [$this, 'add_toc_hook']);
        }

        public static function get_instance(){

            if ( ! isset( self::$_instance ) && ! ( self::$_instance instanceof NSM ) ) {
                self::$_instance = new self();
    
                self::$_instance->includes();
                
            }
    
            return self::$_instance;
        }

        /**
         * add_toc_hook
         * description
         * Add this hook for rankmath content readibility
         * 
         * @param $toc_plugins
         */

         public function add_toc_hook( $toc_plugins ){
            $toc_plugins['ultimate-toc/ultimate-toc.php'] = 'Ultimate TOC';
            return $toc_plugins;
        }
        
        public function includes(){
            $this->define( 'ULTIMATE_TOC', true );
            $this->define( 'ULTIMATE_TOC_PATH', plugin_dir_path( __FILE__ ) );
            $this->define( 'ULTIMATE_TOC_DIR',  plugin_dir_url( __FILE__ ) );
            $this->define( 'ULTIMATE_TOC_BASENAME', plugin_basename( __FILE__ ) );
            $this->define( 'ULTIMATE_TOC_VERSION', $this->version );
            $this->define( 'ULTIMATE_TOC_PREG_HEADING', $this->preg_heading );

            require_once ULTIMATE_TOC_PATH . '/classes/class-toc-setting.php';
            require_once ULTIMATE_TOC_PATH . '/classes/class-toc-front.php';
            require_once ULTIMATE_TOC_PATH . '/classes/class-toc-helper.php';
            
            new Ultimate_TOC_Setting;
            new Ulimate_TOC_Front;
            new Ultimate_TOC_Helper;
        }

        function define( $name, $value = true ) {
            if( !defined($name) ) {
                define( $name, $value );
            }
        }
    }

    function toc(){
        return TOC::get_instance();
    }
    toc();
endif; // class_exists check
?>