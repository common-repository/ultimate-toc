<?php 
/*
    Template used to display style 3
    
    Available params:
    ---------------------
    $args['heading'] - Top Heading
    $args['rows'] - The headings items
*/
if($args['rows']):?>
<div class="toc-table-wrapper table-of-content">
    <p class="toc-heading"><?php echo esc_html($args['heading']); ?></p>
    <?php $count = 0; ?>
    <table class="">
    <?php 
        foreach( $args['rows'] as $key => $row ) {
            $headingname = $row['heading_name'];
            $i = ($count+1).') ';
            if ($count % 2 == 0){
                ?><tr><?php
            }?><td>
                    <a alt="<?php echo esc_attr($row['heading_name']);?>" title="<?php echo esc_attr($row['heading_name']);?>" href="#<?php  echo Ultimate_TOC_Helper::title_str_replace( $row['heading_href'] );?>">
                        <?php echo esc_html($i.$headingname);?>
                    </a>
                </td>
            <?php 
            if ($count % 2 != 0){ ?>
                </tr> <?php
            }
            $count++;
        } ?>
    </table>
</div>
<?php endif; ?>