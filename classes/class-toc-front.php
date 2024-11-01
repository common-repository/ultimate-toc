<?php 
if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if( ! class_exists('Ulimate_TOC_Front') ) :
    /**
     * Class Ulimate_TOC_Front
     *
     * @since 1.0.0
     */
    class Ulimate_TOC_Front{
        
        /**
         * @date 4/6/2023
         * @since 1.0.0
         * 
         * @var int
         */
        private $object_ID;
        
        private $options;
        
        public function __construct( ){
            add_action( 'init', [$this, 'set_objects_with_post'], 999 );
            $this->options = get_option( 'toc_option' );
            add_filter( 'the_content',[ $this, 'toc_acf_get_the_content'], 10 );
            add_filter( 'the_content', [ $this, 'prepend_toc' ], 10 );
            add_filter( 'acf_the_content',[ $this, 'toc_acf_get_the_content' ] );
            add_action( 'wp_enqueue_scripts', [ $this, 'toc_front_enqueue' ] );
            add_shortcode( 'ultimate_toc', [ $this, 'toc_heading_shortcode' ] );
        }
        

        public function set_objects_with_post(){
            $object_ID = get_queried_object_id();
        }

        /**
         * prepend_toc
         * description
         * If auto show selected shortcode auto appear in before the content.
         * 
         * @date 12/24/27
         * @since 1.0.1
         * 
         * @param $content
         * @return $content string
         */
        public function prepend_toc( $content ){
            $autoshow       = isset( $this->options['toc_autoshowpost'] ) ? $this->options['toc_autoshowpost'] : '';
            
            if( $autoshow == null || $autoshow == '0')
                return $content;

            if( is_singular('post')){
                $custom_content = '[ultimate_toc]';
                $content        = $custom_content . $content;
                return $content;
            }else{
                return $content;
            }
        }

        /**
         * toc_acf_get_the_content
         * Description
         * Get the heading with id and attributes
         * 
         * @date 12/24/22
         * @since 1.0.0
         * 
         * Get the h tags from content and acf content
         * 
         * @param $content
         * @return $content content
         */
        public function toc_acf_get_the_content($content){
            
                $prev_match = null;
                $count = 0;

                return preg_replace_callback(
                    '#<(h\d*)(.*?)>(.*?)</h\d*>#i',
                    function($matches) use (&$prev_match, &$count) {
                        $heading_text = Ultimate_TOC_Helper::title_str_replace(do_shortcode($matches[3]));
                        if ($prev_match === $heading_text) {
                            $count++;
                        } else {
                            $prev_match = $heading_text;
                            $count = 0;
                        }
                        $matches[0] = '<' . $matches[1] . ' id="' . $heading_text . ($count ? '-' . ($count + 1) : '') . '" ' . $matches[2] . '>' . $matches[3] . '</' . $matches[1] . '>';
                        return $matches[0];
                    },
                    $content
                );
            
            return $content;
            
        }

        /**
         * @since 1.0.0
         * 
         * Heading Shortcode
         * 
         * Selected taxonomies
         * Collapse boolean with text if yes show collapse button 
         * is_archive function
         * Get fields
         */
        
        public function toc_heading_shortcode(){
            ob_start();

            $toc_style      =   isset( $this->options['toc_style'] ) ? ( $this->options['toc_style'] ? $this->options['toc_style'] : '' ) : '';
            $accepted_tags  =   isset( $this->options['select_headings'] ) && $this->options['select_headings'] ? $this->options['select_headings'] : [];
            if ( empty( $accepted_tags ) )
            return;
            
            $content = get_the_content( null, false, $this->object_ID );
            $headings = [];
            $prev_heading = null;
            $count = 0;

            if( preg_match_all( ULTIMATE_TOC_PREG_HEADING, $content, $matches ) ){
                foreach ($matches[1] as $key => $tag) {
                    foreach ($accepted_tags as $hk => $h) {
                        if ($h === $tag) {
                            $heading_text = strip_tags($matches[3][$key]);
                            if ($prev_heading === $heading_text) {
                                $count++;
                            } else {
                                $prev_heading = $heading_text;
                                $count = 0;
                            }
                            $headings[$key]['heading_tag'] = $tag;
                            $headings[$key]['heading_name'] = $heading_text;
                            $headings[$key]['heading_href'] = $heading_text . ($count ? '-' . ($count + 1) : '');
                        }
                    }
                }
            }
            $this->front_table_of_content_style( $headings, $toc_style );
            
            return ob_get_clean();
        }

        /**
         * front_table_of_content_style
         * description
         * frontend toc style
         * 
         * @date 4/6/2023
         * @since 1.0.0
         * 
         * @param $rows, $collapse
         * @return 
         */
        public function front_table_of_content_style( $rows, $toc_style ){
            if(empty($rows))
            return;
            $heading = isset( $this->options['toc_postheading'] ) ? $this->options['toc_postheading'] : '';
            load_template( ULTIMATE_TOC_PATH . '/template-parts/template.php', true, [
                'style'     => $toc_style,
                'heading'   => $heading,
                'rows'      => $rows
            ]);
        }

        /**
         * 
         * @since 1.0.0
         * 
         * Enqueue Front style and script
         */
        public function toc_front_enqueue(){
            wp_enqueue_style( 'toc-style', ULTIMATE_TOC_DIR . '/assets/css/toc-front.css', false, ULTIMATE_TOC_VERSION, 'all' );
            wp_enqueue_script( 'toc-script', ULTIMATE_TOC_DIR . 'assets/js/toc-front.js',  array('jquery'), ULTIMATE_TOC_VERSION, true );
        }

    }
endif; 