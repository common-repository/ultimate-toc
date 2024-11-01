<?php 
/*
    Template used to display style 4
    
    Available params:
    ---------------------
    $args['heading'] - Top Heading
    $args['rows'] - The headings items
*/
if($args['rows']): ?>
    <div class="toc-fixed-style-wrapper fixme table-of-content">
        <p class="toc-heading"><?php echo esc_html($args['heading']); ?></p>
        <ul class="toc-fixed-style">
        <?php 
        $i = 0;
        foreach( $args['rows'] as $row ) : $i++; ?>
            <li>
                <a title="<?php echo esc_attr($row['heading_name']); ?>" alt="<?php echo esc_attr($row['heading_name']); ?>" href="#<?php  echo Ultimate_TOC_Helper::title_str_replace($row['heading_href']); ?>">
                    <?php echo esc_html($row['heading_name']);?>
                </a>
            </li>
        <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>