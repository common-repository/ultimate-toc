<?php 
if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if( ! class_exists('Ultimate_TOC_Helper') ) :
    /**
     * Class Ulimate_TOC_Helper
     *
     * @since 1.0.0.1
     */
    class Ultimate_TOC_Helper{
        /**
         * 
         */
        public static function title_str_replace( $string ){
            $special_chars = array("<", ">", "&", "\"", "'", " ", "/", ",");
            $underscored_string = str_replace($special_chars, "_", strtolower(strip_tags($string)));
            return $underscored_string;
        }
    }
endif;