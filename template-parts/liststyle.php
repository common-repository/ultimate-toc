<?php 
/*
    Template used to display style 1
    
    Available params:
    ---------------------
    $args['heading'] - Top Heading
    $args['rows'] - The headings items
*/
if($args['rows']):?>
<div class="toc-list-style-wrapper table-of-content">
    <p class="toc-heading"><?php echo esc_html($args['heading']);?></p>
    <?php $hs  = ['h1'=>'pl-0','h2'=>'pl-10','h3'=>'pl-20','h4'=>'pl-30','h5'=>'pl-40','h6'=>'pl-50']; ?>
    <ul class="toc-list-style">
        <?php 
        foreach( $args['rows'] as $row ) :
            foreach($hs as $k => $h) :
                if($row['heading_tag'] === $k):?>
                <li>
                    <a class="<?php echo esc_attr($h); ?>" title="<?php echo esc_attr($row['heading_name']); ?>" alt="<?php echo esc_attr($row['heading_name']); ?>" href="#<?php echo Ultimate_TOC_Helper::title_str_replace($row['heading_href']);?>">
                            <?php echo esc_html($row['heading_name']);?><sup><?php echo esc_html($row['heading_tag']);?> </sup>
                    </a>
                </li> <?php 
                endif;
            endforeach;
        endforeach; ?>
    </ul>
</div>
<?php endif;?>