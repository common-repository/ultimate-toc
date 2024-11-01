<?php 
/*
    Template used to default display style
    
    Available params:
    ---------------------
    $args['heading'] - Top Heading
    $args['rows'] - The headings items
*/ 
if($args['rows']): ?>
<div class="toc-default-style-wrapper">
    <p class="toc-heading"><?php echo esc_html($args['heading']); ?></p>
    <ul class="toc-default-style">
    <?php 
    foreach( $args['rows'] as $row ) { ?>
        <li>
            <a title="<?php echo esc_attr($row['heading_name']); ?>" alt="<?php echo esc_attr($row['heading_name']); ?>" href="#<?php  echo Ultimate_TOC_Helper::title_str_replace($row['heading_href']); ?>">
                <?php echo esc_html($row['heading_name']); ?>
            </a>
        </li>
    <?php 
    }?>
    </ul>
</div>
<?php endif; ?>