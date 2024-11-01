<?php 
/*
    Template used to display style 2
    
    Available params:
    ---------------------
    $args['heading'] - Top Heading
    $args['rows'] - The headings items
*/
if($args['rows']):?>
<div class="toc-collapse-wrapper table-of-content">
    <p class="toc-heading"><?php echo esc_html($args['heading']);?></p>
    <?php 
    if( $args['rows'] ) {
    $text = explode('|',__('More | Less','ultimate_toc'));
    ?>
    <span onclick="read_toggle('toc_id', '<?php echo esc_js($text[0]); ?>', '<?php echo esc_js($text[1]); ?>'); return false;" class="read-link" id="readlinktoc_id" style="readlink"><?php echo esc_html($text[0]); ?></span>
    <div class="toc-collapse read_div" id="readtoc_id" style="display: none;">
        <ul class="toc-ul">
            <?php 
            foreach( $args['rows'] as $row ) {
                $headingname    =   $row['heading_name']; ?>
                    <li>
                        <a title="<?php echo esc_attr($row['heading_name']); ?>" alt="<?php echo esc_attr($row['heading_name']); ?>" href="#<?php echo Ultimate_TOC_Helper::title_str_replace( $row['heading_href'] );?>">
                            <?php echo esc_html($headingname); ?>
                        </a>
                    </li>
                <?php 
                } ?>
        </ul>
    </div>
    <?php 
    } ?>
</div>
<?php endif;?>